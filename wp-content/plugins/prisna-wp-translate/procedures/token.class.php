<?php
/**
 * Prisna WP Translate
 * http://www.prisna.net/
 *
 * LICENSE
 *
 * @package    Prisna WP Translate
 * @copyright  Copyright (c) 2016, Prisna Ltd, www.prisna.net
 * @license    http://www.prisna.net/license/
 * @version    1.9
 * @date       2016-01-13
 */

require_once dirname(__FILE__) . '/../classes/classes.php';

PrisnaWPTranslateCommon::printHeaders();

class PrisnaWPTranslateTokenManage {
	
	public static function main() {

		if (!function_exists('add_action')) {
			header('Status: 403 Forbidden');
			header('HTTP/1.1 403 Forbidden'); 
			exit();
			die();
		}

		try {
			return self::_auth();
		}
		catch(Exception $e) {
			return self::_fail($e);
		}

	}

	protected static function _auth() {

		try {

			$auth = new PrisnaWPTranslateAuth();

			return self::_gen_response($auth->generate());

		}
		catch(Exception $e) {

			return self::_fail($e);

		}

	}

	protected static function _fail($_e) {

		return self::_gen_response(array(
			'error' => $_e->getMessage()
		));

	}

	protected static function _gen_response($_array) {

		PrisnaWPTranslateTranslateValidator::parseMessage($_array);

		echo PrisnaWPTranslateFastJSON::encode($_array);
		
	}

}

PrisnaWPTranslateTokenManage::main();