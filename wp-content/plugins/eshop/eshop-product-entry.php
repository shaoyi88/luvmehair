<?php
//make it available
add_action('admin_menu', 'eshop_add_custom_box');
/* Use the save_post action to do something with the data entered */
add_action('save_post', 'eshop_save_postdata');
add_action('admin_head-post.php', 'eshop_check_error'); // called after the redirect
/* Adds a custom section to the "advanced" Post and Page edit screens */
function eshop_add_custom_box() {
	if( function_exists( 'add_meta_box' )) {
  		get_currentuserinfo() ;
  		$array=array('post','page');
  		$array=apply_filters('eshop_post_types',$array);
		if(current_user_can('eShop')){
			foreach($array as $type){
    			add_meta_box( 'epagepostcustom', __( '产品参数设置', 'eshop' ), 
                'eshop_inner_custom_box', $type, 'normal','high' );
        	}
    	}
  	}
}
   
/* Prints the inner fields for the custom post/page section */
function eshop_inner_custom_box($post) {
    global $wpdb,$eshopoptions;
      // Use nonce for verification
    echo '<input type="hidden" name="eshop_noncename" id="eshop_noncename" value="' . 
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    // The actual fields for data entry
    $osets=array();
    if(isset($_REQUEST[ 'post' ])){
    	$stkav=get_post_meta( $_REQUEST[ 'post' ], '_eshop_stock',true );
    	$eshop_product=maybe_unserialize(get_post_meta( $_REQUEST[ 'post' ], '_eshop_product',true ));    }else{
    	$stkav='';
    	$eshop_product=array();
    }
    if(isset($eshop_product['optset']))
		$osets=$eshop_product['optset'];
 
    //recheck stkqty
    $stocktable=$wpdb->prefix ."eshop_stock";
    if(isset($eshop_product['products'])){
		for ( $i = 1; $i<= count( $eshop_product['products']); $i++) {
			if ( isset( $eshop_product['products'][$i]['option'] ) && !empty( $eshop_product['products'][$i]['option'] ) ) {
				$eshop_product['products'][$i]['stkqty'] = $wpdb->get_var("SELECT available FROM $stocktable where post_id=$post->ID AND option_id=$i");
			}
		}
    }

    ?>
    <div>
	 <p style="display:none;"><label for="eshop_product_description"><strong><?php _e('购物车产品名称: ','eshop'); ?></strong></label>	 <input id="eshop_product_description" name="eshop_product_description" value="<?php if (isset($eshop_product['description'])) echo $eshop_product['description']; ?>" type="text" size="60" />	 <strong><span style="color: #ff0000;">(必填)</span></strong><span style="color: #c0c0c0;">和标题一样即可</span></p>
	<p style="display:none;"><label for="eshop_sku"><strong><?php _e('产品ID: ','eshop'); ?></strong></label><span style="color: #ff0000;"><?php if (isset($eshop_product['sku'])) echo $eshop_product['sku']; ?>  </span>(发布后自动生成)
	</p>				<p><label><strong><?php _e('亚马逊购买链接: ','eshop'); ?></strong></label> <input name="amazon_link" value="<?php if (isset($eshop_product['amazon_link'])) echo $eshop_product['amazon_link']; ?>" type="text" style="width:500px"/>	</p>
	</div>
   
    <?php
    //get list of download products for selection 
    $producttable = $wpdb->prefix ."eshop_downloads";
    $myrowres=$wpdb->get_results("Select * From $producttable");
    //check for existence of downloads
    $eshopdlavail = $wpdb->get_var("SELECT COUNT(id) FROM $producttable WHERE id > 0");
    $numoptions=$eshopoptions['options_num'];
    if(isset($eshopoptions['etax']) && !isset($eshopoptions['etax']['bands']))
    	$eshopoptions['etax']['bands'] = 0;
    ?>
    <div class="eshopwidetable">
	<table class="hidealllabels widefat eshoppopt" id="eshoppopt_price">
   <thead><tr><th id="eshopoption"><?php _e('产品SKU','eshop'); ?><span style="color: #ff0000;">*</span></th>
    <th id="eshopprice"><?php _e('原价','eshop'); ?><span style="color: #ff0000;">*</span></th>
    <?php if(isset($eshopoptions['sale_prices']) && $eshopoptions['sale_prices'] == 1 ){?><th id="eshopsaleprice"><?php _e('卖价','eshop'); ?> <span style="color: #ff0000;">*</span></th><?php } ?>
    <?php if(isset($eshopoptions['etax']) && $eshopoptions['etax']['bands']>'0'){?><th id="eshoptax"><?php _e('税率','eshop'); ?><span style="color: #ff0000;">*</span></th><?php } ?>
    <?php if($eshopdlavail>0){ ?><th id="eshopdownload"><?php _e('下载','eshop'); ?><span style="color: #ff0000;">*</span></th><?php } ?>
    <?php if($eshopoptions['shipping']=='4'){?><th id="eshopweight"><?php _e('重量(g)','eshop'); ?><span style="color: #ff0000;">*</span></th><?php } ?>
    <?php if($eshopoptions['stock_control']=='yes'){?><th id="eshopstkqty"><?php _e('库存数量','eshop'); ?><span style="color: #ff0000;">*</span></th><?php } ?>
    </tr></thead>
        <tbody>
        <?php
		for($i=1;$i<=$numoptions;$i++){
			if(isset($eshop_product['products']) && isset($eshop_product['products'][$i]) && is_array($eshop_product['products'][$i])){
				$opt=$eshop_product['products'][$i]['option'];
				$price=$eshop_product['products'][$i]['price'];
				$downl='';
				if(isset($eshop_product['products'][$i]['download']))
					$downl=$eshop_product['products'][$i]['download'];
				if(isset($eshop_product['products'][$i]['weight'])) 
					$weight=$eshop_product['products'][$i]['weight'];
				else
					$weight='';
				if(isset($eshop_product['products'][$i]['stkqty']) && $eshopoptions['stock_control']=='yes')
					$stkqty=$eshop_product['products'][$i]['stkqty'];
				else
					$stkqty='';
				if(isset($eshop_product['products'][$i]['tax'])) 
					$eshoptax=$eshop_product['products'][$i]['tax'];
				else
					$eshoptax='0';
				
				$saleprice = '';
				if(isset($eshop_product['products'][$i]['saleprice']))
					$saleprice = $eshop_product['products'][$i]['saleprice'];
			}else{
				$saleprice=$stkqty=$weight=$opt=$price=$downl='';
				$eshoptax='0';
			}
			$alt = ($i % 2) ? '' : ' class="alternate"';
			?>
			<tr<?php echo $alt; ?>>
			<td headers="eshopoption eshopnumrow<?php echo $i; ?>"><label for="eshop_option_<?php echo $i; ?>"><?php _e('Option','eshop'); ?> <?php echo $i; ?></label><input id="eshop_option_<?php echo $i; ?>" name="eshop_option_<?php echo $i; ?>" value="<?php echo $opt; ?>" type="text" size="20" /></td>
			<td headers="eshopprice eshopnumrow<?php echo $i; ?>"><label for="eshop_price_<?php echo $i; ?>"><?php _e('Price','eshop'); ?> <?php echo $i; ?></label><input id="eshop_price_<?php echo $i; ?>" name="eshop_price_<?php echo $i; ?>" value="<?php echo $price; ?>" type="text" size="6" /></td>
			<?php 
			//saleprice
			if(isset($eshopoptions['sale_prices']) && $eshopoptions['sale_prices'] == 1 ){
			?>
			<td headers="eshopsaleprice eshopnumrow<?php echo $i; ?>"><label for="eshop_saleprice_<?php echo $i; ?>"><?php _e('Sale Price','eshop'); ?> <?php echo $i; ?></label><input id="eshop_saleprice_<?php echo $i; ?>" name="eshop_saleprice_<?php echo $i; ?>" value="<?php echo $saleprice; ?>" type="text" size="6" /> 产品基础价格</td>
			<?php
			}
			//tax
			if(isset($eshopoptions['etax']['bands']) && $eshopoptions['etax']['bands']>'0'){	?>
				<td headers="eshoptax eshopnumrow<?php echo $i; ?>">
					<label for="eshop_tax_<?php echo $i; ?>"><?php _e('Tax','eshop'); ?> <?php echo $i; ?></label>
					<select name="eshop_tax_<?php echo $i; ?>" id="eshop_tax_<?php echo $i; ?>">
						<option value=""><?php _e('No','eshop'); ?></option>
						<?php
						for($it=1;$it<=$eshopoptions['etax']['bands'];$it++){
							$tzone=sprintf(__('Band %1$d','eshop'),$it);
							$disptzone=apply_filters('eshop_rename_tax_zone',array());
							if(isset($disptzone[$it]))
								$tzone=$disptzone[$it];
							echo '<option value="'.$it.'"'.selected($it,$eshoptax).'>'.$tzone.'</option>'."\n";
						}
						?>
					</select>
				</td>
			<?php }	?>
			<?php if($eshopdlavail>0){ ?>
			<td headers="eshopdownload eshopnumrow<?php echo $i; ?>"><label for="eshop_download_<?php echo $i; ?>"><?php _e('Download','eshop'); ?> <?php echo $i; ?></label><select name="eshop_download_<?php echo $i; ?>" id="eshop_download_<?php echo $i; ?>">
			   <option value=""><?php _e('No (or select)','eshop'); ?></option>
				<?php
				foreach($myrowres as $prow){
					$checked = ( trim( $prow->id ) == trim( $downl ) ) ? ' selected="selected"' : '';
					echo '<option value="'.$prow->id.'"'.$checked.'>'.wp_specialchars(stripslashes($prow->title),1).'</option>'."\n";
				}
				?>
				</select></td>
			<?php } ?>
			<?php if($eshopoptions['shipping']=='4'){//shipping by weight 
			?>
			<td headers="eshopweight eshopnumrow<?php echo $i; ?>"><label for="eshop_weight_<?php echo $i; ?>"><?php _e('Weight','eshop'); ?> <?php echo $i; ?></label><input id="eshop_weight_<?php echo $i; ?>" name="eshop_weight_<?php echo $i; ?>" value="<?php echo $weight; ?>" type="text" size="6" /></td>
			<?php 
			} 
			if($eshopoptions['stock_control']=='yes'){
			?>
			<td headers="eshopstkqty eshopnumrow<?php echo $i; ?>"><label for="eshop_stkqty_<?php echo $i; ?>"><?php _e('Stock','eshop'); ?> <?php echo $i; ?></label><input id="eshop_stkqty_<?php echo $i; ?>" name="eshop_stkqty_<?php echo $i; ?>" value="<?php echo $stkqty; ?>" type="text" size="6" /></td>
			<?php 
			} 
			?>
			</tr>
			<?php
		 }
    ?>
 </tbody>
	</table>
<table class="hidealllabels widefat eshoppopt" id="eshoppopt_whs">
<input type="hidden" id="eshoppopt_price_num" name="eshoppopt_price_num" value="<?php echo count($eshop_whs_data);?>"/>
<tbody>
<?php
$eshop_whs_data=maybe_unserialize(get_post_meta( $post->ID, '_eshop_whs',true ));
if(is_array($eshop_whs_data)){
foreach($eshop_whs_data as $key=>$val){
?>
	<tr id="tr_<?php echo $key;?>">
		<td headers="eshopoption eshopnumrow1" colspan="2">
			购买数量区间			
			<input name="eshop_whs[<?php echo $key;?>][qty_start]" value="<?php echo $val[qty_start];?>" type="text"
			size="6"> 到 <input name="eshop_whs[<?php echo $key;?>][qty_end]" value="<?php echo $val[qty_end];?>" type="text"
			size="6">
		</td>		 
		<td headers="eshopsaleprice eshopnumrow1">
			<input id="eshop_whs_1" name="eshop_whs[<?php echo $key;?>][price]" value="<?php echo $val[price];?>" type="text"
			size="15">
			<p>价格变化（添加实例:加价5，填写“+5”，减价填写“-5”）</p>
		</td>
		<td headers="eshopweight eshopnumrow1">
			 <a style="float:right;color:red" href="javascript:void(0)" onclick="remove_whs_box(<?php echo $key;?>)">删除</a>
		</td>
	</tr>
	</tbody>
<?php
    }
}
?>
</table>
<a style="float:right;color:red" href="javascript:void(0)" onclick="add_whs_box()">+添加批发价格</a>

<div id="" class="clear"></div>
<?php
$eshop_rolesprcie_data=maybe_unserialize(get_post_meta( $post->ID, '_eshop_rolesprcie',true ));
if(!$eshop_rolesprcie_data){$eshop_rolesprcie_data[0]=array();}
$wp_user_roles = get_option('wp_user_roles');
$str_option = $str_option2 = $key='';
foreach($wp_user_roles as $key=>$roles){
	$str_option .= '<option value="'.$key.'">'.$roles['name'].'</option>';
}
?>
<div id="user_roles_html" style="display:none;">
	用户组：<select id="" name="str['user_roles']"><?echo $str_option;?></select>
</div>
<!-- end-->
<table class="hidealllabels widefat eshoppopt" id="eshoppopt_rolesprcie">
<input type="hidden" id="eshoppopt_rolesprcie_num" name="eshoppopt_rolesprcie_num" value="<?php echo count($eshop_rolesprcie_data);?>"/>
<tbody>
<?php
if(is_array($eshop_rolesprcie_data)){
foreach($eshop_rolesprcie_data as $key=>$val){
	$str_option2='';
	foreach($wp_user_roles as $key2=>$roles){
		if($val['user_roles']==$key2){
			$str_option2 .= '<option selected value="'.$key2.'">'.$roles['name'].'</option>';
		}else{
			$str_option2 .= '<option value="'.$key2.'">'.$roles['name'].'</option>';
		}		
	}
?>
	<tr id="tr_<?php echo $key;?>">
		<td headers="eshopoption eshopnumrow1" colspan="2">
			 用户组：<select id="" name="eshop_rolesprcie[<?php echo $key;?>][user_roles]"><?echo $str_option2;?></select>
		</td>		 
		<td headers="eshopsaleprice eshopnumrow1">
			<input id="eshop_rolesprcie_1" name="eshop_rolesprcie[<?php echo $key;?>][price]" value="<?php echo $val[price];?>" type="text"
			size="15">
			<p>价格变化（添加实例:加价5，填写“+5”，减价填写“-5”）</p>
		</td>
		<td headers="eshopweight eshopnumrow1">
			 <a style="float:right;color:red" href="javascript:void(0)" onclick="remove_rolesprcie_box(<?php echo $key;?>)">删除</a>
		</td>
	</tr>
	
<?php
    }
}
?>
</tbody>
</table>
	<a style="float:right;color:red;display:block;" href="javascript:void(0)" onclick="add_rolesprcie_box()">+添加会员组折扣</a>
	</div>

<!--2015-02-05-->
<?php
$eshop_diy_option=maybe_unserialize(get_post_meta( $post->ID, '_eshop_diy_option',true ));
 
?>
<style type="text/css" title="">
.diy_option_box div{width:90%;margin:5px 5px;padding:3px;border:1px solid #ccc;
}
.add_option{margin-right:0px;color:red;font-size:22px;font-weight: 700;cursor: pointer
}
</style>
<div>
	<h4><?php _e('自定义参数','eshop'); ?></h4>
	<input type="button" id="add_diy_option_box" name="add_diy_option_box" value="+添加产品参数"/>
	<input type="hidden" id="diy_option_num" value="<?php echo count($eshop_diy_option);?>"/>
	<?php if($eshopoptions['shipping']=='4'){?>
	    <input type="hidden" id="shipping" value="1"/>
    <?php }else{?>
	    <input type="hidden" id="shipping" value="0"/>
	<?php }?>

	<?php if($eshopoptions['stock_control']=='yes'){?>
	    <input type="hidden" id="stock_control" value="1"/>
	<?php }else{?>
	    <input type="hidden" id="stock_control" value="0"/>
	<?php }?>
<style type="text/css" title="">
	.releat_table tr td{border:none;
	}
</style>
<div id="diy_option_box" class="diy_option_box">
<?php 
if(!is_array($eshop_diy_option)){?>	    
		<div id='option_0_box'>		   
		    <table width="100%">
				<tr>
					<td><strong>参数名称：</strong></td>
					<td><input type="text" name="diy_option[][name]" value=""/>展示样式
					<select id="" name="diy_option[0][show_style]">
					<option value="select">下拉框</option>
					<option value="pic" selected>图文兼容</option>
					<option value="checkbox">单选框</option>
					</select></td>
					<td width="8"><a class="close" href="javascript:void(0)" onclick="remove_option_box(0)" style="color:red" clostid="option_0">×</a></td>
				</tr>
				<tr>
					<td><strong>参数项目：</strong></td>
					<td></td>
					<td></td>
				</tr>
		    </table>
		    <table class="hidealllabels widefat eshoppopt" width="45%" id="option_0_table">
				<thead>				   
					<tr>
						<th id="eshopoption">
							NO.
						</th>
						<th id="eshopprice">
							选项
							<span style="color: #ff0000;">
								*
							</span>
						</th>
						<th id="eshopsaleprice">
							价格变化	<span style="color: #ff0000;"> * </span>
						</th>
						<?php if($eshopoptions['shipping']=='4'){?>
						<th id="eshopweight">重量变化
							<span style="color: #ff0000;"> * </span>
						</th>
						<?php }?>
						<?php if($eshopoptions['stock_control']=='yes'){?>
						<th id="eshopweight">库存变化
							<span style="color: #ff0000;"> * </span>
						</th>
						<?php }?>
						<th id="eshopweight">展示图片 (选择图片后会显示图片ID)
							<span style="color: #ff0000;"> * </span>
						</th>						
					</tr>
				</thead>
				<input type="hidden" id="option_0_num" name="option_0_num" value="1"/>
				<tbody>
					<tr>
						<td headers=" eshopnumrow1">
							1.
						</td>
						<td headers="eshopoption eshopnumrow1">
							<input name="diy_option[0][option][0][title]" value="" type="text" size="6">
						</td>
						<td headers="eshopprice eshopnumrow1">
							<input name="diy_option[0][option][0][price]" value="0.00" type="text" size="6">
						</td>
						<?php if($eshopoptions['shipping']=='4'){?>
						<td headers="eshopweight eshopnumrow1">
							<input name="diy_option[0][option][0][weight]" value="0.00" type="text" size="6">
						</td>
						<?php }?>
						<?php if($eshopoptions['stock_control']=='yes'){?><td headers="eshopstock eshopnumrow1">
							<input name="diy_option[0][option][0][stock]" value="0.00" type="text" size="6">
						</td>
						<?php }?>
						<td headers="eshopprice eshopnumrow1" class="acf-image-uploader" data-preview_size="thumbnail" data-library="uploadedTo">
							<input class="acf-image-value" name="diy_option[0][option][0][img]" value="" type="text" size="40">							 
							<input type="button" class="button add-image" value="添加图片">
					    </td>						
					</tr>	
					 					
				</tbody>
			</table>
			<span class="add_option" onclick="add_option(0)">+</span>
			<!-- end-->
		</div>
<?php }else{
$k=0;
foreach($eshop_diy_option as $option){
?>
        <div id='option_<?php echo $k;?>_box'>		   
		    <table width="100%">
				<tr>
					<td><strong>参数名称：</strong></td>
					<td><input type="text" name="diy_option[][name]" value="<?php echo $option['name'];?>"/>展示样式
					<select id="" name="diy_option[<?php echo $k;?>][show_style]">
					<option value="select" <?php if($option['show_style']=='select') echo "selected";?>>下拉框</option>
					<option value="pic"  <?php if($option['show_style']=='pic') echo "selected";?>>图文兼容</option>
					<option value="checkbox"  <?php if($option['show_style']=='checkbox') echo "selected";?>>单选框</option>
					</select></td>
					<td width="8"><a class="close" href="javascript:void(0)" onclick="remove_option_box(<?php echo $k;?>)" style="color:red" clostid="option_0">×</a></td>
				</tr>
				<tr>
					<td><strong>参数项目：</strong></td>
					<td></td>
					<td></td>
				</tr>
		    </table>
		    <table class="hidealllabels widefat eshoppopt" width="45%" id="option_<?php echo $k;?>_table">
				<thead>				   
					<tr>
						<th id="eshopoption">
							NO.
						</th>
						<th id="eshopprice">
							选项
							<span style="color: #ff0000;">
								*
							</span>
						</th>
						<th id="eshopsaleprice">
							价格变化
							<span style="color: #ff0000;">
								*
							</span>
						</th>
				       <?php if($eshopoptions['shipping']=='4'){ ?>
					   <th id="eshopweight">
							重量变化
							<span style="color: #ff0000;"> * </span>
						</th>
						<?php } ?>
						<?php if($eshopoptions['stock_control']=='yes'){?>
						<th id="eshopweight">库存变化
							<span style="color: #ff0000;"> * </span>
						</th>
						<?php }?>
						<th id="eshopweight">展示图片
							<span style="color: #ff0000;"> * </span>
						</th>
						<th id="eshopweight">条件显示</th>
					</tr>
				</thead>
				<input type="hidden" id="option_<?php echo $k;?>_num" name="option_<?php echo $k;?>_num" value="<?php echo count($option['option']);?>"/>
				<tbody>
<?php 
$n=0;
if(is_array($option['option'])){
foreach($option['option'] as $val){
	if($val[title]!=''){
?>
					<tr>
						<td headers=" eshopnumrow1">
							<?php echo $n+1;?>.
						</td>
						<td headers="eshopoption eshopnumrow1">
							<input name="diy_option[<?php echo $k;?>][option][<?php echo $n;?>][title]" value="<?php echo $val[title];?>" type="text" size="6">
						</td>
						<td headers="eshopprice eshopnumrow1">
<?php
if($val[price]=='' || !is_numeric($val[price]))$val[price]='0.00';
?>
<input name="diy_option[<?php echo $k;?>][option][<?php echo $n;?>][price]" value="<?php echo $val[price];?>" type="text" size="6">
			
						</td>
						<?php if($eshopoptions['shipping']=='4'){//shipping by weight 
			?>
<?php
if($val[weight]=='' || !is_numeric($val[weight]))$val[weight]='0';
?>
			<td headers="eshopweight eshopnumrow1">
							<input name="diy_option[<?php echo $k;?>][option][<?php echo $n;?>][weight]" value="<?php echo $val[weight];?>" type="text" size="6">
						</td>

<?php
}
?>
<?php if($eshopoptions['stock_control']=='yes'){?><td headers="eshopstock eshopnumrow1">
							<input name="diy_option[<?php echo $k;?>][option][<?php echo $n;?>][stock]" value="<?php echo $val[stock];?>" type="text" size="6">
						</td>
<?php }?>
						<td headers="eshopprice eshopnumrow1" class="acf-image-uploader" data-preview_size="thumbnail" data-library="uploadedTo">
						<input class="acf-image-value" name="diy_option[<?php echo $k;?>][option][<?php echo $n;?>][img]" value="<?php echo $val[img];?>" type="text" size="10">							 
						<input type="button" class="button add-image" value="添加图片">
					    </td>
						<td>	
						<table class='releat_table'>
							<tr>
								<td><input type="checkbox" name="diy_option[<?php echo $k;?>][option][<?php echo $n;?>][relate_yes]" value="1" <?php if($val['relate_yes']==1) echo "checked";?> />启用</td><td>
								<select class='diy_option_select' id="diy_option_<?php echo $k;?>_<?php echo $n;?>" name="diy_option[<?php echo $k;?>][option][<?php echo $n;?>][relate][name]">
								    <option value="0">无</option>
									<?php 
	                                    foreach($eshop_diy_option as $val_option){
	                                      if($option['name']!=$val_option['name']){		
	                                   ?>
									    <option value="<?php echo $val_option['name'];?>" <?php if($val['relate']['name']==$val_option['name']) echo "selected";?>><?php echo $val_option['name'];?></option>
									<?php } } ?>	
								</select></td>
							</tr>
							<tr>
								<td></td><td>
								<?php foreach($eshop_diy_option as $val_option){ 
									   if($option['name']!=$val_option['name']){	   
								?>
							      <div id="diy_option_<?php echo $k;?>_<?php echo $n;?>_<?php echo $val_option['name'];?>" class="diy_option_<?php echo $k;?>_<?php echo $n;?>_div" class="" style="border:none;<?php if($val['relate']['name']==$val_option['name']) echo "display:"; else echo "display:none";?>;">
								     <?php foreach($val_option['option'] as $v){?>
									    <p><input type="checkbox" id="" name="diy_option[<?php echo $k;?>][option][<?php echo $n;?>][relate][val][]" value="<?php echo $v['title'];?>@<?php echo $v['price'];?>@<?php echo $v['weight'];?>@<?php echo $v['img'];?>" <?php if(@in_array($v['title']."@".$v['price']."@".$v['weight']."@".$v['img'],$val['relate']['val'])) echo "checked";?>/><?php echo $v[title];?></p>
									<?php }?>
								</div>
								<?php } }?></td>
							</tr>
						</table>					 							 
					    </td>
</tr>	
<?php	
	$n++;
	}
}
}
?>					 
				</tbody>
			</table>
			<span class="add_option" onclick="add_option(<?php echo $k;?>)">+</span>
			<!-- end-->
		</div>
<?php 
       if(($k+1)%2==0){
            echo '<dl class="clear"> </dl>';
        }
		$k++;}
	}
?>	 
	</div>
</div>
<div class="clear"><br /></div>
<script type="text/javascript" src="/wp-content/plugins/eshop/js/t9_diy_option_box.js"></script>
<!--2015-02-05 end-->
	<?php
	$opttable=$wpdb->prefix.'eshop_option_names';
	$myrowres=$wpdb->get_results("select *	from $opttable ORDER BY name ASC");
	if(sizeof($myrowres)>0){
	?>
	<div id="eshoposetc">
	<h4><?php _e('通用参数模块选择','eshop'); ?></h4>
	<div id="eshoposets">
	<ul>
	<?php
	$oi=1;
	if(!is_array($osets)) $osets=array();
	foreach($myrowres as $row){
		$displayname=$row->name;
		if(isset($row->admin_name) && $row->admin_name!='')
			$displayname=$row->admin_name;
	?>
		<li><input type="checkbox" name="eshoposets[]" id="osets<?php echo $oi; ?>" value="<?php echo $row->optid; ?>"<?php if(in_array($row->optid,$osets)) echo ' checked="checked"'; ?> /><label for="osets<?php echo $oi; ?>"><?php echo stripslashes(esc_attr($displayname))?></label></li>
	<?php
		$oi++;
	}
	?>
	</ul>
	</div>
	</div>
	<?php } ?>
	<div id="eshoposetc">
    <h4><?php _e('运费/库存设置','eshop'); ?></h4>
    <?php
	if($eshopoptions['downloads_only'] !='yes' && $eshopoptions['shipping']!='4'){
		?>
		<p><label for="eshop_shipping_rate"><?php _e('运费模块选择','eshop'); ?></label> <select name="eshop_shipping_rate" id="eshop_shipping_rate">
		<option value=""><?php _e('Free Shipping','eshop'); ?></option>
		<?php
		if(isset($eshop_product['shiprate']) && $eshop_product['shiprate']!=''){
			$selected = $eshop_product['shiprate'];
		}else{
			$selected = '';
			$eshop_product['shiprate']='';
		}
		
		$shipcodes_arr=array('A','B','C','D','E','F');
		$shipcodes=apply_filters('eshop_ship_rate_class_array',$shipcodes_arr);
		$size = sizeof($shipcodes)-1;
		for($i=0;$i<=$size;$i++){
			$disshipclass=apply_filters('eshop_shipping_rate_class',$shipcodes[$i]);
			$checked = ( trim($shipcodes[$i]) == trim( $eshop_product['shiprate'] ) ) ? 'selected="selected"' : '';
			echo '<option value="'.$shipcodes[$i].'"'.$checked.'>'.$disshipclass."</option>\n";
		}
		?>
    </select></p>
    <?php
    }else{
	?>
		<input type="hidden" name="eshop_shipping_rate" value="F" />
	<?php
	}
	?>
    <div><input id="eshop_sale_product" name="eshop_sale_product" value="yes"<?php echo isset($eshop_product['sale']) && $eshop_product['sale']=='yes' ? 'checked="checked"' : ''; ?> checked="checked" type="checkbox" /> <label for="eshop_sale_product" class="selectit"><?php _e('产品上架','eshop'); ?> (默认必选)</label></div>
    <div><input id="eshop_stock_available" name="eshop_stock_available" value="Yes"<?php echo $stkav=='1' ? 'checked="checked"' : ''; ?> checked="checked" type="checkbox" /> <label for="eshop_stock_available" class="selectit"><?php _e('库存充足','eshop'); ?> (默认必选)</label></div>
    <?php
    /*
    if($eshopoptions['stock_control']=='yes'){
    ?>
    <p><label for="eshop_stock_quantity"><?php _e('Stock Quantity','eshop'); ?></label> <input id="eshop_stock_quantity" name="eshop_stock_quantity" value="<?php if(isset($eshop_product['qty'])) echo $eshop_product['qty']; ?>" type="text" size="4" /></p>
    <?php
    }
    */
    ?>
	</div><div id="eshoposetc">
    <h4><?php _e('不支持的快递方式选择','eshop'); ?></h4>
     <?php 
	     $not_eshop_shiptype=array();
         $not_eshop_shiptype=maybe_unserialize(get_post_meta( $post->ID, '_not_eshop_shiptype',true ));
		 $typearr=explode("\n", $eshopoptions['ship_types']);
         foreach($typearr as $key=>$ship_types){
	 ?>
    <div><input type="checkbox" name="not_eshop_shiptype[]" id="<?php echo $key;?>" value="<?php echo $key;?>" <?php echo @in_array($key,$not_eshop_shiptype) ? 'checked="checked"' : ''; ?> /> <label for="<?php echo $key;?>" class="selectit"><?php echo $ship_types?></label></div>     
    <?php
	}
	echo '</div><div class="clear"><br /></div>';

}

/* When the post is saved, saves our custom data */
function eshop_save_postdata( $post_id ) {
	global $wpdb,$eshopoptions;
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if (!isset($_POST['eshop_noncename'])){
		return $post_id;
	}
	
	if ( !wp_verify_nonce( $_POST['eshop_noncename'], plugin_basename(__FILE__) )) {
		return $post_id;
	}

	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ))
	  		return $post_id;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ))
	  		return $post_id;
	}
  
	if( !isset( $id ) )
		$id = $post_id;
  // OK, we're authenticated: we need to find and save the data
	$stkav=get_post_meta( $post_id, '_eshop_stock',true );
    $eshop_product=maybe_unserialize(get_post_meta( $post_id, '_eshop_product',true ));
	
	$eshop_product['sku']=get_the_ID();
	$numoptions=$eshopoptions['options_num'];
	for($i=1;$i<=$numoptions;$i++){
		$eshop_product['products'][$i]['option']=htmlspecialchars($_POST['eshop_option_'.$i]);
		if($_POST['eshop_price_'.$i]=='0') $_POST['eshop_price_'.$i]='0.00';
		$eshop_product['products'][$i]['price']=$_POST['eshop_price_'.$i];
		if(!is_numeric($_POST['eshop_price_'.$i]) && $_POST['eshop_price_'.$i]!=''){
			add_filter('redirect_post_location','eshop_price_error');
		}
		if(isset($_POST['eshop_download_'.$i])){
			$eshop_product['products'][$i]['download']=$thisdl=$_POST['eshop_download_'.$i];
		}
		if(isset($_POST['eshop_tax_'.$i])){
			$eshop_product['products'][$i]['tax']=$_POST['eshop_tax_'.$i];
		}
		if(isset($_POST['eshop_weight_'.$i])){
			$eshop_product['products'][$i]['weight']=$_POST['eshop_weight_'.$i];
			if(!is_numeric($_POST['eshop_weight_'.$i]) && $_POST['eshop_weight_'.$i]!=''){
				add_filter('redirect_post_location','eshop_weight_error');
			}
		}
		if(isset($_POST['eshop_stkqty_'.$i])){
			$eshop_product['products'][$i]['stkqty']=$_POST['eshop_stkqty_'.$i];
			if(!is_numeric($_POST['eshop_stkqty_'.$i]) && $_POST['eshop_stkqty_'.$i]!=''){
				add_filter('redirect_post_location','eshop_stkqty_error');
			}
		}
		if(!isset($_POST['eshop_saleprice_'.$i]) || $_POST['eshop_saleprice_'.$i]==''){
			$eshop_product['products'][$i]['saleprice'] = '';
		}elseif(!is_numeric($_POST['eshop_saleprice_'.$i])){
			add_filter('redirect_post_location','eshop_saleprice_error');
		}else{
			$eshop_product['products'][$i]['saleprice'] = $_POST['eshop_saleprice_'.$i];
		}
	}
	$eshop_product['description']=get_the_title();	$eshop_product['amazon_link']=$_POST['amazon_link'];
	$eshop_product['shiprate']=$_POST['eshop_shipping_rate'];
	if($eshop_product['shiprate']=='') $mydata['_Shipping Rate']='F';
	if(isset($_POST['eshop_featured_product'])){
		$eshop_product['featured']='Yes';
		update_post_meta( $id, '_eshop_featured', 'Yes');
	}else{
		$eshop_product['featured']='no';
		delete_post_meta( $id, '_eshop_featured');
	}
	if(isset($_POST['eshop_sale_product'])){
		$eshop_product['sale']='yes';
		update_post_meta( $id, '_eshop_sale', 'yes');
	}else{
		$eshop_product['sale']='no';
		delete_post_meta( $id, '_eshop_sale');
	}
	
	
	
	if(isset($_POST['eshop_stock_available']))
		$stkav='1';
	else
		$stkav='0';
		
	$stocktable=$wpdb->prefix ."eshop_stock";
	//test stk control per option
	for($i=1;$i<=$numoptions;$i++){
		if(isset($eshop_product['products'][$i]['stkqty']) && $eshop_product['products'][$i]['stkqty']!='' && is_numeric($eshop_product['products'][$i]['stkqty'])){
			$stkv=$eshop_product['products'][$i]['stkqty'];
			// Clicking update appears to trigger this function twice (once to create a revision I think, and once to save).  Upshot is that we can't rely on the $post_id variable so...
			$pid = $_POST['post_ID'];
			$sql = "select post_id from $stocktable WHERE post_id=$pid AND option_id=$i";
			$result=$wpdb->get_results($sql);
			if( !empty( $result ) ){
				$sql = "UPDATE $stocktable set available=$stkv where post_id=%d AND option_id=%d";
				$wpdb->query($wpdb->prepare($sql,$pid,$i));
			} else {
				$sql = "INSERT INTO $stocktable (post_id,option_id,available,purchases) VALUES (%d,%d,%d,0)";
				$wpdb->query($wpdb->prepare($sql,$pid,$i,$stkv));
			}
		}
	}
	
	//form setup
	$eshop_product['cart_radio']=$_POST['eshop_cart_radio'];
	//option sets
	if(isset($_POST['eshoposets'])){
		$eshop_product['optset']=$_POST['eshoposets'];
	}else{
		$eshop_product['optset']='';
	}
	update_post_meta( $id, '_eshop_product', $eshop_product);
	if($stkav=='0')
		delete_post_meta( $id, '_eshop_stock');
	else
		update_post_meta( $id, '_eshop_stock', $stkav);

		
	if($stkav=='1' && (trim($eshop_product['sku'])=='' || trim($eshop_product['description'])=='' || trim($eshop_product['products']['1']['option'])=='' || trim($eshop_product['products']['1']['price'])=='')){
		delete_post_meta( $id, '_eshop_stock');
		add_filter('redirect_post_location','eshop_error');
	}
	if($stkav=='0' && trim($eshop_product['sku'])=='' && trim($eshop_product['description'])=='' && trim($eshop_product['products']['1']['option'])=='' && trim($eshop_product['products']['1']['price'])==''){
	//not a product
		delete_post_meta( $id, '_eshop_stock');
		delete_post_meta( $id, '_eshop_product');
	}
	//2015-02-07
	$diy_option = array_filter($_POST['diy_option']);
	 
	update_post_meta( $id, '_eshop_diy_option',$diy_option);
	
	//2015-06-27 增加批发价
	$eshop_whs = array_filter($_POST['eshop_whs']);
	update_post_meta( $id, '_eshop_whs',$eshop_whs);
	//2015-06-27 增加批发价---end
    
	$not_eshop_shiptype = $_POST['not_eshop_shiptype'];
	update_post_meta( $id, '_not_eshop_shiptype',$not_eshop_shiptype);
	
	$eshop_rolesprcie = array_filter($_POST['eshop_rolesprcie']);
	update_post_meta( $id, '_eshop_rolesprcie',$eshop_rolesprcie);

	if(is_array($_POST['combination_sale_ids'])){
		$combination_sale_ids = implode(',',$_POST['combination_sale_ids']);
	    update_post_meta( $id, '_eshop_combination_sale_ids',$combination_sale_ids);
	}	
	return;
}
//2015-02-08
function add_combination_sale_box (){//添加设置区域的函数
add_meta_box('combination_sale_box', __( '组合销售', 'eshop' ), 'combination_sale_box','post','side','high',array());
};
add_action('add_meta_boxes','add_combination_sale_box');
function combination_sale_box($post,$boxargs){
	 $combination_sale_ids = get_post_meta($post->ID, '_eshop_combination_sale_ids',true);
     $combination_sale_ids_arr = explode(',',$combination_sale_ids);
	    $out = '';
		$args = array(
			'post__not_in'   => array($post->ID),
			'numberposts' => 1000,
			'post_type' => 'post',
			'meta_query' => array(
			'relation' => 'OR',
				array(
					'key' => 'special',
					'value' => 'Frequently Bought Together',
					'compare' => 'LIKE'
				)
			)
		);		
      $all_posts = query_posts($args);
      foreach( $all_posts as $post ){
		  if(in_array($post->ID,$combination_sale_ids_arr)){
			  $checked='checked';
		  }else{
		      $checked='';
		  }
         $thumb_id = get_post_meta($post->ID, "_thumbnail_id",true);		  
		 $thumbnail = wp_get_attachment_image_src( $thumb_id, 'thumbnail',true );		 
		$out_tr .= '<tr><td align="center"><input id="in-'.$post->ID.'" type="checkbox" '.$checked.' name="combination_sale_ids[]" value="'.$post->ID.'"></td><td ><img src="'.$thumbnail[0].'" alt="" width="30"/></td><td>'.$post->post_title.'</td></tr>'; 
	  }
       $out =  '
	   <!--<div style="text-align: right;">产品名称<form method="post" action=""><input type="" id="" name=""/><input type="submit" id="" name="dosubmit" value="搜索产品"/></form></div>-->
       <!-- end--><table class="hidealllabels widefat eshoppopt" id="eshoppopt_price"><thead><tr><th id="eshopoption"><input type="checkbox" id="" name="ids"/></th><th id="eshopprice">快照</th><th id="eshopsaleprice">商品名称</th></tr></thead><tbody>'.$out_tr.'</tbody></table>';
	   echo $out;
};

?>