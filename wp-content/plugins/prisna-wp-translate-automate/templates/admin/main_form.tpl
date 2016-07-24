<form method="post" action="" name="prisna_admin" id="prisna_admin" class="prisna_wp_translate_selected_layout_{{ layout }}" onsubmit="return PrisnaWPTranslateAdmin.adjust();">

<div class="prisna_wp_translate_header">
	<div class="prisna_wp_translate_header_icon">
		<div class="prisna_wp_translate_header_title">Goodao Translate System</div>
	</div>
	<div class="prisna_wp_translate_header_version"><a href="http://www.goodao.cn/" target="_blank">Goodao.cn</a></div>
</div>

{{ api_key_validate.false:begin }}
<div class="prisna_wp_translate_automate_api_key_validate prisna_wp_translate_message">
	<p>{{ general_api_key_validate_message }}</p>
</div>
{{ api_key_validate.false:end }}

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

<div class="prisna_wp_translate_admin_container">

	<div class="prisna_wp_translate_ui_tabs_container">
		<ul>
			<li class="prisna_wp_translate_ui_tab prisna_wp_translate_ui_tab_selected" id="general_menu"><span><span>{{ general_message }}</span></span></li> 
		</ul>
	</div>

	<div class="prisna_wp_translate_main_form_container">
	
		<div class="prisna_wp_translate_ui_tabs_main_container">

			<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_display" id="general_tab">

				<div class="prisna_wp_translate_ui_tab_content">
					
					<div id="translations_automate_step_1">
					
					{{ group_0 }}

					<div class="prisna_translations_automate_buttons">
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<input class="button-primary automate-translations" type="button" value="Next" onclick="PrisnaWPTranslateAutomateAdmin.automate.next();" />
								</td>
								<td>&nbsp;&nbsp;&nbsp;</td>
								<td id="prisna_translations_automate_step_1_loading">
								</td>
							</tr>
						</table>
					</div>
					
					</div>
					
					<div id="translations_automate_step_2" class="prisna_wp_translate_no_display">

						<div class="prisna_wp_translate_section" id="section_prisna_automate_processing">
							
							<div class="prisna_wp_translate_title_container prisna_wp_translate_icon prisna_wp_translate_icon_grid2"><h3 class="prisna_wp_translate_title">Summary</h3></div>
							<div class="prisna_wp_translate_setting">
								<div class="prisna_wp_translate_field">
								
									<table border="0" cellpadding="0" cellspacing="0" class="prisna_wp_translate_align_left" id="prisna_wp_translate_automate_selection">
										<tr>
											<td class="prisna_wp_translate_separator">Language:</td>
											<td id="prisna_selected_automate_to"></td>
										</tr>
										<tr>
											<td class="prisna_wp_translate_separator">Resource:</td>
											<td id="prisna_selected_automate_source"></td>
										</tr>
										<tr>
											<td class="prisna_wp_translate_separator">&nbsp;</td>
											<td id="prisna_selected_automate_source_value"></td>
										</tr>
										<tr>
											<td class="prisna_wp_translate_separator">URL behavior:</td>
											<td id="prisna_selected_automate_action"></td>
										</tr>
									</table>
								
								</div>
								
								<div class="prisna_translations_automate_buttons">
									<table border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td id="prisna_translations_automate_step_2_back">
												<input class="button-primary automate-translations" type="button" value="Back" onclick="PrisnaWPTranslateAutomateAdmin.automate.back();" />
											</td>
											<td id="prisna_translations_automate_step_2_run">
												<input class="button-primary automate-translations" type="button" value="Run" />
											</td>
											<td id="prisna_translations_automate_step_2_stop">
												<input class="button-primary automate-translations" type="button" value="Stop" onclick="PrisnaWPTranslateAutomateAdmin.automate.doStop();" />
											</td>
											<td id="prisna_translations_automate_step_2_loading"></td>
											<td id="prisna_automate_processing_current_status" class="prisna_wp_translate_validate_warning"></td>
										</tr>
									</table>
								</div>
								
								<div class="prisna_wp_translate_field prisna_wp_translate_message prisna_wp_translate_warning_message prisna_wp_translate_no_display" id="prisna_automate_processing_container_failed"></div>
								
								<div class="prisna_wp_translate_field prisna_wp_translate_no_display" id="prisna_automate_processing_container">
								
									<table border="0" cellpadding="0" cellspacing="0" id="prisna_automate_processing_container_table">
										<thead>
										<tr>
											<th>Resource</th>
											<th>Status</th>
										</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								
								</div>
								
								<div class="prisna_wp_translate_no_display" id="prisna_automate_processing_target"></div>
								
							</div>

							<div class="prisna_wp_translate_clear"></div>
							
						</div>

					</div>
					

				</div>

			</div>

		</div>
			
	</div>
	
</div>

{{ nonce }}

</form>

<script type="text/javascript">
/*<![CDATA[*/
PrisnaWPTranslateAutomateAdmin.initialize("{{ ajax_url }}");
/*]]>*/
</script>