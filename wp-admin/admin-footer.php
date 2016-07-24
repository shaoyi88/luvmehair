<?php
/**
 * WordPress Administration Template Footer
 *
 * @package WordPress
 * @subpackage Administration
 */

// don't load directly
if ( !defined('ABSPATH') )
	die('-1');
?>
</div>
<div class="clear"></div>
<div style="text-align: left;"></div>
<div style="text-align: right;width: 99%;padding:10px 0px 10px 5px;margin:0px 0px 0px 0px;border-top:1px solid #dedede;">
PHP & MYSQL - GD-Shop</div>

<div class="clear"></div>

<?php
do_action('admin_footer', '');
do_action('admin_print_footer_scripts');
do_action("admin_footer-" . $GLOBALS['hook_suffix']);

// get_site_option() won't exist when auto upgrading from <= 2.7
if ( function_exists('get_site_option') ) {
	if ( false === get_site_option('can_compress_scripts') )
		compression_test();
}

?>

<div class="clear"></div></div><!-- wpwrap --></div>
<script type="text/javascript">if(typeof wpOnload=='function')wpOnload();</script>
</body>
</html>
