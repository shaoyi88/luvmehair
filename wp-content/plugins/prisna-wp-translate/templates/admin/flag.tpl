<div class="prisna_wp_translate_section prisna_wp_translate_{{ type }}{{ dependence.show.false:begin }} prisna_wp_translate_no_display{{ dependence.show.false:end }}{{ has_dependence.true:begin }} prisna_wp_translate_section_tabbed_{{ dependence_count }}{{ has_dependence.true:end }}" id="section_{{ id }}">

	<div class="prisna_wp_translate_tooltip"></div>
	<div class="prisna_wp_translate_description prisna_wp_translate_no_display">{{ description_message }}</div>

	<div class="prisna_wp_translate_title_container prisna_wp_translate_icon prisna_wp_translate_icon_grid2"><h3 class="prisna_wp_translate_title">{{ title_message }}</h3></div>
	<div class="prisna_wp_translate_setting">
		<div class="prisna_wp_translate_field">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="prisna_wp_translate_{{ type }}_country_container">
						<div class="prisna_wp_translate_setting_aux">
							{{ country_formatted }}
						</div>
					</td>
					<td class="prisna_wp_translate_{{ type }}_language_container">
						<div class="prisna_wp_translate_setting_aux">
							{{ language_formatted }}</td>
						</div>
					</td>
					<td id="{{ id }}_add" class="prisna_wp_translate_no_display">
						<input class="button submit-button reset-button" type="button" value="{{ add_message }}" onclick="PrisnaWPTranslateAdmin.addCustomFlag(); return false;" />
					</td>
					<td>
						<div class="prisna_wp_translate_{{ type }}_preview">
							<div class="prisna_wp_translate_language_item">
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td id="{{ id }}_preview_flag" class="prisna_wp_translate_no_display"></td>
										<td id="{{ id }}_preview_language" class="prisna_wp_translate_no_display"></td>
									</tr>
								</table>
							</div>
						</div>
					</td>

				</tr>
			</table>
			<ul id="{{ id }}_view" class="prisna_wp_translate_{{ type }}_view"></ul>
			<input class="prisna_wp_translate_input" name="{{ id }}" id="{{ id }}" type="hidden" value="{{ value }}" />
		</div>
	</div>

	<ul id="{{ id }}_template" class="prisna_wp_translate_no_display">
		<li class="prisna_wp_translate_language_item">
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="prisna_wp_translate_{{ type }}_view_flag"></td>
					<td class="prisna_wp_translate_{{ type }}_view_language"></td>
				</tr>
			</table>
		</li>
	</ul>

	{{ has_dependence.true:begin }}
	<input type="hidden" name="{{ id }}_dependence" id="{{ id }}_dependence" value="{{ formatted_dependence }}" />
	<input type="hidden" name="{{ id }}_dependence_show_value" id="{{ id }}_dependence_show_value" value="{{ formatted_dependence_show_value }}" />
	{{ has_dependence.true:end }}	
	<div class="prisna_wp_translate_clear"></div>

</div>
