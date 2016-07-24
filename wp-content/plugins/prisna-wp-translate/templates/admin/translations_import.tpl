<div class="prisna_wp_translate_section prisna_wp_translate_{{ type }}{{ dependence.show.false:begin }} prisna_wp_translate_no_display{{ dependence.show.false:end }}{{ has_dependence.true:begin }} prisna_wp_translate_section_tabbed_{{ dependence_count }}{{ has_dependence.true:end }}" id="section_{{ id }}">
	
	<div class="prisna_wp_translate_tooltip"></div>
	<div class="prisna_wp_translate_description prisna_wp_translate_no_display">{{ description_message }}</div>
		
	<div class="prisna_wp_translate_title_container prisna_wp_translate_icon prisna_wp_translate_icon_grid2"><h3 class="prisna_wp_translate_title">{{ title_message }}</h3></div>

	<div class="prisna_wp_translate_setting">
		<div class="prisna_wp_translate_field">
	
			<table border="0" cellpadding="0" cellspacing="0" class="prisna_wp_translate_file_upload_container_table">
				<tr>
					<td class="prisna_wp_translate_separator">{{ upload_message }}:</td>
					<td class="prisna_wp_translate_file_upload_container_td">
						<div class="prisna_wp_translate_file_upload_container">
							<div class="prisna_wp_translate_file_upload">
								<input type="file" name="{{ id }}_csv" id="{{ id }}_csv" />
							</div>
							<div class="prisna_wp_translate_z_index_3 prisna_wp_translate_file_upload_container_div">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="text" name="{{ id }}_csv_fk" id="{{ id }}_csv_fk" class="prisna_wp_translate_input" readonly="readonly" value="" /></td>
									</tr>
								</table>
							</div>
							<div class="prisna_wp_translate_z_index_1 prisna_wp_translate_file_upload_container_div">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="text" name="{{ id }}_csv_ufk" id="{{ id }}_csv_ufk" class="prisna_wp_translate_input" readonly="readonly" /></td>
										<td>
											<input name="reset" type="button" value="{{ upload_button_message }}" class="button submit-button reset-button" id="{{ id }}_csv_upload" />
										</td>
									</tr>
								</table>
							</div>
						</div>
					</td>
					<td>&nbsp;&nbsp;&nbsp;</td>
					<td class="prisna_wp_translate_separator">{{ from_message }}:</td>
					<td><div class="prisna_wp_translate_setting_aux">{{ from_formatted }}</div></td>
					<td>&nbsp;&nbsp;&nbsp;</td>
					<td class="prisna_wp_translate_separator">{{ to_message }}:</td>
					<td><div class="prisna_wp_translate_setting_aux">{{ to_formatted }}</div></td>
				</tr>
			</table>
			
		</div>	
	</div>

{{ has_resource.true:begin }}
{{ resource_formatted }}
{{ has_resource.true:end }}

{{ action_formatted }}

{{ test_formatted }}

{{ is_importing.true:begin }}
	<div class="prisna_wp_translate_title_container prisna_wp_translate_icon prisna_wp_translate_icon_grid2"><h3 class="prisna_wp_translate_title">{{ log_title_message }}</h3></div>
	<div class="prisna_wp_translate_setting">
		<div class="prisna_wp_translate_field prisna_wp_translate_import_separator">

			{{ has_errors.false:begin }}
			<table border="0" cellpadding="0" cellspacing="0" class="prisna_wp_translate_align_left">
				<tr>
					<td>
						<table border="0" cellpadding="0" cellspacing="0" class="prisna_wp_translate_align_left prisna_wp_translate_import_translations_log prisna_wp_translate_validate_success">
							{{ log_formatted }}
						</table>
					</td>
				</tr>
			{{ is_test.true:begin }}
				<tr>
					<td class="prisna_wp_translate_validate_warning">{{ log_test_message }}</td>
				</tr>
			{{ is_test.true:end }}
			</table>
			{{ has_errors.false:end }}

			<table border="0" cellpadding="0" cellspacing="0" class="prisna_wp_translate_align_left">
				<tr>
					<td class="prisna_wp_translate_separator">{{ upload_message }}:</td>
					<td class="{{ csv_file.error.true:begin }}prisna_wp_translate_validate_error{{ csv_file.error.true:end }}{{ csv_file.error.false:begin }}prisna_wp_translate_validate_success{{ csv_file.error.false:end }}">{{ csv_file_value_formatted }}</td>
				</tr>
				<tr>
					<td class="prisna_wp_translate_separator">{{ from_message }}:</td>
					<td class="{{ from.error.true:begin }}prisna_wp_translate_validate_error{{ from.error.true:end }}{{ from.error.false:begin }}prisna_wp_translate_validate_success{{ from.error.false:end }}">{{ from_value_formatted }}</td>
				</tr>
				<tr>
					<td class="prisna_wp_translate_separator">{{ to_message }}:</td>
					<td class="{{ to.error.true:begin }}prisna_wp_translate_validate_error{{ to.error.true:end }}{{ to.error.false:begin }}prisna_wp_translate_validate_success{{ to.error.false:end }}">{{ to_value_formatted }}</td>
				</tr>
				<tr>
					<td class="prisna_wp_translate_separator">{{ resource_title_message }}:</td>
					<td class="{{ resource.error.true:begin }}prisna_wp_translate_validate_error{{ resource.error.true:end }}{{ resource.error.false:begin }}prisna_wp_translate_validate_success{{ resource.error.false:end }}">{{ resource_value_formatted }}</td>
				</tr>
				<tr>
					<td class="prisna_wp_translate_separator">{{ action_title_message }}:</td>
					<td class="{{ action.error.true:begin }}prisna_wp_translate_validate_error{{ action.error.true:end }}{{ action.error.false:begin }}prisna_wp_translate_validate_success{{ action.error.false:end }}">{{ action_value_formatted }}</td>
				</tr>
				<tr>
					<td class="prisna_wp_translate_separator">{{ test_title_message }}:</td>
					<td class="{{ test.error.true:begin }}prisna_wp_translate_validate_error{{ test.error.true:end }}{{ test.error.false:begin }}prisna_wp_translate_validate_success{{ test.error.false:end }}">{{ test_value_formatted }}</td>
				</tr>
				{{ has_errors.true:begin }}
				<tr>
					<td colspan="2" class="prisna_wp_translate_validate_error">{{ no_import_message }}</td>
				</tr>
				{{ has_errors.true:end }}
			</table>
						
		</div>
	</div>
{{ is_importing.true:end }}

<div id="prisna_translations_import_translations_buttons">
	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<input class="button-primary save-translations" type="submit" name="{{ id }}_button" value="{{ button_message }}" />
			</td>
		</tr>
	</table>
</div>
	
	{{ has_dependence.true:begin }}
	<input type="hidden" name="{{ id }}_dependence" id="{{ id }}_dependence" value="{{ formatted_dependence }}" />
	<input type="hidden" name="{{ id }}_dependence_show_value" id="{{ id }}_dependence_show_value" value="{{ formatted_dependence_show_value }}" />
	{{ has_dependence.true:end }}	
	<div class="prisna_wp_translate_clear"></div>
	
</div>
