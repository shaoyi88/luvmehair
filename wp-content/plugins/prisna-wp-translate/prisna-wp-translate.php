<?php
/*
Plugin Name: Godoao Translate
Plugin URI: http://www.goodao.cn/
Description: GoodaoCN
Version: 1.0
Author: Goodao
Author URI: http://www.goodao.cn/
*/

$dirname = dirname(__FILE__);
$plugin_dir_url = plugin_dir_url(__FILE__);

define('PRISNA_WP_TRANSLATE_TEMPLATES', $dirname . '/templates');
define('PRISNA_WP_TRANSLATE_PROCEDURES', $dirname . '/procedures');
define('PRISNA_WP_TRANSLATE_CACHE', $dirname . '/cache');
define('PRISNA_WP_TRANSLATE_IMG', $dirname . '/images');
define('PRISNA_WP_TRANSLATE_IMAGES', $plugin_dir_url . 'images');
define('PRISNA_WP_TRANSLATE_CSS', $plugin_dir_url . 'styles');
define('PRISNA_WP_TRANSLATE_JS', $plugin_dir_url . 'javascript');

require_once $dirname . '/classes/classes.php';

?>