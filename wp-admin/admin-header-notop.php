<?php
/**
 * WordPress Administration Template Header
 *
 * @package WordPress
 * @subpackage Administration
 */

@header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));
if ( ! defined( 'WP_ADMIN' ) )
	require_once( './admin.php' );

// In case admin-header.php is included in a function.
global $title, $hook_suffix, $current_screen, $wp_locale, $pagenow, $wp_version,
	$current_site, $update_title, $total_update_count, $parent_file;

// Catch plugins that include admin-header.php before admin.php completes.
if ( empty( $current_screen ) )
	set_current_screen();

get_admin_page_title();
$title = esc_html( strip_tags( $title ) );

if ( is_network_admin() )
	$admin_title = __( 'Network Admin' );
elseif ( is_user_admin() )
	$admin_title = __( 'Global Dashboard' );
else
	$admin_title = get_bloginfo( 'name' );

if ( $admin_title == $title )
	$admin_title = sprintf( __( '%1$s &#8212; EOCMS' ), $title );
else
	$admin_title = sprintf( __( '%1$s &lsaquo; %2$s &#8212; EOCMS' ), $title, $admin_title );

$admin_title = apply_filters( 'admin_title', $admin_title, $title );

wp_user_settings();

_wp_admin_html_begin();
?>
<title><?php echo $admin_title; ?></title>
<?php

wp_enqueue_style( 'colors' );
wp_enqueue_style( 'ie' );
wp_enqueue_script('utils');

$admin_body_class = preg_replace('/[^a-z0-9_-]+/i', '-', $hook_suffix);
?>
<script type="text/javascript">
addLoadEvent = function(func){if(typeof jQuery!="undefined")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};
var ajaxurl = '<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>',
	pagenow = '<?php echo $current_screen->id; ?>',
	typenow = '<?php echo $current_screen->post_type; ?>',
	adminpage = '<?php echo $admin_body_class; ?>',
	thousandsSeparator = '<?php echo addslashes( $wp_locale->number_format['thousands_sep'] ); ?>',
	decimalPoint = '<?php echo addslashes( $wp_locale->number_format['decimal_point'] ); ?>',
	isRtl = <?php echo (int) is_rtl(); ?>;
</script>
<?php

do_action('admin_enqueue_scripts', $hook_suffix);
do_action("admin_print_styles-$hook_suffix");
do_action('admin_print_styles');
do_action("admin_print_scripts-$hook_suffix");
do_action('admin_print_scripts');
do_action("admin_head-$hook_suffix");
do_action('admin_head');

if ( get_user_setting('mfold') == 'f' )
	$admin_body_class .= ' folded';

if ( !get_user_setting('unfold') )
	$admin_body_class .= ' auto-fold';

if ( is_admin_bar_showing() )
	$admin_body_class .= ' admin-bar';

if ( is_rtl() )
	$admin_body_class .= ' rtl';

$admin_body_class .= ' branch-' . str_replace( array( '.', ',' ), '-', floatval( $wp_version ) );
$admin_body_class .= ' version-' . str_replace( '.', '-', preg_replace( '/^([.0-9]+).*/', '$1', $wp_version ) );
$admin_body_class .= ' admin-color-' . sanitize_html_class( get_user_option( 'admin_color' ), 'fresh' );
$admin_body_class .= ' locale-' . sanitize_html_class( strtolower( str_replace( '_', '-', get_locale() ) ) );

if ( wp_is_mobile() )
	$admin_body_class .= ' mobile';

$admin_body_class .= ' no-customize-support';

?><style>
.1000 {float:center;width: 1000px;}
.top-1 {width: 97%;height:80px;border-bottom:1px solid #dedede;margin:-25px 0px 0px 25px;padding-left:0px;}
.top-1-logo {float:left;padding-right:30px;}
.top-1-icon {float:left;padding:20px 0px 0px 220px;}
.top-1-icon-li {float:left;padding-top:15px;width:70px;}
.top-2 {width: 97%;height:85px;border-bottom:1px solid #dedede;margin:0px 0px 0px 25px;padding-left:0px;}
.index-line {height:5px;border-bottom:1px solid #dedede;}
.options {height:100px;border-bottom:1px solid #dedede;}

/* 2.2 Navigation */
#navigation{ font:normal 17px/1em sans-serif;
	
	text-align:center;
	text-decoration:none;
	color:#000000;
	font-weight:lighter;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	padding-top: 0px;
	padding-right: 0px;
	padding-bottom: 0px;
	padding-left: 0px;
 }


.nav { z-index:99; margin:0; padding:0; list-style:none; line-height:1; }
.nav a  { position:relative; border:1px solid transparent; color:#cccccc; display:block;padding:6px 12px 0 0; line-height:10px; text-decoration:none; text-shadow:0 1px 0 #fff; }
.nav li {float:left;padding:0px 0px 10px 5px;width: 115px;}
.nav li a.sf-with-ul { padding-right:20px; }

.nav a:hover { color: #282828; }

.nav li.current_page_item a, 
.nav li.current_page_parent a,
.nav li.current-menu-ancestor a,
.nav li.current-cat a,
.nav li.current-menu-item a,
.nav li.sfHover { background:#fefefe; color: #7B9EBB; }

/* Optional Styling */
 
.nav li.current_page_item a, 
.nav li.current_page_parent a,
.nav li.current-menu-ancestor a,
.nav li.current-cat a,
.nav li.current-menu-item a,
.nav li.sfHover { 
	border: 1px solid #ddd;
	border-color: rgba(0,0,0,.15); 
	
	/* Border Radius */ 
	border-radius: 4px; -moz-border-radius: 4px; -webkit-border-radius: 4px; 
	
	/* Gradient Background */
	background: #f5f5f5;
  	background: -moz-linear-gradient(100% 100% 90deg, #f5f5f5, #fff);
  	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#fff), to(#f5f5f5));

	/* Box Shadow */
	-moz-box-shadow: 0 1px 1px rgba(0,0,0,.03);
	-webkit-box-shadow: 0 1px 1px rgba(0,0,0,.03);
	box-shadow: 0 1px 1px rgba(0,0,0,.03);
}
#navigation .nav li a {}
#navigation .nav li:first-child a {}
#navigation .nav li:last-child { margin-right: 0; }

	/* 2.2.1 Drop-down menus */
	.nav li ul  { background: #fafafa; margin:0; padding:10px 0px 0 0; position: absolute; left: -999em; width: 110px;  z-index:999; }
	.nav li ul li { margin:0; }
	.nav li ul li a  { padding:0px 0px 10px 5px;border-bottom:1px solid #E4E4E4; color: #4F4F4F;width: 93px; font-size:12px;}
	.nav li ul li a:hover  { text-decoration: underline;}
	.nav li ul li a.sf-with-ul { padding-right:0; }
	.nav li ul ul  { margin: -37px 0 0 140px; }
	
	.nav li ul li a:hover, 
	.nav li.current_page_item ul li a, 
	.nav li.current_page_parent ul li a,
	.nav li.current-menu-ancestor ul li a,
	.nav li.current-cat a ul li,
	.nav li.current-menu-item ul li a,
	.nav li.sfHover ul li { background:none;}
	
	.nav li:hover,.nav li.hover  { position:static; }
	.nav li:hover ul ul, .nav li.sfhover ul ul,
	.nav li:hover ul ul ul, .nav li.sfhover ul ul ul,
	.nav li:hover ul ul ul ul, .nav li.sfhover ul ul ul ul { left:-999em; }
	.nav li:hover ul, .nav li.sfhover ul,
	.nav li li:hover ul, .nav li li.sfhover ul,
	.nav li li li:hover ul, .nav li li li.sfhover ul,
	.nav li li li li:hover ul, .nav li li li li.sfhover ul  { left:auto; /* margin-left:-50px; */ }
	

	
</style>

</head>
<body class="wp-admin wp-core-ui no-js <?php echo apply_filters( 'admin_body_class', '' ) . " $admin_body_class"; ?>" >
<script type="text/javascript">
	document.body.className = document.body.className.replace('no-js','js');
</script>

<?php
// Make sure the customize body classes are correct as early as possible.
if ( current_user_can( 'edit_theme_options' ) )
	wp_customize_support_script();
?><center>

<div style="width:1150px;text-align: left;">
<div style="width: 97%;height:80px;margin:-25px 0px 0px 25px;padding-left:0px;">

<div class="clear"></div>
<div id="wpbody">
<?php
unset($title_class, $blog_name, $total_update_count, $update_title);

$current_screen->set_parentage( $parent_file );

?>

<div id="wpbody-content" aria-label="<?php esc_attr_e('Main content'); ?>" tabindex="0">
<?php

$current_screen->render_screen_meta();

if ( is_network_admin() )
	do_action('network_admin_notices');
elseif ( is_user_admin() )
	do_action('user_admin_notices');
else
	do_action('admin_notices');

do_action('all_admin_notices');

if ( $parent_file == 'options-general.php' )
	require(ABSPATH . 'wp-admin/options-head.php');

