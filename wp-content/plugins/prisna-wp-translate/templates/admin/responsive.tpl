<div class="prisna_wp_translate_section prisna_wp_translate_{{ type }}{{ dependence.show.false:begin }} prisna_wp_translate_no_display{{ dependence.show.false:end }}{{ has_dependence.true:begin }} prisna_wp_translate_section_tabbed_{{ dependence_count }}{{ has_dependence.true:end }}" id="section_{{ id }}">

	<div class="prisna_wp_translate_setting">
	
	</div>

	<div class="prisna_wp_translate_{{ type }}_button_container">
		<input name="{{ id }}_add_new" id="{{ id }}_add_new" value="{{ add_new_message }}" class="button-primary" type="button" />
	</div>

	<div class="prisna_wp_translate_responsive_pattern prisna_wp_translate_no_display">

		<div class="prisna_wp_translate_title_container prisna_wp_translate_icon prisna_wp_translate_icon_list2">
			<h3 class="prisna_wp_translate_title">Media query:&nbsp;<input class="prisna_wp_translate_input" type="text" value="" spellcheck="false" /> <input type="button" value="{{ remove_message }}" class="button reset-button" /></h3>
		</div>
		
		<div class="prisna_wp_translate_responsive_body">
			<div class="prisna_wp_translate_ui_tabs_main_container">

				<div class="prisna_wp_translate_ui_tab_container prisna_wp_translate_display">

					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td class="prisna_wp_translate_responsive_body_show_td prisna_wp_translate_responsive_body_td">
				
								<h3 class="prisna_wp_translate_title">{{ show_message }}</h3>
								<div class="prisna_wp_translate_main_form_container">

									<div class="prisna_wp_translate_ui_tab_content">
										<ul>{{ languages_formatted }}</ul>
									</div>
									
								</div>
								
							</td>
							<td class="prisna_wp_translate_responsive_body_hide_td prisna_wp_translate_responsive_body_td">
								
								<h3 class="prisna_wp_translate_title">{{ hide_message }}</h3>
								<div class="prisna_wp_translate_main_form_container">

									<div class="prisna_wp_translate_ui_tab_content">
										<ul>{{ languages_formatted }}</ul>
									</div>
									<input type="hidden" value="" />
									
								</div>
								
							</td>
						</tr>
					</table>
				
				</div>
			</div>
		</div>
		
	</div>

	<input name="{{ id }}" id="{{ id }}" type="hidden" value="{{ value }}" />

	<div class="prisna_wp_translate_clear"></div>

</div>
