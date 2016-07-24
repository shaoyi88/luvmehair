<?php
if ('eshop-user-orders.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');
     
/*
See eshop.php for information and license terms
*/
if (file_exists(ABSPATH . 'wp-includes/l10n.php')) {
    require_once(ABSPATH . 'wp-includes/l10n.php');
}
else {
    require_once(ABSPATH . 'wp-includes/wp-l10n.php');
}
global $wpdb;
//probably not req'd but suggested by CyberOto
if(!is_user_logged_in()){
	//no user logged in
	die( '<p class="notice">There are no orders to display.</p>');
}
if (!function_exists('displaymyorders')) {
	function displaymyorders(){
	
		global $wpdb,$eshopoptions;
		global $current_user;
		get_currentuserinfo();
		$user_id=$current_user->ID;
		//these should be global, but it wasn't working *sigh*
		$phpself=esc_url($_SERVER['REQUEST_URI']);
		$dtable=$wpdb->prefix.'eshop_orders';
		$itable=$wpdb->prefix.'eshop_order_items';
		
		$sortby='ORDER BY custom_field DESC';
		
		$max = $wpdb->get_var("SELECT COUNT(id) FROM $dtable WHERE id > 0 AND user_id='$user_id'");
		if($max>0){
			if($eshopoptions['records']!='' && is_numeric($eshopoptions['records'])){
				$records=$eshopoptions['records'];
			}else{
				$records='10';
			}
			if(isset($_GET['_p']) && is_numeric($_GET['_p']))
				$epage=$_GET['_p'];
			else 
				$epage='1';
			if(!isset($_GET['eshopall'])){
				$page_links = paginate_links( array(
					'base' => add_query_arg( '_p', '%#%' ),
					'format' => '',
					'total' => ceil($max / $records),
					'current' => $epage,
					'type'=>'array'
					));
				$offset=($epage*$records)-$records;
			}else{
				$page_links = paginate_links( array(
					'base' => add_query_arg( '_p', '%#%' ),
					'format' => '',
					'total' => ceil($max / $records),
					'current' => $epage,
					'type'=>'array',
					'show_all' => true,
				));
				$offset='0';
				$records=$max;
			}
			//
			$myrowres=$wpdb->get_results("Select * From $dtable where user_id='$user_id' $sortby LIMIT $offset, $records");
			$calt=0;

			echo '<div class="orderlist tablecontainer"> ';
			echo '<table style="width:720px;"> 
			<caption class="offset">'.__('','eshop').'</caption>
			<thead>
			<tr>
			<th id="line" title="'.__('reference number:', 'eshop').'">Order No.</th>
			<th id="date">'.__('Ordered on:','eshop').' </th>
			<th id="price" style="text-align:right;">'.__('Total:','eshop').'</th>
			<th id="state" style="text-align:right;">'.__('Status:','eshop').'</th>
			<!--<th id="state" style="text-align:right;">Support</th>-->
			<th id="state" style="text-align:right;">Details</th>
			</tr></thead><tbody>'."\n";
			$move=array();
			$c=0;
			foreach($myrowres as $myrow){
				//total + products
				$c++;//count for the  number of results.
				$checkid=$myrow->checkid;
				$itemrowres=$wpdb->get_results("Select * From $itable where checkid='$checkid'");
				$total=0;
				$x=-1;
				foreach($itemrowres as $itemrow){
					$value=$itemrow->item_qty * $itemrow->item_amt;
					$total=$total+$value;
					$x++;
				}
				//
				$status=$myrow->status;
				if($status=='Completed'){$status=__('Awaiting Dispatch','eshop');}
				if($status=='Pending'){$status=__('Awaiting Payment','eshop');}
				if($status=='Waiting'){$status=__('Awaiting Payment','eshop');}
				if($status=='Sent'){$status=__('Shipped','eshop');}
				if($status=='Deleted'){$status=__('Deleted Order','eshop');}
				if($status=='Failed'){$status=__('Awaiting Dispatch','eshop');}
				if($x>0){
					$thisdate = eshop_real_date($myrow->custom_field);
					$calt++;
					$alt = ($calt % 2) ? '' : ' class="alternate"';
					if($myrow->company!=''){
						$company=__(' of ','eshop').$myrow->company;
					}else{
						$company='';
					}
					$currsymbol=$eshopoptions['currency_symbol'];
					$user_data = get_userdata($myrow->salesman);
					$user_name = $user_data->data->user_login;
					$user_email = $user_data->data->user_email;
					echo '<tr'.$alt.'>
					<td headers="line" id="numb'.$c.'">'.$myrow->id.'</td>
					<td headers="date numb'.$c.'">'.$thisdate.'</td>
					<td headers="price numb'.$c.'" class="right ">'.sprintf( __('%1$s%2$s','eshop'), $currsymbol, number_format_i18n($total, __('2','eshop'))).'</td>
					<td headers="state numb'.$c.'" class="right"><a href="'.$phpself.'&amp;view='.$myrow->id.'" title="'.__('View complete order details','eshop').'">'.$status.'</a></td>
					<!--<td  class="right" headers="state numb'.$c.'"><a href="mailto:'.$user_email.'">'.$user_email.'</a></td>-->
					<td headers="state numb'.$c.'" class="right"><a href="'.$phpself.'&amp;view='.$myrow->id.'" title="'.__('View complete order details','eshop').'">View order details</a></td>
					</tr>';
				}

			}
			echo "</tbody></table></div>\n";
			//paginate
				echo '';
				if($records!=$max){
					$eecho = $page_links;
				}
				echo sprintf( '',
					number_format_i18n( ( $epage - 1 ) * $records + 1 ),
					number_format_i18n( min( $epage * $records, $max ) ),
					number_format_i18n( $max)
				);
				if(isset($eecho)){
					$thispage=esc_url(add_query_arg('eshopall', 'yes', $_SERVER['REQUEST_URI']));
					echo "";
				}
				echo '';
			//end
						
		}else{
			echo '<p class="notice">There are no orders to display.</p>';
		}
	}
}

$dtable=$wpdb->prefix.'eshop_orders';
$itable=$wpdb->prefix.'eshop_order_items';
$stable=$wpdb->prefix.'eshop_states';
$ctable=$wpdb->prefix.'eshop_countries';
$eshopoptions = get_option('eshop_plugin_settings');
echo '<div class="wrap" style="margin-left:-100px;">';
echo '<div style="margin-top:-20px;"></div>';
if (isset($_POST['dosubmit'])){
	global $current_user;
	$user_id=$current_user->ID;
	$eshop_payment = $_POST['eshop_payment'];
	$pid = $_POST['pid'];
	$wpdb->query("UPDATE $dtable SET paidvia = '$eshop_payment' WHERE id = '$pid' && user_id='$user_id'");
}
if (isset($_GET['view']) && is_numeric($_GET['view'])){
	global $current_user;
	get_currentuserinfo();
	$user_id=$current_user->ID;
	$view=esc_sql($_GET['view']);
	$dquery=$wpdb->get_results("Select * From $dtable where id='$view' && user_id='$user_id'");
	
	if(sizeof($dquery)>0){
		foreach($dquery as $drow){
			$status=$drow->status;
			$checkid=$drow->checkid;
		    $admin_note=htmlspecialchars(stripslashes($drow->admin_note));
			$custom=$drow->custom_field;
			$transid=$drow->transid;
			$user_notes=$drow->user_notes;
			$logistics_notes=$drow->logistics_notes;
			$admin_note=$drow->admin_note;
			$paidvia=$drow->paidvia;
		}
		if($status=='Completed'){$status=__('Awaiting Dispatch.','eshop');}
		if($status=='Pending'){$status=__('Awaiting Payment.','eshop');}
		if($status=='Waiting'){$status=__('Awaiting Payment.','eshop');}
		if($status=='Sent'){$status=__('Shipped.','eshop');}
		if($status=='Deleted'){$status=__('Deleted.','eshop');}
		if($status=='Failed'){$status=__('Awaiting Dispatch.','eshop');}
		echo '<h3 class="status"><span style="color: #ff0000;"><strong>Order No. ['.$view.']</strong> - Order Details: '.$status.'</span></h3>
		';
		$result=$wpdb->get_results("Select * From $itable where checkid='$checkid' ORDER BY id ASC");
		$totaltax=$total=0;
		$calt=0;
		$currsymbol=$eshopoptions['currency_symbol'];
		?>
		<div class="orders tablecontainer">
		<?php
		if($user_notes!=''){
			echo '<div id="eshop_admin_note" class="noprint"><h4>'.__('Note: ','eshop')."</h4>\n";
			echo nl2br(htmlspecialchars(stripslashes($user_notes))).'</div>'."\n";
		}
		?>
<table style="width:660px;">


			<caption></caption>
			<thead>
			<tr>
			<th id="opname"><?php _e('Product Name: ','eshop'); ?></th>
			<th id="oitem"><?php _e('Item or Unit Data: ','eshop'); ?></th>
			<th id="oqty"><?php _e('Quantity: ','eshop'); ?></th>
			<th id="oprice"><?php _e('Price: ','eshop'); ?></th>
			<?php if(isset($eshopoptions['tax']) && $eshopoptions['tax']=='1') : ?>
			<th id="otax"><?php _e('Tax Rate:','eshop'); ?></th>
			<th id="otaxamt"><?php _e('Tax amt:','eshop'); ?></th>
			<?php endif; ?>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach($result as $myrow){
				$value=$myrow->item_qty * $myrow->item_amt;
				if(isset($eshopoptions['tax']) && $eshopoptions['tax']=='1') {
					$linetax='';
					if($myrow->tax_amt!=='' && is_numeric($myrow->tax_amt)) {
						$linetax=$myrow->tax_amt;
						$totaltax=$totaltax+$linetax;
					}
				}else{
					if($myrow->tax_amt!=='' && is_numeric($myrow->tax_amt)) {
						$value = $value + $myrow->tax_amt;
					}
				}
				$total=$total+$value;
						$eprodlink=$myrow->post_id;
		$itemid=$myrow->item_id;
		if ( $eprodlink != 0 )
			$itemid='<a target="_bank" href="'.get_permalink($eprodlink).'">View Product</a>';
		
		if($myrow->optsets!='')
			$itemid.='<span class="eshopoptsets">'.nl2br($myrow->optsets).'</span>';
				//check if downloadable product
				$dordtable=$wpdb->prefix.'eshop_download_orders';
				$downstable=$wpdb->prefix.'eshop_downloads';
				$downloadable='';
				if($myrow->down_id!='0'){
					//item is a download
					$dlinfo= $wpdb->get_row("SELECT d.downloads, d.id FROM $dordtable as d, $downstable as dl WHERE d.checkid='$myrow->checkid' AND dl.id='$myrow->down_id' AND d.files=dl.files");
					if(isset($dlinfo->downloads)){
						$downloadable=''.__('Yes - remaining:','eshop');
						$downloadable .='';			
					}else{
						$downloadable = __('Download Item Missing','eshop');
					}
				}
			
				// add in a check if postage here as well as a link to the product
				$showit=$myrow->optname;
				$calt++;
				$alt = ($calt % 2) ? '' : ' class="alternate"';
				echo '<tr'.$alt.'>
				<td id="onum'.$calt.'" headers="opname">'.$showit.'</td>
				<td headers="oitem onum'.$calt.'">'.$itemid.'</td>
				<td headers="oqty onum'.$calt.'">'.$myrow->item_qty.'</td>
				<td headers="oprice onum'.$calt.'" class="right">'.sprintf( __('%1$s%2$s','eshop'), $currsymbol, number_format_i18n($value, __('2','eshop')))."</td>\n";
				if(isset($eshopoptions['tax']) && $eshopoptions['tax']=='1') {
					echo '<td headers="otax onum'.$calt.'" class="right">'.$myrow->tax_rate.'</td>';
					$ectax='';
					if( $linetax !='' )
						$ectax=sprintf( __('%1$s%2$s','eshop'), $currsymbol, number_format_i18n($linetax, __('2','eshop')));
					
					echo '<td headers="otaxamt onum'.$calt.'" class="right">'.$ectax."</td>\n";
				}
				echo "</tr>\n";
		
			}
			if($transid==__('Processing&#8230;','eshop'))
				echo "<tr><td colspan=\"3\" >".__('Total - &raquo;','eshop')." </td><td class=\"total\">".sprintf( __('%1$s%2$s','eshop'), $currsymbol, number_format_i18n($total, __('2','eshop')))."</td>";
			else
				echo "<tr><td colspan=\"3\" >".sprintf(__('Total - paid via %1$s &raquo;','eshop'),ucfirst($paidvia))." </td><td class=\"total\">".sprintf( __('%1$s%2$s','eshop'), $currsymbol, number_format_i18n($total, __('2','eshop')))."</td>\n";
			
			if(isset($eshopoptions['tax']) && $eshopoptions['tax']=='1') {
				echo '<td class="totalr">'.__('Total Tax - &raquo;','eshop').'</td>';
				echo '<td class="total">'.sprintf( __('%1$s%2$s: ','eshop'), $currsymbol, number_format_i18n($totaltax, __('2','eshop')))."</td>\n";
				$totalwithtax=$total + $totaltax;
				echo '</tr>
				<tr><td colspan="5" class="totalr">'.__('Total - with tax &raquo;','eshop').'</td><td class="total">'.sprintf( __('%1$s%2$s','eshop'), $currsymbol, number_format_i18n($totalwithtax, __('2','eshop')))."</td>\n";
			}
		echo "</tr></tbody></table>\n";

		$thisdate = eshop_real_date($custom);
		echo "<span style=\"font-size: small;\">".__('Order placed on: ','eshop')." ".$thisdate.".";
		echo "</span></div><hr style='padding:0 0 8px 0;'>\n";
		if($drow->reference!=''){
			echo '<p><strong>'.__('Reference:','eshop').'</strong> '.$drow->reference.'</p>';
		}
		echo "<h3 class='status'><span style='color: #ff0000;'><strong>Shipping Details</strong></span></h3>";
		foreach($dquery as $drow){

			echo '<p><strong>'.__("Your Name: ",'eshop').'</strong>'.$drow->first_name." ".$drow->last_name."<br />\n";
			if($drow->company!='') echo '<strong>'.__("Company: ",'eshop').'</strong>'.$drow->company."<br />\n";
			echo '<strong>'.__('Your Email: ','eshop').'</strong>'.$drow->email."<br />\n";
			if('no' == $eshopoptions['downloads_only']){
				echo '<strong>'.__("Your Phone: ",'eshop').'</strong>'.$drow->phone."</p>\n";

				echo '<strong>'.__('Shipping to: ','eshop').'</strong>';
				$address=$drow->address1;
				if($drow->address2!='') $address.= ', '.$drow->address2;

					if ($drow -> company != '') echo __("Company: ", 'eshop') . $drow -> company . "";
					echo '<br/>Address: ' . $address . "<br/>";
					echo 'City: ' . $drow -> city . "<br/>";
					echo 'State: ' . $drow -> state . "<br/>";
					echo 'Zip: ' . $drow -> zip . "<br/>";

				$qcode=esc_sql($drow->country);
				$qcountry = $wpdb->get_var("SELECT country FROM $ctable WHERE code='$qcode' limit 1");
				$countryzone = $wpdb->get_var("SELECT zone FROM $ctable WHERE code='$qcode' limit 1");
					echo 'Country: ' .$qcountry . "";
				if($eshopoptions['shipping_zone']=='country'){
					$qzone=$countryzone;
				}else{
					$qzone=$statezone;
					if($statezone=='') $qzone=$eshopoptions['unknown_state'];
				}
				echo '<hr style="padding:0 0 8px 0;"><h3 class="status"><span style="color: #ff0000;"><strong>Order Track No. : '.$logistics_notes.'</strong></span></h3>';
				
				
			}?>
<script type="text/javascript" src="//www.17track.net/api/scripts/17track_api_p.js"></script>
<script type="text/javascript">
    function doTrack() {
        var num = document.getElementById('yq_num').value;
        if(num===''){
            alert('Please enter the number');
            return;
        }
        
        yqtrack_v4({
            container: document.getElementById('track_container'),
            width: 650,
            height: 400,
            num: num,
            et: document.getElementById('yq_et').value,
            lng: 'en'
        });
    }
</script>
<select id="yq_et"><!--#﻿<!--代码脚本示例中的选项-->
    <option value="0">Global Postal</option>
    <option value="100002">UPS</option>
    <option value="100001">DHL</option>
    <option value="100003">Fedex</option>
    <option value="100004">TNT</option>
    <option value="100007">DPD</option>
    <option value="100010">DPD(UK)</option>
    <option value="100011">One World</option>
    <option value="100005">GLS</option>
    <option value="100006">Aramex</option>
    <option value="100008">EShipper</option>
    <option value="100009">Toll</option>
    <option value="190002">FLYT</option>
    <option value="190008">YUNPOST</option>
    <option value="190011">BQC</option>
    <option value="190007">XRU</option>
    <option value="190009">KingDelivery</option>
    <option value="190003">HHEXP</option>

</select>
<input name="" maxlength="38" type="text" id="yq_num" value=""/>
<input type="button" value="TRACK" onclick="doTrack()"/>
<div id="track_container"></div>
<hr>
		<?php
		
						echo '<hr style="padding:0 0 8px 0;"><h3 class="status"><span style="color: #ff0000;"><strong>ADMIN NOTO</strong></span></h3><p style="padding-left:4px;">'.$admin_note.'</p>';

		
			do_action('eshopshowuserdetails',$drow);
			echo '<hr class="eshopclear" />';
			if($drow->thememo!=''){
				echo '<div class="paypalmemo"><h4>'.__('Paypal memo:','eshop').'</h4><p>'.nl2br(htmlspecialchars(stripslashes($drow->thememo))).'</p></div>';
			}

			if($drow->comments!=''){
				echo '<div class="eshopmemo"><h4>'.__('Order comments:','eshop').'</h4><p>'.nl2br(htmlspecialchars(stripslashes($drow->comments))).'</p></div>';
			}
			if($drow->thememo!='' || $drow->comments!=''){
				echo '<hr class="eshopclear" />';
			}
		} 
	echo "<h3 class='status'><span style='color: #ff0000;'><strong>Methods of payment: ".$dquery[0]->paidvia."</strong></span></h3>";
	$token = uniqid(md5($_SESSION['date'.$blog_id]), true);
	if($dquery[0]->status=='Pending'){
		if($dquery[0]->paidvia=='dhpay'){
			$slink=add_query_arg('eshopaction','success',get_permalink($eshopoptions['cart_success']));
			$return_url=apply_filters('eshop_paypal_return_link',$slink);
			
			$merchant_id = $eshopoptions['dhpay']['merchant_id'];
            $private_key = $eshopoptions['dhpay']['private_key'];
            $hash_key = array('amount','currency','invoice_id','merchant_id');
			
			$i=1;
			 
			foreach($result as $myrow){
				$product_name .= $myrow->optname;
				$product_quantity +=$myrow->item_qty;
				if($i < (count($result)-2)){
					$product_name .=",";
				}
				$i++;
			}
			$espost_hash = array();
			$total = number_format($total,2);
			$espost_hash['amount']=$total;
			$espost_hash['currency']='USD';
			$espost_hash['invoice_id']=$dquery[0]->custom_field;
			$espost_hash['merchant_id']=$merchant_id;

			$hash_key = array('amount','currency','invoice_id','merchant_id');
			sort($hash_key);
			foreach ($hash_key as $key) {
				$hash_src .= $espost_hash[$key];
			}
			$hash_src = $private_key . $hash_src;
			$hash = hash('sha256', $hash_src);

			$pay_str ='<table>
			<tr>
				<td>
				<form id="dsubmit" class="eshop eshop-confirm" action="https://www.dhpay.com/merchant/web/cashier" target="_blank" method="post">
						<input type="hidden" name="merchant_id" value="'.$merchant_id.'"/>
						<input type="hidden" name="invoice_id" value="'.$dquery[0]->custom_field.'"/>
						<input type="hidden" name="order_no" value="'.$dquery[0]->checkid.'"/>
						<input type="hidden" name="currency" value="USD"/>
						<input type="hidden" name="amount" value="'.$total.'"/>
						<input type="hidden" name="buyer_email" value="'.$dquery[0]->email.'"/>
						<input type="hidden" name="return_url" value="'.$return_url.'"/>
						<input type="hidden" name="remark" value="'.$remark.'"/>
						<input type="hidden" name="shipping_country" value="'.$dquery[0]->country.'"/>
						<input type="hidden" name="first_name" value="'.$dquery[0]->first_name.'"/>
						<input type="hidden" name="last_name" value="'.$dquery[0]->last_name.'"/>
						<input type="hidden" name="product_name" value="'.$product_name.'"/>
						<input type="hidden" name="product_price" value="'.$total.'"/>
						<input type="hidden" name="product_quantity" value="'.$product_quantity.'"/>
						<input type="hidden" name="address_line" value="'.$dquery[0]->address1.'"/>
						<input type="hidden" name="city" value="'.$dquery[0]->city.'"/>
						<input type="hidden" name="country" value="'.$dquery[0]->country.'"/>
						<input type="hidden" name="state" value="'.$dquery[0]->state.'"/>
						<input type="hidden" name="zipcode" value="'.$dquery[0]->zip.'"/>
						<input type="hidden" name="hash" value="'.$hash.'"/>
						<input type="hidden" name="payname" value="dhpay" />
					<label for="ppsubmit" class="finalize">
					<small><strong>Note:</strong> Submit to finalize order at Credit card.</small>
					<br /><input class="button submit2" type="submit" id="ppsubmit" name="ppsubmit" value="Proceed to Checkout &raquo;" /></label></div></form>
				</td>
			</tr>
		</table>';
		
			if(sizeof((array)$eshopoptions['method'])!=1){
			foreach($eshopoptions['method'] as $k=>$eshoppayment){
				$replace = array(".");
				$eshoppayment = str_replace($replace, "", $eshoppayment);
				$eshoppayment_text=$eshoppayment;
				if($eshoppayment_text=='cash'){
					$eshopcash = $eshopoptions['cash'];
					if($eshopcash['rename']!='')
						$eshoppayment_text=$eshopcash['rename'];
				}
				if($eshoppayment_text=='bank'){
					$eshopbank = $eshopoptions['bank'];
					if($eshopbank['rename']!='')
						$eshoppayment_text=$eshopbank['rename'];
				}
				$eshopmi=apply_filters('eshop_merchant_img_'.$eshoppayment,array('path'=>$eshopfiles['0'].$eshoppayment.'.png','url'=>$eshopfiles['1'].$eshoppayment.'.png'));
				$eshopmerchantimgpath=$eshopmi['path'];
				$eshopmerchantimgurl="/uploads/eshop_files/".$eshopmi['url'];
				$dims=array('3'=>'');
				if(file_exists($eshopmerchantimgpath))
					$dims=getimagesize($eshopmerchantimgpath);
				$echo .='<li style="padding:20px 0 0px 0;"><input class="rad" type="radio" name="eshop_payment" value="'.$eshoppayment.'" id="eshop_payment'.$i.'"'.checked($dquery[0]->paidvia,$eshoppayment,false).' /><label for="eshop_payment'.$i.'"><div class="eshop_pay_img" ><img style="padding:0px 0 0 25px;margin-top:-30px;border:0px solid #dadada;box-shadow:0 0 0px rgba(0,0,0,0);" src="'.$eshopmerchantimgurl.'" '.$dims[3].' alt="'.__('Pay via','eshop').' '.$eshoppayment_text.'" title="'.__('Pay via','eshop').' '.$eshoppayment_text.'" /></div></label></li>';
				$i++;
			}
		}else{
			foreach($eshopoptions['method'] as $k=>$eshoppayment){
				$replace = array(".");
				$eshoppayment = str_replace($replace, "", $eshoppayment);
				$eshoppayment_text=$eshoppayment;
				if($eshoppayment_text=='cash'){
					$eshopcash = $eshopoptions['cash'];
					if($eshopcash['rename']!='')
						$eshoppayment_text=$eshopcash['rename'];
				}
				if($eshoppayment_text=='bank'){
					$eshopbank = $eshopoptions['bank'];
					if($eshopbank['rename']!='')
						$eshoppayment_text=$eshopbank['rename'];
				}
				$eshopmi=apply_filters('eshop_merchant_img_'.$eshoppayment,array('path'=>$eshopfiles['0'].$eshoppayment.'.png','url'=>$eshopfiles['1'].$eshoppayment.'.png'));
				$eshopmerchantimgpath=$eshopmi['path'];
				$eshopmerchantimgurl=$eshopmi['url'];
				$dims='';
				if(file_exists($eshopmerchantimgpath))
					$dims=getimagesize($eshopmerchantimgpath);
				//$echo .='<li><img src="'.$eshopmerchantimgurl.'" '.$dims[3].' alt="'.__('Pay via','eshop').' '.$eshoppayment_text.'" title="'.__('Pay via','eshop').' '.$eshoppayment_text.'" /><input type="hidden" name="eshop_payment" value="'.$eshoppayment.'" id="eshop_payment'.$i.'" /></li>'."\n";
				$echo .='<input type="radio" name="eshop_payment" checked value="paypal" style="width:30px;"/> Paypal <input type="radio" name="eshop_payment" value="dhpay"style="width:30px;"/>  Dhpay'."\n";
				$i++;
			}
		}
		echo '<p>Change Payment Method: </p><form method="post" action=""><input type="hidden" id="" name="pid" value="'.$view.'"
		><ul>'.$echo.'</ul><input style="margin-left:4px;" type="submit" id="submit" name="dosubmit" value="Update Change"/></form>';
		
		
		}else if($dquery[0]->paidvia=='alipay'){
			$pay_str ='<table>
			<tr>
				<td align="right">alipay<input type="submit" id="pay" name="pay" value="pay"/></td>
			</tr>
		</table>';
		}else if($dquery[0]->paidvia=='amazon'){			require_once(ESHOP_PATH.'amazon/eshop-amazon.class.php');			require_once (ESHOP_PATH.'amazon/config.php');			$info = (array)$dquery[0];			$info['return'] = add_query_arg('eshopaction', 'amazon_succeed', get_permalink($eshopoptions['cart_success']));			$info['cancel_return'] = add_query_arg('eshopaction','cancel',get_permalink($eshopoptions['cart_cancel']));			$info['seller_id'] = $amazon_config['seller_id'];			$info['client_id'] = $amazon_config['client_id'];			$info['access_key'] = $amazon_config['access_key'];			$info['secret_key'] = $amazon_config['secret_key'];			$info['debug'] = $amazon_config['debug'];			$info['amount'] = get_currency_price($total);			$info['currency_code'] = get_currency();						$p = new eshop_amazon_class;			$echoit= $p->eshop_submit_amazon_post($info);							if(sizeof((array)$eshopoptions['method'])!=1){			foreach($eshopoptions['method'] as $k=>$eshoppayment){				$replace = array(".");				$eshoppayment = str_replace($replace, "", $eshoppayment);				$eshoppayment_text=$eshoppayment;				if($eshoppayment_text=='cash'){					$eshopcash = $eshopoptions['cash'];					if($eshopcash['rename']!='')						$eshoppayment_text=$eshopcash['rename'];				}				if($eshoppayment_text=='bank'){					$eshopbank = $eshopoptions['bank'];					if($eshopbank['rename']!='')						$eshoppayment_text=$eshopbank['rename'];				}				$eshopmi=apply_filters('eshop_merchant_img_'.$eshoppayment,array('path'=>$eshopfiles['0'].$eshoppayment.'.png','url'=>$eshopfiles['1'].$eshoppayment.'.png'));				$eshopmerchantimgpath=$eshopmi['path'];				$eshopmerchantimgurl="/uploads/eshop_files/".$eshopmi['url'];				$dims=array('3'=>'');				if(file_exists($eshopmerchantimgpath))					$dims=getimagesize($eshopmerchantimgpath);				$echo .='<li style="padding:20px 0 0px 0;"><input class="rad" type="radio" name="eshop_payment" value="'.$eshoppayment.'" id="eshop_payment'.$i.'"'.checked($dquery[0]->paidvia,$eshoppayment,false).' /><label for="eshop_payment'.$i.'"><div class="eshop_pay_img" ><img style="padding:0px 0 0 25px;margin-top:-30px;border:0px solid #dadada;box-shadow:0 0 0px rgba(0,0,0,0);" src="'.$eshopmerchantimgurl.'" '.$dims[3].' alt="'.__('Pay via','eshop').' '.$eshoppayment_text.'" title="'.__('Pay via','eshop').' '.$eshoppayment_text.'" /></div></label></li>';				$i++;			}						$pay_str ='<table style="margin-top:20px">			<tr>				<td align="right">'.$echoit.'</td>			</tr>		</table>';					}else{			foreach($eshopoptions['method'] as $k=>$eshoppayment){				$replace = array(".");				$eshoppayment = str_replace($replace, "", $eshoppayment);				$eshoppayment_text=$eshoppayment;				if($eshoppayment_text=='cash'){					$eshopcash = $eshopoptions['cash'];					if($eshopcash['rename']!='')						$eshoppayment_text=$eshopcash['rename'];				}				if($eshoppayment_text=='bank'){					$eshopbank = $eshopoptions['bank'];					if($eshopbank['rename']!='')						$eshoppayment_text=$eshopbank['rename'];				}				$eshopmi=apply_filters('eshop_merchant_img_'.$eshoppayment,array('path'=>$eshopfiles['0'].$eshoppayment.'.png','url'=>$eshopfiles['1'].$eshoppayment.'.png'));				$eshopmerchantimgpath=$eshopmi['path'];				$eshopmerchantimgurl=$eshopmi['url'];				$dims='';				if(file_exists($eshopmerchantimgpath))					$dims=getimagesize($eshopmerchantimgpath);				$echo .='<input type="radio" name="eshop_payment" checked value="paypal" style="width:30px;"/> Paypal <input type="radio" name="eshop_payment" value="dhpay"style="width:30px;"/>  Dhpay'."\n";				$i++;			}		}		echo '<p>Change Payment Method: </p><form method="post" action=""><input type="hidden" id="" name="pid" value="'.$view.'"		><ul>'.$echo.'</ul><input style="margin-left:4px;" type="submit" id="submit" name="dosubmit" value="Update Change"/></form>';		}else{
			$slink=add_query_arg('eshopaction','success',get_permalink($eshopoptions['cart_success']));
			$slink=apply_filters('eshop_paypal_return_link',$slink);
			$cancel_clink=add_query_arg('eshopaction','cancel',get_permalink($eshopoptions['cart_cancel']));
			$notify_url_ilink=add_query_arg('eshopaction','paypalipn',get_permalink($eshopoptions['cart_success']));
			$k=1;
			foreach($result as $myrow){
				if($myrow->item_id!='Shipping'){
					$product_str.='<input type="hidden" name="item_name_'.$k.'" value="'.$myrow->optname.'">
			<input type="hidden" name="eshopident_'.$k.'" value="'.$myrow->checkid.'">
			<input type="hidden" name="quantity_'.$k.'" value="'.get_currency_price($myrow->item_qty).'">
			<input type="hidden" name="weight_'.$k.'" value="'.$myrow->weight.'">
			<input type="hidden" name="amount_'.$k.'" value="'.$myrow->item_amt.'">
			<input type="hidden" name="item_number_'.$k.'" value="'.$myrow->item_qty.'">
			<input type="hidden" name="postid_'.$k.'" value="'.$myrow->id.'">';
					$k++;
				}else{
					$product_str.='<input type="hidden" name="shipping_1" value="'.$myrow->item_amt.'">';
				}			
			}
			$pay_str ='<table>
			<tr>
				<td align="right">
				<form method="post" class="eshop" target="_blank" id="eshopgateway" action="https://www.paypal.com/cgi-bin/webscr">
				<p><input type="hidden" name="business" value="'.$eshopoptions['business'].'">
				<input type="hidden" name="return" value="'.$slink.'">
				<input type="hidden" name="cancel_return" value="'.$cancel_clink.'">
				<input type="hidden" name="notify_url" value="'.$notify_url_ilink.'">
				<input type="hidden" name="eshop_shiptype" value="0">
				<input type="hidden" name="email" value="'.$dquery[0]->email.'">
				<input type="hidden" name="first_name" value="'.$dquery[0]->first_name.'">
				<input type="hidden" name="last_name" value="'.$dquery[0]->last_name.'">
				<input type="hidden" name="contact_phone" value="'.$dquery[0]->contact_phone.'">
				<input type="hidden" name="address1" value="'.$dquery[0]->address1.'">
				<input type="hidden" name="address2" value="'.$dquery[0]->address2.'">
				<input type="hidden" name="city" value="'.$dquery[0]->city.'">
				<input type="hidden" name="state" value="'.$dquery[0]->state.'">
				<input type="hidden" name="zip" value="'.$dquery[0]->zip.'">
				<input type="hidden" name="country" value="'.$dquery[0]->country.'">
				<input type="hidden" name="ship_name" value="'.$dquery[0]->ship_name.'">
				<input type="hidden" name="ship_company" value="'.$dquery[0]->ship_company.'">
				<input type="hidden" name="ship_phone" value="'.$dquery[0]->ship_phone.'">
				<input type="hidden" name="ship_address" value="'.$dquery[0]->ship_address.'">
				<input type="hidden" name="ship_city" value="'.$dquery[0]->ship_city.'">
				<input type="hidden" name="ship_state" value="'.$dquery[0]->ship_state.'">
				<input type="hidden" name="ship_postcode" value="'.$dquery[0]->ship_postcode.'">
				<input type="hidden" name="ship_country" value="'.$dquery[0]->ship_country.'">
				<input type="hidden" name="eshop_discount" value="'.$dquery[0]->eshop_discount.'">			
				<input type="hidden" name="eshop_payment" value="paypal">
				'.$product_str.'
				<input type="hidden" name="numberofproducts" value="'.$dquery[0]->eshop_discount.'">
				<input type="hidden" name="amount" value="'.get_currency_price($total).'">
				<input type="hidden" name="ship_altstate" value="'.$dquery[0]->ship_altstate.'">
				<input type="hidden" name="custom" value="'.$token.'">
				<input type="hidden" name="reference" value="'.$dquery[0]->reference.'">
				<input type="hidden" name="comments" value="'.$dquery[0]->comments.'">
				<input type="hidden" name="rm" value="2">
				<input type="hidden" name="currency_code" value="'.get_currency().'">
				<input type="hidden" name="lc" value="CN">
				<input type="hidden" name="cmd" value="_ext-enter">
				<input type="hidden" name="redirect_cmd" value="_cart">
				<input type="hidden" name="upload" value="1">
				<input class="button" type="submit" id="ppsubmit" name="ppsubmit" value="Proceed to Paypal »"></p></form></td>
			</tr>
		</table>';
		
		if(sizeof((array)$eshopoptions['method'])!=1){
			foreach($eshopoptions['method'] as $k=>$eshoppayment){
				$replace = array(".");
				$eshoppayment = str_replace($replace, "", $eshoppayment);
				$eshoppayment_text=$eshoppayment;
				if($eshoppayment_text=='cash'){
					$eshopcash = $eshopoptions['cash'];
					if($eshopcash['rename']!='')
						$eshoppayment_text=$eshopcash['rename'];
				}
				if($eshoppayment_text=='bank'){
					$eshopbank = $eshopoptions['bank'];
					if($eshopbank['rename']!='')
						$eshoppayment_text=$eshopbank['rename'];
				}
				$eshopmi=apply_filters('eshop_merchant_img_'.$eshoppayment,array('path'=>$eshopfiles['0'].$eshoppayment.'.png','url'=>$eshopfiles['1'].$eshoppayment.'.png'));
				$eshopmerchantimgpath=$eshopmi['path'];
				$eshopmerchantimgurl="/uploads/eshop_files/".$eshopmi['url'];
				$dims=array('3'=>'');
				if(file_exists($eshopmerchantimgpath))
					$dims=getimagesize($eshopmerchantimgpath);
				$echo .='<li style="padding:20px 0 10px 0;"><input class="rad" type="radio" name="eshop_payment" value="'.$eshoppayment.'" id="eshop_payment'.$i.'"'.checked($dquery[0]->paidvia,$eshoppayment,false).' /><label for="eshop_payment'.$i.'"><div class="eshop_pay_img" ><img style="padding:0px 0 0 25px;margin-top:-30px;border:0px solid #dadada;box-shadow:0 0 0px rgba(0,0,0,0);" src="'.$eshopmerchantimgurl.'" '.$dims[3].' alt="'.__('Pay via','eshop').' '.$eshoppayment_text.'" title="'.__('Pay via','eshop').' '.$eshoppayment_text.'" /></div></label></li>';
				$i++;
			}
		}else{
			foreach($eshopoptions['method'] as $k=>$eshoppayment){
				$replace = array(".");
				$eshoppayment = str_replace($replace, "", $eshoppayment);
				$eshoppayment_text=$eshoppayment;
				if($eshoppayment_text=='cash'){
					$eshopcash = $eshopoptions['cash'];
					if($eshopcash['rename']!='')
						$eshoppayment_text=$eshopcash['rename'];
				}
				if($eshoppayment_text=='bank'){
					$eshopbank = $eshopoptions['bank'];
					if($eshopbank['rename']!='')
						$eshoppayment_text=$eshopbank['rename'];
				}
				$eshopmi=apply_filters('eshop_merchant_img_'.$eshoppayment,array('path'=>$eshopfiles['0'].$eshoppayment.'.png','url'=>$eshopfiles['1'].$eshoppayment.'.png'));
				$eshopmerchantimgpath=$eshopmi['path'];
				$eshopmerchantimgurl=$eshopmi['url'];
				$dims='';
				if(file_exists($eshopmerchantimgpath))
					$dims=getimagesize($eshopmerchantimgpath);
				//$echo .='<li><img src="'.$eshopmerchantimgurl.'" '.$dims[3].' alt="'.__('Pay via','eshop').' '.$eshoppayment_text.'" title="'.__('Pay via','eshop').' '.$eshoppayment_text.'" /><input type="hidden" name="eshop_payment" value="'.$eshoppayment.'" id="eshop_payment'.$i.'" /></li>'."\n";
				$echo .='<input type="radio" name="eshop_payment" checked value="paypal" style="width:30px;"/> Paypal <input type="radio" name="eshop_payment" value="dhpay"style="width:30px;"/>  Dhpay'."\n";
				$i++;
			}
		}
		echo '<p>Change Payment Method: </p><form method="post" action=""><input type="hidden" id="" name="pid" value="'.$view.'"
		><ul>'.$echo.'</ul><input style="margin-left:4px;" type="submit" id="submit" name="dosubmit" value="Update Change"/></form>';
		
		
		}
		echo $pay_str.'<div id="" class="clear"></div>';
	}
	
	}else{
			echo '<p class="notice">There are no orders to display.</p>';
	}

	echo '<br class="clearbr" />&nbsp;';
	

}else{
displaymyorders();
}
echo '</div>';
?>