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
								<input type="file" name="{{ id }}_xml" id="{{ id }}_xml" />
							</div>
							<div class="prisna_wp_translate_z_index_3 prisna_wp_translate_file_upload_container_div">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="text" name="{{ id }}_xml_fk" id="{{ id }}_xml_fk" class="prisna_wp_translate_input" readonly="readonly" value="" /></td>
									</tr>
								</table>
							</div>
							<div class="prisna_wp_translate_z_index_1 prisna_wp_translate_file_upload_container_div">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="text" name="{{ id }}_xml_ufk" id="{{ id }}_xml_ufk" class="prisna_wp_translate_input" readonly="readonly" /></td>
										<td>
											<input name="reset" type="button" value="{{ select_button_message }}" class="button submit-button reset-button" id="{{ id }}_xml_upload" />
										</td>
										<td id="{{ id }}_submit_container">
											<input name="{{ id }}_button" type="submit" value="{{ upload_button_message }}" class="button-primary" />
										</td>
									</tr>
								</table>
							</div>
						</div>
					</td>
				</tr>
			</table>
			
		</div>	
	</div>

	{{ has_dependence.true:begin }}
	<input type="hidden" name="{{ id }}_dependence" id="{{ id }}_dependence" value="{{ formatted_dependence }}" />
	<input type="hidden" name="{{ id }}_dependence_show_value" id="{{ id }}_dependence_show_value" value="{{ formatted_dependence_show_value }}" />
	{{ has_dependence.true:end }}	
	<div class="prisna_wp_translate_clear"></div>
	
</div>
