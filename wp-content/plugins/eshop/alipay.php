<?php
global $wpdb, $wp_query, $wp_rewrite, $blog_id, $eshopoptions;
$detailstable = $wpdb -> prefix . 'eshop_orders';
$derror = __('There appears to have been an error, please contact the site admin', 'eshop');

include_once(ESHOP_PATH . 'cart-functions.php');
include_once(ESHOP_PATH . 'alipay/alipay_submit.class.php');
include_once(ESHOP_PATH . 'alipay/eshop-alipay.class.php');
//支付宝支付配置信息
$alipay_config['partner']		= $eshopoptions['alipay']['partner'];
$alipay_config['seller_email']	= $eshopoptions['alipay']['seller_email'];
$alipay_config['key']			= $eshopoptions['alipay']['key'];

$alipay_config['sign_type']    = strtoupper('MD5');
$alipay_config['input_charset']= strtolower('utf-8');
$alipay_config['cacert']    = getcwd().'\\cacert.pem';
//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$alipay_config['transport']    = 'http';

$p = new eshop_alipay_class;
$this_script = site_url();
if (!isset($wp_query -> query_vars['eshopaction']))
	$eshopaction = 'process';
else
	$eshopaction = $wp_query -> query_vars['eshopaction'];

$this_script = site_url();
if($eshopoptions['checkout']!=''){
	$p->autoredirect=add_query_arg('eshopaction','redirect',get_permalink($eshopoptions['checkout']));
}else{
	die('<p>'.$derror.'</p>');
}
$espost=sanitise_array($espost);
$this_script = site_url();
$token = uniqid(md5($_SESSION['date'.$blog_id]), true);
$pvalue = $espost['amount'] + eshopShipTaxAmt();
$eshopemailbus=$eshopoptions['business'];
$checkid=md5($eshopemailbus.$token.number_format($pvalue,2));
orderhandle($espost,$checkid);

switch ($eshopaction) {
	case 'redirect':
		$espost = sanitise_array($espost);
		if ($espost['eshop_payment'] != 'alipay')
			return;
		/**************************请求参数**************************/
        //支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url = $_POST['notify_url'];
        //页面跳转同步通知页面路径
        $return_url = $_POST['return'];
        //商户订单号
        $out_trade_no = $_POST['checkid'];
        //订单名称
        $subject = $_POST['item_name_1'];
        //付款金额
       // $total_fee = $_POST['amount'];
		$total_fee = $_POST['amount'];
        //订单描述
        $body = "shopping";
        //商品展示地址
        $show_url = "http://www.funny-smoke.com";
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
        //防钓鱼时间戳
        $anti_phishing_key = "";
        //若要使用请调用类文件submit中的query_timestamp函数
        //客户端的IP地址
        $exter_invoke_ip = "";
        //非局域网的外网IP地址，如：221.0.0.1
		/************************************************************/
		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "create_direct_pay_by_user",
				"partner" => trim($alipay_config['partner']),
				"seller_email" => trim($alipay_config['seller_email']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"total_fee"	=> $total_fee,
				"body"	=> $body,
				"show_url"	=> $show_url,
				"anti_phishing_key"	=> $anti_phishing_key,
				"exter_invoke_ip"	=> $exter_invoke_ip,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);

		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "支付宝支付提交中...");
		$echoit.=$html_text;
		break;
	case 'process':
		if ($eshopoptions['cart_success'] != '') {
			$slink = add_query_arg('eshopaction', 'success', get_permalink($eshopoptions['cart_success']));
			$slink = apply_filters('eshop_alipay_return_link', $slink);
		} else {
			die('<p>' . $derror . '</p>');
		} 
		if ($eshopoptions['cart_cancel'] != '') {
			$clink = add_query_arg('eshopaction', 'cancel', get_permalink($eshopoptions['cart_cancel']));
		} else {
			die('<p>' . $eshopoptions['cart_cancel'] . $derror . '</p>');
		} 
		$p -> add_field('return', $slink);
		$p -> add_field('cancel_return', $clink); 
		$p -> add_field('checkid', $checkid); 
		if ($eshopoptions['cart_success'] != '') {
			$ilink = add_query_arg('eshopaction', 'alipayipn', get_permalink($eshopoptions['cart_success']));
		} else {
			die('<p>' . $derror . '</p>');
		} 
		$p -> add_field('notify_url', $ilink);
		$p -> add_field('shipping_1', eshopShipTaxAmt());
		$sttable = $wpdb -> prefix . 'eshop_states';
		$getstate = $eshopoptions['shipping_state'];
		if ($eshopoptions['show_allstates'] != '1') {
			$stateList = $wpdb -> get_results("SELECT id,code,stateName FROM $sttable WHERE list='$getstate' ORDER BY stateName", ARRAY_A);
		} else {
			$stateList = $wpdb -> get_results("SELECT id,code,stateName,list FROM $sttable ORDER BY list,stateName", ARRAY_A);
		} 
		foreach($stateList as $code => $value) {
			$eshopstatelist[$value['id']] = $value['code'];
		} 
		foreach($espost as $name => $value) {
			if (strstr($name, 'amount_')) {
				if(isset($_SESSION['eshop_discount'.$blog_id]) && eshop_discount_codes_check()){
					$chkcode=valid_eshop_discount_code($_SESSION['eshop_discount'.$blog_id]);
					
					if ($chkcode && apply_eshop_discount_code('discount') > 0) {
						    $dtype=$_SESSION['eshop_discount_dtype'.$blog_id];
							if($dtype==7||$dtype==8||$dtype==9){
								$discount = apply_eshop_discount_code('discount') ;
						        $value = number_format(round($value - $discount, 2), 2);
							}else{
								$discount = apply_eshop_discount_code('discount') / 100;
						        $value = number_format(round($value - ($value * $discount), 2), 2);
							}						    
						    $vset = 'yes';
					   } 
				}
				if(is_discountable(calculate_total())!=0 && !isset($vset)){
					if($eshopoptions['discount_type']==1){
							$discount=is_discountable(calculate_total())/100;
					         $value = number_format(round($value-($value * $discount), 2),2);
						}else{
							$discount=is_discountable(calculate_total())/100;
					         $value = number_format(round($value-$discount, 2),2);
						}
				} 
				$espost[$name] = $value;
			} 
			if (sizeof($stateList) > 0 && ($name == 'state' || $name == 'ship_state')) {
				if ($value != '')
					$value = $eshopstatelist[$value];
			} 
			$p -> add_field($name, $value);
		} 
		$runningtotal = 0;
		for ($i = 1; $i <= $espost['numberofproducts']; $i++) {
			$runningtotal += $espost['quantity_' . $i] * $espost['amount_' . $i];
		} 
		$p -> add_field('amount', $runningtotal); 
		 
		if ($eshopoptions['status'] != 'live' && is_user_logged_in() && current_user_can('eShop_admin') || $eshopoptions['status'] == 'live') {
			$echoit .= $p -> submit_alipay_post(); // submit the fields to alipay 
		} 
		break;
	case 'success':
		$_SESSION = array();
		session_destroy();
		$echoit .= "<h3>" . __('Thank you for your order!', 'eshop') . "</h3>";
		break;
	case 'cancel':
		break;
	case 'alipayipn':
        require_once(ESHOP_PATH . 'alipay/alipay_notify.class.php');
	    
		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();
		if($verify_result) {
			//验证成功
			$out_trade_no = $_POST['out_trade_no'];
			//支付宝交易号
			$trade_no = $_POST['trade_no'];
			//交易状态
			$trade_status = $_POST['trade_status'];
			if($_POST['trade_status'] == 'TRADE_FINISHED') {				
			}else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {	
				$table = $wpdb->prefix.'eshop_orders';
				$data = array('status' =>"Completed");
				$where = array('checkid' =>$trade_no);
				$format = array('%s');
				$where_format = array('%s');
				$wpdb->update($table, $data, $where, $format, $where_format);
				$checked=$_GET['order_no'];
				eshop_send_customer_email($checked, '3');
			}
			echo "success";		//请不要修改或删除
		}
		else {
			//验证失败
			echo "fail";
		}
		break;
} 

?>