<?php
if ('eshop-shipping.php' == basename($_SERVER['SCRIPT_FILENAME']))
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
global $wpdb,$eshopoptions;
//had to recreate these 2 functions here - the include didn't work!
//sanitises input array!
if (!function_exists('sanitise_this')) {
	function sanitise_this($array) {
		return is_array($array) ? array_map('sanitise_this', $array) : esc_html($array);
	}
}


if (isset($_GET['eshopaction']) )
	$action_status = esc_attr($_GET['eshopaction']);
else
	$_GET['eshopaction']=$action_status = 'shipping';


// for what was the US state list - ensures the menu is changed 
$dtable=$wpdb->prefix.'eshop_states';

if(isset($_POST['submitstate'])){
	$eshopoptions = get_option('eshop_plugin_settings');
	$eshopoptions['shipping_state']=esc_sql($_POST['eshop_shipping_state']);
	if(!isset($_POST['eshop_show_allstates']))$_POST['eshop_show_allstates']='0';
	$eshopoptions['show_allstates']=esc_sql($_POST['eshop_show_allstates']);
	update_option('eshop_plugin_settings',$eshopoptions);

}

$echosub= '<ul class="nav-tab-wrapper">';
$stati=array('shipping'=>__('运费设置','eshop'),'countries' => __('国家/分区设置','eshop'),'states'=>$eshopoptions['shipping_state'].' '.__('州/市/县设置','eshop'));
foreach ( $stati as $status => $label ) {
	$class = '';
	if ( $status == $action_status )
		$class = ' nav-tab-active';

	$status_links[] = '<li><a href="?page=eshop-shipping.php&amp;eshopaction='.$status.'" class="nav-tab'.$class.'">' . $label . '</a>';
}
$echosub.= implode('</li>', $status_links) . '</li>';
$echosub.= '</ul><br class="clear " />';



switch ($_GET['eshopaction']){
case ('countries'):
	$dtable=$wpdb->prefix.'eshop_countries';
	$error='';
	if(isset($_POST['submit'])){
		//sanitise for display purposes.
		$_POST['code']=sanitise_this($_POST['code']);
		$_POST['country']=sanitise_this($_POST['country']);
		$_POST['zone']=sanitise_this($_POST['zone']);
		$eshoptestarray=array();
		//create the query
		$build="INSERT INTO $dtable (`code`,`country`,`zone`,`list`) VALUES";
		$count=count($_POST['code']);
		$inlinecount=0;
		for($i=0;$i<=$count-1;$i++){
			//so if none of them are empty
			if(($_POST['code'][$i]!='' && $_POST['country'][$i]!='' && $_POST['zone'][$i]!='') && !isset($_POST['delete'][$i])){
			//complicated error checking - cannot check state name so easily
				if(!in_array($_POST['code'][$i],$eshoptestarray)){ //testing for duplicates
					$eshoptestarray[]=$_POST['code'][$i];
					if(isset($_POST['list'][$i]))
						$list[$i]='0';
					else
						$list[$i]='1';

					if(!preg_match("/[A-Z]/", $_POST['code'][$i])){
						$error.="<li>".__('Code:','eshop').$_POST['code'][$i]." ".__('is not valid.','eshop')." ".__('State:','eshop').$_POST['country'][$i].",".__('Zone:','eshop').$_POST['zone'][$i]."</li>\n";
					}elseif(!preg_match("/[0-9]/", $_POST['zone'][$i]) || strlen($_POST['zone'][$i])!='1'){
						$error.="<li>".__('Zone:','eshop').$_POST['zone'][$i]." ".__('is not valid.','eshop')." ".__('Code:','eshop').$_POST['code'][$i].", ".__('State:','eshop').$_POST['country'][$i]."</li>\n";
					}else{
						//all must be ok
						$inlinecount++;
						$build.=" ('".esc_sql($_POST['code'][$i])."','".esc_sql($_POST['country'][$i])."','".esc_sql($_POST['zone'][$i])."','".esc_sql($list[$i])."'),";
					}
				}
			}elseif($_POST['code'][$i]=='' && $_POST['country'][$i]=='' && $_POST['zone'][$i]==''){
				//ie no new state added
				//had to put this line here as I don't know where else it should go!
				//it hides the additional input if it wasn't used.
			}elseif(!isset($_POST['delete'][$i])){
				//if not set for deletion then there was an error
				$error.="<li>".__('Code:','eshop').$_POST['code'][$i].", ".__('Country:','eshop').$_POST['country'][$i].", ".__('Zone:','eshop').$_POST['zone'][$i]."</li>\n";
			}
		}
		$build=trim($build,",");
		//check to stop someone being dumb enough to try and delete all the countries
		if($inlinecount==0){
			$error .='<li>'.__('You cannot delete all the Countries!','eshop').'</li>'."\n";
		}else{
			//warning this truncates the table and then recreates it
			$query=$wpdb->query("TRUNCATE TABLE $dtable");
			$query=$wpdb->query($build);
		//	//and the errors are because I truncate :(
		}
	}

	//each time re-request from the database
	$query=$wpdb->get_results("SELECT * from $dtable GROUP BY list,country");
	if($error!=''){
		echo'<div id="message" class="error fade"><p>'.__('<strong>Error</strong> the following were not valid:','eshop').'<ul>'.$error.'</ul></div>'."\n";
	}elseif(isset($_POST['submit'])){
		echo'<div id="message" class="updated fade"><p>'.__('Country Shipping Zones changed successfully.','eshop').'</p></div>'."\n";
	}
	
	?>
	<div class="wrap">
	<div id="eshopicon" class="icon32"></div><h2><?php _e('Country Shipping Zones','eshop'); ?></h2>
	<?php eshop_admin_mode(); ?>
	<?php echo $echosub; ?>
	<p><?php _e('&#8220;Code&#8221; 为国家简码，系统目前仅提供1-5区的默认分区，1-9区的设置请自己根据快递公司的报价重新 划分区域.','eshop'); ?></p>
	<p><?php _e('&#8220;Top&#8221; 选择的国家会自动排列在<购物车选择国家栏>的顶部，可以设置主要的销售国家，方便客户选择.','eshop'); ?></p>
	<p><?php _e('  警告：删除所有国家，购物车会失效！ 部分非常落后的国家暂未添加，如果需要，在底部自行添加！','eshop'); ?></p>
	<div id="eshopformfloat">
	<form id="filterzones" action="" method="post">
	<fieldset><legend><?php _e('过滤分区','eshop'); ?></legend>
	<label for="filter"><?php _e('Zone','eshop'); ?></label><select id="filter" name="filter">
	<?php
	$eshopavailzones=apply_filters('eshop_available_zones','9');
	for($x=0;$x<=$eshopavailzones;$x++){
		if(!isset($_POST['filter'])){
			$_POST['filter']=0;
		}
		$text=$x;
		if($x==0){$text='All';}
		if($_POST['filter']==$x){
			$add=' selected="selected"';
		}else{
			$add='';
		}
		echo '<option value="'.$x.'"'.$add.'>'.$text.'</option>';
	}
	?>
	</select>
	<p class="submit"><input type="submit" id="submitfilter" name="submitfilter" value="<?php _e('过滤','eshop'); ?>" /></p>
	</fieldset>
	</form>
	</div>

	<form id="zoneform" action="" method="post">
	<fieldset><legend><?php _e('国家分区设置','eshop'); ?></legend>
	<table class="hidealllabels widefat">
	<thead>
	<tr>
	<th id="code"><?php _e('Code','eshop'); ?></th>
	<th id="country"><?php _e('Country','eshop'); ?></th>
	<th id="zone"><?php _e('Zone','eshop'); ?></th>
		<th id="list"><?php _e('Top','eshop'); ?></th>
	<th id="delete"><?php _e('Delete','eshop'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	$x=0;
	$hidden='';
	foreach ($query as $row){
		if((isset($_POST['filter']) && $_POST['filter']== $row->zone) || 
		isset($_POST['filter']) && $_POST['filter']==0){
			echo '<tr>';
			echo '<td headers="code" id="headcode'.$x.'"><label for="code'.$x.'">'.__('Code','eshop').'</label><input id="code'.$x.'" name="code[]" type="text" value="'.$row->code.'" size="2" maxlength="2" /></td>'."\n";
			echo '<td headers="country headcode'.$x.'"><label for="country'.$x.'">'.__('Country name','eshop').'</label><input id="country'.$x.'" name="country[]" type="text" value="'.$row->country.'" size="30" maxlength="50" /></td>'."\n";
			echo '<td headers="zone headcode'.$x.'"><label for="zone'.$x.'">'.__('Zone','eshop').'</label><input id="zone'.$x.'" name="zone[]" type="text" value="'.$row->zone.'" size="2" maxlength="1" /></td>'."\n";
				if($row->list == '0') $sel='checked="checked" '; else $sel ='';
				echo '<td headers="list headcode'.$x.'"><label for="list'.$x.'">'.__('List','eshop').'</label><input id="list'.$x.'" name="list['.$x.']" type="checkbox" value="0" '.$sel.'/></td>'."\n";
			echo '<td headers="delete headcode'.$x.'"><label for="delete'.$x.'">'.__('Delete','eshop').'</label><input id="delete'.$x.'" name="delete['.$x.']" type="checkbox" value="delete" /></td>'."\n";
			echo '</tr>'."\n";
		}else{
			$hidden.='
			<input id="code'.$x.'" name="code[]" type="hidden" value="'.$row->code.'" />
			<input id="country'.$x.'" name="country[]" type="hidden" value="'.$row->country.'" />
			<input id="zone'.$x.'" name="zone[]" type="hidden" value="'.$row->zone.'" />
			';
		}
		$x++;
	}
	echo '<tr>';
	echo '<td headers="code" id="headcode'.$x.'"><label for="code'.$x.'">'.__('Code','eshop').'</label><input id="code'.$x.'" name="code[]" type="text" value="" size="2" maxlength="2" /></td>'."\n";
	echo '<td headers="country headcode'.$x.'"><label for="country'.$x.'">'.__('Country name','eshop').'</label><input id="country'.$x.'" name="country[]" type="text" value="" size="30" maxlength="50" /></td>'."\n";
	echo '<td headers="zone headcode'.$x.'"><label for="zone'.$x.'">'.__('Zone','eshop').'</label><input id="zone'.$x.'" name="zone[]" type="text" value="" size="2" maxlength="1" /></td>'."\n";
	echo '<td>&nbsp;</td>';
	echo '</tr>'."\n";
	?>
	</tbody>
	</table>
	<?php
	echo $hidden;
	?>
	<p class="submit eshop"><input type="submit" name="submit" class="button-primary" id="submit" value="<?php _e('保存更新','eshop'); ?>" /></p>
	</fieldset>
	</form>

	</div>
	<?php
		break;
case ('states'):
	$dtable=$wpdb->prefix.'eshop_states';
	$error='';

	if(isset($_POST['submit'])){
		//sanitise for display purposes.
		$_POST['code']=sanitise_this($_POST['code']);
		$_POST['stateName']=sanitise_this($_POST['stateName']);
		$_POST['zone']=sanitise_this($_POST['zone']);
		$eshoptestarray=array();

		$build="UPDATE $dtable SET ";
		$i=0;
		foreach($_POST['id'] as $id){
			if(!in_array($_POST['code'][$i],$eshoptestarray)){ //testing for duplicates
				$eshoptestarray[]=$_POST['code'][$i];
			//so if none of them are empty
				if(isset($_POST['delete'][$id])){
					$wpdb->query("DELETE from $dtable WHERE id='".$_POST['delete'][$id]."' limit 1");
				}elseif($id=='0' && $_POST['code'][$i]!='' && $_POST['stateName'][$i]!='' && $_POST['zone'][$i]!=''){
					if(!preg_match("/[a-zA-Z]/", $_POST['code'][$i])){
						$error.="<li>".__('Code:','eshop').$_POST['code'][$i]." ".__('is not valid.','eshop')." ".__('State:','eshop').$_POST['stateName'][$i].",".__('Zone:','eshop').$_POST['zone'][$i]."</li>\n";
					}elseif(!preg_match("/[0-9]/", $_POST['zone'][$i]) || strlen($_POST['zone'][$i])!='1'){
						$error.="<li>".__('Zone:','eshop').$_POST['zone'][$i]." ".__('is not valid.','eshop')." ".__('Code:','eshop').$_POST['code'][$i].", ".__('State:','eshop').$_POST['stateName'][$i]."</li>\n";
					}else{
						//all must be ok
						$buildit="INSERT INTO $dtable (code,stateName,zone,list) VALUES ('".esc_sql($_POST['code'][$i])."','".esc_sql($_POST['stateName'][$i])."','".esc_sql($_POST['zone'][$i])."','".$eshopoptions['shipping_state']."')";
						$wpdb->query($buildit);
					}
				}elseif($_POST['code'][$i]!='' && $_POST['stateName'][$i]!='' && $_POST['zone'][$i]!='' && !isset($_POST['delete'][$i])){
				//complicated error checking - cannot check state name so easily
					if(!preg_match("/[A-Z]/", $_POST['code'][$i])){
						$error.="<li>".__('Code:','eshop').$_POST['code'][$i]." ".__('is not valid.','eshop')." ".__('State:','eshop').$_POST['stateName'][$i].",".__('Zone:','eshop').$_POST['zone'][$i]."</li>\n";
					}elseif(!preg_match("/[0-9]/", $_POST['zone'][$i]) || strlen($_POST['zone'][$i])!='1'){
						$error.="<li>".__('Zone:','eshop').$_POST['zone'][$i]." ".__('is not valid.','eshop')." ".__('Code:','eshop').$_POST['code'][$i].", ".__('State:','eshop').$_POST['stateName'][$i]."</li>\n";
					}else{
						//all must be ok
						$buildit=$build." code='".esc_sql($_POST['code'][$i])."',stateName='".esc_sql($_POST['stateName'][$i])."',zone='".esc_sql($_POST['zone'][$i])."' where id='$id'";
						$wpdb->query($buildit);
					}
				}elseif($_POST['code'][$i]=='' && $_POST['stateName'][$i]=='' && $_POST['zone'][$i]==''){
					//ie no new state added
					//had to put this line here as I don't know where else it should go!
					//it hides the additional input if it wasn't used.
				}elseif(!isset($_POST['delete'][$i])){
					//if not set for deletion then there was an error
					$error.="<li>".__('Code:','eshop').$_POST['code'][$i].", ".__('State:','eshop').$_POST['stateName'][$i].", ".__('Zone:','eshop').$_POST['zone'][$i]."</li>\n";
				}
			}
			$i++;
		}
	}
	if($error!=''){
		echo'<div id="message" class="error fade"><p>'.__('<strong>Error</strong> the following were not valid:','eshop').'<ul>'.$error.'</ul></div>'."\n";
	}elseif(isset($_POST['submit'])){
		echo'<div id="message" class="updated fade"><p>'.$eshopoptions['shipping_state'].' '.__('Specific Shipping Zones changed successfully','eshop').'.</p></div>'."\n";
	}
	//each time re-request from the database
	$getstate=$eshopoptions['shipping_state'];

	$query=$wpdb->get_results("SELECT * from $dtable WHERE list='$getstate' ORDER BY stateName");
	?>
	<div class="wrap">
	<div id="eshopicon" class="icon32"></div><h2><?php echo $eshopoptions['shipping_state'].' '.__('State/County/Province Shipping Zones','eshop'); ?></h2>
	<?php eshop_admin_mode(); ?>
	<?php echo $echosub; ?>
	<p><?php _e('注：如果未选择指定国家销售，该页面不用做任何设置；如果选择指定只在美国销售，就需要设置美国不同地区分区设置！&#8220;Code&#8221; 地区代码.','eshop'); ?></p>
	<p><?php _e('例如: AZ, Arizona,4','eshop'); ?></p>
	<p><?php _e('警告：如果选择指定国家销售，删除所有区域，购物车会失效！.','eshop'); ?></p>

	<div id="eshopformfloat">
	<form id="eshop_shipping_state_form" action="" method="post">
	<fieldset><legend><?php _e('选择指定销售国家，进行设置','eshop'); ?></legend>
<br/>	<select id="eshop_shipping_state" name="eshop_shipping_state">
	<?php
		$ctable=$wpdb->prefix.'eshop_countries';
		$currentlocations=$wpdb->get_results("SELECT * from $ctable ORDER BY country");
		foreach ($currentlocations as $row){
			if($row->code == $eshopoptions['shipping_state']){
				$sel=' selected="selected"';
			}else{
				$sel='';
			}
			echo '<option value="'. $row->code .'"'. $sel .'>'. $row->country .'</option>';
		}
		?>
	</select><br />
	<p class="submit"><input type="submit" id="submitstate" name="submitstate" value="<?php _e('Submit','eshop'); ?>" /></p>
	</fieldset>
	</form>
	</div>

	<form id="zoneform" action="" method="post">
	<fieldset><legend><?php _e('Shipping Zones','eshop'); ?></legend>

	<table class="hidealllabels widefat">
	<caption><?php _e('State/County/Province','eshop'); ?></caption>
	<thead>
	<tr>
	<th id="code"><?php _e('Code','eshop'); ?></th>
	<th id="statename"><?php _e('Name','eshop'); ?></th>
	<th id="zone"><?php _e('Zone','eshop'); ?></th>
	<th id="delete"><?php _e('Delete','eshop'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	
	foreach ($query as $row){
	$x=$row->id;
	echo '<tr>';
	echo '<td headers="code" id="headcode'.$x.'"><label for="code'.$x.'">'.__('Code','eshop').'</label><input id="code'.$x.'" name="code[]" type="text" value="'.$row->code.'" size="4" maxlength="4" /><input id="id'.$x.'" name="id[]" type="hidden" value="'.$row->id.'" /></td>'."\n";
	echo '<td headers="statename headcode'.$x.'"><label for="state'.$x.'">'.__('Statename','eshop').'</label><input id="state'.$x.'" name="stateName[]" type="text" value="'.$row->stateName.'" size="30" maxlength="50" /></td>'."\n";
	echo '<td headers="zone headcode'.$x.'"><label for="zone'.$x.'">'.__('Zone','eshop').'</label><input id="zone'.$x.'" name="zone[]" type="text" value="'.$row->zone.'" size="2" maxlength="1" /></td>'."\n";
	echo '<td headers="delete headcode'.$x.'"><label for="delete'.$x.'">'.__('Delete','eshop').'</label><input id="delete'.$x.'" name="delete['.$x.']" type="checkbox" value="'.$row->id.'" /></td>'."\n";
	echo '</tr>'."\n";
	}
	$x=0;
	echo '<tr>';
	echo '<td headers="code" id="headcode'.$x.'"><label for="code'.$x.'">'.__('Code','eshop').'</label><input id="code'.$x.'" name="code[]" type="text" value="" size="4" maxlength="4" /><input id="id'.$x.'" name="id[]" type="hidden" value="'.$x.'" /></td>'."\n";
	echo '<td headers="statename headcode'.$x.'"><label for="state'.$x.'">'.__('Statename','eshop').'</label><input id="state'.$x.'" name="stateName[]" type="text" value="" size="30" maxlength="50" /></td>'."\n";
	echo '<td headers="zone headcode'.$x.'"><label for="zone'.$x.'">'.__('Zone','eshop').'</label><input id="zone'.$x.'" name="zone[]" type="text" value="" size="2" maxlength="1" /></td>'."\n";
	echo '<td>&nbsp;</td>';
	echo '</tr>'."\n";

	?>
	</tbody>
	</table>

	<p class="submit eshop"><input type="submit" name="submit" class="button-primary" id="submit" value="<?php _e('保存更新','eshop'); ?>" /></p>
	</fieldset>
	</form>

	</div>
	<?php
	break;
case ('shipping'):
default:
	$dtable=$wpdb->prefix.'eshop_rates';
	$error='';

	if(isset($_POST['shipmethod'])){
		$eshopoptions = get_option('eshop_plugin_settings');
		$eshopoptions['shipping']=$_POST['eshop_shipping'];
		$eshopoptions['shipping_zone']=$_POST['eshop_shipping_zone'];
		$eshopoptions['show_zones']=$_POST['eshop_show_zones'];
		$eshopoptions['unknown_state']=$_POST['eshop_unknown_state'];
		$eshopoptions['ship_types']=trim($_POST['eshop_ship_types']);
		$eshopoptions['weight_unit']=$_POST['eshop_weight_unit'];
		$eshopoptions['numb_shipzones']=$_POST['eshop_numb_shipzones'];
		$eshopoptions['shipping_country_selected']=$_POST['eshop_shipping_country_selected'];
		$eshopoptions['shipping_state_selected']=$_POST['eshop_shipping_state_selected'];
		update_option('eshop_plugin_settings',$eshopoptions);
	}
	if(isset($_POST['eshopstd'])){
		unset ($_POST['eshopstd']);
		foreach($_POST as $k=>$v){
			$class=substr($k,0,1);
			$items=substr($k,1,1);
			$zone=substr($k,2);
			$zonenum=substr($k,-1);

			if(!is_numeric($v) && ($k!='submit'&& $k!='eshop_shipping')){
				$error.='<li>'.__('Class','eshop').' '.$class.': '.__('Zone','eshop').' '.$zonenum.'</li>'."\n";
			}elseif($k!='submit' && $k!='eshop_shipping'){
				$query=$wpdb->query("UPDATE $dtable set $zone='$v' where class='$class' and items='$items'");
			//echo "<p>UPDATE $dtable set $zone='$v' where class='$class' and items='$items'</p>";
			}
		}
	}
	if(isset($_POST['eshopwgt'])){
		$barray=array();
		for($z=1;$z<=$eshopoptions['numb_shipzones'];$z++){
			$barray[]='zone'.$z;
		}
		$buildit="INSERT INTO $dtable (`".implode("`, `",$barray)."`, `weight`, `class`, `rate_type`, `area`, `maxweight`) VALUES ";
		$shipwletter = "a";
		$build='';
		foreach($_POST['row'] as $k=>$v){
			$eshoparea=$_POST['eshop_shipping_area'][$k];
			$eshopmaxweight=$_POST['eshop_max_weight'][$k];
			if(!is_numeric($eshopmaxweight) && $eshopmaxweight!='')
				$eshopmaxweight='';
			foreach($v as $f=>$value){
				if($value['weight']!=''){
					$bvarray=array();
					for($z=1;$z<=$eshopoptions['numb_shipzones'];$z++){
						$bvarray[]=$value['zone'.$z];
					}
					$build.="('".implode("', '",$bvarray)."','".$value['weight']."','".$k."','ship_weight','$eshoparea','$eshopmaxweight'),";
					$shipwletter++;
				}
			}
		}
		$queri=trim($build,',');
		if($queri!=''){
			$queri=$buildit.$queri;
			$wpdb->query("DELETE from $dtable where rate_type='ship_weight'");
			$wpdb->query($queri);
		}
	}
	if($error!=''){
		echo'<div id="message" class="error fade"><p>'.__('<strong>Error</strong> the following were not valid amounts:','eshop').'</p><ul>'.$error.'</ul></div>'."\n";
	}elseif(isset($_POST['shipmethod'])||isset($_POST['submit'])){
		echo'<div id="message" class="updated fade"><p>'.__('Shipping Rates changed successfully.','eshop').'</p></div>'."\n";
	}
	echo '<div class="wrap">';
	echo '<div id="eshopicon" class="icon32"></div><h2>'.__('运费设置','eshop').'</h2>'."\n";
	eshop_admin_mode();
	?>
	<?php echo $echosub; ?>
	<p></p>
	<p></p>
	<form id="shipformmethod" action="" method="post" >
	<fieldset style="padding: 10px 0 10px 20px;">
<?php
	for($i=1;$i<=4;$i++){
		$selected='';
		if($i == $eshopoptions['shipping']){$selected=' checked="checked"';}
		if($i==1){
			$extra=' '.__('( 按照产品数量递增运费，不同产品可设置不同的运费，可按照不同地区设置运费； )','eshop').'';
		}elseif($i==2){
			$extra=' '.__('( 每个产品固定运费，无论该产品数量，不同的产品运费会累加，不同产品可设置不同的运费，可按照不同地区设置运费； )','eshop').'';
		}elseif($i==3){
			$extra=' '.__('( 每笔订单固定运费，无论产品型号和数量，可按照不同地区设置运费； )','eshop').'';
		}elseif($i==4){
			$extra=' '.__('( 根据不同快递公司/重量/地区计算运费. )','eshop').'';
		}		
		echo '<input type="radio" class="radio" name="eshop_shipping" id="eshop_shipping'.$i.'" value="'.$i.'" '.$selected.'/><label for="eshop_shipping'.$i.'">'.__('运费模式 ','eshop').$i.$extra.'</label><br />';
	}
	?><br />
	<label for="eshop_shipping_zone"><?php _e('○选择发货区域','eshop'); ?></label>
	<select id="eshop_shipping_zone" name="eshop_shipping_zone">
	<?php
	echo '<option value="country" '.selected($eshopoptions['shipping_zone'],'country',false).'>'.__('Country','eshop').'</option>';
	echo '<option value="state"'.selected($eshopoptions['shipping_zone'],'state',false).'>'.__('State/County/Province','eshop').'</option>';
	?>
	</select> 全球销售请选择国家(如果只做美国市场，选择省，然后在省的选项中设置美国的州市县等)<br />
	<?php
	$eshopavailzones=apply_filters('eshop_available_zones','9');
	?><br />
	<label for="eshop_numb_shipzones"><?php _e('○国家分区数量设置','eshop'); ?></label>
			<select id="eshop_numb_shipzones" name="eshop_numb_shipzones">
			<?php
			for($i=1;$i<=$eshopavailzones;$i++){
			?>
				<option value="<?php echo $i; ?>"<?php selected($i,$eshopoptions['numb_shipzones']) ?>><?php echo $i; ?></option>
			<?php
			}
			?>
	</select>
	<label for="eshop_unknown_state"><?php _e('○州/市/县分区数量设置','eshop'); ?></label>
		<select id="eshop_unknown_state" name="eshop_unknown_state">
		<?php
		for($i=1;$i<=$eshopavailzones;$i++){
		?>
			<option value="<?php echo $i; ?>"<?php if($i==$eshopoptions['unknown_state']) echo ' selected="selected"'; ?>><?php echo $i; ?></option>
		<?php
		}
		?>
	</select><br /><br />
	<div><label for="eshop_show_zones"><?php _e('○运费计算时是否显示国家分区','eshop'); ?></label>
	<select id="eshop_show_zones" name="eshop_show_zones">
	<?php
	echo '<option value="yes" '.selected($eshopoptions['show_zones'],'yes',false).'>'.__('Yes','eshop').'</option>';
	echo '<option value="no" '.selected($eshopoptions['show_zones'],'no',false).'>'.__('No','eshop').'</option>';
	?>
	</select></div><br />
	<?php /* choose one to be selected */ ?>
	<label for="eshop_shipping_country_selected"><?php _e('○默认选择国家','eshop'); ?></label>
	<select id="eshop_shipping_country_selected" name="eshop_shipping_country_selected">
	<option value=""><?php _e('Please Select','eshop'); ?></option>
	<?php
	$eshop_shipping_country_selected='';
	if(isset($eshopoptions['shipping_country_selected']))
		$eshop_shipping_country_selected=$eshopoptions['shipping_country_selected'];
		
	$ctable=$wpdb->prefix.'eshop_countries';
	$currentlocations=$wpdb->get_results("SELECT * from $ctable ORDER BY country");
	foreach ($currentlocations as $row){
		echo '<option value="'.$row->code.'"'. selected($row->code,$eshop_shipping_country_selected,false).'>'. $row->country .'</option>';
	}
	?>
	</select>
	<?php
	$eshop_shipping_state_selected='';
	if(isset($eshopoptions['shipping_state_selected']))
		$eshop_shipping_state_selected=$eshopoptions['shipping_state_selected'];
	$tablest=$wpdb->prefix.'eshop_states';
	$stateList=$wpdb->get_results("SELECT id,code,stateName,list FROM $tablest ORDER BY list,stateName",ARRAY_A);
	if(sizeof($stateList)>0){
		$echo ='<label for="eshop_shipping_state_selected">'.__('○默认选择州/市/县','eshop').'</label>
		  <select class="med pointer" name="eshop_shipping_state_selected" id="eshop_shipping_state_selected">';
		$echo .='<option value="">'.__('Please Select','eshop').'</option>';
		foreach($stateList as $code => $value){
			if(isset($value['list'])) $li=$value['list'];
			else $li='1';
			$eshopstatelist[$li][$value['id']]=array($value['id'],$value['stateName']);
		}
		$tablec=$wpdb->prefix.'eshop_countries';
		foreach($eshopstatelist as $egroup =>$value){
			$eshopcname=$wpdb->get_var("SELECT country FROM $tablec where code='$egroup' limit 1");
			$echo .='<optgroup label="'.$eshopcname.'">'."\n";

			foreach($value as $code =>$stateName){
				$echo.= '<option value="'.$code.'"'. selected($code,$eshop_shipping_state_selected,false).'>'. $stateName['1'] .'</option>'."\n";
			}
			$echo .="</optgroup>\n";
		}
	}
	$echo.= "</select><br />\n";
	echo $echo;
	/* end */ ?><br />
	<label for="eshop_ship_types"><?php _e('○国际快递方式 (一行一个，仅支持运费模式4，其他运费模式忽略此栏)','eshop'); ?></label><br />
	<?php
	if(isset($eshopoptions['ship_types']))	
		$ship_types=$eshopoptions['ship_types'];
	else
		$ship_types='';
	?>
	<textarea id="eshop_ship_types" name="eshop_ship_types" cols="60" rows="6"><?php echo stripslashes(esc_attr($ship_types)); ?></textarea>
	<?php if(!isset($eshopoptions['weight_unit'])) $eshopoptions['weight_unit']=''; ?>
	<p><label for="eshop_weight_unit"><?php _e('重量单位: 目前只支持g','eshop'); ?></label>
	<input id="eshop_weight_unit" name="eshop_weight_unit" type="text" value="<?php echo stripslashes(esc_attr($eshopoptions['weight_unit'])); ?>" size="10" maxlength="10" /><br /></p>

	<p class="submit eshop"><input type="submit" name="shipmethod" class="button-primary" id="submitit" value="<?php _e('保存以上设置','eshop'); ?>" /></p>

	</fieldset>
	</form>
<?php if($eshopoptions['shipping']!=4){ ?>
	<form id="shipform" action="" method="post">
	<fieldset><legend><span><?php _e('运输方式以及国家分区','eshop'); ?></span></legend>
	<table class="hidealllabels widefat">
	<thead>
	<tr>
	<th id="class"><?php _e('Class','eshop'); ?></th>
	<?php
	for($z=1;$z<=$eshopoptions['numb_shipzones'];$z++){
		$echozone=sprintf(__('Zone %1$d','eshop'),$z);
		$dispzone=apply_filters('eshop_rename_ship_zone',array());
		if(isset($dispzone[$z]))
			$echozone=$dispzone[$z];
	?>
		<th id="zone<?php echo $z; ?>" class="zone<?php echo $z; ?>"><?php echo $echozone; ?></th>
	<?php
	}
	?>
	</tr>
	</thead>
	<?php
	/* although this could be condensed, I'll split each method up for ease and future expansion */
	switch ($eshopoptions['shipping']){
		case '1':// ( per quantity of 1, prices reduced for additional items )
			$x=1;
			$calt=0;
			$query=$wpdb->get_results("SELECT * from $dtable where rate_type='shipping' ORDER BY class ASC, items ASC");

			foreach ($query as $row){
				$calt++;
				$alt = ($calt % 2) ? '' : ' class="alternate"';
				$row->eclass=apply_filters('eshop_shipping_rate_class',$row->class);
				echo '<tr'.$alt.'>';
				if($row->items==1){
					echo '<th id="cname'.$x.'" headers="class">'.$row->eclass.' <small>'.__('(First Item)','eshop').'</small></th>'."\n";
				}else{
					echo '<th id="cname'.$x.'" headers="class">'.$row->eclass.' <small>'.__('(Additional Items)','eshop').'</small></th>'."\n";
				}
				for($z=1;$z<=$eshopoptions['numb_shipzones'];$z++){
					$y='zone'.$z;
					$echozone=sprintf(__('Zone %1$d','eshop'),$z);
					$dispzone=apply_filters('eshop_rename_ship_zone',array());
					if(isset($dispzone[$z]))
						$echozone=$dispzone[$z];
					echo '<td headers="zone'.$z.' cname'.$x.'" class="zone'.$z.'"><label for="'.$row->class.$row->items.'zone'.$z.'">'.sprintf(__('%1$s class','eshop'),$echozone).' '.$row->class.$row->items.'</label><input id="'.$row->class.$row->items.'zone'.$z.'" name="'.$row->class.$row->items.'zone'.$z.'" type="text" value="'.$row->$y.'" size="6" maxlength="16" /></td>'."\n";
				}
				echo '</tr>';
				$x++;
			}
			break;
		case '2'://( once per shipping class no matter what quantity is ordered )
			$x=1;
			$calt=0;
			$query=$wpdb->get_results("SELECT * from $dtable where items='1' && rate_type='shipping' ORDER BY 'class'  ASC");
			foreach ($query as $row){
				$calt++;
				$alt = ($calt % 2) ? '' : ' class="alternate"';
				$row->eclass=apply_filters('eshop_shipping_rate_class',$row->class);
				echo '<tr'.$alt.'>';
				echo '<th id="cname'.$x.'" headers="class">'.$row->eclass.'</th>'."\n";
				for($z=1;$z<=$eshopoptions['numb_shipzones'];$z++){
					$y='zone'.$z;
					$echozone=sprintf(__('Zone %1$d','eshop'),$z);
					$dispzone=apply_filters('eshop_rename_ship_zone',array());
					if(isset($dispzone[$z]))
						$echozone=$dispzone[$z];
					echo '<td headers="zone'.$z.' cname'.$x.'" class="zone'.$z.'"><label for="'.$row->class.$row->items.'zone'.$z.'">'.sprintf(__('%1$s class','eshop'),$echozone).' '.$row->class.'</label><input id="'.$row->class.$row->items.'zone'.$z.'" name="'.$row->class.$row->items.'zone'.$z.'" type="text" value="'.$row->$y.'" size="6" maxlength="16" /></td>'."\n";
				}
				echo '</tr>';
				$x++;
			}
			break;
		case '3'://( one overall charge no matter how many are ordered )
			$x=1;
			$query=$wpdb->get_results("SELECT * from $dtable where items='1' and rate_type='shipping' and class='".__('A','eshop')."' ORDER BY 'class'  ASC");
			foreach ($query as $row){
				$row->eclass=apply_filters('eshop_shipping_rate_class',$row->class);
				echo '<tr class="alternate">';
				echo '<th id="cname'.$x.'" headers="class">'.$row->eclass.' <small>'.__('(Overall charge)','eshop').'</small></th>'."\n";
				for($z=1;$z<=$eshopoptions['numb_shipzones'];$z++){
					$y='zone'.$z;
					$echozone=sprintf(__('Zone %1$d','eshop'),$z);
					$dispzone=apply_filters('eshop_rename_ship_zone',array());
					if(isset($dispzone[$z]))
						$echozone=$dispzone[$z];
					echo '<td headers="zone'.$z.' cname'.$x.'" class="zone'.$z.'"><label for="'.$row->class.$row->items.'zone'.$z.'">'.$echozone.'</label><input id="'.$row->class.$row->items.'zone'.$z.'" name="'.$row->class.$row->items.'zone'.$z.'" type="text" value="'.$row->$y.'" size="6" maxlength="16" /></td>'."\n";
				}
				echo '</tr>';
			}
			break;
	}
	?>
	</table>
	<p class="submit eshop"><input type="hidden" name="eshopstd" value="1" /><input type="submit" name="submit" class="button-primary" id="submit" value="<?php _e('保存更新','eshop'); ?>" /></p>
	</fieldset>
	</form>
	<?php
	}else{//ship by weight
	if(isset($eshopoptions['ship_types'])){
	?>
	<form id="shipform" action="" method="post">
	<fieldset  ><legend style="padding:10px;"> <span><b><?php _e('不同运输方式，按照不同重量/分区设置运费 <span style="color:red;">(注意: 保存以下内容，请点击底部 "更新运费设置" 按钮)</span>','eshop'); ?></b></span></legend>
	<br />
	<?php
	$typearr=explode("\n", $eshopoptions['ship_types']);
	$eshopletter = "A";
	foreach ($typearr as $k=>$type){
		$k++;
		$query=$wpdb->get_results("SELECT * from $dtable where rate_type='ship_weight' and class='$k' ORDER BY weight ASC");
		$eshoparea='country';
		$maxweight='';
		if(isset($query[0]->area))
			$eshoparea=$query[0]->area;
		if(isset($query[0]->maxweight))
			$maxweight=$query[0]->maxweight;
		?>
		<fieldset>
		<legend style="padding:5px;"><b><?php echo stripslashes(esc_attr($type)); ?></b></legend>
		<label for="eshop_shipping_area<?php echo $eshopletter; ?>"><?php _e('选择发货区域','eshop'); ?></label>
		<select id="eshop_shipping_area<?php echo $eshopletter; ?>" name="eshop_shipping_area[<?php echo $k; ?>]">
		<?php
		echo '<option value="country" '.selected($eshoparea,'country',false).'>'.__('Country','eshop').'</option>';
		echo '<option value="state"'.selected($eshoparea,'state',false).'>'.__('State/County/Province','eshop').'</option>';
		?>
		</select>
		<label for="eshop_max_weight<?php echo $eshopletter; ?>"><?php _e('最大重量限制','eshop'); ?></label><input id="eshop_max_weight<?php echo $eshopletter; ?>" name="eshop_max_weight[<?php echo $k; ?>]" type="text" value="<?php echo $maxweight; ?>" size="4" /><label for="eshop_max_weight<?php echo $eshopletter; ?>"><?php _e('<small>警告: 如果买家购物车中的所有产品重量大于该数值，运费为0！ 留空则无上限。</small>','eshop'); ?></label>
		<table class="hidealllabels widefat">
		<thead>
		<tr>
		<th id="<?php echo $eshopletter; ?>weight"><?php _e('起始重量 ≥','eshop'); ?></th>
		<?php
		for($z=1;$z<=$eshopoptions['numb_shipzones'];$z++){
			$echozone=sprintf(__('Zone %1$d','eshop'),$z);
			$dispzone=apply_filters('eshop_rename_ship_zone',array());
			if(isset($dispzone[$z]))
				$echozone=$dispzone[$z];
		?>
			<th id="<?php echo $eshopletter.'zone'. $z; ?>" class="zone<?php echo $z; ?>"><?php echo $echozone; ?></th>
		<?php
		}
		?>
		</tr>
		</thead>
		<tbody>
		<?php
		$x=1;
		foreach ($query as $row){
			$alt = ($x % 2) ? '' : ' class="alt"';
			echo '<tr'.$alt.'>';
			echo '<td id="'.$eshopletter.'cname'.$x.'" headers="'.$eshopletter.'weight"><label for="'.$eshopletter.'weight'.$x.'">'.__('Weight','eshop').'</label><input id="'.$eshopletter.'weight'.$x.'" name="row['.$k.']['.$x.'][weight]" type="text" value="'.$row->weight.'" /></td>'."\n";
			for($z=1;$z<=$eshopoptions['numb_shipzones'];$z++){
				$y='zone'.$z;
				$echozone=sprintf(__('Zone %1$d','eshop'),$z);
				$dispzone=apply_filters('eshop_rename_ship_zone',array());
				if(isset($dispzone[$z]))
					$echozone=$dispzone[$z];
				echo '<td headers="'.$eshopletter.'zone'.$z.' '.$eshopletter.'cname'.$x.'" class="zone'.$z.'"><label for="'.$eshopletter.'zone'.$z.$x.'">'.$echozone.'</label><input id="'.$eshopletter.'zone'.$z.$x.'" name="row['.$k.']['.$x.']['.$y.']" type="text" value="'.$row->$y.'" size="6" maxlength="16" /></td>'."\n";
			}
			echo '</tr>';
			$x++;
		}
		extraeshopweights($x,$eshopletter,$k);
		$eshopletter++;
		?>
		</tbody>
		</table>
		</fieldset>
		<?php
	}
	?>
	<p class="submit eshop"><input type="hidden" name="eshopwgt" value="1" /><input type="submit" name="submit" class="button-primary" id="submit" value="<?php _e('更新运费设置','eshop'); ?>" /></p>
	</fieldset>
	</form>
	<?php
	}else{
		echo '<p>'.__('No modes setup','eshop').'</p>';
	}
	}
	?>
	</div>
<?php
	break;
}
function extraeshopweights($start,$eshopletter,$k){
	global $eshopoptions;
	$x = $start;
	$finish=$start+3;
	while ($x <= $finish) {
		$alt = ($x % 2) ? '' : ' class="alt"';
		echo '<tr'.$alt.'>';
		echo '<td id="'.$eshopletter.'cname'.$x.'" headers="'.$eshopletter.'weight"><label for="'.$eshopletter.'weight'.$x.'">'.__('Weight','eshop').'</label><input id="'.$eshopletter.'weight'.$x.'" name="row['.$k.']['.$x.'][weight]" type="text" value="" /></td>'."\n";
		for($z=1;$z<=$eshopoptions['numb_shipzones'];$z++){
			$y='zone'.$z;
			$echozone=sprintf(__('Zone %1$d','eshop'),$z);
			$dispzone=apply_filters('eshop_rename_ship_zone',array());
			if(isset($dispzone[$z]))
				$echozone=$dispzone[$z];
			echo '<td headers="'.$eshopletter.'zone'.$z.' '.$eshopletter.'cname'.$x.'" class="zone'.$z.'"><label for="'.$eshopletter.'zone'.$z.$x.'">'.$echozone.'</label><input id="'.$eshopletter.'zone'.$z.$x.'" name="row['.$k.']['.$x.']['.$y.']" type="text" value="" size="6" maxlength="16" /></td>'."\n";
		}
		echo '</tr>';
		$x++;
	}
	?>
	<?php
}
?>