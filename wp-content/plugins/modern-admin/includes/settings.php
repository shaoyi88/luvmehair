<?php

global $wpdb;
if(isset($_POST['reset_modern_settings'])) $Options=$this->getOptions(true);
else $Options=$this->getOptions();
if(isset($_POST['reset_modern_settings'])) {
	delete_option($this->OptionsName);
	delete_option($wpdb->prefix.'modern_admin_dashboard_widget_registered');
	?>
	<div class="updated"><p><strong><?php _e('Reset successfully',self::LANG);?>.</strong></p></div>
<?php
}
if (isset($_POST['save_modern_settings'])) {
	$settings=array();
	if(isset($_POST['settings'])){
		foreach($_POST['settings'] as $key => $value){
			$settings[$key]=stripslashes($value);
		}
		if(!isset($_POST['settings']['admin_footer_version'])) $settings['admin_footer_version']=0;
		if(!isset($_POST['settings']['turnon'])) $settings['turnon']=0;
		$Options['settings'] = $settings;
		if(isset($_POST['user_roles'])){
			$user_roles= array();
			foreach($_POST['user_roles'] as $key => $value){
				$user_roles[$key]=stripslashes($value);
			}
			$Options['user_roles'] = $user_roles;

		}
		update_option($this->OptionsName, $Options);

	}
	?>
	<div class="updated"><p><strong><?php _e('Settings Updated',self::LANG);?>.</strong></p></div>
<?php
}

if(isset($_POST['reset_settings'])){
	unset($Options['settings']);
	unset($Options['user_roles']);
	update_option($this->OptionsName, $Options);
	?>
	<div class="updated"><p><strong><?php _e('Reset ok',self::LANG);?>.</strong></p></div>
<?php
}
$UserRoles = $this->get_user_role();
$color = (isset($Options['settings']['color']))?$Options['settings']['color']:0;
$hover = (isset($Options['settings']['hover']))?$Options['settings']['hover']:'';
$turnon = (isset($Options['settings']['turnon']))?$Options['settings']['turnon']:1;
$custom_css=(isset($Options['settings']['custom_css']))?$Options['settings']['custom_css']:'';
$admin_logo_image = (isset($Options['settings']['admin_logo_image']))?$Options['settings']['admin_logo_image']:'';
$admin_logo_text = (isset($Options['settings']['admin_logo_text']))?$Options['settings']['admin_logo_text']:'';
$admin_logo_url = (isset($Options['settings']['admin_logo_url']))?$Options['settings']['admin_logo_url']:'';
$admin_footer_text = (isset($Options['settings']['admin_footer_text']))?$Options['settings']['admin_footer_text']:'';
$admin_footer_version = (isset($Options['settings']['admin_footer_version']))?$Options['settings']['admin_footer_version']:1;
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br></div>
<h2><?php _e('Settings',self::LANG);?></h2>

<form action="" method="post">
<table class="form-table" id="modern-admin-icons-table">
	<tbody>
	<tr valign="top">
		<th scope="row">Turn On</th>
		<td id="front-static-pages">
			<p>

				<input type="checkbox" id="admin_turn_on" value="1" <?php checked($turnon,'1');?> name="settings[turnon]"/>
			</p>
		</td>
	</tr>
	</tbody>
</table>
<?php if($turnon):?>
	<h4><?php _e('Apply For',self::LANG);?></h4>
	<table class="form-table" id="modern-admin-icons-table">
		<tbody>

		<?php
		//$admin_list = array("administrator","super admin","Super Admin","Administrator");
		foreach($UserRoles as $role_name => $val): ?>
			<?php

			if(!isset($Options['user_roles']) || empty($Options['user_roles'])) $checked=1;
			else $checked = (isset($Options['user_roles'][$role_name]))?$Options['user_roles'][$role_name]:0;

			?>
			<?php //if(!in_array($role_name,$admin_list)):?>
			<tr valign="top">
				<th scope="row"><?php echo $role_name; ?></th>
				<td id="front-static-pages">

					<input type="checkbox" id="admin_turn_on" value="1" <?php checked($checked,'1');?> name="user_roles[<?php echo $role_name; ?>]"/>

				</td>
			</tr>
			<?php //endif;?>
		<?php endforeach; ?>

		</tbody>
	</table>
	<h4><?php _e('Color',self::LANG);?></h4>
	<table class="form-table" id="modern-admin-icons-table">
		<tbody>
		<tr valign="top">
			<th scope="row"><?php _e('Choose color',self::LANG);?></th>
			<td id="front-static-pages">

				<p>
					<label for="admin_color1"><?php _e('Default',self::LANG);?></label>
					<input type="radio" id="admin_color1" class="tog" value="0" <?php checked($color,0);?> name="settings[color]">

				</p>
				<p>
					<label for="admin_color2"><?php _e('Red',self::LANG);?></label>
					<input type="radio" id="admin_color2" class="tog" value="red" <?php checked($color,'red');?> name="settings[color]">

				</p>
				<p>
					<label for="admin_color3"><?php _e('Yellow',self::LANG);?></label>
					<input type="radio" id="admin_color3" class="tog" value="yellow" <?php checked($color,'yellow');?> name="settings[color]">

				</p>
				<p>
					<label for="admin_color4"><?php _e('Green',self::LANG);?></label>
					<input type="radio" id="admin_color4" class="tog" value="green" <?php checked($color,'green');?> name="settings[color]">

				</p>
				<p>
					<label for="admin_color5"><?php _e('Purple',self::LANG);?></label>
					<input type="radio" id="admin_color5" class="tog" value="purple" <?php checked($color,'purple');?> name="settings[color]">

				</p>

				<p>
					<label for="admin_color6"><?php _e('Custom',self::LANG);?></label>
					<input type="radio" id="admin_color6" class="tog" value="custom" <?php checked($color,'custom');?> name="settings[color]">
				<div class='custom-color' style="display: none">
					<p>
						<?php
						$field = "main_color";
						$value = (isset($Options['settings']['custom_color_'.$field]))?$Options['settings']['custom_color_'.$field]:'';
						$value2 = (isset($Options['settings']['custom_color_'.$field.'_d']))?$Options['settings']['custom_color_'.$field.'_d']:'';
						?>
						<label for="<?php echo $field;?>">Main Color:</label>
						<input type="text" class="choosecolor custom_color" style="margin-top: -10px;" id="<?php echo $field;?>" name="settings[custom_color_<?php echo $field;?>]" value="<?php echo $value;?>"  >
						<input type="hidden" class="custom_color" name="settings[custom_color_<?php echo $field;?>_d]" value="<?php echo $value2;?>"  >
					</p>

					<p>
						<?php
						$field = "link_color";
						$value = (isset($Options['settings']['custom_color_'.$field]))?$Options['settings']['custom_color_'.$field]:'';
						$value2 = (isset($Options['settings']['custom_color_'.$field.'_d']))?$Options['settings']['custom_color_'.$field.'_d']:'';
						?>
						<label for="<?php echo $field;?>">Link Color:</label>
						<input type="text" class="choosecolor custom_color" id="<?php echo $field;?>"  name="settings[custom_color_<?php echo $field;?>]" value="<?php echo $value;?>"  >
						<input type="hidden" class="custom_color" name="settings[custom_color_<?php echo $field;?>_d]" value="<?php echo $value2;?>"  >
					</p>
					<p>
						<?php
						$field = "link_active_color";
						$value = (isset($Options['settings']['custom_color_'.$field]))?$Options['settings']['custom_color_'.$field]:'';
						$value2 = (isset($Options['settings']['custom_color_'.$field.'_d']))?$Options['settings']['custom_color_'.$field.'_d']:'';
						?>
						<label for="<?php echo $field;?>">Link Active/Hover Color:</label>
						<input type="text" class="choosecolor custom_color" id="<?php echo $field;?>"  name="settings[custom_color_<?php echo $field;?>]" value="<?php echo $value;?>"  >
						<input type="hidden" class="custom_color" name="settings[custom_color_<?php echo $field;?>_d]" value="<?php echo $value2;?>"  >
					</p>
					<p>
						<?php
						$field = "admin_bar_bg_color";
						$value = (isset($Options['settings']['custom_color_'.$field]))?$Options['settings']['custom_color_'.$field]:'';
						$value2 = (isset($Options['settings']['custom_color_'.$field.'_d']))?$Options['settings']['custom_color_'.$field.'_d']:'';
						?>
						<label for="<?php echo $field;?>">Sidebar Background Color:</label>
						<input type="text" class="choosecolor custom_color" id="<?php echo $field;?>" name="settings[custom_color_<?php echo $field;?>]" value="<?php echo $value;?>"  >
						<input type="hidden" class="custom_color" name="settings[custom_color_<?php echo $field;?>_d]" value="<?php echo $value2;?>"  >
					</p>
					<p>
						<?php
						$field = "admin_bar_text_color";
						$value = (isset($Options['settings']['custom_color_'.$field]))?$Options['settings']['custom_color_'.$field]:'';
						$value2 = (isset($Options['settings']['custom_color_'.$field.'_d']))?$Options['settings']['custom_color_'.$field.'_d']:'';
						?>
						<label for="<?php echo $field;?>">Sidebar Text Color:</label>
						<input type="text" class="choosecolor custom_color" id="<?php echo $field;?>" name="settings[custom_color_<?php echo $field;?>]" value="<?php echo $value;?>"  >
						<input type="hidden" class="custom_color" name="settings[custom_color_<?php echo $field;?>_d]" value="<?php echo $value2;?>"  >
					</p>
					<p>
						<?php
						$field = "button_bg_color";
						$value = (isset($Options['settings']['custom_color_'.$field]))?$Options['settings']['custom_color_'.$field]:'';
						$value2 = (isset($Options['settings']['custom_color_'.$field.'_d']))?$Options['settings']['custom_color_'.$field.'_d']:'';
						?>
						<label for="<?php echo $field;?>">Button Background Color:</label>
						<input type="text" class="choosecolor custom_color" id="<?php echo $field;?>" name="settings[custom_color_<?php echo $field;?>]" value="<?php echo $value;?>"  >
						<input type="hidden" class="custom_color" name="settings[custom_color_<?php echo $field;?>_d]" value="<?php echo $value2;?>"  >
					</p>
					<p>
						<?php
						$field = "button_text_color";
						$value = (isset($Options['settings']['custom_color_'.$field]))?$Options['settings']['custom_color_'.$field]:'';
						$value2 = (isset($Options['settings']['custom_color_'.$field.'_d']))?$Options['settings']['custom_color_'.$field.'_d']:'';
						?>
						<label for="<?php echo $field;?>">Button Text Color:</label>
						<input type="text" class="choosecolor custom_color" id="<?php echo $field;?>" name="settings[custom_color_<?php echo $field;?>]" value="<?php echo $value;?>"  >
						<input type="hidden" class="custom_color" name="settings[custom_color_<?php echo $field;?>_d]" value="<?php echo $value2;?>"  >
					</p>

				</div>
				</p>
			</td>
		</tr>
		</tbody>
	</table>
	<h4><?php _e('Admin menu',self::LANG);?></h4>
	<table class="form-table" id="modern-admin-icons-table">
		<tbody>
		<tr valign="top">
			<th scope="row"></th>
			<td id="front-static-pages">
				<p>
					<input type="checkbox" id="admin_menu_hover" value="hover" <?php checked($hover,'hover');?> name="settings[hover]"/>
					<label for="admin_menu_hover"><?php _e('Hover to show submenu',self::LANG);?></label>
				</p>
			</td>
		</tr>
		</tbody>
	</table>
	<h4><?php _e('Admin logo',self::LANG);?></h4>
	<table class="modern-admin-form form-table">
		<tbody>
		<tr valign="top">
			<th scope="row"><label for="admin_logo_image"><?php _e('Admin Logo Image',self::LANG);?></label></th>
			<td>
				<input type="text" class="regular-text" id="admin_logo_image" value="<?php echo stripslashes($admin_logo_image);?>" name="settings[admin_logo_image]">
				<input type="button" class="button button-secondary" value="Upload" name="admin_upload">
			</td>

		</tr>
		<tr valign="top">
			<th scope="row"><label for="admin_logo_image"><?php _e('Admin Logo Text',self::LANG);?></label></th>
			<td>
				<input type="text" class="regular-text" id="admin_logo_image" value="<?php echo esc_html(stripslashes($admin_logo_text));?>" name="settings[admin_logo_text]">

			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="admin_logo_url"><?php _e('Logo URL',self::LANG);?></label></th>
			<td>
				<input type="text" class="regular-text" id="admin_logo_url" value="<?php echo esc_html(stripslashes($admin_logo_url));?>" name="settings[admin_logo_url]">

			</td>

		</tr>

		</tbody>
	</table>
	<h4><?php _e('Footer Settings',self::LANG);?></h4>
	<table class="modern-admin-form form-table">
		<tbody>
		<tr valign="top">
			<th scope="row"><label for="admin_footer_text"><?php _e('Footer Text',self::LANG);?></label></th>
			<td>
				<input type="text" class="regular-text" id="admin_footer_text"  value="<?php echo esc_html(stripslashes($admin_footer_text));?>" name="settings[admin_footer_text]">
			</td>

		</tr>
		<tr valign="top">
			<th scope="row"><label for="admin_footer_version"><?php _e('Footer Version',self::LANG);?></label></th>
			<td>
				<input type="checkbox" id="admin_footer_version" value="1" name="settings[admin_footer_version]" <?php checked($admin_footer_version,1);?>>
			</td>

		</tr>
		</tbody>
	</table>
	<h4><?php _e('Custom CSS',self::LANG);?></h4>
	<table class="modern-admin-form form-table">
		<tbody>
		<tr valign="top">
			<th scope="row"><label for="your_custom_css"><?php _e('Your CSS',self::LANG);?></label></th>
			<td>
				<textarea name="settings[custom_css]" id="your_custom_css"><?php echo $custom_css;?></textarea>
			</td>

		</tr>

		</tbody>
	</table>
<?php endif?>
<p class="submit">

	<input type="submit" name="save_modern_settings" class="button button-primary"  value="<?php _e('Save Changes',self::LANG);?>">
	<input type="submit" name="reset_settings" class="button button-secondary"  value="<?php _e('Reset',self::LANG);?>">
</p>
<?php if($turnon):?>
	<input type="submit" name="reset_modern_settings" class="button button-secondary"  value="<?php _e('Reset All Settings',self::LANG);?>">
<?php endif;?>
</form>
</div>