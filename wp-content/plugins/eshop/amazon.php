<?php
global $wpdb, $wp_query, $wp_rewrite, $blog_id, $eshopoptions;

$detailstable = $wpdb -> prefix . 'eshop_orders';

$derror = __('There appears to have been an error, please contact the site admin', 'eshop');

include_once(ESHOP_PATH . 'cart-functions.php');
$espost=sanitise_array($espost);

include_once (ESHOP_PATH.'amazon/config.php');

require_once(ESHOP_PATH.'amazon/eshop-amazon.class.php'); 

$p = new eshop_amazon_class;

$p->add_field('seller_id', $amazon_config['seller_id']);
$p->add_field('client_id', $amazon_config['client_id']);
$p->add_field('access_key', $amazon_config['access_key']);
$p->add_field('secret_key', $amazon_config['secret_key']);
$p->add_field('debug', $amazon_config['debug']);

$this_script = site_url();
if($eshopoptions['checkout']!=''){
	$p->autoredirect=add_query_arg('eshopaction','redirect',get_permalink($eshopoptions['checkout']));
}else{
	die('<p>'.$derror.'</p>');
}

if(!isset($wp_query->query_vars['eshopaction']))
	$eshopaction='process';
else
	$eshopaction=$wp_query->query_vars['eshopaction'];

switch ($eshopaction) {
	 case 'redirect':
		if(isset($_SESSION['espost'.$blog_id]))
			$espost=$_SESSION['espost'.$blog_id];
		else
			break;
		if('no'==$eshopoptions['paypal_noemail']){
			unset($espost['email']);
		}
		if(isset($echoit))
			$echoit.=$p->eshop_submit_amazon_post($espost);
		//$p->dump_fields();      // for debugging, output a table of all the fields
		break;
	 case 'process': 
	 	$p->add_field('business', $eshopoptions['business']);
		if($eshopoptions['cart_success']!=''){
			$slink = add_query_arg('eshopaction', 'amazon_succeed', get_permalink($eshopoptions['cart_success']));
		}else{
			die('<p>'.$derror.'</p>');
		}
		if($eshopoptions['cart_cancel']!=''){
			$clink=add_query_arg('eshopaction','cancel',get_permalink($eshopoptions['cart_cancel']));
		}else{
			die('<p>'.$eshopoptions['cart_cancel'].$derror.'</p>');
		}
		$p->add_field('return', $slink);
		$p->add_field('cancel_return', $clink);
		$p->add_field('shipping_1', eshopShipTaxAmt());
		$sttable=$wpdb->prefix.'eshop_states';
		$getstate=$eshopoptions['shipping_state'];
		if($eshopoptions['show_allstates'] != '1'){
			$stateList=$wpdb->get_results("SELECT id,code,stateName FROM $sttable WHERE list='$getstate' ORDER BY stateName",ARRAY_A);
		}else{
			$stateList=$wpdb->get_results("SELECT id,code,stateName,list FROM $sttable ORDER BY list,stateName",ARRAY_A);
		}
		foreach($stateList as $code => $value){
			$eshopstatelist[$value['id']]=$value['code'];
		}
		foreach($espost as $name=>$value){
			//have to do a discount code check here - otherwise things just don't work - but fine for free shipping codes
			if(strstr($name,'amount_')){
				
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
							$discount=is_discountable(calculate_total());
					         $value = number_format(round($value-$discount, 2),2);
						}
				}
				//amending for discounts
				$espost[$name]=$value;
			}
			if(sizeof($stateList)>0 && ($name=='state' || $name=='ship_state')){
				if($value!='')
					$value=$eshopstatelist[$value];
			}
			$p->add_field($name, $value);
		}
		$runningtotal=0;
		for ($i = 1; $i <= $espost['numberofproducts']; $i++) {
			$runningtotal+=$espost['quantity_'.$i]*$espost['amount_'.$i];
		}
		$p->add_field('amount',$runningtotal);
		$p->add_field('rm','2'); //1=GET 2=POST
		
		//settings in paypal/index.php to change these
		$p->add_field('currency_code',$eshopoptions['currency']);
		$p->add_field('lc',$eshopoptions['location']);
		$p->add_field('cmd','_ext-enter');
		$p->add_field('redirect_cmd','_cart');
		$p->add_field('upload','1');
		if('yes' == $eshopoptions['downloads_only'])
			$p->add_field('no_shipping','1');
		if($eshopoptions['status']!='live' && is_user_logged_in() &&  current_user_can('eShop_admin')||$eshopoptions['status']=='live'){
			$echoit .= $p->submit_amazon_post();
    	}
	 	break;
	 case 'amazon_succeed':
	 	$_SESSION = array();
      	session_destroy();
		if($p->validateSignature($amazon_config['secret_key'])){
			// 更新订单
			if($eshopoptions['status']=='live'){
				$subject = __('新订单提醒：Amazon付款 -','eshop');
			}else{
				$subject = __('测试: Amazon 付款 - ','eshop');
			}
			$txn_id  = $_GET['orderReferenceId'];
			$checked = $_GET['sellerOrderId'];
			$astatus=$wpdb->get_var("select status from $detailstable where checkid='$checked' limit 1");
			if($astatus=='Pending' && $_GET['resultCode']=='Success'){
				$subject .=__("交易编号",'eshop');	
				eshop_mg_process_product($txn_id,$checked);
				
				$subject .=": ".$txn_id;
				$array=eshop_rtn_order_details($checked);
			 	$body =  __("Amazon新订单（在线支付）",'eshop')."\n";
			 	$body .= "\n".__("订单时间：",'eshop').date('m/d/Y');
			 	$body .= __(" at ",'eshop').date('g:i A')."\n\n".__('详情访问后台：','eshop').":\n";
			 	if(isset($array['dbid']))
			 		$body .= get_option( 'siteurl' ).'/wp-admin/admin.php?page=eshop-orders.php&view='.$array['dbid']."&eshop\n";

				$headers=eshop_from_address();
				$eshopemailbus=$eshopoptions['business'];
				if(isset( $eshopoptions['business_sec'] ) && $eshopoptions['business_sec'] !=''){
					$eshopemailbus=$eshopoptions['business_sec'];
				}
				$to = apply_filters('eshop_gateway_details_email', array($eshopemailbus));

				wp_mail($to, $subject, $body, $headers);

				include_once(ESHOP_PATH.'cart-functions.php');
				eshop_send_customer_email($checked, '3');
				
			}
		}
		$slink = add_query_arg('eshopaction', 'succeed', get_permalink($eshopoptions['cart_success']));
		header("Location: ".$slink);
	 	break;
	 case 'amazon_ipn':    
	 	echo 'amazon2123';
	 	break;
}