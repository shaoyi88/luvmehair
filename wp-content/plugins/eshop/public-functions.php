<?php
if ('public-functions.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');

if (!function_exists('eshop_pre_wp_head')) {
    function eshop_pre_wp_head() {
    	global $wp_query,$blog_id;
		if(isset($wp_query->query_vars['eshopaction'])) {
   	 		$eshopaction = urldecode($wp_query->query_vars['eshopaction']);
		   	if($eshopaction=='success'){
		   		//destroy cart
				$_SESSION = array();
				//session_destroy();
			}
			//we need to buffer output on a few pages
			if($eshopaction=='redirect'){
				global $eshopoptions;
				ob_start();
				if(isset($eshopoptions['zero']) && $eshopoptions['zero']=='1'){
					if($_POST['amount']=='0' && $_SESSION['final_price'.$blog_id]== '0')
						$_POST['eshop_payment']=$_SESSION['eshop_payment'.$blog_id]='cash';

				}
			}
			if($eshopaction=='webtopayipn'){
				include_once 'webtopay.php';
				exit;
			}
			if($eshopaction=='paypalipn'){
				include_once 'paypal.php';
				exit;
			}						if($eshopaction=='amazon_succeed'){				include_once 'amazon.php';							}						if($eshopaction=='amazon_ipn'){				include_once 'amazon.php';			}
			if($eshopaction=='paysonipn'){
				include_once 'payson.php';
				//exit;
			}
			if($eshopaction=='alipayipn'){
				include_once 'alipay.php';
				//exit;
			}
			if($eshopaction=='authorizenetipn'){
				include_once 'authorizenet.php';
				//exit;
			}
			if($eshopaction=='idealliteipn'){
				include_once 'ideallite.php';
				//exit;
			}
			if($eshopaction=='ogoneipn'){
				include_once 'ogone.php';
				//exit;
			}
			do_action('eshop_include_mg_ipn',$eshopaction);
		}
		if(isset($_POST['eshopident_1'])){
			ob_start();
		}
		
    }
}
if (!function_exists('eshop_wp_head_add')) {
    /**
     * javascript functions
     */
    function eshop_wp_head_add() {
    	global $wp_query,$eshopoptions,$wpdb;
    	$eshopurl=eshop_files_directory();
		if(isset($wp_query->query_vars['eshopaction'])) {
   	 		$eshopaction = urldecode($wp_query->query_vars['eshopaction']);
		   	if($eshopaction=='redirect'){
				//this automatically submits the redirect form
				if($eshopoptions['status']=='live'){			
					wp_register_script('eShopSubmit', $eshopurl['1'].'eshop-onload.js', array('jquery'));
					wp_enqueue_script('eShopSubmit');
				}
			}
		}
    }
}


if (!function_exists('add_eshop_query_vars')) {
	function add_eshop_query_vars($aVars) {
		$aVars[] = "eshopaction";    // represents the name of the product category as shown in the URL
		$aVars[] = "eshopaz";
		$aVars[] = "eshopall";
		$aVars[] = "_p";
		return $aVars;
	}
}

if (!function_exists('eshop_stylesheet')) {
	function eshop_stylesheet() {
		global $eshopoptions;
		$eshopurl=eshop_files_directory();
		if(@file_exists(STYLESHEETPATH.'/eshop.css')) {
			$myStyleUrl = get_stylesheet_directory_uri().'/eshop.css';
			$myStyleFile=STYLESHEETPATH.'/eshop.css';
		}elseif($eshopoptions['style']=='yes'){
			$myStyleUrl = $eshopurl['1'] . 'eshop.css';
			$myStyleFile=$eshopurl['0'] . 'eshop.css';
		}
		if ( file_exists($myStyleFile) ) {
			wp_register_style('myStyleSheets', $myStyleUrl);
			wp_enqueue_style( 'myStyleSheets');
		}
	}
}

if (!function_exists('eshop_unversion')) {
	function eshop_unversion($src) {
		if( strpos($src,'eshop.css'))
			$src=remove_query_arg('ver', $src);
		return $src;
	}
}
function eshop_bits_and_bobs(){
	global $eshopoptions;
	/**
	* eshop download products - need to process afore page is rendered
	* so this has to be called like this - unless anyone can come up with a better idea!
	*/
	if (isset($_POST['eshoplongdownloadname'])){
	//long silly name to ensure it isn't used elsewhere!
		eshop_download_the_product($_POST); 
	}
	
	//add images to the search page if set
	if('no' != $eshopoptions['search_img']){
		add_filter('the_excerpt','eshop_excerpt_img');
		add_filter('the_content','eshop_excerpt_img');
	}
	if($eshopoptions['fold_menu'] == 'yes'){
		add_filter('wp_list_pages_excludes', 'eshop_fold_menus');
	}
}

/* ajax */
if (!function_exists('eshop_ajax_inc')) {
	function eshop_ajax_inc(){
		wp_enqueue_script('jquery');
	}
}

if (!function_exists('eshop_action_javascript')) {
	function eshop_action_javascript() {
		$eshopajaxcart['addfadein']=100;
		$eshopajaxcart['addfadeout']=3000;
		$eshopajaxcart['cartcleardelay']=1000;
		$eshopajaxcart['cartdelay']=750;
		$eshopajaxcart['cartupdate']=3000;
		$eshopajaxcart['cartfadeout']=50;
		$eshopajaxcart['cartfadein']=700;
		//expects an array
		$eshopajaxcart=apply_filters('eshop_ajax_cart',$eshopajaxcart);
		
		$eshopCartParams = array(
		  'addfadein' => $eshopajaxcart['addfadein'],
		  'addfadeout' => $eshopajaxcart['addfadeout'],
		  'cartcleardelay' => $eshopajaxcart['cartcleardelay'],
		  'cartdelay' => $eshopajaxcart['cartdelay'],
		  'cartupdate' => $eshopajaxcart['cartupdate'],
		  'cartfadeout' => $eshopajaxcart['cartfadeout'],
		  'cartfadein' => $eshopajaxcart['cartfadein'],
		  'adminajax' => get_admin_url().'admin-ajax.php'
		);
		$eshopurl=eshop_files_directory();
		wp_register_script( 'eshop_cart_widget', ''.$eshopurl['1'].'eshop-cart.js', array('jquery'));
		wp_enqueue_script('eshop_cart_widget');
		wp_localize_script('eshop_cart_widget', 'eshopCartParams', $eshopCartParams);
	}
}

if (!function_exists('eshop_cart_callback')) {
	function eshop_cart_callback($array) {
		global $eshopoptions, $blog_id;
		if(isset($_SESSION['eshopcart'.$blog_id]))
			echo display_cart($_SESSION['eshopcart'.$blog_id],false, $eshopoptions['checkout'],'widget');
		die();

	}
}

if (!function_exists('eshop_special_action_callback')) {
	function eshop_special_action_callback($array) {
		global $_POST, $blog_id; 
		// extract the data
		$jdata=$_POST['post'];
		$q = explode("&",$jdata);
		foreach ($q as $qi){
			if ($qi != ""){
				$qa = explode("=",$qi);
				list ($key, $val) = $qa;
				if(substr(urldecode($key),0,6)=='optset' && $val){
					$arr2[urldecode($key)] = urldecode($val);
				}elseif ($val){
					$data[urldecode($key)] = urldecode($val);
				}
			}
		} 
		if(isset($arr2)){
			foreach ($arr2 as $arr => $v){
				$off=substr($arr,6);
				$off=$off.'[val]['.$v.']';
				$on[]=explode('][',trim($off,'[]'));

			}
			foreach($on as $c){
				//change string array into proper array
				//0 = arraynum
				//1=arraykey
				//3=value
				$data['optset'][$c[0]][$c[1]]=$c[3];
			}
		}
		//quick qunatity check
		if(!isset($data['qty']) || isset($data['qty']) && !ctype_digit($data['qty'])){
			$msg=apply_filters('eshopCartQtyError','<p><strong class="eshoperror error">'.__('Warning: you must supply a valid quantity.','eshop').'</strong></p>');
		}
		if(!isset($msg)){
			eshop_cart_process($data);
			if(isset($_SESSION['eshopcart'.$blog_id]['error'])){
				$msg=apply_filters('eshopCartError',$_SESSION['eshopcart'.$blog_id]['error']);
				unset($_SESSION['eshopcart'.$blog_id]['error']);
			}elseif(isset($_SESSION['eshopcart'.$blog_id]['enote'])){
				$msg=apply_filters('eshopCartNote',$_SESSION['eshopcart'.$blog_id]['enote']);
				unset($_SESSION['eshopcart'.$blog_id]['enote']);
			}else{
				$msg=apply_filters('eshopCartSuccess',__('<p>Added</p>','eshop'));
			}
		}
		echo $msg;
		die();
	}
}
//randomise
function eshop_random() {
 	global $wpdb;
	$random_id=$wpdb->get_var("SELECT $wpdb->postmeta.post_id from $wpdb->postmeta,$wpdb->posts WHERE $wpdb->postmeta.meta_key='_eshop_stock' AND $wpdb->postmeta.meta_value='1' AND $wpdb->posts.ID=$wpdb->postmeta.post_id AND $wpdb->posts.post_status='publish' order by rand() limit 1");
  	wp_redirect( get_permalink( $random_id ) );
 	exit;
}

class eshop_search {
	function eshop_search() {
		add_action('posts_where_request', array(&$this, 'search'));
	}
	function search($where)	{
		if ( isset( $_GET['eshopsearch'] ) && is_search()) {
			global $wpdb, $wp;
			$meta='_eshop_product';
			if($_GET['eshopsearch'] == 'instock')
				$meta='_eshop_stock';
			$where .= " AND $wpdb->postmeta.meta_key = '{$meta}'";
			add_filter('posts_join_request', array(&$this, 'search_join'));
		}
		return $where;
	}
	function search_join($join)	{
		global $wpdb;
		return $join .= " LEFT JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id) ";
	}
}

function eshopgbase(){
	if(isset($_GET['eshopbasefeed'])){
		include ESHOP_PATH.'eshop-base-feed.php';
	}
}

if (!function_exists('eshop_change_total')) {
	function eshop_change_total() {
		global $wpdb,$blog_id,$_POST;
		$dtable=$wpdb->prefix.'eshop_orders';
		$itable=$wpdb->prefix.'eshop_order_items';
		$id=$_POST['id'];
		$amt_discount =$_POST['amt_discount'];
		$item_amt = 0;
		if($id&&$amt_discount>0){
			$query=$wpdb->query("UPDATE $dtable set amt_discount='$amt_discount' where id='$id'");
			$checkid=$wpdb->get_var("Select checkid From $dtable where id='$id'");
			$result=$wpdb->get_results("Select * From $itable where checkid='$checkid' ");
			foreach($result as $crow){				
				if($crow->item_amt_pristine == 0.00){
					$item_amt = $crow->item_amt*$amt_discount;
				    $wpdb->query("UPDATE $itable set item_amt_pristine='$crow->item_amt' ,item_amt='$item_amt' where id='$crow->id'");
				}else{
					$item_amt = $crow->item_amt_pristine*$amt_discount;
				     $wpdb->query("UPDATE $itable set item_amt='$item_amt' where id='$crow->id'");
				}					 
			}
		}		
		echo $query;
		die();
	}
}

if (!function_exists('eshop_nopriv_change_total')) {
	function eshop_nopriv_change_total() {
		die();
	}
}

if (!function_exists('eshop_get_shipping_amt')) {
	function eshop_get_shipping_amt() {
		global $wpdb, $blog_id, $eshopoptions, $_GET;
		$shopcart=$_SESSION['eshopcart'.$blog_id];
		$change=false;
        $eshopcheckout=$eshopoptions['checkout'];
		//$pzone
        $espost=$_POST;
		if(isset($espost['ship_name'])){			 
			$tablecountries=$wpdb->prefix.'eshop_countries';
			$tablestates=$wpdb->prefix.'eshop_states';
			$shippingzone=$eshopoptions['shipping_zone'];
			if(isset($espost['eshop_shiptype']) && $espost['eshop_shiptype'] != '0'){
				$sztype=esc_sql($espost['eshop_shiptype']);
				$shippingzone=$wpdb->get_var("SELECT area FROM ".$wpdb->prefix."eshop_rates WHERE rate_type='ship_weight' && class='$sztype' LIMIT 1");
			}		
			$pzoneid='';//$eshopoptions['unknown_state'];
			 
			if($shippingzone=='country'){
				if(isset($espost['ship_country']) && $espost['ship_country']!=''){
					$pzoneid=esc_sql($espost['ship_country']);
				}elseif(isset($espost['country']) && $espost['country']!=''){
					$pzoneid=esc_sql($espost['country']);
				}
				$pzone=$wpdb->get_var("SELECT zone FROM $tablecountries WHERE code='$pzoneid' LIMIT 1");
			}else{
				if(isset($espost['state']) && $espost['state']!=''){
					$pzoneid=$espost['state'];
				}
				if(isset($espost['ship_state']) && $espost['ship_state']!=''){
					$pzoneid=$espost['ship_state'];
				}
				$pzone=$wpdb->get_var("SELECT zone FROM $tablestates WHERE id='$pzoneid' LIMIT 1");
				if(isset($espost['altstate']) && $espost['altstate']!=''){
					$pzone=$eshopoptions['unknown_state'];
				}
				if(isset($espost['ship_altstate']) && $espost['ship_altstate']!=''){
					$pzone=$eshopoptions['unknown_state'];
				}
			}             
		}else{
			$pzoneid='';//$eshopoptions['unknown_state'];
			$tablecountries=$wpdb->prefix.'eshop_countries';
			$tablestates=$wpdb->prefix.'eshop_states';
			$shippingzone=$eshopoptions['shipping_zone'];
			if(isset($espost['eshop_shiptype'])){
				$sztype=esc_sql($espost['eshop_shiptype']);
				$shippingzone=$wpdb->get_var("SELECT area FROM ".$wpdb->prefix."eshop_rates WHERE rate_type='ship_weight' && class='$sztype' LIMIT 1");
			}
			if($shippingzone=='country'){
				if(isset($espost['ship_country']) && $espost['ship_country']!=''){
					$pzoneid=esc_sql($espost['ship_country']);
				}elseif(isset($espost['country']) && $espost['country']!=''){
					$pzoneid=esc_sql($espost['country']);
				}
				$pzone=$wpdb->get_var("SELECT zone FROM $tablecountries WHERE code='$pzoneid' LIMIT 1");

			}else{
				if(isset($espost['ship_state']) && $espost['ship_state']!=''){
					$pzoneid=$espost['ship_state'];
				}
				if(isset($espost['state']) && $espost['state']!=''){
					$pzoneid=$espost['state'];
				}
				$pzone=$wpdb->get_var("SELECT zone FROM $tablestates WHERE id='$pzoneid' LIMIT 1");
				if(isset($espost['altstate']) && $espost['altstate']!=''){
					$pzone=$eshopoptions['unknown_state'];
				}
				if(isset($espost['ship_altstate']) && $espost['ship_altstate']!=''){
					$pzone=$eshopoptions['unknown_state'];
				}
			}
		}
		//shiparray
        $shiparray=array();
		$eshopcartarray=$_SESSION['eshopcart'.$blog_id];
		foreach ($eshopcartarray as $productid => $opt){
			if(is_array($opt)){
				switch($eshopoptions['shipping']){
					case '1'://( per quantity of 1, prices reduced for additional items )
						for($i=1;$i<=$opt['qty'];$i++){
							array_push($shiparray, $opt["pclas"]);
						}
						break;
					case '2'://( once per shipping class no matter what quantity is ordered )
						if(!in_array($opt["pclas"], $shiparray)) {
							array_push($shiparray, $opt["pclas"]);
						}
						break;
					case '3'://( one overall charge no matter how many are ordered )
						if(!in_array($opt["pclas"], $shiparray)) {
							if($opt["pclas"]!='F'){
								array_push($shiparray, 'A');
							}
						}
						break;

					case '4'://( weight )
						if(isset($espost['eshop_shiptype'])){
							unset ($shiparray);
							$shiparray=$espost['eshop_shiptype'];
						}
						break;
				}
			}
		}
		if (!isset($_SESSION['shipping' . $blog_id]) || !is_array($_SESSION['shipping' . $blog_id])) $_SESSION['shipping' . $blog_id] = array();
		if ($pzone == 'widget') {
			$pzone = '';
			$iswidget = 'w';
		} else {
			$iswidget = '';
		} 
		$echo = '';
		$check = 0;
		$sub_total = 0;
		$tempshiparray = array(); 
		$eshopcartarray = $_SESSION['eshopcart' . $blog_id];
		if ($change == true) {
			if (isset($_SESSION['eshop_discount' . $blog_id]))
				unset($_SESSION['eshop_discount' . $blog_id]);
		} 

		foreach ($eshopcartarray as $productid => $opt) {
			if (is_array($opt)) {
				foreach($opt as $qty) {
					$check = $check + $qty;
				} 
			} 
		} 
		if ($check > 0) {
			global $final_price;
			$sub_total = 0; 
			if (isset($eshopoptions['etax']))
				$etax = $eshopoptions['etax'];
			$calt = 0;
			$shipping = 0;
			$totalweight = 0;
			$taxtotal = 0;
			$currsymbol = get_currency_symbol();
			$eshopcartarray = $_SESSION['eshopcart' . $blog_id];
			foreach ($eshopcartarray as $productid => $opt) {
				$addoprice = 0;
				if (is_array($opt)) {
					$key = $opt['option'];
					$calt++;
					$alt = ($calt % 2) ? '' : ' class="alt"';
					$eshop_product = maybe_unserialize(get_post_meta($opt['postid'], '_eshop_product', true));
					if (isset($opt['optset'])) {
						$data['optset'] = $opt['optset'];
						$data['addoprice'] = $addoprice;
						$data = eshop_parse_optsets($data);
						$optset = '<span class="eshopoptsets">' . $data['optset'] . '</span>';
						$addoprice = $data['addoprice'];
					} else {
						$optset = '';
					} 
					$echooptset = apply_filters('eshop_optset_cart_display', $optset);
					if (!has_filter('eshop_optset_cart_display')) $echooptset = nl2br($optset); 
					  
					if (isset($eshopoptions['etax']))
						$etax = $eshopoptions['etax'];
					if (($pzone != '' && isset($eshopoptions['tax']) && $eshopoptions['tax'] == '1') || ('yes' == $eshopoptions['downloads_only'] && isset($etax['unknown']) && $etax['unknown'] != '')) {
						if (isset($eshop_product['products'][$opt['option']]['tax']) && $eshop_product['products'][$opt['option']]['tax'] != '' && $eshop_product['products'][$opt['option']]['tax'] != '0') {
							if ($pzone != '')
								$taxrate = eshop_get_tax_rate($eshop_product['products'][$opt['option']]['tax'], $pzone);
							else
								$taxrate = $etax['unknown'];
							$ttotax = $line_total;
							if (isset($disc_line))
								$ttotax = $disc_line * $opt["qty"];
							$taxamt = round(($ttotax * $taxrate) / 100, 2);
							$echo = 0;
							$taxtotal += $taxamt;
							$_SESSION['eshopcart' . $blog_id][$productid]['tax_rate'] = $taxrate;
							$_SESSION['eshopcart' . $blog_id][$productid]['tax_amt'] = $taxamt;
						} 
					} 
					if ($iswidget == '' && $change == 'true') {
						$eshopdeleteimage = apply_filters('eshop_delete_image', plugins_url('/eshop/no.png'));
					} 
					if (isset($disc_line))
						$sub_total += $disc_line * $opt["qty"];
					else
						$sub_total += $line_total; 
					if (isset($opt['diy_option'])){
						$diy_option_arr=explode("@",$opt['diy_option']);
						$opt['weight']+=$diy_option_arr[2];
					}
					if (isset($opt['weight']))
						$totalweight += $opt['weight'] * $opt['qty'];
				} 
			} 
			$sub_total = get_currency_price($sub_total);
			if (is_discountable(calculate_total()) > 0) {
				$discount = is_discountable(calculate_total());
			} 			 
			$final_price = $sub_total;
			$_SESSION['final_price' . $blog_id] = $final_price; 
			$shipping = 0; 
			if ($pzone != '' || ('yes' == $eshopoptions['downloads_only'] && isset($etax['unknown']) && $etax['unknown'] != '')) {
				if ($pzone != '') {
					if ($eshopoptions['shipping_zone'] == 'country') {
						$table = $wpdb -> prefix . 'eshop_countries';
					} else {
						$table = $wpdb -> prefix . 'eshop_states';
					} 
					$table2 = $wpdb -> prefix . 'eshop_rates';
					switch ($eshopoptions['shipping']) {
						case '1':
							foreach ($shiparray as $nowt => $shipclass) {
								if (!in_array($shipclass, $tempshiparray)) {
									if ($shipclass != 'F') {
										array_push($tempshiparray, $shipclass);
										$shipzone = 'zone' . $pzone;
										$shipcost = $wpdb -> get_var("SELECT $shipzone FROM $table2 WHERE class='$shipclass' and items='1' and rate_type='shipping' limit 1");
										$shipping += $shipcost;
									} 
								} else {
									if ($shipclass != 'F') {
										$shipzone = 'zone' . $pzone;
										$shipcost = $wpdb -> get_var("SELECT $shipzone FROM $table2 WHERE class='$shipclass'  and items='2' and rate_type='shipping' limit 1");
										$shipping += $shipcost;
									} 
								} 
							} 
							break;
						case '2':// ( once per shipping class no matter what quantity is ordered )
							foreach ($shiparray as $nowt => $shipclass) {
								if (!in_array($shipclass, $tempshiparray)) {
									array_push($tempshiparray, $shipclass);
									if ($shipclass != 'F') {
										$shipzone = 'zone' . $pzone;
										$shipcost = $wpdb -> get_var("SELECT $shipzone FROM $table2 WHERE class='$shipclass' and items='1' and rate_type='shipping' limit 1");
										$shipping += $shipcost;
									} 
								} 
							} 
							break;
						case '3':// ( one overall charge no matter how many are ordered )
							$shiparray = array_unique($shiparray);
							foreach ($shiparray as $nowt => $shipclass) {
								if ($shipclass != 'F') {
									$shipzone = 'zone' . $pzone;
									$shipcost = $wpdb -> get_var("SELECT $shipzone FROM $table2 WHERE class='A' and items='1' and rate_type='shipping' limit 1");
									$shipping += $shipcost;
								} 
							} 
							break;
						case '4':// by weight/zone etc 
							// $totalweight
							if (sizeof($shiparray) < 1)
								$shiparray = '';
							$shipzone = 'zone' . $pzone;
							$shipcost = $wpdb -> get_var("SELECT $shipzone FROM $table2 where weight <= '$totalweight' && class='$shiparray' and rate_type='ship_weight' order by weight DESC limit 1");
							$shipping += $shipcost;
							$_SESSION['eshopshiptype' . $blog_id] = $shiparray;
					} 
					if (is_shipfree(calculate_total()) || eshop_only_downloads()) $shipping = 0;
					if ($eshopoptions['shipping'] == '4' && !eshop_only_downloads() && $shiparray != '0') {
						$eshopoptions['ship_types'] = trim($eshopoptions['ship_types']);
						$typearr = explode("\n", $eshopoptions['ship_types']); 
						} else {
						} 
					if ($eshopoptions['cart_shipping'] != '') {
						$ptitle = get_post($eshopoptions['cart_shipping']);
					} 
					$echo = sprintf(__('%1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($shipping, __('2', 'eshop'))) ;
				} 
			 
			} 
 
		} 		 
		echo $echo;
	}
}
if (!function_exists('eshop_nopriv_get_shipping_amt')) {
	function eshop_nopriv_get_shipping_amt() {
		 eshop_get_shipping_amt();
	}
}

function eshop_ie_fix(){
?>
<!--[if lt IE 8]>
<style type="text/css">
.eshoppanels li{
    display:inline;
    margin:10px 5px 0 5px;
}
</style>
<![endif]-->
<?php
}
?>