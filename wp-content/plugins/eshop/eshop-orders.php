<?php
if ('eshop-orders.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('<h2>Direct File Access Prohibited</h2>');
/**
 * See eshop.php for information and license terms
 */
if (file_exists(ABSPATH . 'wp-includes/l10n.php')) {
	require_once(ABSPATH . 'wp-includes/l10n.php');
} else {
	require_once(ABSPATH . 'wp-includes/wp-l10n.php');
} 
global $wpdb;
$eshopoptions = get_option('eshop_plugin_settings');

$eshopactionarray = array('Completed', 'Pending', 'Failed', 'Waiting', 'Sent', 'Deleted');

if (isset($_GET['action']) && in_array($_GET['action'], $eshopactionarray))
	$action_status = esc_attr($_GET['action']);
else
	$_GET['action'] = $action_status = 'Pending';

if (isset($_GET['eshop'])) $action_status = '';

if (isset($_POST['eshopdeletedata'])) {
	$etable[] = $wpdb -> prefix . 'eshop_orders';
	$etable[] = $wpdb -> prefix . 'eshop_download_orders';
	$etable[] = $wpdb -> prefix . 'eshop_order_items';
	foreach($etable as $detable) {
		$wpdb -> query("TRUNCATE $detable");
	} 
	$dltable = $wpdb -> prefix . "eshop_downloads";
	$wpdb -> query("UPDATE $dltable set downloads='0',purchases='0'");
	$stktable = $wpdb -> prefix . "eshop_stock";
	$wpdb -> query("UPDATE $stktable set purchases='0'");
	echo '<p id="eshopddata">' . __('Records deleted', 'eshop') . '</p>';
	unset($_GET['eshopddata']);
} 
if (isset($_GET['eshopddata'])) {

	?><script>function btnPrintClick(){
		window.print();
	}
	</script>
	<form action="" method="post" id="eshopddata" name="eshopddata">
	<fieldset>
	<input type="hidden" name="eshopdeletedata" value='1' />
	<label for="esub"><?php _e('Delete all orders and reset all stats <small>(this action cannot be undone)</small>', 'eshop');
	?></label>
	<span class="submit eshop"><input type="submit" value="<?php _e('Delete', 'eshop');
	?>" id="esub" name="submit" /></span>
	</fieldset>
</form>
<?php
} 
// admin note handling
if (isset($_POST['change_shoping'])) {
	$items_table = $wpdb -> prefix . 'eshop_order_items';
	$sid = $_POST['sid'];
	$new_val = $_POST['new_val'];
	$wpdb->query("UPDATE $items_table SET item_amt = '$new_val' WHERE id = '$sid' ");
}
if (isset($_POST['eshop-adnote'])) {
	$dtable = $wpdb -> prefix . 'eshop_orders';
	if (isset($_GET['view']) && is_numeric($_GET['view'])) {
		$view = $_GET['view'];
		$admin_note = esc_sql($_POST['eshop-adnote']);
		$logistics_notes = esc_sql($_POST['eshop-logisticsnote']);
		if (isset($eshopoptions['users']) && $eshopoptions['users'] == 'yes') {
			$user_notes = esc_sql($_POST['eshop-unote']);
		} else {
			$user_notes = '';
		} 
		$query2 = $wpdb -> query("UPDATE $dtable set admin_note='$admin_note',user_notes='$user_notes',logistics_notes='$logistics_notes' where id='$view'");
		echo '<div class="updated fade"><p>' . __('Notes changed successfully.', 'eshop') . '</p></div>';
	} else {
		echo '<div class="error fade"><p>' . __('Error: Notes were not changed.', 'eshop') . '</p></div>';
	} 
} 

if (!function_exists('displayorders')) {
	function displayorders($type, $default) {		
		global $wpdb, $eshopoptions; 
		// these should be global, but it wasn't working *sigh*
		$phpself = esc_url($_SERVER['REQUEST_URI']);
		$dtable = $wpdb -> prefix . 'eshop_orders';
		$itable = $wpdb -> prefix . 'eshop_order_items';
		$sa = $sb = $sc = $sd = $where = '';
		$q = trim($_GET['q']);
		if (isset($_GET['type'])) {
			switch ($_GET['type']) {
				case'id':// date descending
					$where = "AND id ='$q'";
					$sa = 'selected';
					break;
				case'email':// date descending
					$where = "AND email like '%$q%'";
					$sb = 'selected';
					break;
				case'username':// date descending
					$where = "AND (first_name like '%$q%' OR first_name like '%$q%')";
					$sc = 'selected';
					break;
				case'dateline':// date descending
					$where = "AND edited like '%$q%'";
					$sd = 'selected';
					break;
				case'logistics_notes':// date descending
					$where = "AND logistics_notes like '%$q%'";
					$sd = 'selected';
					break;
				default:
					$where = "";
					$sa = 'selected';
			    } 
		    }
			if (!isset($_GET['by']))
				$_GET['by'] = $default;

			$cda = $cdd = $ctn = $cca = $cna = '';
			if (isset($_GET['by'])) {
				switch ($_GET['by']) {
					case'dd':// date descending
						$sortby = 'ORDER BY custom_field DESC';
						$cdd = ' class="current"';
						break;
					case'tn':// transaction id numerically
						$sortby = 'ORDER BY transid ASC';
						$ctn = ' class="current"';
						break;
					case'na':// name alphabetically (last name)
						$sortby = 'ORDER BY last_name ASC';
						$cna = ' class="current"';
						break;
					case'ca':// company name alphabetically
						$sortby = 'ORDER BY company ASC';
						$cca = ' class="current"';
						break;
					case'da':// date ascending
					default:
						$sortby = 'ORDER BY custom_field ASC';
						$cda = ' class="current"';
				} 
			} else {
				$cda = ' class="current"';
				$sortby = 'ORDER BY custom_field ASC';
			} 			global $current_user;
			$sql = "SELECT COUNT(id) FROM $dtable WHERE id > 0 AND status='$type'";
				
			if(current_user_can('supplier')){
				$sql .= " and from_id=$current_user->id";
			}
			$max = $wpdb -> get_var($sql);
			if ($max > 0) {
				if ($eshopoptions['records'] != '' && is_numeric($eshopoptions['records'])) {
					$records = $eshopoptions['records'];
				} else {
					$records = '10';
				} 
				if (isset($_GET['_p']) && is_numeric($_GET['_p']))
					$epage = $_GET['_p'];
				else
					$epage = '1';
				if (!isset($_GET['eshopall'])) {
					$page_links = paginate_links(array('base' => add_query_arg('_p', '%#%'),
							'format' => '',
							'total' => ceil($max / $records),
							'current' => $epage,
							'type' => 'array'
							));
					$offset = ($epage * $records) - $records;
				} else {
					$page_links = paginate_links(array('base' => add_query_arg('_p', '%#%'),
							'format' => '',
							'total' => ceil($max / $records),
							'current' => $epage,
							'type' => 'array',
							'show_all' => true,
							));
					$offset = '0';
					$records = $max;
				} 
				global $current_user;
				
				$sql = "Select * From $dtable where status='$type' ";
				
				if(current_user_can('supplier')){
					$sql .= "and from_id=$current_user->id";
				}
				
				$sql .= " $where $sortby LIMIT $offset, $records";

				$myrowres = $wpdb -> get_results($sql);
				$calt = 0;
				$apge = get_admin_url() . 'admin.php?page=' . $_GET['page'] . '&amp;action=' . $_GET['action'];
				echo '<form method="get" action="' . get_admin_url() . 'admin.php"><div id="eshopsubso" class="stuffbox" style="text-align: right;">';				
				if(current_user_can('supplier')){
					echo '<div style="float:left;padding:8px 0 0 8px;"><a href="admin.php?page=eshop-orders.php&amp;eshopdl=yes">Order Download(CSV)</a></div><span>' . __('Order Searching &raquo;', 'eshop') . '</span><input type="hidden" id="" name="page" value="' . $_GET['page'] . '"/><input type="hidden" id="" name="action" value="' . $_GET['action'] . '"/><input type="hidden" id="" name="by" value="' . $_GET['by'] . '"/>';

					echo '<select id="type" name="type"><option value="id" '.$sa.'>Order Number</option><option value="email" '.$sb.'>Buyer Email</option><option value="username" '.$sc.'>User Name</option><option value="dateline" '.$sd.'>Time of Ordering</option><option value="logistics_notes" '.$sd.'>Tracking Number</option></select><input type="text" id="q" name="q" value="'.$q.'"/><input type="submit" id="search" name="search" value="search" style="vertical-align: middle;margin:0px"/>';

					echo '</div></form>';



					echo '<ul id="eshopsubmenu" class="stuffbox">';

					echo '<li><span>' . __('The Type of Rankig &raquo;', 'eshop') . '</span></li>';

					echo '<li><a href="' . $apge . '&amp;by=da"' . $cda . '>' . __('The Earliest Order', 'eshop') . '</a></li>';

					echo '<li><a href="' . $apge . '&amp;by=dd"' . $cdd . '>' . __('The Latest Orders', 'eshop') . '</a></li>';
	
					echo '<li><a href="' . $apge . '&amp;by=tn"' . $ctn . '>' . __('Order Number', 'eshop') . '</a></li>';

					echo '<li><a href="' . $apge . '&amp;by=na"' . $cna . '>' . __("Buyer's Name", 'eshop') . '</a></li>';
				}else{
					echo '<div style="float:left;padding:8px 0 0 8px;"><a href="admin.php?page=eshop-orders.php&amp;eshopdl=yes">订单导出(CSV)</a></div><span>' . __('订单搜索 &raquo;', 'eshop') . '</span><input type="hidden" id="" name="page" value="' . $_GET['page'] . '"/><input type="hidden" id="" name="action" value="' . $_GET['action'] . '"/><input type="hidden" id="" name="by" value="' . $_GET['by'] . '"/>';

					echo '<select id="type" name="type"><option value="id" '.$sa.'>订单编号</option><option value="email" '.$sb.'>客户邮箱</option><option value="username" '.$sc.'>用户名</option><option value="dateline" '.$sd.'>订单时间</option><option value="logistics_notes" '.$sd.'>运单号</option></select><input type="text" id="q" name="q" value="'.$q.'"/><input type="submit" id="search" name="search" value="search" style="vertical-align: middle;margin:0px"/>';

					echo '</div></form>';



					echo '<ul id="eshopsubmenu" class="stuffbox">';

					echo '<li><span>' . __('排序方式 &raquo;', 'eshop') . '</span></li>';

					echo '<li><a href="' . $apge . '&amp;by=da"' . $cda . '>' . __('最早订单', 'eshop') . '</a></li>';

					echo '<li><a href="' . $apge . '&amp;by=dd"' . $cdd . '>' . __('最近订单', 'eshop') . '</a></li>';
	
					echo '<li><a href="' . $apge . '&amp;by=tn"' . $ctn . '>' . __('订单编号', 'eshop') . '</a></li>';

					echo '<li><a href="' . $apge . '&amp;by=na"' . $cna . '>' . __('客户名称', 'eshop') . '</a></li>';
				}
				
				
				echo '</ul>';

				echo "<form id=\"orderstatus\" action=\"" . $phpself . "\" method=\"post\">";
				echo '<div class="orderlist tablecontainer">';				if(current_user_can('supplier')){
				echo '<table class="hidealllabels widefat">

			<caption class="offset">' . __('Order Listing', 'eshop') . '</caption>

			<thead>

			<tr>
			
			<th id="customer">Order Details</th>
			
			<th id="customer">Order Source</th>

			<th id="date">' . __('Time of Ordering', 'eshop') . '</th>

			<th id="customer">' . __(' Customer Information(Marked with * is the Registered User)', 'eshop') . '</th>

			<th id="items">' . __('Product Quantity', 'eshop') . '</th>

			<th id="price">' . __('Order Price', 'eshop') . '</th>

			<th id="transid">' . __('Transaction ID', 'eshop') . '</th>

			<th id="line" title="' . __('reference number', 'eshop') . '">Order Number</th>

			<th id="bulk"><input type="checkbox" value="" name="checkAllAuto" id="checkAllAuto" /><label style="padding:0 0 0 8px; font-size:12px;margin-top:-10px;" for="checkAllAuto">' . __('Select All', 'eshop') . '</label></th>			


</tr></thead><tbody>' . "\n";
				}else{
					echo '<table class="hidealllabels widefat">

			<caption class="offset">' . __('Order Listing', 'eshop') . '</caption>

			<thead>

			<tr>
			
			<th id="customer">订单详情</th>
			
			<th id="customer">订单来源</th>

			<th id="date">' . __('订单时间', 'eshop') . '</th>

			<th id="customer">' . __('客户信息(*为注册用户)', 'eshop') . '</th>

			<th id="items">' . __('产品数量', 'eshop') . '</th>

			<th id="price">' . __('订单价格', 'eshop') . '</th>

			<th id="transid">' . __('支付交易ID', 'eshop') . '</th>

			<th id="line" title="' . __('reference number', 'eshop') . '">订单编号</th>

			<th id="bulk"><input type="checkbox" value="" name="checkAllAuto" id="checkAllAuto" /><label style="padding:0 0 0 8px; font-size:12px;margin-top:-10px;" for="checkAllAuto">' . __('全选()', 'eshop') . '</label></th>			

</tr></thead><tbody>' . "\n";
				}
				
				$move = array();
				$c = 0;
				foreach($myrowres as $myrow) {
					// total + products
					$c++; //count for the  number of results.
					$checkid = $myrow -> checkid;
					$itemrowres = $wpdb -> get_results("Select * From $itable where checkid='$checkid'");
					$total = 0;
					$x = 0;
					foreach($itemrowres as $itemrow) {
						$value = $itemrow -> item_qty * $itemrow -> item_amt;
						if ($itemrow -> tax_amt !== '' && is_numeric($itemrow -> tax_amt))
							$value = $value + $itemrow -> tax_amt;
						$total = $total + $value;
						$x++;
					} 
					
					$status = $type; 
					// if($x>0){
					$thisdate = eshop_real_date($myrow -> custom_field);

					$calt++;
					$alt = ($calt % 2) ? '' : ' class="alternate"';
					if ($myrow -> company != '') {
						$company = __(' of ', 'eshop') . $myrow -> company;
					} else {
						$company = '';
					} 
					$currsymbol = $eshopoptions['currency_symbol'];
					$ic = $x-1;
					$userlink = '';
					//业务员
					$salesman_option = $selected = '';
					$usermeta_table = $wpdb -> prefix . 'usermeta';
					$user_arr = $wpdb->get_results("SELECT * FROM $usermeta_table WHERE meta_key = 'wp_capabilities' AND meta_value like '%yewu%'",'ARRAY_A');
					foreach($user_arr as $u){
						$userdata = get_userdata($u['user_id']);
						$username = $userdata->data->user_login;
						if($myrow->salesman==$u['user_id']){
							$selected="selected='selected'";
						}else{
							$selected="";
						}
						$salesman_option .= '<option value="'.$u['user_id'].'" '.$selected.'>'.$username.'</option>';
					}
					 
					$salesman_select = '<select name="salesman['.$checkid.']"><option value="0">空</option>'.$salesman_option.'</select>';;					$msg = '';
					if($myrow -> from_site)
						$msg =  $myrow -> from_site . '（'.$myrow -> from_name.'）';
					
					
					if (isset($myrow -> user_id) && $myrow -> user_id != '0')
						$userlink = '* ';
					
					if(current_user_can('supplier')){
						$detailMsg = 'View Details';
					}else{
						$detailMsg = '查看详情';
					}
					echo '<tr' . $alt . '>
										<td headers="line" id="numb' . $c . '">' . $myrow -> id . '</td>
										
										<td>' . $msg . '</td>
					<td headers="date numb' . $c . '">' . $thisdate . '</td>
					<td headers="customer numb' . $c . '">' . $myrow -> first_name . ' ' . stripslashes($myrow -> last_name) . $company . '' . $userlink . '(' . $myrow -> email . ')</td>
					<td headers="items numb' . $c . '">' . $ic . '</td>
					<td headers="price numb' . $c . '" class="right">' . sprintf(__('%1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($total, __('2', 'eshop'))) . '</td>
					<td headers="transid numb' . $c . '">' . $myrow -> transid . '</td>
					<td headers="customer numb' . $c . '"><a href="' . $phpself . '&amp;view=' . $myrow -> id . '" title="' . __($detailMsg, 'eshop') . '">'.$detailMsg.'</a></td>
					' . '<td style="padding:8px 0 0 16px;" headers="bulk numb' . $c . '"><label for="move' . $c . '">Move #' . $c . '</label><input type="checkbox" value="' . $checkid . '" name="move[]" id="move' . $c . '" />'
					 . "</td></tr>\n"; 
					// }
				} 
				echo "</tbody></table></div>\n"; 
				// paginate
				echo '<div class="paginate tablenav-pages stuffbox">';
				if ($records != $max) {
					$eecho = $page_links;
				} 
				echo sprintf('<span class="displaying-num">' . __('show： %s&#8211;%s of %s', 'eshop') . '</span>',
					number_format_i18n(($epage - 1) * $records + 1),
					number_format_i18n(min($epage * $records, $max)),
					number_format_i18n($max)
					);
				if (isset($eecho)) {
					$thispage = esc_url(add_query_arg('eshopall', 'yes', $_SERVER['REQUEST_URI']));
					echo "<ul class='page-numbers'>\n\t<li>" . join("</li>\n\t<li>", $eecho) . "</li>\n<li>" . '<a href="' . $thispage . '">' . __('显示所有订单', 'eshop') . '</a>' . "</li>\n</ul>\n";
				} 
				echo '<br /></div>'; 
				// end
				// moved order status box
				?>
				<fieldset id="changestat"><legend><?php if(current_user_can('supplier')){echo "Change the Status of Order";}else{ _e('切换订单状态', 'eshop');}?></legend>
				<p class="submit eshop"><label for="mark"><?php if(current_user_can('supplier')){echo "Change the Status of Order to";}else{_e('切换订单状态为：', 'eshop');}?></label>
				<select name="mark" id="mark">				<option value="Sent"><?php if(current_user_can('supplier')){echo "Shipped";}else{_e('已发货', 'eshop');}

				?></option>
				
				<option value="Completed"><?php if(current_user_can('supplier')){echo "Shipped";}else{_e('已发货', 'eshop');}

				?></option>

				<option value="Pending"><?php if(current_user_can('supplier')){echo "Unpaid Order";}else{_e('未付款', 'eshop');}

				?></option>

				<option value="Waiting"><?php if(current_user_can('supplier')){echo "Awaiting Payment";}else{_e('等待付款', 'eshop');}

				?></option>

				<option value="Failed"><?php if(current_user_can('supplier')){echo "Payment Failed";}else{_e('付款失败', 'eshop');}

				?></option>

				<option value="Deleted"><?php if(current_user_can('supplier')){echo "Recycle Bin";}else{_e('回收站', 'eshop');}

				?></option>
				</select>
				<input type="hidden" name="action" value="<?php echo $_GET['action'];
				?>" />
				<input type="hidden" name="change" value="yes" />
				<input type="submit" id="submit1" value="<?php if(current_user_can('supplier')){echo "Save";}else{_e('保存修改', 'eshop');}
				?>" /></p>
				</fieldset></form>
				<?php 
				// order status box code end
				if ($type == 'Deleted') {

					?>
				<div id="eshopformleft"><form id="ordersdelete" action="<?php echo esc_url($_SERVER['REQUEST_URI']);
					?>" method="post">
				<fieldset><legend><?php if(current_user_can('supplier')){echo "Delete the Order in Recycle Bin";}else{_e('删除回收站订单选择', 'eshop');}
					?></legend>
				<p class="submit eshop"><label for="dhours"><?php if(current_user_can('supplier')){echo "The Time of Ordering is";}else{_e('订单时间在： ', 'eshop');}
					?>
				<select name="dhours" id="dhours">
				<option value="72" selected="selected">72</option>
				<option value="36">48</option>
				<option value="24">24</option>
				<option value="16">16</option>
				<option value="8">8</option>
				<option value="4">4</option>
				<option value="0">0</option>
				</select> <?php if(current_user_can('supplier')){echo "Hour Ago";}else{_e('小时之前', 'eshop');}
					?></label><br />
				<input type="hidden" name="dall" value="yes" />				<?php if(current_user_can('supplier')){
					echo '<input type="submit" id="submit2" value="delete" /></p>';
				}else{
					echo '<input type="submit" id="submit2" value="删除" /></p>';
				}?>
				</fieldset></form></div>
			<?php
				} 
			} else {				if(current_user_can('supplier')){
					if ($type == 'Completed') {

					$disptype = __('Paid Order', 'eshop');

				} 

				if ($type == 'Sent') {

					$disptype = __('Shipped', 'eshop');

				} 

				if ($type == 'Waiting') {

					$disptype = __('Awaiting Payment', 'eshop');

				} 

				if ($type == 'Pending') {

					$disptype = __('Unpaid Order', 'eshop');

				} 

				if ($type == 'Deleted') {

					$disptype = __('Deleted', 'eshop');

				} 

				if ($type == 'Failed') {

					$disptype = __('Payment Failed', 'eshop');

				} 
				
				echo "<p class=\"notice\">";

				printf(__('no %s order.', 'eshop'), "<span>" . __($disptype, 'eshop') . "</span>");

				echo "</p>";
				}else{
				if ($type == 'Completed') {
					$disptype = __('付款成功', 'eshop');
				} 
				if ($type == 'Sent') {
					$disptype = __('已发货', 'eshop');
				} 
				if ($type == 'Waiting') {
					$disptype = __('等待付款', 'eshop');
				} 
				if ($type == 'Pending') {
					$disptype = __('未付款', 'eshop');
				} 
				if ($type == 'Deleted') {
					$disptype = __('已删除', 'eshop');
				} 
				if ($type == 'Failed') {
					$disptype = __('付款失败', 'eshop');
				} 				
				echo "<p class=\"notice\">";
				printf(__('无 %s 订单.', 'eshop'), "<span>" . __($disptype, 'eshop') . "</span>");
				echo "</p>";				}
			} 
		} 
	} 
	if (!function_exists('deleteorder')) {
		function deleteorder($delid) {
			global $wpdb;
			$dtable = $wpdb -> prefix . 'eshop_orders';
			$itable = $wpdb -> prefix . 'eshop_order_items';
			$dltable = $wpdb -> prefix . 'eshop_download_orders';
			$checkid = $wpdb -> get_var("Select checkid From $dtable where id='$delid' && status='Deleted'");
			$delquery2 = $wpdb -> get_results("DELETE FROM $itable WHERE checkid='$checkid'");
			$delquery = $wpdb -> get_results("DELETE FROM $dtable WHERE checkid='$checkid'");
			$delquery = $wpdb -> get_results("DELETE FROM $dltable WHERE checkid='$checkid'");

			echo '<div class="updated fade">' . __('That order has now been deleted from the system.', 'eshop') . '</div>';
		} 
	} 
	// sub sub menu - may change to a little form:
	$phpself = '?page=' . $_GET['page'];
	$dtable = $wpdb -> prefix . 'eshop_orders';
	$itable = $wpdb -> prefix . 'eshop_order_items';
	$stable = $wpdb -> prefix . 'eshop_states';
	$ctable = $wpdb -> prefix . 'eshop_countries';
	// $eshopoptions = get_option('eshop_plugin_settings');
	/**
	 * ##########
	 * ##########
	 */
	if ((isset($_GET['viewemail']) && is_numeric($_GET['viewemail'])) || isset($_POST['thisemail'])) {
		include 'eshop-email.php';
	} 
	
	elseif ((isset($_GET['printed']) && is_numeric($_GET['printed'])) || isset($_POST['thisemail'])) {
		include 'eshop-printed.php';
	} 

	
	else {
		// paypal tries upto 4 days after a transaction.
		$delit = 4;
		// $wpdb->query("UPDATE $dtable set status='Deleted' where status='Pending' && edited < DATE_SUB(NOW(), INTERVAL $delit DAY)");
		$updated_orders = $wpdb -> get_results("SELECT checkid FROM $dtable WHERE status='Pending' && edited < DATE_SUB(NOW(), INTERVAL $delit DAY)");
		if (count($updated_orders) > 0) {
			$wpdb -> query("UPDATE $dtable set status='Deleted' where status='Pending' && edited < DATE_SUB(NOW(), INTERVAL $delit DAY)");
			foreach($updated_orders as $updated_order) {
				do_action('eshop_order_status_updated', $updated_order -> checkid, 'Deleted');
			} 
		} 
		// try and move all orders that only have downloadable products
		$moveit = $wpdb -> get_results("Select checkid From $dtable where downloads='yes'");

		foreach($moveit as $mrow) {
			$pdownload = $numbrows = 0;
			$result = $wpdb -> get_results("Select down_id From $itable where checkid='$mrow->checkid' AND post_id!='0'");
			foreach($result as $crow) {
				// check if downloadable product
				if ($crow -> down_id != '0')
					$pdownload++;

				$numbrows++;
			} 
			if ($pdownload == $numbrows) {
				// in theory this will only activate if the order only contains downloads
				$wpdb -> query("UPDATE $dtable set status='Sent' where status='Completed' && checkid='$mrow->checkid'");
				do_action('eshop_order_status_updated', $mrow -> checkid, 'Sent');
			} 
		} 

		echo '<div class="wrap">';
		if (isset($_GET['view'])) {
			$view = $_GET['view'];
			$status = $wpdb -> get_var("Select status From $dtable where id='$view'");
			if ($status == 'Completed') {
				$status = __('Active Order', 'eshop');
			} 
			if ($status == 'Pending') {
				$status = __('Pending Order', 'eshop');
			} 
			if ($status == 'Waiting') {
				$status = __('Orders Awaiting Payment', 'eshop');
			} 
			if ($status == 'Sent') {
				$status = __('Shipped Order', 'eshop');
			} 
			if ($status == 'Deleted') {
				$status = __('Deleted Order', 'eshop');
			} 
			if ($status == 'Failed') {
				$status = __('Failed Order', 'eshop');
			} 
			$state = $status;
		} elseif (isset($_GET['action'])) {			if(current_user_can('supplier')){
				switch ($_GET['action']) {

				case 'Completed':

					$state = __('Paid Order', 'eshop');

					break;

				case 'Pending':

					$state = __('Unpaid Order', 'eshop');

					break;

				case 'Failed':

					$state = __('Payment Failed Order', 'eshop');

					break;

				case 'Waiting':

					$state = __('Awaiting Payment', 'eshop');

					break;

				case 'Sent':

					$state = __('Shipped Order', 'eshop');

					break;

				case 'Deleted':

					$state = __('Recycle Bin', 'eshop');

					break;

				default:

					break;

				} 
			}else{
				switch ($_GET['action']) {

				case 'Completed':

					$state = __('成功订单', 'eshop');

					break;

				case 'Pending':

					$state = __('未付款订单', 'eshop');

					break;

				case 'Failed':

					$state = __('付款失败订单', 'eshop');

					break;

				case 'Waiting':

					$state = __('等待付款', 'eshop');

					break;

				case 'Sent':

					$state = __('已发货订单', 'eshop');

					break;

				case 'Deleted':

					$state = __('回收站', 'eshop');

					break;

				default:

					break;

				} 
			}
		} else {
			die ('<h2 class="error">' . __('Error', 'eshop') . '</h2>');
		} 

		echo '<div id="eshopicon" class="icon32"></div><h2>' . $state . "</h2>\n";		if(!current_user_can('supplier')){
			eshop_admin_mode();		}
		if (isset($_GET['delid']) && !isset($_GET['view'])) {
			deleteorder($_GET['delid']);
			unset($_GET['view']);
			$_GET['action'] = $_POST['action'];
			$_GET['action'] = 'Deleted';
		} 
		if (isset($_POST['dall'])) {
			$dhours = $_POST['dhours'];
			if ($_POST['dhours'] == '0' || $_POST['dhours'] == '4' || $_POST['dhours'] == '8' || $_POST['dhours'] == '16' || $_POST['dhours'] == '24' || $_POST['dhours'] == '48' || $_POST['dhours'] == '72') {
				$delay = esc_sql($_POST['dhours']);
				$replace = $delay . __(' hours', 'eshop');
				if ($delay == 24) {
					$replace = __('1 day', 'eshop');
				} 
				$dtable = $wpdb -> prefix . 'eshop_orders';
				$itable = $wpdb -> prefix . 'eshop_order_items';
				$dltable = $wpdb -> prefix . 'eshop_download_orders';
				$myrows = $wpdb -> get_results("Select checkid From $dtable where status='Deleted' && edited < DATE_SUB(NOW(), INTERVAL $delay HOUR)");
				foreach($myrows as $myrow) {
					$checkid = $myrow -> checkid;
					do_action('eshop_order_delete', $checkid);
					$delquery2 = $wpdb -> query("DELETE FROM $itable WHERE checkid='$checkid'");
					$delquery = $wpdb -> get_results("DELETE FROM $dltable WHERE checkid='$checkid'");
					$query2 = $wpdb -> query("DELETE FROM $dtable WHERE status='Deleted' && checkid='$checkid' && edited < DATE_SUB(NOW(), INTERVAL $delay HOUR)");
				} 
				echo '<div class="updated fade">' . __('Deleted orders older than', 'eshop') . ' ' . $replace . ' ' . __('have now been <strong>completely</strong> deleted.', 'eshop') . '</div>';
			} else {
				echo '<p class="error">' . __('There was an error, and nothing has been deleted.', 'eshop') . '</p>';
			} 
		} 
		if (isset($_POST['mark']) && !isset($_POST['change'])) {
			$mark = $_POST['mark'];
			
			$checkid = $_POST['checkid'];
			$query2 = $wpdb -> get_results("UPDATE $dtable set status='$mark' where checkid='$checkid'");
			do_action('eshop_order_status_updated', $checkid, $mark);
			echo '<div class="updated fade">' . __('Order status changed successfully.', 'eshop') . '</div>';
		} 

		if (isset($_POST['change'])) {
			if (isset($_POST['move']) && $_POST['move'][0] != '') {
				foreach($_POST['move'] as $v => $ch) {
					$mark = $_POST['mark'];
					$salesman = $_POST['salesman'];
					$query2 = $wpdb -> get_results("UPDATE $dtable set status='$mark' ,salesman='$salesman[$ch]' where checkid='$ch'");
					do_action('eshop_order_status_updated', $ch, $mark);
				} 
				echo '<div class="updated fade"><p>' . __('Order status changed successfully.', 'eshop') . '</p></div>';
			} else {
				echo '<div class="error fade"><p>' . __('No orders were selected.', 'eshop') . '</p></div>';
			} 
		} 

		echo '<ul class="nav-tab-wrapper">';
		if (current_user_can('eShop_admin')){
			if(current_user_can('supplier')){
				$stati = array('Pending' => __('Unpaid Order', 'eshop'), 'Waiting' => __('Awaiting Payment', 'eshop'), 'Completed' => __('Paid Order', 'eshop'), 'Sent' => __('Shipped Order', 'eshop'), 'Failed' => __('Payment Failed Order', 'eshop'), 'Deleted' => __('Recycle Bin', 'eshop'));
			}else{
				$stati = array('Pending' => __('未付款订单', 'eshop'), 'Waiting' => __('等待付款', 'eshop'), 'Completed' => __('成功订单', 'eshop'), 'Sent' => __('已发货订单', 'eshop'), 'Failed' => __('付款失败订单', 'eshop'), 'Deleted' => __('回收站', 'eshop'));
			}
		}else{
			$stati = array();
		}
		$dtable = $wpdb -> prefix . 'eshop_orders';
		
		global $current_user;
		
		$sql = "SELECT COUNT( id ) as amt, status FROM $dtable WHERE id >0 ";
		
		if(current_user_can('supplier')){
			$sql .= " and from_id=$current_user->id";
		}
		
		$sql .= " GROUP BY status";
		$myres = $wpdb -> get_results($sql);
		
		foreach ($myres as $row) {
			$counted[$row -> status] = $row -> amt;
		} 

		foreach ($stati as $status => $label) {
			$class = '';
			if ($status == $action_status)
				$class = ' nav-tab-active';
			$cnt = '(0)';
			if (isset($counted[$status]))
				$cnt = '(' . $counted[$status] . ')';
			$status_links[] = '<li><a href="?page=eshop-orders.php&amp;action=' . $status . '" class="nav-tab' . $class . '">' . $label . ' <span class="count">' . $cnt . '</span></a>';
		} 
		echo implode('</li>', $status_links) . '</li>';
		echo '</ul><br class="clear" />';

		if (isset($_GET['view']) && is_numeric($_GET['view'])) {
			$view = esc_sql($_GET['view']);
			if (isset($_GET['adddown']) && is_numeric($_GET['adddown'])) {
				$dordtable = $wpdb -> prefix . 'eshop_download_orders';
				$adddown = esc_sql($_GET['adddown']);
				$wpdb -> query("UPDATE $dordtable SET downloads=downloads+1 where id='$adddown' limit 1");
				echo '<div class="updated fade"><p>' . __('Download allowance increased.', 'eshop') . '</p></div>';
			} 
			if (isset($_GET['decdown']) && is_numeric($_GET['decdown'])) {
				$dordtable = $wpdb -> prefix . 'eshop_download_orders';
				$decdown = esc_sql($_GET['decdown']);
				$wpdb -> query("UPDATE $dordtable SET downloads=downloads-1 where id='$decdown' limit 1");
				echo '<div class="updated fade"><p>' . __('Download allowance decreased.', 'eshop') . '</p></div>';
			} 
			$dquery = $wpdb -> get_results("Select * From $dtable where id='$view'");
			foreach($dquery as $drow) {
				$status = $drow -> status;
				$checkid = $drow -> checkid;
				$custom = $drow -> custom_field;
				$transid = $drow -> transid;
				$admin_note = htmlspecialchars(stripslashes($drow -> admin_note));
				$user_notes = htmlspecialchars(stripslashes($drow -> user_notes));
				$logistics_notes = htmlspecialchars(stripslashes($drow -> logistics_notes));
				$paidvia = $drow -> paidvia;
				$eshopaff = $drow -> affiliate;
				$amt_discount = $drow -> amt_discount;
			} 
			if(current_user_can('supplier')){
				if ($status == 'Completed') {

				$status = __('Paid Order', 'eshop');

			} 

			if ($status == 'Pending') {

				$status = __('Unpaid Order', 'eshop');

			} 

			if ($status == 'Sent') {

				$status = __('Shipped Order', 'eshop');

			} 

			if ($status == 'Waiting') {

				$status = __('Awaiting Payment Order', 'eshop');

			} 

			if ($status == 'Failed') {

				$status = __('Payment Failed Order', 'eshop');

			} 

			if ($status == 'Deleted') {

				$status = __('Deleted Order', 'eshop');

			} 
			}else{
				if ($status == 'Completed') {

				$status = __('成功订单', 'eshop');

			} 

			if ($status == 'Pending') {

				$status = __('未付款订单', 'eshop');

			} 

			if ($status == 'Sent') {

				$status = __('已发货订单', 'eshop');

			} 

			if ($status == 'Waiting') {

				$status = __('等待付款订单', 'eshop');

			} 

			if ($status == 'Failed') {

				$status = __('付款失败订单', 'eshop');

			} 

			if ($status == 'Deleted') {

				$status = __('已删除订单', 'eshop');

			} 
			}
			
			// moved order status box
			echo "<div id=\"eshopformfloat\"><form id=\"orderstatus\" action=\"" . $phpself . "\" method=\"post\">";

			?>
	<fieldset style="width:260px;padding:5px;">
	<div style="float:right;">
	<input type="submit" id="submit3" value="<?php  if(current_user_can('supplier')){echo "Save Changes";}else{_e('保存修改', 'eshop');}
			?>" /></div><label for="mark" style="padding:0 10px;"><?php if(current_user_can('supplier')){echo "Change Status";}else{ _e('修改状态:', 'eshop');}
			?></label>
	<select name="mark" id="mark">
	<option value="Sent"><?php if(current_user_can('supplier')){echo "Shipped";}else{_e('已发货', 'eshop');}
			?></option>
	<option value="Completed"><?php if(current_user_can('supplier')){echo "Paid Order";}else{_e('成功订单', 'eshop');}
			?></option>
	<option value="Waiting"><?php if(current_user_can('supplier')){echo " Awaiting Payment";}else{_e('等待付款', 'eshop');}
			?></option>
	<option value="Pending"><?php if(current_user_can('supplier')){echo "Unpaid Order";}else{_e('未付款订单', 'eshop');}
			?></option>
	<option value="Failed"><?php if(current_user_can('supplier')){echo "Payment Failed";}else{_e('付款失败', 'eshop');}
			?></option>
	<option value="Deleted"><?php if(current_user_can('supplier')){echo "Recycle Bin";}else{_e('回收站', 'eshop');}
			?></option>
	</select>
	<input type="hidden" name="action" value="<?php echo $_GET['action'];
			?>" />
	<input type="hidden" name="checkid" value="<?php echo $checkid;
			?>" />
	</fieldset></form></div>
	<?php 
				echo '';

			// order status box code end			if(current_user_can('supplier')){
				echo '<h3 class="status">

			<span>' . __('Order Number', 'eshop') . ' <small>:' . $view . '</small></span>  

			<span>Transaction ID: <small>' . $transid . '</small></span>  <br /> <br />

			<span>Status: ' . $status . '</span> 

			';
			}else{
				echo '<h3 class="status">

			<span>' . __('订单编号', 'eshop') . ' <small>:' . $view . '</small></span>  

			<span>支付交易ID:  <small>' . $transid . '</small></span>  <br /> <br />

			<span>状态: ' . $status . '</span> 

			';
			}
			
			$result = $wpdb -> get_results("Select * From $itable where checkid='$checkid' ORDER BY id ASC");
			$totaltax = $total = 0;
			$calt = 0;
			$currsymbol = $eshopoptions['currency_symbol'];

			?>


	<?php		if(current_user_can('supplier')){
			if ($admin_note != '') {
				echo '<span>Tracking Number: <small>';

				echo nl2br($admin_note) . '</small>' . "\n";

				echo '<a href="#eshop-anote">Change</a></span>  </h3>';

			} else {

				echo '<span><a href="#eshop-anote">Add Shipping Information</a></span></h3>';

			} 	
		}else{
			
			if ($admin_note != '') {
				echo '<span>运单号: <small>';
				echo nl2br($admin_note) . '</small>' . "\n";
				echo '<a href="#eshop-anote">修改</a></span>  </h3>';
			} else {
				echo '<span><a href="#eshop-anote">添加物流信息</a></span></h3>';
			} 		}

			?>
		<div class="orders tablecontainer">
	<table class="widefat">
	<thead>
	<tr>
	<th id="opname"><?php if(current_user_can('supplier')){echo "Product Name";}else{_e('产品名称', 'eshop');}
			?></th>
	<th id="oitem"><?php if(current_user_can('supplier')){echo "Product Parameter";}else{_e('产品参数', 'eshop');}
			?></th>
	<th id="oqty"><?php if(current_user_can('supplier')){echo "Quantity";}else{_e('数量', 'eshop');}
			?></th>
	<th id="oprice"><?php if(current_user_can('supplier')){echo "Total Price";}else{_e('总价', 'eshop');}
			?></th>
	<?php if (isset($eshopoptions['tax']) && $eshopoptions['tax'] == '1') : ?>
	<th id="otax"><?php if(current_user_can('supplier')){echo "Tax Rate";}else{_e('税率', 'eshop');}
			?></th>
	<th id="otaxamt"><?php if(current_user_can('supplier')){echo "Tax Amount";}else{_e('税额', 'eshop');}
			?></th>
	<?php endif;
			?>
	</tr>
	</thead>
	<tbody>
	<?php
	 
			foreach($result as $myrow) {
				$value = $myrow -> item_qty * $myrow -> item_amt;
				if (isset($eshopoptions['tax']) && $eshopoptions['tax'] == '1') {
					$linetax = '';
					if ($myrow -> tax_amt !== '' && is_numeric($myrow -> tax_amt)) {
						$linetax = $myrow -> tax_amt;
						$totaltax = $totaltax + $linetax;
					} 
				} else {
					if ($myrow -> tax_amt !== '' && is_numeric($myrow -> tax_amt)) {
						$value = $value + $myrow -> tax_amt;
					} 
				} 
				$eprodlink = $myrow -> post_id;
				$total = $total + $value;
				$itemid = $myrow -> item_id; 
				// diy_option
				if ($myrow -> diy_option != '') {
					$diy_option_v_arr = array();
					$diy_option_arr = explode(',', $myrow -> diy_option);
					$diy_option_str = '';
					$diy_option_price_totle = 0;
					foreach($diy_option_arr as $v) {
						$v_arr = explode(':', $v);
						$diy_option_name = $v_arr[0];
						$option_arr = explode('@', $v_arr[1]);
						$diy_option_v[$diy_option_name]['title'] = $option_arr[0];
						$diy_option_v[$diy_option_name]['price'] = $option_arr[1];
						$diy_option_price_totle += $option_arr[1];
						$diy_option_str .= '<strong>' . $diy_option_name . ':</strong>' . $diy_option_v[$diy_option_name]['title'] . ' <br />';
					} 
				} 
				// enfdiy_option
				if ($eprodlink != 0)
					$itemid = '' . $diy_option_str;

				if ($myrow -> optsets != '')
					$itemid .= '' . nl2br($myrow -> optsets) . ''; 
				// check if downloadable product
				$dordtable = $wpdb -> prefix . 'eshop_download_orders';
				$downstable = $wpdb -> prefix . 'eshop_downloads';
				$downloadable = '';
				if ($myrow -> down_id != '0') {
					// item is a download
					$dlinfo = $wpdb -> get_row("SELECT d.downloads, d.id FROM $dordtable as d, $downstable as dl WHERE d.checkid='$myrow->checkid' AND dl.id='$myrow->down_id' AND d.files=dl.files");
					if (isset($dlinfo -> downloads)) {
						$downloadable = '<span class="downprod">' . __('Yes - remaining:', 'eshop');
						$downloadable .= ' ' . $dlinfo -> downloads . '<a href="' . $phpself . '&amp;view=' . $view . '&amp;adddown=' . $dlinfo -> id . '" title="' . __('Increase download allowance by 1', 'eshop') . '">' . __('Increase', 'eshop') . '</a>, <a href="' . $phpself . '&amp;view=' . $view . '&amp;decdown=' . $dlinfo -> id . '" title="' . __('Decrease download allowance by 1', 'eshop') . '">' . __('Decrease', 'eshop') . '</a></span>';
					} else {
						$downloadable = __('Download Item Missing', 'eshop');
					} 
				} 
				// add in a check if postage here as well as a link to the product
				$showit = $myrow -> optname;
				$calt++;
				$alt = ($calt % 2) ? '' : ' class="alternate"';
                $change_shoping='';
				if($drow -> status=='Pending'||$drow -> status=='Waiting'){					if(current_user_can('supplier')){
						$change_shoping = '&nbsp;<form method="post" action="">Change to：<input type="text" id="" size="4" name="new_val"/><input type="hidden" id="" size="4" name="sid" value="'.$myrow ->id.'"/><input type="submit" id="" name="change_shoping" value="Change"/></form>';
					}else{
						$change_shoping = '&nbsp;<form method="post" action="">修改为：<input type="text" id="" size="4" name="new_val"/><input type="hidden" id="" size="4" name="sid" value="'.$myrow ->id.'"/><input type="submit" id="" name="change_shoping" value="修改"/></form>';
					}
					
				}
				
				echo '<tr' . $alt . '>
		<td id="onum' . $calt . '" headers="opname"><a target="_bank" href="' . get_permalink($eprodlink) . '" title="view">' . $showit . '</a></td>
		<td headers="oitem onum' . $calt . '">' . $itemid . '</td>
		<td headers="oqty onum' . $calt . '">' . $myrow -> item_qty . '</td>
		
		<td headers="oprice onum' . $calt . '" class="right">' . sprintf(__('%1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($value, __('2', 'eshop'))) . $change_shoping ."</td>\n";
				
				
				if (isset($eshopoptions['tax']) && $eshopoptions['tax'] == '1') {
					echo '<td headers="otax onum' . $calt . '" class="right">' . $myrow -> tax_rate . '</td>';
					$ectax = '';
					if ($linetax != '')
						$ectax = sprintf(__('%1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($linetax, __('2', 'eshop')));

					echo '<td headers="otaxamt onum' . $calt . '" class="right">' . $ectax . "</td>\n";
				} 
				echo "</tr>\n";
			} 
			if ($transid == __('Processing&#8230;', 'eshop')){
				if(current_user_can('supplier')){
					echo "<tr><td colspan=\"3\" class=\"totalr\">" . __('Total &raquo;', 'eshop') . " <div style='float:right;'><input type='hidden' id='order_id' size='4' name='order_id' value='" . $view . "'/>Change Price = Total Price (including shipping fee) * <input type='text' id='amt_discount' size='8' name='amt_discount' value='" . $amt_discount . "'/> <input type='button' id='change_total' name='change_total' value='Change Now' /></div></td><td class=\"total\">" . sprintf(__('%1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($total, __('2', 'eshop'))) . "</td>";
				}else{
					echo "<tr><td colspan=\"3\" class=\"totalr\">" . __('Total &raquo;', 'eshop') . " <div style='float:right;'><input type='hidden' id='order_id' size='4' name='order_id' value='" . $view . "'/>修改价格 = 总价(包含运费) * <input type='text' id='amt_discount' size='8' name='amt_discount' value='" . $amt_discount . "'/> <input type='button' id='change_total' name='change_total' value='立即修改' /></div></td><td class=\"total\">" . sprintf(__('%1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($total, __('2', 'eshop'))) . "</td>";
				}
			}else{
				echo "<tr><td colspan=\"3\" class=\"totalr\">" . sprintf(__('Total paid via %1$s &raquo;', 'eshop'), ucfirst($paidvia)) . " </td><td class=\"total\">" . sprintf(__('%1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($total, __('2', 'eshop'))) . "</td>\n";
			}
			if (isset($eshopoptions['tax']) && $eshopoptions['tax'] == '1') {
				echo '<td class="totalr">' . __('Total Tax &raquo;', 'eshop') . '</td>';
				echo '<td class="total">' . sprintf(__('%1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($totaltax, __('2', 'eshop'))) . "</td>\n";
				$totalwithtax = $total + $totaltax;
				echo '</tr>
		<tr><td colspan="6" class="totalr">' . __('Total with tax &raquo;', 'eshop') . '</td><td class="total">' . sprintf(__('%1$s%2$s', 'eshop'), $currsymbol, number_format_i18n($totalwithtax, __('2', 'eshop'))) . "</td>\n";
			} 
			echo "</tr></tbody></table>\n";

			$thisdate = eshop_real_date($custom);			if(current_user_can('supplier')){
				echo "" . __('<input id="btnPrint" style="height:30px;" value="Print the Order" type="button" onclick="btnPrintClick()";/>
     				<br /><hr><!--startprint1--><strong>Time of Order：</strong>', 'eshop') . " " . $thisdate . ".";
			}else{
				echo "" . __('<input id="btnPrint" style="height:30px;" value="订单打印" type="button" onclick="btnPrintClick()";/>
     				<br /><hr><!--startprint1--><strong>订单时间：</strong>', 'eshop') . " " . $thisdate . ".";
			}
			
			if ($eshopaff != '') echo '<br />' . __('Affiliate Reference:', 'eshop') . ' <strong>' . $eshopaff . '</strong>';
			echo "\n</div>\n";
			if ($drow -> reference != '') {
				echo '<p><strong>' . __('Customer reference:', 'eshop') . '</strong> ' . $drow -> reference . '</p>';
			} 
			echo "<div class=\"\">";
			foreach($dquery as $drow) {
				$userlink = '';
				if (isset($drow -> user_id) && $drow -> user_id != '0')				if(current_user_can('supplier')){
					$userlink = '';
				}else{
					$userlink = ' (<a href="user-edit.php?user_id=' . $drow -> user_id . '" title="' . esc_attr(sprintf(__('Profile for %1$s', 'eshop'), $drow -> first_name . ' ' . stripslashes($drow -> last_name))) . '" class="eshop-userlink">*注册用户</a>)';
				}

									echo '<div style="float:right;width:55%;padding-top:0px;"> <strong>Shipping to: </strong>';
					$address = $drow -> address1;
					if ($drow -> address2 != '') $address .= ', ' . $drow -> address2;

					if ($drow -> company != '') echo __("Company: ", 'eshop') . $drow -> company . "";
					echo '<br/><b>Address: </b>' . $address . "<br/>";
					echo '<b>City: </b>' . $drow -> city . "  ";
					echo '<b>State: </b>' . $drow -> state . "  ";
					echo '<b>Zip: </b>' . $drow -> zip . "  ";

					$qcode = esc_sql($drow -> country);
					$qcountry = $wpdb -> get_var("SELECT country FROM $ctable WHERE code='$qcode' limit 1");
					$countryzone = $wpdb -> get_var("SELECT zone FROM $ctable WHERE code='$qcode' limit 1");
					echo '<b>Country: </b>' .$qcountry . "";
					/**
					 * if($eshopoptions['shipping_zone']=='country'){
					 * $qzone=$countryzone;
					 * }else{
					 * $qzone=$statezone;
					 * if($statezone=='') $qzone=$eshopoptions['unknown_state'];
					 * }
					 * echo '<p>'.__('Shipping Zone: ','eshop')."<strong>".$qzone."</strong></p>
					 */
					echo "</div>\n";
									if(current_user_can('supplier')){
					echo '<p><strong>' . __('Email:', 'eshop') . '</strong>' . $drow -> email . "<br />\n";
				}else{
					echo '<p><strong>' . __('Email:', 'eshop') . '</strong>' . " <a href=\"" . $phpself . "&amp;viewemail=" . $view . "\" title=\"" . __('Send a form email', 'eshop') . "\">" . $drow -> email . '</a> <small style="color:red;font-size:12px;">' . __('<< 发送邮件') . "</small><br />\n";
				}
				
				echo '<strong>' . __("Name: ", 'eshop') . '</strong>' . $drow -> first_name . " " . stripslashes($drow -> last_name) . $userlink . "<br />\n";
				if ($drow -> company != '') echo '<strong>' . __("Company: ", 'eshop') . '</strong>' . $drow -> company . "<br />\n";
				if ('no' == $eshopoptions['downloads_only']) {
					echo '<strong>' . __("Phone: ", 'eshop') . '</strong>' . $drow -> phone . "</p>\n";

					echo "</div>\n";
					if ($drow -> ship_name != '' && $drow -> ship_address != '' && $drow -> ship_city != '' && $drow -> ship_postcode != '') {
						echo "<div style=\"display:none;\" class=\"shippingaddress\"><h4>" . __('Shipping', 'eshop') . "</h4>";
						echo '<p><strong>' . __("Name: ", 'eshop') . '</strong>' . stripslashes($drow -> ship_name) . "<br />\n";
						if ($drow -> ship_company != '') echo '<strong>' . __("Company: ", 'eshop') . '</strong>' . $drow -> ship_company . "<br />\n";
						echo '<strong>' . __("Phone: ", 'eshop') . '</strong>' . $drow -> ship_phone . "</p>\n";
						echo '<h5>' . __('Address', 'eshop') . '</h5>';
						echo '<address>' . stripslashes($drow -> ship_name) . '<br />' . "\n";
						if ($drow -> ship_company != '') echo $drow -> ship_company . "<br />\n";
						echo $drow -> ship_address . "<br />\n";
						echo $drow -> ship_city . "<br />\n";
						$qcode = esc_sql($drow -> ship_state);
						$qstate = $wpdb -> get_var("SELECT stateName FROM $stable WHERE id='$qcode' limit 1");
						if ($qstate != '') {
							$statezone = $wpdb -> get_var("SELECT zone FROM $stable WHERE id='$qcode' limit 1");
							echo $qstate . "<br />";
						} else {
							echo $drow -> ship_state . "<br />";
						} 
						echo $drow -> ship_postcode . "<br />\n";
						$qcode = esc_sql($drow -> ship_country);
						$qcountry = $wpdb -> get_var("SELECT country FROM $ctable WHERE code='$qcode' limit 1");
						$countryzone = $wpdb -> get_var("SELECT zone FROM $ctable WHERE code='$qcode' limit 1");
						echo $qcountry . "</address>";
						/**
						 * if($eshopoptions['shipping_zone']=='country'){
						 * $qzone=$countryzone;
						 * }else{
						 * $qzone=$statezone;
						 * if($statezone=='') $qzone=$eshopoptions['unknown_state'];
						 * }
						 * echo '<p>'. __('Shipping Zone:','eshop')." <strong>".$qzone."</strong></p>
						 */
						echo "</div><!--endprint1-->\n";
					} 
				} else {
					echo '</p></div>';
				} 

				do_action('eshopshowdetails', $drow);
				echo '<hr class="eshopclear" />';
				if ($drow -> thememo != '') {
					echo '<div class="paypalmemo"><h4>' . __('Customer paypal memo:', 'eshop') . '</h4><p>' . nl2br($drow -> thememo) . '</p></div>';
				} 

				if ($drow -> comments != '') {
					echo '<div class="eshopmemo"><h4>' . __('Customer order comments:', 'eshop') . '</h4><p>' . nl2br($drow -> comments) . '</p></div>';
				} 
				if ($drow -> thememo != '' || $drow -> comments != '') {
					echo '<hr class="eshopclear" />';
				} 
			} 
			// admin note form goes here
			?><hr>
	<form method='post' action="" id="eshop-anote"><fieldset>
	<p><label for="eshop-adnote"><b style="color:#ff0000;"><?php if(current_user_can('supplier')){echo " Shipping Information（after shipped,pls add tracking number,E.g: DHL 28174192)";}else{echo "物流信息(发货后，请填写单号，如:  DHL 28174192)";}?> </b></label><br />
	<textarea rows="2" cols="30" id="eshop-logisticsnote" name="eshop-logisticsnote"><?php echo $logistics_notes;
			?></textarea></p>
			
			<p><label for="eshop-adnote"><b style="color:#ff0000;"><?php if(current_user_can('supplier')){echo "Administrator Remark";}else{echo "管理员备注";}?></b></label><br />
	<textarea rows="2" cols="30" id="eshop-adnote" name="eshop-adnote"><?php echo $admin_note;
			?></textarea></p>
	<?php
			if (isset($eshopoptions['users']) && $eshopoptions['users'] == 'yes') {

				?>
	<p><label for="eshop-unote"><?php if(current_user_can('supplier')){echo "The Tracking Number will Appear in Buyer's 'My Order' Page";}else{_e('订单物流编号会显示在客户My order界面', 'eshop');}
				?></label><br />
	<textarea rows="5" cols="80" id="eshop-unote" name="eshop-unote"><?php echo $user_notes;
				?></textarea></p>
	<?php
			} 

			?>
	<p class="submit eshop"><input type="submit" class="button-primary" value="<?php if(current_user_can('supplier')){echo "Save Update";}else{echo "保存更新";}?>" name="submit" /></p>
	</fieldset>
	</form>
	<?php
			if ($status == 'Deleted') {
				$delete = "<p class=\"delete noprint\"><a href=\"" . $phpself . "&amp;delid=" . $view . "\">" . __('Completely delete this order?', 'eshop') . "</a><br />" . __('<small><strong>Warning:</strong> this order will be completely deleted and cannot be recovered at a later date.</small>', 'eshop') . "</p>";
			} else {
				$delete = '';
			} ;
			echo $delete;
		} else {
			if (empty($_GET['action'])) $_GET['action'] = 'Completed';
			switch ($_GET['action']) {
				case 'Completed':
					displayorders('Completed', apply_filters('eshop-orders-orderby-completed', 'da'));
					break;
				case 'Failed':
					displayorders('Failed', apply_filters('eshop-orders-orderby-failed', 'dd'));
					break;
				case 'Waiting':
					displayorders('Waiting', apply_filters('eshop-orders-orderby-waiting', 'da'));
					break;
				case 'Sent':
					displayorders('Sent', apply_filters('eshop-orders-orderby-sent', 'dd'));
					break;
				case 'Deleted':
					displayorders('Deleted', apply_filters('eshop-orders-orderby-deleted', 'dd'));
					break;
				case 'Pending':
				default:
					displayorders('Pending', apply_filters('eshop-orders-orderby-pending', 'da'));
					break;
			} 
		} 

		echo '<br class="clearbr" />&nbsp;</div>';
	} 

	?>
<script>
$(document).ready(function(){
   $('#change_total').click(function(){
	   var id = $('#order_id').val();
	   var amt_discount = $('#amt_discount').val();
       $.post("/wp-admin/admin-ajax.php?action=change_total", { id: id, amt_discount: amt_discount },
		   function(data){
			 if(data==1){
				 location.reload();
			 }else{
				 alert('Modify failed');
			 }
		 });
    })
});
</script>
<script>function btnPrintClick(){
		window.print();
	}
	</script>