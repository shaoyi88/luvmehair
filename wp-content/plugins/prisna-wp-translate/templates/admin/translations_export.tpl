<div class="prisna_wp_translate_section prisna_wp_translate_{{ type }}{{ dependence.show.false:begin }} prisna_wp_translate_no_display{{ dependence.show.false:end }}{{ has_dependence.true:begin }} prisna_wp_translate_section_tabbed_{{ dependence_count }}{{ has_dependence.true:end }}" id="section_{{ id }}">
	
	<div class="prisna_wp_translate_tooltip"></div>
	<div class="prisna_wp_translate_description prisna_wp_translate_no_display">{{ description_message }}</div>
		
	<div class="prisna_wp_translate_title_container prisna_wp_translate_icon prisna_wp_translate_icon_grid2"><h3 class="prisna_wp_translate_title">{{ title_message }}</h3></div>

	<div class="prisna_wp_translate_setting">
		<div class="prisna_wp_translate_field">
			{{ empty_collection.false:begin }}
			{{ collection_formatted }}
			{{ empty_collection.false:end }}
			{{ empty_collection.true:begin }}
			<div class="prisna_wp_translate_validate_warning">{{ empty_collection_message }}</div>
			{{ empty_collection.true:end }}
		</div>	
	</div>

	{{ empty_collection.false:begin }}
	<div id="prisna_translations_export_translations_buttons">
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<input class="button-primary export-translations" type="submit" name="{{ id }}_button" value="{{ button_message }}" />
				</td>
			</tr>
		</table>
	</div>
	{{ empty_collection.false:end }}
	
	{{ has_dependence.true:begin }}
	<input type="hidden" name="{{ id }}_dependence" id="{{ id }}_dependence" value="{{ formatted_dependence }}" />
	<input type="hidden" name="{{ id }}_dependence_show_value" id="{{ id }}_dependence_show_value" value="{{ formatted_dependence_show_value }}" />
	{{ has_dependence.true:end }}	
	<div class="prisna_wp_translate_clear"></div>
	
</div>
