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

class PrisnaWPTranslateTranslateManage {

	protected static $_token;
	protected static $_crc;
	protected static $_text;
	protected static $_from;
	protected static $_to;
	protected static $_ct;
	protected static $_nd;
	
	public static function main() {
		
		if (!function_exists('add_action')) {
			header('Status: 403 Forbidden');
			header('HTTP/1.1 403 Forbidden'); 
			exit();
			die();
		}
		
		self::$_token = PrisnaWPTranslateCommon::getVariable('tk');
		self::$_crc = PrisnaWPTranslateCommon::getVariable('cr');
		self::$_from = PrisnaWPTranslateCommon::getVariable('f');
		self::$_to = PrisnaWPTranslateCommon::getVariable('t');
		self::$_ct = PrisnaWPTranslateCommon::getVariable('ct');
		self::$_nd = PrisnaWPTranslateCommon::getVariable('nd');
		self::$_text = PrisnaWPTranslateCommon::getVariable('tx');
		
		try {
			$validate = new PrisnaWPTranslateTranslateValidator(array(
				'token' => self::$_token,
				'crc' => self::$_crc,
				'text' => self::$_text,
				'from' => self::$_from,
				'to' => self::$_to,
				'ct' => self::$_ct,
				'nd' => self::$_nd
			));
		}
		catch(Exception $e) {
			return self::_fail($e);
		}

		try {
			$translate = new PrisnaWPTranslateTranslateTransport($validate);
			self::_gen_response($translate->generate());
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

PrisnaWPTranslateTranslateManage::main();