<?php
function eshop_template_email(){
	global $wpdb;
	$table=$wpdb->prefix.'eshop_emails';
	if(isset($_POST['edit'])){
		$subject=esc_sql($_POST['subject']);
		$content=esc_sql($_POST['templateContent']);
		$edit=esc_sql($_POST['edit']);
 		$wpdb->query("UPDATE $table set emailSubject='$subject',emailContent='$content' where id='$edit'");
   		echo '<div id="message" class="updated fade"><p><strong>'.__('The Template Has Been Updated','eshop').'</strong></p></div>'."\n";
	}
	if(isset($_GET['eshopuse']) && is_numeric($_GET['eshopuse'])){
		$edit=$_GET['eshopuse'];
		$wpdb->query("UPDATE $table set emailUse=(CASE WHEN emailUse=1 THEN 0 ELSE 1 END) where id='$edit'");
   		echo '<div id="message" class="updated fade"><p><strong>'.__('The Template Has Been Changed','eshop').'</strong></p></div>'."\n";
	}
?>
<div class="wrap">
<div id="eshopicon" class="icon32"></div><h2><?php _e('邮件模版设置','eshop'); ?></h2>
<?php eshop_admin_mode(); ?>
<table class="eshop widefat">
<thead><tr><th id="type"><?php _e('邮件模版','eshop'); ?></th><th id="blank"><?php _e('样式', 'eshop'); ?></th><th id="act"><?php _e('使用','eshop'); ?></th><th id="chg"><?php _e('修改','eshop'); ?></th></tr></thead>
<tbody>
<?php
$eshoptemplate='1';
if(isset($_GET['eshoptemplate']) && is_numeric($_GET['eshoptemplate']))
	$eshoptemplate=$_GET['eshoptemplate'];


$thisemail=$wpdb->get_results("Select * From $table");
$phpself=get_admin_url().'admin.php?page=eshop-templates.php'; 
$x=1;
foreach($thisemail as $this_email){
	$active='';
	$state=__('已启用','eshop');
	if($this_email->id>2){
		if($this_email->emailUse==1) $active=__('Deactivate','eshop').' '.$this_email->id;
		else{
			$active=__('Activate','eshop').' '.$this_email->id;
			$state='';
		}
	}
	$alt = ($x % 2) ? '' : ' class="alternate"';
	if($this_email->emailContent=='') $ewarn=' <span class="ewarn">'.__('Template is blank','eshop').'</span>';
	else $ewarn=' <span class="emailok">'.__('Template exists','eshop').'</span>';
	?>
	<tr class="row<?php echo $x; ?>" <?php echo $alt; ?>><td headers="row<?php echo $x; ?> num"><a class="email<?php echo $x; ?>"  href="<?php echo $phpself.'&amp;eshoptemplate='.$this_email->id; ?>#edit_section" title="<?php _e('点击编辑该模版','eshop'); ?>">【邮件模版】</a></td>
	<td headers="row<?php echo $x; ?> blank"><?php echo $ewarn; ?></td>
	<td headers="row<?php echo $x; ?> act"><?php echo $state; ?></td><td headers="row<?php echo $x; ?> chg"><a href="<?php echo $phpself.'&amp;eshopuse='.$this_email->id; ?>">启用/关闭</a></td></tr>
	<?php
	$x++;
}
?>
</tbody>
</table>

</div>
<div class="wrap">
<?php
$thisemail=$wpdb->get_row("Select emailType, emailSubject,emailContent From $table where id=$eshoptemplate");
?>
<h2 id="edit_section"><?php _e('邮件模版修改','eshop'); ?></h2>
 <form method="post" action="" id="edit_box">
  <fieldset>
   <legend><?php _e('样式:','eshop'); ?> <?php echo $thisemail->emailType; ?> </legend>
   	<label for="subject"><?php _e('Subject','eshop'); ?><br /><input type="text" id="subject" name="subject" size="60" value="<?php echo htmlspecialchars(stripslashes($thisemail->emailSubject)); ?>" /></label><br />

   <label for="stylebox"><?php _e('Email Content','eshop'); ?></label><br />
<textarea rows="20" cols="80" id="stylebox" name="templateContent">
<?php 
echo htmlspecialchars(stripslashes($thisemail->emailContent));
?>
</textarea>
	<input type="hidden" name="edit" value="<?php echo $eshoptemplate;?>" />
	<input type="hidden" name="eshoptemplate" value="<?php echo $eshoptemplate;?>" />
   <p class="submit eshop"><input type="submit" class="button-primary" value="<?php _e('更新样式','eshop'); ?>" name="submit" /></p>
  </fieldset>
</form>
</div>
<div class="wrap">
<h2><?php _e('邮件使用代码','eshop'); ?></h2>
<ul>
<li><strong>{STATUS}</strong> - <?php _e('订单状态.','eshop'); ?></li>
<li><strong>{FIRSTNAME}</strong> - <?php _e('Customers First Name.','eshop'); ?></li>
<li><strong>{NAME}</strong> - <?php _e('Customers Full Name.','eshop'); ?></li>
<li><strong>{EMAIL}</strong> - <?php _e('Customers Email address.','eshop'); ?></li>
<li><strong>{CART}</strong> - <?php _e('订单产品内容.','eshop'); ?></li>
<li><strong>{DOWNLOADS}</strong> - <?php _e('下载地址 (仅下载类网站支持).','eshop'); ?></li>
<li><strong>{ADDRESS}</strong> - <?php _e('发货地址.','eshop'); ?></li>
<li><strong>{CONTACT}</strong> - <?php _e('发货地址及联系电话.','eshop'); ?></li>
<li><strong>{ORDERDATE}</strong> - <?php _e('订单时间.','eshop'); ?></li>
<?php do_action('eshopemailtags'); ?>
</ul>
</div>
	<?php 
}
?>