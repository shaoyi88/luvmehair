<?php
if ('eshop-discount-codes.php' == basename($_SERVER['SCRIPT_FILENAME']))
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

function eshop_discounts_manager() {
	global $wpdb;
	include_once(ESHOP_PATH.'cart-functions.php');
	$legtext=__('增加优惠卷代码','eshop'); 
	$subtext=__('提交','eshop');
	$edit=false;
	$phpself='admin.php?page=eshop-discount-codes.php';
	$disctable=$wpdb->prefix.'eshop_discount_codes';
	//blank - will change as we check things
	$eshop_code=$eshop_percent=$eshop_remain=$eshop_used=$eshop_live=$eshop_free_ship=$eshop_code_date=$eshop_code_type='';
	$editid='0';
	//delete
	if(isset($_GET['delcode']) && is_numeric($_GET['delcode'])){
		$id=$_GET['delcode'];
		$wpdb->query("DELETE FROM $disctable WHERE id='$id' limit 1");
		echo '<div class="updated fade"><p>'.__('Discount code deleted.','eshop').'</p></div>';
	}
	
	//edit
	if(isset($_GET['editcode']) && is_numeric($_GET['editcode'])){
		$editid=$_GET['editcode'];
		$row=$wpdb->get_row("SELECT * FROM $disctable WHERE id='$editid'");
		$eshop_code=$row->disccode;
		$eshop_code_type=$row->dtype;
		$eshop_percent=$row->percent;
		$eshop_remain=$row->remain;
		$eshop_used=$row->used;
		$eshop_live=$row->live;
		$eshop_code_date=$row->enddate;
		if($eshop_code_date=='0000-00-00')
			$eshop_code_date='';
		$edit=true;
		$legtext=__('修改 优惠券 方案','eshop'); 
		$subtext=__('保存更新','eshop');
	}
	//new or edit
	
	if(isset($_POST['editid'])){
		$eshop_id=esc_sql(trim($_POST['editid']));
		if(isset($_POST['eshop_live']))
			$eshop_live='yes';
		else
			$eshop_live='no';
		if(isset($_POST['eshop_code_type']))
			$eshop_code_type=$_POST['eshop_code_type'];
		else
			$eshop_code_type='';
		if(isset($_POST['eshop_percent']))
			$eshop_percent=$_POST['eshop_percent'];
		else
			$eshop_percent='';
		$eshop_code_month=$_POST['eshop_code_month'];
		$eshop_code_day=$_POST['eshop_code_day'];
		$eshop_code_year=$_POST['eshop_code_year'];
		//error check - first check if discount
		switch($eshop_code_type){
			case '':
				$error[]=__('You must choose a discount code type','eshop');
				break;
			case '1':
			case '2':
			case '3':
				if(!is_numeric($eshop_percent) || $eshop_percent>100)
					$error[]=__('Percentage must be a number no greater than 100.00','eshop');
				elseif($eshop_percent<=0)
					$error[]=__('Percentage must be a number above 0','eshop');
				break;
		}
		//error check if date is required it must be valid
		switch($eshop_code_type){
			case '2':
			case '3':
			case '5':
			case '6':
				if(!checkdate($eshop_code_month, $eshop_code_day, $eshop_code_year))
					$error[]=__('The date you have chosen is not valid','eshop');
				break;
		}
		//standard errors
		if(isset($_POST['eshop_code']))
			$eshop_code=$_POST['eshop_code'];
		else
			$eshop_code=='';
			
		if($eshop_code=='')
			$error[]=__('You must specify a code','eshop');
		
		if($eshop_code!=''){
			$ecode=esc_sql(trim(strtolower($eshop_code)));
			$ecount=$wpdb->get_var("SELECT COUNT(id) FROM $disctable WHERE LOWER(disccode)='$ecode' && id!='$eshop_id'");
			if($ecount!=0)
				$error[]=__('That code already exists','eshop');
		}
		
		if(isset($_POST['eshop_remain']))
			$eshop_remain=$_POST['eshop_remain'];
		else
			$eshop_remain='';
			
		if((!is_numeric($eshop_remain) || $eshop_remain<0) && $eshop_remain!='')
			$error[]=__('How many times can this be used - must be numeric, or blank','eshop');
		
		if(isset($error)){
			echo '<div class="error fade"><p>'.__('There were some errors:','eshop').'</p>';
			echo '<ul>';
			foreach($error as $err)
				echo '<li>'.$err."</li>\n";
			echo "</ul></div>\n";
		}else{
			//no errors!
			//create date
			$eshop_code_date=$eshop_code_year.'-'.$eshop_code_month.'-'.$eshop_code_day;
			$eshop_id=trim($_POST['editid']);
			$eshop_code=stripslashes(trim($_POST['eshop_code']));
			$eshop_percent=$_POST['eshop_percent'];
			$eshop_remain=$_POST['eshop_remain'];
			$eshop_code_type=$_POST['eshop_code_type'];
			$eshop_code_month=trim($_POST['eshop_code_month']);
			$eshop_code_day=trim($_POST['eshop_code_day']);
			$eshop_code_year=trim($_POST['eshop_code_year']);
			if($eshop_id!='0'){
				//edit
				//$wpdb->query($wpdb->prepare("UPDATE $stocktable set available=$meta_value where post_id=$id"));

				$query="UPDATE $disctable SET 
				dtype=%s, 
				disccode=%s,
				percent=%s,
				remain=%s,
				enddate=%s,
				live=%s
				WHERE id=%d limit 1";
				$wpdb->query($wpdb->prepare($query,$eshop_code_type,$eshop_code,$eshop_percent,$eshop_remain,$eshop_code_date,$eshop_live,$eshop_id));
				echo '<div class="updated fade"><p>'.__('Discount code details updated','eshop').'</p></div>';
			}else{
				//new
				$query="INSERT INTO $disctable 
				(dtype,disccode,percent,remain,enddate,live)
				VALUES
				(%s,%s,%s,%d,%s,%s)";
				$wpdb->query($wpdb->prepare($query,$eshop_code_type,$eshop_code,$eshop_percent,$eshop_remain,$eshop_code_date,$eshop_live));
				echo '<div class="updated fade"><p>'.__('Discount code details entered','eshop').'</p></div>';
				//resetvalues
				$eshop_code=$eshop_percent=$eshop_remain=$eshop_used=$eshop_live=$eshop_free_ship=$eshop_code_date=$eshop_code_type='';
				$editid='0';
			}
		}
	}
	//for display:
	$eshop_code=esc_html((stripslashes(trim($eshop_code))),'1');


	?>
	<div class="wrap">
	<div id="eshopicon" class="icon32"></div><h2><?php _e('折扣代码设置','eshop'); ?></h2>
	<?php eshop_admin_mode(); ?>
	<div id="eshopdisccodesform">
	<?php echo $eshop_suggest; ?>
	<form id="eshopdisccodes" action="<?php echo esc_url($_SERVER['REQUEST_URI']);?>" method="post">
		<fieldset><legend><?php echo $legtext; ?></legend>
			<p><label for="eshop_code_type"><?php _e('折扣方案','eshop'); ?></label>
			<select name="eshop_code_type" id="eshop_code_type">
		   	<option value=""><?php _e('请选择方案','eshop'); ?></option>
		   	<optgroup label="<?php _e('百分比折扣','eshop'); ?>">
			<option value="1"<?php echo $eshop_code_type=='1' ? ' selected="selected"' : ''; ?>><?php _e('%  & 限制使用次数','eshop'); ?></option>
			<option value="2"<?php echo $eshop_code_type=='2' ? ' selected="selected"' : ''; ?>><?php _e('%  & 限制时间','eshop'); ?></option>
			<option value="3"<?php echo $eshop_code_type=='3' ? ' selected="selected"' : ''; ?>><?php _e('%  & 同时限制使用次数及时间','eshop'); ?></option>
			</optgroup>
			<optgroup label="<?php _e('Free Shipping','eshop'); ?>">
			<option value="4"<?php echo $eshop_code_type=='4' ? ' selected="selected"' : ''; ?>><?php _e('Free Ship - 限制使用次数','eshop'); ?></option>
			<option value="5"<?php echo $eshop_code_type=='5' ? ' selected="selected"' : ''; ?>><?php _e('Free Ship - 限制时间','eshop'); ?></option>
			<option value="6"<?php echo $eshop_code_type=='6' ? ' selected="selected"' : ''; ?>><?php _e('Free Ship - 同时限制使用次数及时间','eshop'); ?></option>
			</optgroup>


			<optgroup label="<?php _e('立减','eshop'); ?>">
			<option value="7"<?php echo $eshop_code_type=='7' ? ' selected="selected"' : ''; ?>><?php _e('立减 - 限制使用次数','eshop'); ?></option>
			<option value="8"<?php echo $eshop_code_type=='8' ? ' selected="selected"' : ''; ?>><?php _e('立减 - 限制时间','eshop'); ?></option>
			<option value="9"<?php echo $eshop_code_type=='9' ? ' selected="selected"' : ''; ?>><?php _e('立减 - 同时限制使用次数及时间','eshop'); ?></option>
			</optgroup>



			</select></p>
			<p><label for="eshop_code"><?php _e('代码： (例如：15OFF ,可以对应方案15%的优惠 - 在购物流程中输入此代码后即可享受本方案的折扣)','eshop'); ?></label><br />
			<input type="text" id="eshop_code" name="eshop_code" size="30" value="<?php echo $eshop_code; ?>" /></p>
			<p><label for="eshop_percent"><?php _e('折扣百分比/立减金额$ (均针对于单个产品)','eshop'); ?></label><br />
			<input type="text" id="eshop_percent" name="eshop_percent" size="4" value="<?php echo $eshop_percent; ?>" /></p>
			<p><label for="eshop_remain"><?php _e('使用次数 (留空不限制, 同一用户可用多次)','eshop'); ?></label><br />
			<input type="text" id="eshop_remain" name="eshop_remain" size="4" value="<?php echo $eshop_remain; ?>" /></p>
			<fieldset><legend><?php _e('失效时间','eshop'); ?></legend>
			<p><label for="eshop_code_year"><?php _e('Year','eshop'); ?></label>
				<select name="eshop_code_year" id="eshop_code_year">
				<?php
				// work this out!!!
				$eshopdate=date('Y-m-d',mktime(0, 0, 0, date("m") , date("d"), date("Y")));
				if($eshop_code_date!='')
					$eshopdate=$eshop_code_date;

				list($eshop_code_year, $eshop_code_month, $eshop_code_day) = explode('-', $eshopdate);


				for($i=date('Y');$i<=date('Y')+5;$i++){
					if($i==$eshop_code_year){
						$sel=' selected="selected"';
					}else{
						$sel='';
					}
					echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>'."\n";
				}
				?>
			  </select>
				<label for="eshop_code_month"><?php _e('Month','eshop'); ?></label>

				  <select name="eshop_code_month" id="eshop_code_month">
				<?php

				for($i=1;$i<=12;$i++){
					if($i==$eshop_code_month){
						$sel=' selected="selected"';
					}else{
						$sel='';
					}
					echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>'."\n";
				}
				?>
			  </select>
				<label for="eshop_code_day"><?php _e('Day','eshop'); ?></label>

				  <select name="eshop_code_day" id="eshop_code_day">
				<?php

				for($i=1;$i<=31;$i++){
					if($i==$eshop_code_day){
						$sel=' selected="selected"';
					}else{
						$sel='';
					}
					echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>'."\n";
				}
				?>
	 			</select></p>
	 		</fieldset>
			<p><input id="eshop_live" name="eshop_live" value="yes"<?php echo $eshop_live=='yes' ? ' checked="checked"' : ''; ?> type="checkbox" /> <label for="eshop_live" class="selectit"><?php _e('启用?','eshop'); ?></label></p>
			<input type="hidden" name="editid" value="<?php echo $editid; ?>" />
			</fieldset>
			<p class="submit eshop"><input type="submit" id="submit" class="button-primary" value="<?php echo $subtext; ?>" /></p>
		</form>
	</div>
	<?php
	$max = $wpdb->get_var("SELECT COUNT(id) FROM $disctable WHERE id > 0");
	if($max>0){
		?>
		<div id="eshopdisccodesexisting">
		<h3><?php _e('已设置 优惠券','eshop'); ?></h3>
		<table class="widefat">
		<thead>
		<tr>
		<th id="code"><?php _e('代码','eshop'); ?></th>
		<th id="disc"><?php _e('折扣/立减','eshop'); ?></th>
		<th id="type"><?php _e('方案','eshop'); ?></th>
		<th id="remain"><?php _e('剩余使用数量','eshop'); ?></th>
		<th id="enddate"><?php _e('失效时间','eshop'); ?></th>
		<th id="used"><?php _e('使用次数','eshop'); ?></th>
		<th id="active"><?php _e('启用?','eshop'); ?></th>
		<th id="delete"><?php _e('删除','eshop'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php
		$row=$wpdb->get_results("SELECT * FROM $disctable");
		$calt=0;
		foreach($row as $myrow){
			$calt++;
			$alt = ($calt % 2) ? '' : ' class="alternate"';
			$delete='';
			$remain=$myrow->remain;
			if($myrow->remain=='')
				$remain=__('未限制','eshop');
			if($myrow->live!='yes')
				$delete='<a href="'.$phpself.'&amp;delcode='.$myrow->id.'">'.__('Delete','eshop').' '.$myrow->disccode.'</a>';
			$eshopdate=$myrow->enddate;
			//add in check to see if used.
			switch($myrow->dtype){
				case '1':
					$type=__('%  - 限制使用次数','eshop');
				    $t=__('%','eshop');
					$eshopdate=__('未限制','eshop');
					break;
				case '2':
					$type=__('%  - 限制时间','eshop');
				     $t=__('%','eshop');
					break;
				case '3':
					$type=__('%  - 同时限制使用次数及时间','eshop');
				    $t=__('%','eshop');
					break;
				case '4':
					$type=__('Free Ship - 限制使用次数','eshop');
				    $t=__('%','eshop');
					$eshopdate=__('Not applicable','eshop');
					break;
				case '5':
					$type=__('Free Ship - 限制时间','eshop');
				    $t=__('%','eshop');
					break;
				case '6':
					$type=__('Free Ship - 同时限制使用次数及时间','eshop');
				    $t=__('%','eshop');
					break;
				case '7':
					$type=__('立减 - 限制使用次数','eshop');
				    $t1=__('$','eshop');
					$t=__('','eshop');
					$eshopdate=__('Not applicable','eshop');
					break;
				case '8':
					$type=__('立减 - 限制时间','eshop');
				    $t1=__('$','eshop');
					$t=__('','eshop');
					break;
				case '9':
					$type=__('立减 - 同时限制使用次数及时间','eshop');
				    $t1=__('$','eshop');
					$t=__('','eshop');
					break;
			}
	
			echo '<tr'.$alt.'>
			<td headers="code" id="numb'.$calt.'"><a href="'.$phpself.'&amp;editcode='.$myrow->id.'" title="'.__('Edit this discount','eshop').'">'.$myrow->disccode.'</a></td>
			<td headers="disc numb'.$calt.'">'.$t1.number_format_i18n($myrow->percent,2).$t.' </td>
			<td headers="type numb'.$calt.'">'.$type.'</td>
			<td headers="remain numb'.$calt.'">'.$remain.'</td>
			<td headers="enddate numb'.$calt.'">'.$eshopdate.'</td>
			<td headers="used numb'.$calt.'">'.$myrow->used.'</td>
			<td headers="active numb'.$calt.'">'.$myrow->live.'</td>
			<td headers="delete numb'.$calt.'">'.$delete.'</td>'

			."</tr>\n";
		}
		echo "</tbody></table></div>\n";
	}
	?>
	</div>
	<?php
}
?>