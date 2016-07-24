<?php
/**
 * Plugin Name: eshop currency
 * Plugin URI: http://www.eoseo.cn/
 * Description: eshop currency
 * Version: 1.0.00
 * Author: eshop currency
 * Author URI: http://www.eoseo.cn/
 */register_activation_hook( __FILE__,'t9_currency_install');
register_deactivation_hook(__FILE__,'t9_currency_uninstall');	
add_action('admin_menu', 't9_currency_init');
function t9_currency_init() {
	add_menu_page('Eshop货币切换', 'Eshop货币切换', 7, 't9_eshop_currency');
	add_submenu_page('t9_eshop_currency', 'Eshop货币切换', 'Eshop货币切换', 7, 't9_eshop_currency', 'currency_setting');
} 
function t9_currency_install () {
	$info=array();
	add_option('currency_setting', $info);
} 
function t9_currency_uninstall () {
	delete_option('currency_setting');
}
function currency_setting() {
	global $wpdb;
	if($_POST['dosubmit']){
		$info = $_POST['info'];
		update_option(currency_setting, $info);
		echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>设置已保存。</strong></p></div>';
		$currency_setting=get_option('currency_setting');
		echo '<h3>汇率设置</h3>
		<form method="post" action="">
			<table>
			<tr>
				<th align="right">US $:</th>	<td>$1.00</td>
			</tr>
			<tr>
				<th align="right">EUR €:</th><td><input type="" id="" name="info[euro]" value="'.$currency_setting['euro'].'"/></td>
			</tr>
			<tr>
				<th align="right">CAD $:</th><td><input type="" id="" name="info[canadian]" value="'.$currency_setting['canadian'].'"/></td>
			</tr>
			<tr>
				<th align="right">GBP £:</th><td><input type="" id="" name="info[british]" value="'.$currency_setting['british'].'"/></td>
			</tr>
			<tr>
				<th align="right">AUD $:</th><td><input type="" id="" name="info[australian]" value="'.$currency_setting['australian'].'"/></td>
			</tr>
			<tr>
				<th align="right">HK $:</th><td><input type="" id="" name="info[HK]" value="'.$currency_setting['HK'].'"/></td>
			</tr>
			<tr>
				<th align="right">JPY 円:</th><td><input type="" id="" name="info[JPY]" value="'.$currency_setting['JPY'].'"/></td>
			</tr>
			<tr>
				<th align="right">RUB руб.:</th><td><input type="" id="" name="info[RUB]" value="'.$currency_setting['RUB'].'"/></td>
			</tr>
			<tr>
				<th align="right">CHF CHF:</th><td><input type="" id="" name="info[CHF]" value="'.$currency_setting['CHF'].'"/></td>
			</tr>
			<tr>
				<th align="right">$MXN:</th><td><input type="" id="" name="info[MXN]" value="'.$currency_setting['MXN'].'"/></td>
			</tr>
			<tr>
				<th align="right">NOK Kr:</th><td><input type="" id="" name="info[NOK]" value="'.$currency_setting['NOK'].'"/></td>
			</tr>
			<tr>
				<th align="right">CZK Kč:</th><td><input type="" id="" name="info[CZK]" value="'.$currency_setting['CZK'].'"/></td>
			</tr>
			<tr>
				<th align="right">BRL R$:</th><td><input type="" id="" name="info[BRL]" value="'.$currency_setting['BRL'].'"/></td>
			</tr>
			<tr>
				<th align="right">ARS $:</th><td><input type="" id="" name="info[ARS]" value="'.$currency_setting['ARS'].'"/></td>
			</tr>
			<tr>
				<th align="right"></th><td><input type="submit" id="dosubmit" name="dosubmit" value="提交"/></td>
			</tr>
		</table>
		</form>';	
	}else{
		$currency_setting=get_option('currency_setting');
		echo '<h3>汇率设置</h3>
		<form method="post" action="">
			<table>
			<tr>
				<th align="right">US $:</th>	<td>$1.00</td>
			</tr>
			<tr>
				<th align="right">EUR €:</th><td><input type="" id="" name="info[euro]" value="'.$currency_setting['euro'].'"/></td>
			</tr>
			<tr>
				<th align="right">CAD $:</th><td><input type="" id="" name="info[canadian]" value="'.$currency_setting['canadian'].'"/></td>
			</tr>
			<tr>
				<th align="right">GBP £:</th><td><input type="" id="" name="info[british]" value="'.$currency_setting['british'].'"/></td>
			</tr>
			<tr>
				<th align="right">AUD $:</th><td><input type="" id="" name="info[australian]" value="'.$currency_setting['australian'].'"/></td>
			</tr>
			<tr>
				<th align="right">HK $:</th><td><input type="" id="" name="info[HK]" value="'.$currency_setting['HK'].'"/></td>
			</tr>
			<tr>
				<th align="right">JPY 円:</th><td><input type="" id="" name="info[JPY]" value="'.$currency_setting['JPY'].'"/></td>
			</tr>
			<tr>
				<th align="right">RUB руб.:</th><td><input type="" id="" name="info[RUB]" value="'.$currency_setting['RUB'].'"/></td>
			</tr>
			<tr>
				<th align="right">CHF CHF:</th><td><input type="" id="" name="info[CHF]" value="'.$currency_setting['CHF'].'"/></td>
			</tr>
			<tr>
				<th align="right">$MXN:</th><td><input type="" id="" name="info[MXN]" value="'.$currency_setting['MXN'].'"/></td>
			</tr>
			<tr>
				<th align="right">NOK Kr:</th><td><input type="" id="" name="info[NOK]" value="'.$currency_setting['NOK'].'"/></td>
			</tr>
			<tr>
				<th align="right">CZK Kč:</th><td><input type="" id="" name="info[CZK]" value="'.$currency_setting['CZK'].'"/></td>
			</tr>
			<tr>
				<th align="right">BRL R$:</th><td><input type="" id="" name="info[BRL]" value="'.$currency_setting['BRL'].'"/></td>
			</tr>
			<tr>
				<th align="right">ARS $:</th><td><input type="" id="" name="info[ARS]" value="'.$currency_setting['ARS'].'"/></td>
			</tr>
			<tr>
				<th align="right"></th><td><input type="submit" id="dosubmit" name="dosubmit" value="提交"/></td>
			</tr>
		</table>
		</form>';	
	}
	 
} 
 