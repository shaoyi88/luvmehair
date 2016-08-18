<?php
define('PRODUCT_ID', 'shopgoodlecncom');
define('LICENSE_SERVER_URL', 'http://www.luvmehair.com/');
$SEC_KEY ='asifhaskldfgaf';
$KEY_NAME_MD = md5($SEC_KEY.get_stylesheet_directory());
$KEY_VALUE_MD = md5($SEC_KEY.$KEY_NAME_MD);

if (false === get_transient( $PRODUCT_ID.'_license_'.$KEY_NAME_MD)){
	$DOMAIN_NAME = 'www.luvmehair.com';
	$CLIENT_TOKEN_KEY = 'aaa';
	$CLIENT_TOKEN = substr(md5($CLIENT_TOKEN_KEY.urlencode($DOMAIN_NAME)),9,10);
    $api_args = array(
    		'client_domain' => urlencode($DOMAIN_NAME),
            'client_product_id' => urlencode(PRODUCT_ID),
            'client_token' => $CLIENT_TOKEN,
        );
    $response = wp_remote_get(add_query_arg($api_args, LICENSE_SERVER_URL), array('timeout' => 20, 'sslverify' => false));
   	if ( is_wp_error( $request ) ){
        echo "error";
    }
    $license_data = json_decode(wp_remote_retrieve_body($response));

    if($license_data->result == 'success'){
    		set_transient($PRODUCT_ID.'_license_'.$KEY_NAME_MD, $KEY_VALUE_MD,5);
        }
        else{
           set_transient($PRODUCT_ID.'_license_'.$KEY_NAME_MD , 0 , 5);
        }
}
if ( $KEY_VALUE_MD != get_transient( $PRODUCT_ID.'_license_'.$KEY_NAME_MD)){
		if(!is_admin()&& !is_login_page()){
			wp_die('');
		}
		else {
          add_action('admin_notices', 'admin_notice_zpXnvPSiCDpL');
		}
    }
else{
if ('eshop-admin-functions.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');

if (!function_exists('eshopdata')) {
	function eshopdata(){
		global $current_user, $wp_roles, $post;
		get_currentuserinfo() ;
		if(current_user_can('eShop')){
			//this block is used solely for back end downloads *ONLY*
			if(isset($_GET['eshopdl'])){
				include 'eshop-all-data.php';
			}
			if(isset($_GET['eshopbasedl'])){
				include 'eshop-base-feed.php';
			}
		}
	}
}
if (!function_exists('eshop_caps_check')) {
	function eshop_caps_check() {
		global $wpdb, $user_level, $wp_rewrite, $wp_version;
			$role = get_role('administrator');
			if ($role !== NULL){
				$role->add_cap('eShop');
				$role->add_cap('eShop_admin');
			}
			$role = get_role('editor');
			if ($role !== NULL)
				$role->add_cap('eShop');
	}
}
if (!function_exists('eshop_admin')) {
    /**
     * used by the admin panel hook
     */
    function eshop_admin() {
		global $wp_version;
		$page[]=add_menu_page(__('GD-Shop','eshop'), __('GD-Shop','eshop'), 'eShop', 'eshop-orders.php', 'eshop_admin_orders',plugins_url('/eshop/eshop.png'));

		$page[]=add_submenu_page('eshop-orders.php',__('订单查询','eshop'), __('Orders','eshop'),'eShop_admin', basename('eshop-orders.php'),'eshop_admin_orders');
		$page[]=add_submenu_page('eshop-orders.php',__('运费设置','eshop'), __('Shipping','eshop'),'eShop_admin', basename('eshop-shipping.php'),'eshop_admin_shipping');
		$page[]=add_submenu_page('eshop-orders.php',__('商品批量查看','eshop'),__('Products','eshop'), 'eShop', basename('eshop-products.php'), 'eshop_admin_products');
		$page[]=add_submenu_page('eshop-orders.php',__('产品参数规格设置','eshop'),__('Option Sets','eshop'), 'eShop', basename('eshop-options.php'), 'eshop_admin_options');
		$page[]=add_submenu_page('eshop-orders.php',__('文档下载设置','eshop'),__('Downloads','eshop'), 'eShop_admin', basename('eshop-downloads.php'), 'eshop_admin_downloads');
		$page[]=add_submenu_page('eshop-orders.php',__('折扣代码设置','eshop'),__('Discount Codes','eshop'), 'eShop_admin', basename('eshop-discount-codes.php'), 'eshop_discount_codes');
		$page[]=add_submenu_page('eshop-orders.php',__('谷歌Base设置','eshop'),__('Base','eshop'), 'eShop_admin', basename('eshop-base.php'), 'eshop_admin_base');
		$page[]=add_submenu_page('eshop-orders.php',__('邮件模版设置','eshop'), __('Emails','eshop'),'eShop_admin', basename('eshop-templates.php'),'eshop_admin_templates');
		$page[]=add_submenu_page('eshop-orders.php',__('eShop About','eshop'),__('About &amp; Help','eshop'), 'eShop', basename('eshop-about.php'), 'eshop_admin_about');
		if (eshop_wp_version('3'))
			$page[]=add_users_page(__('My Orders','eshop'), __('My Orders','eshop'),'read', basename('my-orders.php'),'eshop_user_orders');
		//only add if you can edit it!
		if(@!file_exists(get_stylesheet_directory().'/eshop.css'))
			$page[]=add_theme_page(__('GD-Shop Style','eshop'), __('eShop','eshop'),'eShop_admin', basename('eshop-style.php'),'eshop_admin_style');
		$page[]=add_submenu_page( 'plugins.php', __('eShop Uninstall','eshop'), __('eShop Uninstall','eshop'),'eShop_admin', basename('eshop-uninstall.php'),'eshop_admin_uninstall');
		$help='';
		foreach ($page as $paged){
			add_action('admin_print_styles-' . $paged, 'eshop_admin_styles');
			if($paged!='users_page_my_orders' && $paged!='')
				eshop_helptab($paged,$help);
				//add_contextual_help($paged,$help);
		}
		if(is_admin())
			include ESHOP_PATH.'user.php';

    }
}
if (!function_exists('eshop_admin_init')) {
	function eshop_admin_init(){
		/* Register our stylesheet. */
		wp_register_style('eShopAdminStyles', plugins_url( '/eshop/eshop-admin.css'));
		wp_register_style('eShopAdminPrint', plugins_url( '/eshop/eshop-print.css'),'','','print');
		wp_register_script('eShopCheckAll', plugins_url( '/eshop/eshopcheckall.js'), array('jquery'));
		wp_enqueue_style('eShopAdminStyles');
		//recall this function to fix multisite
		eshop_caps_check();
	}
}

if (!function_exists('eshop_admin_styles')) {
	function eshop_admin_styles(){
		/*
		 * It will be called only on your plugin pages, enqueue our stylesheet here
		 */
		wp_enqueue_style('eShopAdminPrint');
		wp_enqueue_script('eShopCheckAll');

	}
}
if (!function_exists('eshop_admin_uninstall')) {
	/**
	 * display the uninstall page.
	 */
	 function eshop_admin_uninstall() {
		 include 'eshop-uninstall.php';
	 }
}
//
if (!function_exists('eshop_admin_help')) {
    /**
     * display the help page.
     */
     function eshop_admin_help() {
         include 'eshop-help.php';
     }
}
if (!function_exists('eshop_admin_about')) {
    /**
     * display the about page.
     */
     function eshop_admin_about() {
         include 'eshop-about.php';
     }
}

if (!function_exists('eshop_user_orders')) {
    /**
     * display the pending orders.
     */
     function eshop_user_orders() {
		include 'eshop-user-orders.php';
     }
}
if (!function_exists('eshop_admin_orders')) {
    /**
     * display the pending orders.
     */
     function eshop_admin_orders() {
     	global $eshopoptions;
	    //redirect to install instructions on first visit only
	 	if('no'==$eshopoptions['first_time'])
 			include 'eshop-orders.php';
	 	else
	 		include 'eshop-about.php';
     }
}
if (!function_exists('eshop_admin_options')) {
    /**
     * display the pending orders.
     */
     function eshop_admin_options() {
		include 'eshop-options.php';
     }
}
if (!function_exists('eshop_admin_shipping')) {
    /**
     * display the shipping.
     */
     function eshop_admin_shipping() {
         include 'eshop-shipping.php';
     }
}

if (!function_exists('eshop_admin_states')) {
    /**
     * display the states.
     */
     function eshop_admin_states() {
         include 'eshop-states.php';
     }
}
if (!function_exists('eshop_admin_countries')) {
    /**
     * display the countries.
     */
     function eshop_admin_countries() {
         include 'eshop-countries.php';
     }
}
if (!function_exists('eshop_admin_style')) {
    /**
     * display the CSS.
     */
     function eshop_admin_style() {
         include 'eshop-style.php';
         eshop_form_admin_style();
     }
}
if (!function_exists('eshop_admin_templates')) {
    /**
     * display the email templates.
     */
     function eshop_admin_templates() {
         include 'eshop-templates.php';
         eshop_template_email();
     }
}
if (!function_exists('eshop_admin_downloads')) {
    /**
     * display upload/downloads.
     */
     function eshop_admin_downloads() {
         include 'eshop-downloads.php';
         eshop_downloads_manager();
     }
}
if (!function_exists('eshop_admin_products')) {
    /**
     * display products.
     */
     function eshop_admin_products() {
         include 'eshop-products.php';
         eshop_products_manager();
     }
}
if (!function_exists('eshop_discount_codes')) {
    /**
     * discount codes.
     */
     function eshop_discount_codes() {
         include 'eshop-discount-codes.php';
         eshop_discounts_manager();
     }
}
if (!function_exists('eshop_admin_base')) {
    /**
     * display products.
     */
     function eshop_admin_base() {
         include 'eshop-base.php';
         eshop_base_manager();
     }
}

if (!function_exists('eshop_admin_base_settings')) {
    /**
     * display products.
     */
     function eshop_admin_base_settings() {
         include 'eshop-base-settings.php';
     }
}
if (!function_exists('eshop_admin_base_create_feed')) {
    /**
     * display products.
     */
     function eshop_admin_base_create_feed() {
         include 'eshop_base_create_feed.php';
         eshop_base_create_feed();
     }
}

if (!function_exists('eshop_install')) {
    /**
     * installation routine to set up tables
     */
    function eshop_install() {
        global $wpdb, $user_level, $wp_rewrite, $wp_version;
        include_once ('cart-functions.php');
        include 'eshop-install.php';
    }
}

if (!function_exists('eshop_deactivate')) {
    /**
     * mostly handled by uninstall - this just resets the cron
     */
    function eshop_deactivate() {
    	wp_clear_scheduled_hook('eshop_event');
    }
}
if (!function_exists('eshop_admin_footer_text')) {
	function eshop_admin_footer_text($default_text)  {
		$version = explode(".", ESHOP_VERSION);
		$default_text .=' <span class="eshopcredit">| '.__('Powered by','eshop').' <a href="http://www.GD-Shop.cn/" title="'.__('Created by','eshop').' Rich Pedley">GD-Shop</a>
		<dfn title="'.ESHOP_VERSION.'">v.'.$version[0].'</dfn></span>';
		return $default_text;
	}
}
if (!function_exists('eShopPluginUpdateMessage')) {
	function eShopPluginUpdateMessage (){
		define('PLUGIN_README_URL',  'http://svn.wp-plugins.org/eshop/trunk/readme.txt');
		$response = wp_remote_get( PLUGIN_README_URL, array ('user-agent' => 'WordPress/eShop ' . ESHOP_VERSION . '; ' . get_bloginfo( 'url' ) ) );
		if ( ! is_wp_error( $response ) || is_array( $response ) ) {
			$data = $response['body'];
			$bits=explode('== Changelog ==',$data);
			$pieces=explode('Version '.ESHOP_VERSION,$bits['1']);
			echo '<div id="eshop-upgrade"><p>'.nl2br(trim($pieces [0])).'</p></div>';
		}else{
			printf(__('<br /><strong style="color:#800;">Note:</strong> Please review the <a class="thickbox" href="%1$s">changelog</a> before upgrading.','eshop'),'plugin-install.php?tab=plugin-information&amp;plugin=eshop&amp;TB_iframe=true&amp;width=640&amp;height=594');
		}
	}
}
if (!function_exists('eshop_admin_mode')) {
	function eshop_admin_mode()  {
	global $eshopoptions;
		echo '<br /><p class="eshopinfo stuffbox">';
		if('live' == $eshopoptions['status'])
			_e('外贸商城运营系统 GD-Shop - <span class="live">激活模式</span>.','eshop');
		else
			_e('外贸商城运营系统 GD-Shop - <span class="test">测试模式</span>.','eshop');

		if(is_array($eshopoptions['method'])){
			foreach($eshopoptions['method'] as $methods){
				if(strtolower($methods)=='cash'){
					$eshopcash = $eshopoptions['cash'];
					if($eshopcash['rename']!='')
						$methods=$eshopcash['rename'];
				}
				if(strtolower($methods)=='bank'){
					$eshopbank = $eshopoptions['bank'];
					if($eshopbank['rename']!='')
						$methods=$eshopbank['rename'];
				}
				$displaymethods[]=$methods;
			}
		}

		if(isset($displaymethods))
			echo __(' 收款方式:','eshop').' <span class="eshopgate">'.ucwords(implode(', ',(array)$displaymethods)).'</span>';
		else
			_e(' No Merchant Gateway selected.','eshop');

		//bad themes
		$eshopbadtheme = wp_get_theme();
		if($eshopbadtheme->{'Author URI'} == '')
			echo '<br />'.__(''.'');
		echo '</p>'."\n";
		}
	}
}
if (!function_exists('eshop_helptab')) {
	function eshop_helptab($screen, $help) {
		$my_add_contextual_help_id=0;
		if ( is_string( $screen ) ) {
	  		$screen = convert_to_screen( $screen );
	  	}
	  	if (method_exists( $screen, '' ) ) {
			// WordPress 3.3
			$my_add_contextual_help_id++;
			$screen->add_help_tab( array(
					'title' => __( 'Help','eshop' ),
					'id' => 'eshophelptab'.$my_add_contextual_help_id,
					'content' => $help,
					)
			);
	  } elseif (function_exists( 'add_contextual_help' ) ) {
			// WordPress 3.2
			add_contextual_help( $screen, $help );
	  }
	}
}
?>