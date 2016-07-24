<?phpglobal $wpdb, $wp_query, $wp_rewrite, $blog_id, $eshopoptions;$detailstable = $wpdb -> prefix . 'eshop_orders';$derror = __('There appears to have been an error, please contact the site admin', 'eshop');include_once(ESHOP_PATH . 'cart-functions.php');$espost = sanitise_array($espost);$this_script = site_url();$token = uniqid(md5($_SESSION['date' . $blog_id]), true);$pvalue = $espost['amount'] + eshopShipTaxAmt();$eshopemailbus = $eshopoptions['business'];$checkid = md5($eshopemailbus . $token . number_format($pvalue, 2));orderhandle($espost, $checkid);$sttable = $wpdb -> prefix . 'eshop_states';$getstate = $eshopoptions['shipping_state'];if ($eshopoptions['show_allstates'] != '1') {	$stateList = $wpdb -> get_results("SELECT id,code,stateName FROM $sttable WHERE list='$getstate' ORDER BY stateName", ARRAY_A);} else {	$stateList = $wpdb -> get_results("SELECT id,code,stateName,list FROM $sttable ORDER BY list,stateName", ARRAY_A);} foreach($stateList as $code => $value) {	$eshopstatelist[$value['id']] = $value['code'];} foreach($espost as $name => $value) {	// have to do a discount code check here - otherwise things just don't work - but fine for free shipping codes	if (strstr($name, 'amount_')) {		if (isset($_SESSION['eshop_discount' . $blog_id]) && eshop_discount_codes_check()) {			$chkcode = valid_eshop_discount_code($_SESSION['eshop_discount' . $blog_id]);			if ($chkcode && apply_eshop_discount_code('discount') > 0) {				$dtype = $_SESSION['eshop_discount_dtype' . $blog_id];				if ($dtype == 7 || $dtype == 8 || $dtype == 9) {					$discount = apply_eshop_discount_code('discount') ;					$value = number_format(round($value - $discount, 2), 2);				} else {					$discount = apply_eshop_discount_code('discount') / 100;					$value = number_format(round($value - ($value * $discount), 2), 2);				} 				$vset = 'yes';			} 		} 		if (is_discountable(calculate_total()) != 0 && !isset($vset)) {			if ($eshopoptions['discount_type'] == 1) {				$discount = is_discountable(calculate_total()) / 100;				$value = number_format(round($value - ($value * $discount), 2), 2);			} else {				$discount = is_discountable(calculate_total());				$value = number_format(round($value - $discount, 2), 2);			} 		} 		// amending for discounts		$espost[$name] = $value;	} 	if (sizeof($stateList) > 0 && ($name == 'state' || $name == 'ship_state')) {		if ($value != '')			$value = $eshopstatelist[$value];	} } $runningtotal = 0;for ($i = 1; $i <= $espost['numberofproducts']; $i++) {	$runningtotal += $espost['quantity_' . $i] * $espost['amount_' . $i];}  $runningtotal = $runningtotal + eshopShipTaxAmt();$espost_hash = array();$espost_hash['amount'] = number_format($runningtotal, 2);$espost_hash['currency'] = 'USD';$espost_hash['invoice_id'] = $espost['custom'];$espost_hash['merchant_id'] = $merchant_id = $eshopoptions['dhpay']['merchant_id'];$private_key = $eshopoptions['dhpay']['private_key'];$hash_key = array('amount', 'currency', 'invoice_id', 'merchant_id');sort($hash_key);foreach ($hash_key as $key) {	$hash_src .= $espost_hash[$key];} $hash_src = $private_key . $hash_src;$hash = hash('sha256', $hash_src);$invoice_id = $espost['custom']; //交易号$order_no = $checkid;$currency = 'USD';$amount = $runningtotal;$buyer_email = $espost['email'];$slink = add_query_arg('dhpay_eshopaction', 'success', get_permalink($eshopoptions['cart_success']));$return_url = apply_filters('eshop_paypal_return_link', $slink);for($i = 1;$i < $espost['numberofproducts'] + 1;$i++) {	$product_name .= $espost['item_name_' . $i];	if ($i < $espost[numberofproducts]) {		$product_name .= ",";	} } $remark = '';$shipping_country = $espost['country'];;$first_name = $espost['first_name'];$last_name = $espost['last_name'];$product_name = cut_str(trim($product_name), 256);$product_price = $espost['amount'];$product_quantity = $espost['numberofproducts'];$address_line = $espost['address1'];$city = $espost['city'];$country = $espost['country'];$state = $espost['state'];;$zipcode = $espost['zip'];$echoit .= '<link type="text/css" rel="stylesheet" href="/wp-content/plugins/eshop/dhpay/css/payment.css">';$echoit .= '<form id="dsubmit" class="eshop eshop-confirm" action="https://www.dhpay.com/merchant/web/cashier" method="post">    <input type="hidden" name="merchant_id" value="' . $merchant_id . '"/>    <input type="hidden" name="invoice_id" value="' . $invoice_id . '"/>    <input type="hidden" name="order_no" value="' . $order_no . '"/>    <input type="hidden" name="currency" value="' . $currency . '"/>    <input type="hidden" name="amount" value="' . number_format($amount, 2) . '"/>	<input type="hidden" name="buyer_email" value="' . $buyer_email . '"/>    <input type="hidden" name="return_url" value="' . $return_url . '"/>	<input type="hidden" name="remark" value="' . $remark . '"/>	<input type="hidden" name="shipping_country" value="' . $shipping_country . '"/>	<input type="hidden" name="first_name" value="' . $first_name . '"/>	<input type="hidden" name="last_name" value="' . $last_name . '"/>	<input type="hidden" name="product_name" value="' . $product_name . '"/>	<input type="hidden" name="product_price" value="' . $product_price . '"/>	<input type="hidden" name="product_quantity" value="' . $product_quantity . '"/>	<input type="hidden" name="address_line" value="' . $address_line . '"/>	<input type="hidden" name="city" value="' . $city . '"/>	<input type="hidden" name="country" value="' . $country . '"/>	<input type="hidden" name="state" value="' . $state . '"/>	<input type="hidden" name="zipcode" value="' . $zipcode . '"/>    <input type="hidden" name="hash" value="' . $hash . '"/>	<input type="hidden" name="payname" value="dhpay" /><label for="ppsubmit" class="finalize"><small><strong>Note:</strong> Submit to finalize order at Credit card.</small><br /><input class="button submit2" type="submit" id="ppsubmit" name="ppsubmit" value="Proceed to Checkout &raquo;" /></label></div></form>';?>