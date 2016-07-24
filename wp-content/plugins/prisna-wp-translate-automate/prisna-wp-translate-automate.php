<?php
/*
Plugin Name: Godoao Translate Automate
Plugin URI: http://www.goodao.cn/
Description: GoodaoCN
Version: 1.0
Author: Goodao
Author URI: http://www.goodao.cn/
*/

class PrisnaWPTranslateAutomateLoader {
	
	public static function last() {
		
		$wp_path_to_this_file = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR."/$2", __FILE__);
		$this_plugin = plugin_basename(trim($wp_path_to_this_file));
		$active_plugins = get_option('active_plugins');
		$this_plugin_key = array_search($this_plugin, $active_plugins);
		
		if ($this_plugin_key != (count($active_plugins)-1)) { 
			array_splice($active_plugins, $this_plugin_key, 1);
			$active_plugins[] = $this_plugin;
			update_option('active_plugins', $active_plugins);
		}
		
	}

}

add_action('activated_plugin', array('PrisnaWPTranslateAutomateLoader', 'last'));

if (class_exists('PrisnaWPTranslate')) {

	$dirname = dirname(__FILE__);
	$plugin_dir_url = plugin_dir_url(__FILE__);

	define('PRISNA_WP_TRANSLATE_AUTOMATE_TEMPLATES', $dirname . '/templates');
	define('PRISNA_WP_TRANSLATE_AUTOMATE_CSS', $plugin_dir_url . 'styles');
	define('PRISNA_WP_TRANSLATE_AUTOMATE_JS', $plugin_dir_url . 'javascript');

	require_once $dirname . '/classes/classes.php';

}

?>