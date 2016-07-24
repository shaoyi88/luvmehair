<?php
/**
 * Prisna WP Translate Automate
 * http://www.prisna.net/
 *
 * LICENSE
 *
 * @package    Prisna WP Translate
 * @copyright  Copyright (c) 2016, Prisna Ltd, www.prisna.net
 * @license    http://www.prisna.net/license/
 * @version    1.0
 * @date       2016-01-13
 */

class PrisnaWPTranslateAutomateUninstall { 
 
 	public static function run() {
		
		require_once dirname(__FILE__) . '/classes/classes.php';
		
		$name = PrisnaWPTranslateAutomateConfig::getDbSettingsName();
		$name_cache = PrisnaWPTranslateAutomateConfig::getDbCacheWritableName();
		
		if (get_option($name))
			delete_option($name);

		if (get_option($name_cache))
			delete_option($name_cache);

	}
	
}

PrisnaWPTranslateAutomateUninstall::run();