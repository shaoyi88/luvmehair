<?php
if(isset($_POST['import_settings'])){
	$content=false;
	if(isset($_POST['modern_admin_option_settings']) && !empty($_POST['modern_admin_option_settings'])){
		$content = $_POST['modern_admin_option_settings'];
		$content = stripslashes($content);
		$content = unserialize($content);
	}
	if(is_array($content)){
		update_option($this->OptionsName, $content);
		?>
		<div class="updated"><p><strong><?php _e('Import Successfully. Please wait few seconds to load data.',self::LANG);?>.</strong></p></div>
		<script>
			setInterval(function(){
				window.location.href=window.location.href;
			}, 2000)
		</script>
	<?php
	}else{
		?>
		<div class="updated"><p><strong><?php _e('There are somethings wrong',self::LANG);?>.</strong></p></div>
		<?php
	}

}
?>

<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2><?php _e('Import/Export Settings',self::LANG);?></h2>


		<h4><?php _e('Import',self::LANG);?></h4>
		<form method="POST" action="">
		<table class="modern-admin-form form-table">
			<tbody>
			<tr valign="top">
				<th scope="row"><label for="admin_logo_image"><?php _e('Import Your Settings',self::LANG);?></label></th>
				<td>
					<textarea rows="10" cols="80" name="modern_admin_option_settings"></textarea>
				</td>

			</tr>
			<tr>
				<td></td>
				<td><input class="button-primary" type="submit" name="import_settings" id="uploadfile_btn" value="Import"  /></td>
			</tr>
			</tbody>
		</table>
		</form>
		<h4><?php _e('Export',self::LANG);?></h4>
		<table class="modern-admin-form form-table">
			<tbody>
			<tr valign="top">
				<th scope="row"><label for="admin_footer_text"><?php _e('Export Your Settings',self::LANG);?></label></th>
				<td>
					<?php
						$Option = $this->getOptions();
						$content = serialize($Option);
					?>
					<textarea rows="10" cols="80"><?php echo $content;?></textarea>


				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="button" name="export_settings" class="button button-primary"  value="<?php _e('Save To File',self::LANG);?>"></td>
			</tr>
			</tbody>
		</table>

</div>
<script>
	jQuery.download = function(url, data, method){
		if( url && data ){
			data = typeof data == 'string' ? data : jQuery.param(data);
			var inputs = '';
			jQuery.each(data.split('&'), function(){
				var pair = this.split('=');
				inputs+='<input type="hidden" name="'+ pair[0] +'" value="'+ pair[1] +'" />';
			});
			jQuery('<form action="'+ url +'" method="'+ (method||'post') +'">'+inputs+'</form>')
				.appendTo('body').submit().remove();
		};
	};
	jQuery(document).ready(function($){
		$("input[name=export_settings]").click(function(){
			$.download(ajaxurl,'action=export_modern_admin');
			return false;
		});
	})
</script>