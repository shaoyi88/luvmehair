<?php
if (!defined('ESHOP_VERSION'))
	define('ESHOP_VERSION', '6.3.11');

if (!defined('ESHOP_PATH'))
	define('ESHOP_PATH', plugin_dir_path(__FILE__));
/**
 * Plugin Name: GD-Shop
 * Plugin URI: http://www.GD-Shop.cn/
 * Description: The accessible shopping cart for GD-Shop and above.
 * Version: 6.3.11
 * Author: Rich Pedley 
 * Author URI: http://www.GD-Shop.cn/
 * 
 * Copyright 2007-2011  R PEDLEY  (email : 8837840@qq.com)
 */
// grab all options here in one go
$eshopoptions = get_option('eshop_plugin_settings');

add_action('init', 'eshop_load_lang', 1);
if (!function_exists('eshop_load_lang')) {
	function eshop_load_lang() {
		$eshoplanguage = apply_filters('eshop_language_dir', dirname(plugin_basename(__FILE__)));
		load_plugin_textdomain('eshop', false, $eshoplanguage); 
		// grab all options here in one go
		$eshopoptions = get_option('eshop_plugin_settings');
	} 
} 

/**
 * eShop general (or not sure where they are utilised!
 */
add_action('init', 'eshopsession', 1);
if (!function_exists('eshopsession')) {
	function eshopsession() {
		if (!session_id()) {
			session_start();
		} 
	} 
} 
/**
 * cron
 */
add_action('eshop_event', 'eshop_cron');
if (!function_exists('eshop_cron')) {
	function eshop_cron() {
		global $wpdb, $eshopoptions, $blog_id;
		if ($eshopoptions['cron_email'] != '') {
			$dtable = $wpdb -> prefix . 'eshop_orders';
			$max = $wpdb -> get_var("SELECT COUNT(id) FROM $dtable WHERE status='Completed' OR status='Waiting'");
			if ($max > 0) {
				$to = $eshopoptions['cron_email']; //  your email
				$body = __("You may have some outstanding orders to process\n\nregards\n\nYour eShop plugin", 'eshop');
				$body .= "\n\n" . get_admin_url($blog_id) . '/admin.php?page=eshop-orders.php&action=Completed' . "\n";
				$headers = eshop_from_address();
				$subject = get_bloginfo('name') . __(": outstanding orders");
				wp_mail($to, $subject, $body, $headers);
			} 
		} 
	} 
} 
add_action('init', 'eshop_update_routine', 1);
if (!function_exists('eshop_update_routine')) {
	function eshop_update_routine() {
		$eshopoptions = get_option('eshop_plugin_settings');
		if (get_option('eshop_version') != '')
			$eshopoptions['version'] = get_option('eshop_version');

		if ($eshopoptions['version'] == '' || $eshopoptions['version'] >= ESHOP_VERSION)
			return false;

		include_once('eshop-upgrade.php');
	} 
} 
include_once 'cart-functions.php';
// process order - not working on init
add_action ('wp', 'eshop_orderhandle_process');
/**
 * the widget
 */
include_once 'eshop-widget.php';
// make sure theme thumbnail support is on, even for those themes that don't use it.
add_theme_support('post-thumbnails');

if (is_admin()) {
	/**
	 * eShop ADMIN SPECIFIC HERE
	 */
	include_once 'eshop-admin-functions.php';
	include_once 'eshop-settings.php';
	include_once 'eshop-product-entry.php';
	include_once 'eshop-dashboard.php';
	/**
	 * activations
	 */
	register_activation_hook(__FILE__, 'eshop_install');
	/**
	 * deactivation
	 */
	register_deactivation_hook(__FILE__, 'eshop_deactivate');
	add_action('admin_init', 'eshopdata');
	add_action('admin_init', 'eshop_admin_init');
	add_action('admin_menu', 'eshop_admin');
	add_filter('admin_footer_text', 'eshop_admin_footer_text');
	add_action('in_plugin_update_message-eshop/eshop.php', 'eShopPluginUpdateMessage');
	add_action('wp_dashboard_setup', 'eshop_add_dashboard_widgets');
} else {
	/**
	 * eShop Public facing only
	 */
	include_once 'public-functions.php';
	include_once('eshop-shortcodes.php');
	include_once('eshop-add-cart.php');
	include_once 'eshop-mgs-redirect.php';
	/**
	 * add_filter('eshop_orderhandle_process', 'eshop_paypal_redirect');
	 * add_filter('eshop_orderhandle_process', 'eshop_cash_redirect');
	 */ 
	// add credits
	
	add_action('wp_footer', 'eshop_visible_credits'); 
	// process cart
	add_action ('init', 'eshop_cart_process');
	add_filter('the_content', 'eshop_boing'); 
	// this automatically hides the relevant pages
	add_filter('wp_list_pages_excludes', 'eshop_add_excludes'); 
	// fold the page menu as it is likely to get long...
	add_filter('style_loader_src', 'eshop_unversion'); 
	// removes version number from css, needed for multisite
	add_action ('init', 'eshop_bits_and_bobs');
	add_filter('query_vars', 'add_eshop_query_vars');
	add_action('wp', 'eshop_pre_wp_head');
	add_action('wp_print_scripts', 'eshop_wp_head_add');
	add_action('wp_print_styles', 'eshop_stylesheet');
	add_action('wp_head', 'eshop_ie_fix');
	new eshop_search();
	add_action('template_redirect', 'eshopgbase');

} 
/**
 * ajax the cart - won't allow me to put this in the above
 */

if (isset($eshopoptions['ajax_cart']) && 'yes' == $eshopoptions['ajax_cart']) {
	include_once 'public-functions.php';
	add_action('wp_enqueue_scripts', 'eshop_ajax_inc'); //CHANGED HERE
	add_action('wp_enqueue_scripts', 'eshop_action_javascript'); // CHANGED HERE
	add_action('wp_ajax_eshop_special_action', 'eshop_special_action_callback');
	add_action('wp_ajax_nopriv_eshop_special_action', 'eshop_special_action_callback');
	add_action('wp_ajax_eshop_cart', 'eshop_cart_callback');
	add_action('wp_ajax_nopriv_eshop_cart', 'eshop_cart_callback'); 
	// change total 2015/4/22
	add_action('wp_ajax_change_total', 'eshop_change_total');
	add_action('wp_ajax_nopriv_change_total', 'eshop_nopriv_change_total'); 
	// get shipping amt 2015/4/23
	add_action('wp_ajax_get_shipping_amt', 'eshop_get_shipping_amt');
	add_action('wp_ajax_nopriv_get_shipping_amt', 'eshop_nopriv_get_shipping_amt');

	if (isset($_GET['eshoprandom']))
		add_action('template_redirect', 'eshop_random');
} else {
	include_once 'public-functions.php'; 
	// change total 2015/4/22
	add_action('wp_ajax_change_total', 'eshop_change_total');
	add_action('wp_ajax_nopriv_change_total', 'eshop_nopriv_change_total'); 
	// get shipping amt 2015/4/23
	add_action('wp_ajax_get_shipping_amt', 'eshop_get_shipping_amt');
	add_action('wp_ajax_nopriv_get_shipping_amt', 'eshop_nopriv_get_shipping_amt');
} 
// test/live mode
add_action ('init', 'eshop_test_or_live');


?>