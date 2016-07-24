<?php
	if(isset($_GET['gd'])){
		
?>
<script>
	
	jQuery(document).ready(function($) {
		jQuery('#translations_menu').trigger('click');
	});
</script>
<form method="post" action="" name="prisna_admin" id="prisna_admin" class="prisna_wp_translate_selected_layout_{{ layout }}" onsubmit="return PrisnaWPTranslateAdmin.adjust();">

<div class="prisna_wp_translate_header">
	<div class="prisna_wp_translate_header_icon">
		<div class="prisna_wp_translate_header_title">Goodao Translate System</div>
	</div>
	<div class="prisna_wp_translate_header_version"><a href="http://www.goodao.cn/" target="_blank">Goodao.cn</a></div>
</div>

{{ api_key_google_empty_validate.false:begin }}
<div class="prisna_wp_translate_api_key_google_empty_validate prisna_wp_translate_message prisna_wp_translate_warning_message">
	<p>{{ general_api_key_google_empty_validate_message }}</p>
</div>
{{ api_key_google_empty_validate.false:end }}

{{ client_id_microsoft_empty_validate.false:begin }}
<div class="prisna_wp_translate_client_id_microsoft_empty_validate prisna_wp_translate_message prisna_wp_translate_warning_message">
	<p>{{ general_client_id_microsoft_empty_validate_message }}</p>
</div>
{{ client_id_microsoft_empty_validate.false:end }}

{{ client_secret_microsoft_empty_validate.false:begin }}
<div class="prisna_wp_translate_client_secret_microsoft_empty_validate prisna_wp_translate_message prisna_wp_translate_warning_message">
	<p>{{ general_client_secret_microsoft_empty_validate_message }}</p>
</div>
{{ client_secret_microsoft_empty_validate.false:end }}

{{ cache_folder_validate.false:begin }}
<div class="prisna_wp_translate_cache_folder_validate prisna_wp_translate_message">
	<p>{{ general_cache_folder_validate_message }}</p>
</div>
{{ cache_folder_validate.false:end }}

{{ cache_file_validate.false:begin }}
<div class="prisna_wp_translate_cache_file_validate prisna_wp_translate_message">
	<p>{{ general_cache_file_validate_message }}</p>
</div>
{{ cache_file_validate.false:end }}

{{ openssl_validate.false:begin }}
<div class="prisna_wp_translate_openssl_validate prisna_wp_translate_message">
	<p>{{ general_openssl_validate_message }}</p>
</div>
{{ openssl_validate.false:end }}

{{ hash_validate.false:begin }}
<div class="prisna_wp_translate_hash_validate prisna_wp_translate_message">
	<p>{{ general_hash_validate_message }}</p>
</div>
{{ hash_validate.false:end }}

{{ widget_validate.false:begin }}
<div class="prisna_wp_translate_widget_validate prisna_wp_translate_message prisna_wp_translate_warning_message">
	<p>{{ general_widget_validate_message }}</p>
</div>
{{ widget_validate.false:end }}

{{ fsockopen_validate.false:begin }}
<div class="prisna_wp_translate_fsockopen_validate prisna_wp_translate_message">
	<p>{{ general_fsockopen_validate_message }}</p>
</div>
{{ fsockopen_validate.false:end }}

{{ dom_validate.false:begin }}
<div class="prisna_wp_translate_dom_validate prisna_wp_translate_message">
	<p>{{ general_dom_validate_message }}</p>
</div>
{{ dom_validate.false:end }}

{{ ssl_validate.false:begin }}
<div class="prisna_wp_translate_ssl_validate prisna_wp_translate_message">
	<p>{{ general_ssl_validate_message }}</p>
</div>
{{ ssl_validate.false:end }}

{{ seo_validate.false:begin }}
<div class="prisna_wp_translate_seo_validate prisna_wp_translate_message">
	<p>{{ general_seo_validate_message }}</p>
</div>
{{ seo_validate.false:end }}

{{ wp_super_cache_validate.false:begin }}
<div class="prisna_wp_translate_wp_super_cache_validate prisna_wp_translate_message">
	<p>{{ general_wp_super_cache_validate_message }}</p>
</div>
{{ wp_super_cache_validate.false:end }}

{{ layout_changed.true:begin }}
<div class="prisna_wp_translate_saved prisna_wp_translate_message">
	<p>{{ layout_changed_message }}</p>
</div>
<script type="text/javascript">
PrisnaWPTranslateAdmin.hideMessage(".prisna_wp_translate_saved", 1000);
</script>
{{ layout_changed.true:end }}

{{ just_saved.true:begin }}
<div class="prisna_wp_translate_saved prisna_wp_translate_message">
	<p>{{ saved_message }}</p>
</div>
<script type="text/javascript">
PrisnaWPTranslateAdmin.hideMessage(".prisna_wp_translate_saved", 1000);
</script>
{{ just_saved.true:end }}

{{ just_imported_all_success.true:begin }}
<div class="prisna_wp_translate_imported_success prisna_wp_translate_message">
	<p>{{ advanced_import_all_success_message }}</p>
</div>
<script type="text/javascript">
PrisnaWPTranslateAdmin.hideMessage(".prisna_wp_translate_imported_success", 3000);
</script>
{{ just_imported_all_success.true:end }}

{{ just_imported_all_fail.true:begin }}
<div class="prisna_wp_translate_imported_fail prisna_wp_translate_message">
	<p>{{ advanced_import_all_fail_message }}</p>
</div>
<script type="text/javascript">
PrisnaWPTranslateAdmin.hideMessage(".prisna_wp_translate_imported_fail", 10000);
</script>
{{ just_imported_all_fail.true:end }}

{{ just_imported_success.true:begin }}
<div class="prisna_wp_translate_imported_success prisna_wp_translate_message">
	<p>{{ advanced_import_success_message }}</p>
</div>
<script type="text/javascript">
PrisnaWPTranslateAdmin.hideMessage(".prisna_wp_translate_imported_success", 3000);
</script>
{{ just_imported_success.true:end }}

{{ just_imported_fail.true:begin }}
<div class="prisna_wp_translate_imported_fail prisna_wp_translate_message">
	<p>{{ advanced_import_fail_message }}</p>
</div>
<script type="text/javascript">
PrisnaWPTranslateAdmin.hideMessage(".prisna_wp_translate_imported_fail", 10000);
</script>
{{ just_imported_fail.true:end }}

{{ just_reseted.true:begin }}
<div class="prisna_wp_translate_reseted prisna_wp_translate_message">
	<p>{{ reseted_message }}</p>
</div>
<script type="text/javascript">
PrisnaWPTranslateAdmin.hideMessage(".prisna_wp_translate_reseted", 1000);
</script>
{{ just_reseted.true:end }}

<div class="prisna_wp_translate_admin_container">

	<div class="prisna_wp_translate_submit_top_container" style="display:none;">
		<input class="button-primary" type="submit" name="save_top" value="{{ save_button_message }}" />
	</div>

	<div class="prisna_wp_translate_ui_tabs_container">
		<ul>
			<li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_unselected prisna_wp_translate_hidden_important" id="general_menu" style="display:none;"><span><span>{{ general_message }}</span></span></li> 

			<li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_selected " id="translations_menu"><span><span>{{ translations_message }}</span></span></li> 
		</ul>
	</div>

	<div class="prisna_wp_translate_main_form_container">
	
		<div class="prisna_wp_translate_ui_tabs_main_container">

			<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_no_display" id="layout_tab">
				<div class="prisna_wp_translate_ui_tab_content">

					

				</div>
			</div>

			<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_no_display" id="general_tab">
				<div class="prisna_wp_translate_ui_tab_content">

					{{ group_1 }}

				</div>
			</div>

			<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ advanced.show.false:begin }}no_{{ advanced.show.false:end }}display" id="advanced_tab">
				<div class="prisna_wp_translate_ui_tab_content">

					<div class="prisna_wp_translate_ui_tabs_container prisna_wp_translate_ui_tabs_container_alt">
						<ul>
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ advanced_general.show.false:begin }}un{{ advanced_general.show.false:end }}selected{{ advanced_general.show.false:begin }} prisna_wp_translate_hidden_important{{ advanced_general.show.false:end }}" id="advanced_general_menu"><span><span>{{ advanced_general_message }}</span></span></li> 
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ advanced_access.show.false:begin }}un{{ advanced_access.show.false:end }}selected{{ advanced_access.show.false:begin }} prisna_wp_translate_hidden_important{{ advanced_access.show.false:end }}" id="advanced_access_menu"><span><span>{{ advanced_access_message }}</span></span></li> 
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ advanced_import_export.show.false:begin }}un{{ advanced_import_export.show.false:end }}selected{{ advanced_import_export.show.false:begin }} prisna_wp_translate_hidden_important{{ advanced_import_export.show.false:end }}" id="advanced_import_export_menu"><span><span>{{ advanced_import_export_message }}</span></span></li> 
						</ul>
					</div>

					<div class="prisna_wp_translate_main_form_container">
			
						<div class="prisna_wp_translate_ui_tabs_main_container">

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ advanced_general.show.false:begin }}no_{{ advanced_general.show.false:end }}display" id="advanced_general_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
										{{ group_2 }}

								</div>

							</div>

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ advanced_access.show.false:begin }}no_{{ advanced_access.show.false:end }}display" id="advanced_access_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
										{{ group_13 }}

								</div>

							</div>

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ advanced_import_export.show.false:begin }}no_{{ advanced_import_export.show.false:end }}display" id="advanced_import_export_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
									{{ group_3 }}
		
								</div>
									
							</div>
						
						</div>
						
					</div>

				</div>
			</div>

			<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_display" id="translations_tab">
				<div class="prisna_wp_translate_ui_tab_content">

					<div class="prisna_wp_translate_ui_tabs_container prisna_wp_translate_ui_tabs_container_alt">
						<ul>
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ translations_general.show.false:begin }}un{{ translations_general.show.false:end }}selected{{ translations_general.show.false:begin }} prisna_wp_translate_hidden_important{{ translations_general.show.false:end }}" id="translations_general_menu"><span><span>{{ translations_general_message }}</span></span></li> 
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ translations_import.show.false:begin }}un{{ translations_import.show.false:end }}selected{{ translations_import.show.false:begin }} prisna_wp_translate_hidden_important{{ translations_import.show.false:end }}" id="translations_import_menu"><span><span>{{ translations_import_message }}</span></span></li> 
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ translations_export.show.false:begin }}un{{ translations_export.show.false:end }}selected{{ translations_export.show.false:begin }} prisna_wp_translate_hidden_important{{ translations_export.show.false:end }}" id="translations_export_menu"><span><span>{{ translations_export_message }}</span></span></li> 
						</ul>
					</div>

					<div class="prisna_wp_translate_main_form_container">
			
						<div class="prisna_wp_translate_ui_tabs_main_container">

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ translations_general.show.false:begin }}no_{{ translations_general.show.false:end }}display" id="translations_general_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
									{{ group_4 }}

								</div>

							</div>

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ translations_import.show.false:begin }}no_{{ translations_import.show.false:end }}display" id="translations_import_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
									{{ group_8 }}
		
								</div>
									
							</div>
						
							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ translations_export.show.false:begin }}no_{{ translations_export.show.false:end }}display" id="translations_export_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
									{{ group_9 }}
		
								</div>
									
							</div>
						
						</div>
						
					</div>

				</div>
			</div>

			<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ seo.show.false:begin }}no_{{ seo.show.false:end }}display" id="seo_tab">
				<div class="prisna_wp_translate_ui_tab_content">

					<div class="prisna_wp_translate_ui_tabs_container prisna_wp_translate_ui_tabs_container_alt">
						<ul>
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ seo_general.show.false:begin }}un{{ seo_general.show.false:end }}selected{{ seo_general.show.false:begin }} prisna_wp_translate_hidden_important{{ seo_general.show.false:end }}" id="seo_general_menu"><span><span>{{ seo_general_message }}</span></span></li> 
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ seo_permalink.show.false:begin }}un{{ seo_permalink.show.false:end }}selected{{ seo_enabled.false:begin }} prisna_wp_translate_no_display{{ seo_enabled.false:end }}{{ seo_permalink.show.false:begin }} prisna_wp_translate_hidden_important{{ seo_permalink.show.false:end }}" id="seo_permalink_menu"><span><span>{{ seo_permalink_message }}</span></span></li> 
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ seo_sitemap.show.false:begin }}un{{ seo_sitemap.show.false:end }}selected{{ seo_enabled.false:begin }} prisna_wp_translate_no_display{{ seo_enabled.false:end }}{{ seo_sitemap.show.false:begin }} prisna_wp_translate_hidden_important{{ seo_sitemap.show.false:end }}" id="seo_sitemap_menu"><span><span>{{ seo_sitemap_message }}</span></span></li> 
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ seo_log.show.false:begin }}un{{ seo_log.show.false:end }}selected{{ seo_enabled.false:begin }} prisna_wp_translate_no_display{{ seo_enabled.false:end }}{{ seo_log.show.false:begin }} prisna_wp_translate_hidden_important{{ seo_log.show.false:end }}" id="seo_log_menu"><span><span>{{ seo_log_message }}</span></span></li> 
						</ul>
					</div>

					<div class="prisna_wp_translate_main_form_container">
			
						<div class="prisna_wp_translate_ui_tabs_main_container">

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ seo_general.show.false:begin }}no_{{ seo_general.show.false:end }}display" id="seo_general_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
									{{ group_5 }}

								</div>

							</div>

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ seo_permalink.show.false:begin }}no_{{ seo_permalink.show.false:end }}display" id="seo_permalink_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
									{{ group_10 }}
		
								</div>
									
							</div>

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ seo_sitemap.show.false:begin }}no_{{ seo_sitemap.show.false:end }}display" id="seo_sitemap_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
									{{ group_11 }}
		
								</div>
									
							</div>

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ seo_log.show.false:begin }}no_{{ seo_log.show.false:end }}display" id="seo_log_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
									{{ group_12 }}
		
								</div>
									
							</div>
						
						</div>
						
					</div>

				</div>
			</div>

			<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ styles.show.false:begin }}no_{{ styles.show.false:end }}display" id="styles_tab">
				<div class="prisna_wp_translate_ui_tab_content">

					{{ group_6 }}

				</div>
			</div>

			<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ responsive.show.false:begin }}no_{{ responsive.show.false:end }}display" id="responsive_tab">
				<div class="prisna_wp_translate_ui_tab_content">

					{{ group_7 }}

				</div>
			</div>

		</div>

		<div class="prisna_wp_translate_submit_container" style="display:none;">

			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<input name="reset" type="button" value="{{ reset_button_message }}" class="button submit-button reset-button reset-settings" onclick="return PrisnaWPTranslateAdmin.resetSettings('{{ reset_message }}');" >
					</td>
					<td>
						<input class="button-primary" type="submit" name="save" value="{{ save_button_message }}" />
					</td>
				</tr>
			</table>			

			<input type="hidden" name="prisna_wp_translate_admin_action" id="prisna_wp_translate_admin_action" value="prisna_wp_translate_save_settings" />
			<input type="hidden" name="prisna_tab" id="prisna_tab" value="{{ tab }}" />
			<input type="hidden" name="prisna_tab_2" id="prisna_tab_2" value="{{ tab_2 }}" />
			<input type="hidden" name="prisna_tab_3" id="prisna_tab_3" value="{{ tab_3 }}" />
			<input type="hidden" name="prisna_tab_4" id="prisna_tab_4" value="{{ tab_4 }}" />

		</div>
			
	</div>
	
</div>

{{ nonce }}

</form>
















<?php


//**************************************
	}else{



?>

<form method="post" action="" name="prisna_admin" id="prisna_admin" class="prisna_wp_translate_selected_layout_{{ layout }}" onsubmit="return PrisnaWPTranslateAdmin.adjust();">

<div class="prisna_wp_translate_header">
	<div class="prisna_wp_translate_header_icon">
		<div class="prisna_wp_translate_header_title">Goodao Translate System</div>
	</div>
	<div class="prisna_wp_translate_header_version"><a href="http://www.goodao.cn/" target="_blank">Goodao.cn</a></div>
</div>

{{ api_key_google_empty_validate.false:begin }}
<div class="prisna_wp_translate_api_key_google_empty_validate prisna_wp_translate_message prisna_wp_translate_warning_message">
	<p>{{ general_api_key_google_empty_validate_message }}</p>
</div>
{{ api_key_google_empty_validate.false:end }}

{{ client_id_microsoft_empty_validate.false:begin }}
<div class="prisna_wp_translate_client_id_microsoft_empty_validate prisna_wp_translate_message prisna_wp_translate_warning_message">
	<p>{{ general_client_id_microsoft_empty_validate_message }}</p>
</div>
{{ client_id_microsoft_empty_validate.false:end }}

{{ client_secret_microsoft_empty_validate.false:begin }}
<div class="prisna_wp_translate_client_secret_microsoft_empty_validate prisna_wp_translate_message prisna_wp_translate_warning_message">
	<p>{{ general_client_secret_microsoft_empty_validate_message }}</p>
</div>
{{ client_secret_microsoft_empty_validate.false:end }}

{{ cache_folder_validate.false:begin }}
<div class="prisna_wp_translate_cache_folder_validate prisna_wp_translate_message">
	<p>{{ general_cache_folder_validate_message }}</p>
</div>
{{ cache_folder_validate.false:end }}

{{ cache_file_validate.false:begin }}
<div class="prisna_wp_translate_cache_file_validate prisna_wp_translate_message">
	<p>{{ general_cache_file_validate_message }}</p>
</div>
{{ cache_file_validate.false:end }}

{{ openssl_validate.false:begin }}
<div class="prisna_wp_translate_openssl_validate prisna_wp_translate_message">
	<p>{{ general_openssl_validate_message }}</p>
</div>
{{ openssl_validate.false:end }}

{{ hash_validate.false:begin }}
<div class="prisna_wp_translate_hash_validate prisna_wp_translate_message">
	<p>{{ general_hash_validate_message }}</p>
</div>
{{ hash_validate.false:end }}

{{ widget_validate.false:begin }}
<div class="prisna_wp_translate_widget_validate prisna_wp_translate_message prisna_wp_translate_warning_message">
	<p>{{ general_widget_validate_message }}</p>
</div>
{{ widget_validate.false:end }}

{{ fsockopen_validate.false:begin }}
<div class="prisna_wp_translate_fsockopen_validate prisna_wp_translate_message">
	<p>{{ general_fsockopen_validate_message }}</p>
</div>
{{ fsockopen_validate.false:end }}

{{ dom_validate.false:begin }}
<div class="prisna_wp_translate_dom_validate prisna_wp_translate_message">
	<p>{{ general_dom_validate_message }}</p>
</div>
{{ dom_validate.false:end }}

{{ ssl_validate.false:begin }}
<div class="prisna_wp_translate_ssl_validate prisna_wp_translate_message">
	<p>{{ general_ssl_validate_message }}</p>
</div>
{{ ssl_validate.false:end }}

{{ seo_validate.false:begin }}
<div class="prisna_wp_translate_seo_validate prisna_wp_translate_message">
	<p>{{ general_seo_validate_message }}</p>
</div>
{{ seo_validate.false:end }}

{{ wp_super_cache_validate.false:begin }}
<div class="prisna_wp_translate_wp_super_cache_validate prisna_wp_translate_message">
	<p>{{ general_wp_super_cache_validate_message }}</p>
</div>
{{ wp_super_cache_validate.false:end }}

{{ change_loading_image_validate.false:begin }}
<div class="prisna_wp_translate_loading_image_validate prisna_wp_translate_message">
	<p>{{ general_loading_image_validate_message }}</p>
</div>
{{ change_loading_image_validate.false:end }}

{{ change_controls_image_validate.false:begin }}
<div class="prisna_wp_translate_controls_image_validate prisna_wp_translate_message">
	<p>{{ general_controls_image_validate_message }}</p>
</div>
{{ change_controls_image_validate.false:end }}

{{ layout_changed.true:begin }}
<div class="prisna_wp_translate_saved prisna_wp_translate_message">
	<p>{{ layout_changed_message }}</p>
</div>
<script type="text/javascript">
PrisnaWPTranslateAdmin.hideMessage(".prisna_wp_translate_saved", 1000);
</script>
{{ layout_changed.true:end }}

{{ just_saved.true:begin }}
<div class="prisna_wp_translate_saved prisna_wp_translate_message">
	<p>{{ saved_message }}</p>
</div>
<script type="text/javascript">
PrisnaWPTranslateAdmin.hideMessage(".prisna_wp_translate_saved", 1000);
</script>
{{ just_saved.true:end }}

{{ just_imported_all_success.true:begin }}
<div class="prisna_wp_translate_imported_success prisna_wp_translate_message">
	<p>{{ advanced_import_all_success_message }}</p>
</div>
<script type="text/javascript">
PrisnaWPTranslateAdmin.hideMessage(".prisna_wp_translate_imported_success", 3000);
</script>
{{ just_imported_all_success.true:end }}

{{ just_imported_all_fail.true:begin }}
<div class="prisna_wp_translate_imported_fail prisna_wp_translate_message">
	<p>{{ advanced_import_all_fail_message }}</p>
</div>
<script type="text/javascript">
PrisnaWPTranslateAdmin.hideMessage(".prisna_wp_translate_imported_fail", 10000);
</script>
{{ just_imported_all_fail.true:end }}

{{ just_imported_success.true:begin }}
<div class="prisna_wp_translate_imported_success prisna_wp_translate_message">
	<p>{{ advanced_import_success_message }}</p>
</div>
<script type="text/javascript">
PrisnaWPTranslateAdmin.hideMessage(".prisna_wp_translate_imported_success", 3000);
</script>
{{ just_imported_success.true:end }}

{{ just_imported_fail.true:begin }}
<div class="prisna_wp_translate_imported_fail prisna_wp_translate_message">
	<p>{{ advanced_import_fail_message }}</p>
</div>
<script type="text/javascript">
PrisnaWPTranslateAdmin.hideMessage(".prisna_wp_translate_imported_fail", 10000);
</script>
{{ just_imported_fail.true:end }}

{{ just_reseted.true:begin }}
<div class="prisna_wp_translate_reseted prisna_wp_translate_message">
	<p>{{ reseted_message }}</p>
</div>
<script type="text/javascript">
PrisnaWPTranslateAdmin.hideMessage(".prisna_wp_translate_reseted", 1000);
</script>
{{ just_reseted.true:end }}

<div class="prisna_wp_translate_admin_container">

	<div class="prisna_wp_translate_submit_top_container">
		<input class="button-primary" type="submit" name="save_top" value="{{ save_button_message }}" />
	</div>

	<div class="prisna_wp_translate_ui_tabs_container">
		<ul>
			<li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ general.show.false:begin }}un{{ general.show.false:end }}selected{{ general.show.false:begin }} prisna_wp_translate_hidden_important{{ general.show.false:end }}" id="general_menu"><span><span>{{ general_message }}</span></span></li> 
			<li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ advanced.show.false:begin }}un{{ advanced.show.false:end }}selected{{ advanced.show.false:begin }} prisna_wp_translate_hidden_important{{ advanced.show.false:end }}" id="advanced_menu"><span><span>{{ advanced_message }}</span></span></li> 
			<li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ translations.show.false:begin }}un{{ translations.show.false:end }}selected{{ translations.show.false:begin }} prisna_wp_translate_hidden_important{{ translations.show.false:end }}" id="translations_menu"><span><span>{{ translations_message }}</span></span></li> 
			<li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ seo.show.false:begin }}un{{ seo.show.false:end }}selected{{ seo.show.false:begin }} prisna_wp_translate_hidden_important{{ seo.show.false:end }}" id="seo_menu"><span><span>{{ seo_message }}</span></span></li> 
			<li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ layout.show.false:begin }}un{{ layout.show.false:end }}selected{{ layout.show.false:begin }} prisna_wp_translate_hidden_important{{ layout.show.false:end }}" id="layout_menu"><span><span>{{ layout_message }}</span></span></li> 
			<li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ styles.show.false:begin }}un{{ styles.show.false:end }}selected{{ styles.show.false:begin }} prisna_wp_translate_hidden_important{{ styles.show.false:end }}" id="styles_menu"><span><span>{{ styles_message }}</span></span></li> 
			<li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ responsive.show.false:begin }}un{{ responsive.show.false:end }}selected{{ responsive.show.false:begin }} prisna_wp_translate_hidden_important{{ responsive.show.false:end }}" id="responsive_menu"><span><span>{{ responsive_message }}</span></span></li> 
		</ul>
	</div>

	<div class="prisna_wp_translate_main_form_container">
	
		<div class="prisna_wp_translate_ui_tabs_main_container">

			<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ layout.show.false:begin }}no_{{ layout.show.false:end }}display" id="layout_tab">
				<div class="prisna_wp_translate_ui_tab_content">

					{{ group_0 }}

				</div>
			</div>

			<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ general.show.false:begin }}no_{{ general.show.false:end }}display" id="general_tab">
				<div class="prisna_wp_translate_ui_tab_content">

					{{ group_1 }}

				</div>
			</div>

			<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ advanced.show.false:begin }}no_{{ advanced.show.false:end }}display" id="advanced_tab">
				<div class="prisna_wp_translate_ui_tab_content">

					<div class="prisna_wp_translate_ui_tabs_container prisna_wp_translate_ui_tabs_container_alt">
						<ul>
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ advanced_general.show.false:begin }}un{{ advanced_general.show.false:end }}selected{{ advanced_general.show.false:begin }} prisna_wp_translate_hidden_important{{ advanced_general.show.false:end }}" id="advanced_general_menu"><span><span>{{ advanced_general_message }}</span></span></li> 
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ advanced_access.show.false:begin }}un{{ advanced_access.show.false:end }}selected{{ advanced_access.show.false:begin }} prisna_wp_translate_hidden_important{{ advanced_access.show.false:end }}" id="advanced_access_menu"><span><span>{{ advanced_access_message }}</span></span></li> 
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ advanced_import_export.show.false:begin }}un{{ advanced_import_export.show.false:end }}selected{{ advanced_import_export.show.false:begin }} prisna_wp_translate_hidden_important{{ advanced_import_export.show.false:end }}" id="advanced_import_export_menu"><span><span>{{ advanced_import_export_message }}</span></span></li> 
						</ul>
					</div>

					<div class="prisna_wp_translate_main_form_container">
			
						<div class="prisna_wp_translate_ui_tabs_main_container">

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ advanced_general.show.false:begin }}no_{{ advanced_general.show.false:end }}display" id="advanced_general_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
										{{ group_2 }}

								</div>

							</div>

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ advanced_access.show.false:begin }}no_{{ advanced_access.show.false:end }}display" id="advanced_access_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
										{{ group_13 }}

								</div>

							</div>

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ advanced_import_export.show.false:begin }}no_{{ advanced_import_export.show.false:end }}display" id="advanced_import_export_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
									{{ group_3 }}
		
								</div>
									
							</div>
						
						</div>
						
					</div>

				</div>
			</div>

			<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ translations.show.false:begin }}no_{{ translations.show.false:end }}display" id="translations_tab">
				<div class="prisna_wp_translate_ui_tab_content">

					<div class="prisna_wp_translate_ui_tabs_container prisna_wp_translate_ui_tabs_container_alt">
						<ul>
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ translations_general.show.false:begin }}un{{ translations_general.show.false:end }}selected{{ translations_general.show.false:begin }} prisna_wp_translate_hidden_important{{ translations_general.show.false:end }}" id="translations_general_menu"><span><span>{{ translations_general_message }}</span></span></li> 
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ translations_import.show.false:begin }}un{{ translations_import.show.false:end }}selected{{ translations_import.show.false:begin }} prisna_wp_translate_hidden_important{{ translations_import.show.false:end }}" id="translations_import_menu"><span><span>{{ translations_import_message }}</span></span></li> 
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ translations_export.show.false:begin }}un{{ translations_export.show.false:end }}selected{{ translations_export.show.false:begin }} prisna_wp_translate_hidden_important{{ translations_export.show.false:end }}" id="translations_export_menu"><span><span>{{ translations_export_message }}</span></span></li> 
						</ul>
					</div>

					<div class="prisna_wp_translate_main_form_container">
			
						<div class="prisna_wp_translate_ui_tabs_main_container">

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ translations_general.show.false:begin }}no_{{ translations_general.show.false:end }}display" id="translations_general_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
									{{ group_4 }}

								</div>

							</div>

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ translations_import.show.false:begin }}no_{{ translations_import.show.false:end }}display" id="translations_import_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
									{{ group_8 }}
		
								</div>
									
							</div>
						
							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ translations_export.show.false:begin }}no_{{ translations_export.show.false:end }}display" id="translations_export_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
									{{ group_9 }}
		
								</div>
									
							</div>
						
						</div>
						
					</div>

				</div>
			</div>

			<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ seo.show.false:begin }}no_{{ seo.show.false:end }}display" id="seo_tab">
				<div class="prisna_wp_translate_ui_tab_content">

					<div class="prisna_wp_translate_ui_tabs_container prisna_wp_translate_ui_tabs_container_alt">
						<ul>
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ seo_general.show.false:begin }}un{{ seo_general.show.false:end }}selected{{ seo_general.show.false:begin }} prisna_wp_translate_hidden_important{{ seo_general.show.false:end }}" id="seo_general_menu"><span><span>{{ seo_general_message }}</span></span></li> 
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ seo_permalink.show.false:begin }}un{{ seo_permalink.show.false:end }}selected{{ seo_enabled.false:begin }} prisna_wp_translate_no_display{{ seo_enabled.false:end }}{{ seo_permalink.show.false:begin }} prisna_wp_translate_hidden_important{{ seo_permalink.show.false:end }}" id="seo_permalink_menu"><span><span>{{ seo_permalink_message }}</span></span></li> 
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ seo_sitemap.show.false:begin }}un{{ seo_sitemap.show.false:end }}selected{{ seo_enabled.false:begin }} prisna_wp_translate_no_display{{ seo_enabled.false:end }}{{ seo_sitemap.show.false:begin }} prisna_wp_translate_hidden_important{{ seo_sitemap.show.false:end }}" id="seo_sitemap_menu"><span><span>{{ seo_sitemap_message }}</span></span></li> 
						   <li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_{{ seo_log.show.false:begin }}un{{ seo_log.show.false:end }}selected{{ seo_enabled.false:begin }} prisna_wp_translate_no_display{{ seo_enabled.false:end }}{{ seo_log.show.false:begin }} prisna_wp_translate_hidden_important{{ seo_log.show.false:end }}" id="seo_log_menu"><span><span>{{ seo_log_message }}</span></span></li> 
						</ul>
					</div>

					<div class="prisna_wp_translate_main_form_container">
			
						<div class="prisna_wp_translate_ui_tabs_main_container">

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ seo_general.show.false:begin }}no_{{ seo_general.show.false:end }}display" id="seo_general_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
									{{ group_5 }}

								</div>

							</div>

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ seo_permalink.show.false:begin }}no_{{ seo_permalink.show.false:end }}display" id="seo_permalink_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
									{{ group_10 }}
		
								</div>
									
							</div>

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ seo_sitemap.show.false:begin }}no_{{ seo_sitemap.show.false:end }}display" id="seo_sitemap_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
									{{ group_11 }}
		
								</div>
									
							</div>

							<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ seo_log.show.false:begin }}no_{{ seo_log.show.false:end }}display" id="seo_log_tab">

								<div class="prisna_wp_translate_ui_tab_content">
									
									{{ group_12 }}
		
								</div>
									
							</div>
						
						</div>
						
					</div>

				</div>
			</div>

			<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ styles.show.false:begin }}no_{{ styles.show.false:end }}display" id="styles_tab">
				<div class="prisna_wp_translate_ui_tab_content">

					{{ group_6 }}

				</div>
			</div>

			<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_{{ responsive.show.false:begin }}no_{{ responsive.show.false:end }}display" id="responsive_tab">
				<div class="prisna_wp_translate_ui_tab_content">

					{{ group_7 }}

				</div>
			</div>

		</div>

		<div class="prisna_wp_translate_submit_container">

			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<input name="reset" type="button" value="{{ reset_button_message }}" class="button submit-button reset-button reset-settings" onclick="return PrisnaWPTranslateAdmin.resetSettings('{{ reset_message }}');" >
					</td>
					<td>
						<input class="button-primary" type="submit" name="save" value="{{ save_button_message }}" />
					</td>
				</tr>
			</table>			

			<input type="hidden" name="prisna_wp_translate_admin_action" id="prisna_wp_translate_admin_action" value="prisna_wp_translate_save_settings" />
			<input type="hidden" name="prisna_tab" id="prisna_tab" value="{{ tab }}" />
			<input type="hidden" name="prisna_tab_2" id="prisna_tab_2" value="{{ tab_2 }}" />
			<input type="hidden" name="prisna_tab_3" id="prisna_tab_3" value="{{ tab_3 }}" />
			<input type="hidden" name="prisna_tab_4" id="prisna_tab_4" value="{{ tab_4 }}" />

		</div>
			
	</div>
	
</div>

{{ nonce }}

</form>

<?php
	}

?>
<script type="text/javascript">
/*<![CDATA[*/
PrisnaWPTranslateAdmin.initialize("{{ ajax_url }}", "{{ images_url }}");
/*]]>*/
</script>