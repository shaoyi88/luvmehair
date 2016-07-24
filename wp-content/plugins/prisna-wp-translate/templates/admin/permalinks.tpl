<div class="prisna_wp_translate_section prisna_wp_translate_{{ type }}{{ dependence.show.false:begin }} prisna_wp_translate_no_display{{ dependence.show.false:end }}{{ has_dependence.true:begin }} prisna_wp_translate_section_tabbed_{{ dependence_count }}{{ has_dependence.true:end }}" id="section_{{ id }}">
	
	<div class="prisna_wp_translate_tooltip"></div>
	<div class="prisna_wp_translate_description prisna_wp_translate_no_display">{{ description_message }}</div>
		
	<div class="prisna_wp_translate_title_container prisna_wp_translate_icon prisna_wp_translate_icon_grid2"><h3 class="prisna_wp_translate_title">{{ title_message }}</h3></div>
	<div class="prisna_wp_translate_setting">
		<div class="prisna_wp_translate_field">
{{ resource_formatted }}
		</div>	
	</div>
	
	<div id="{{ id }}_permalinks" class="prisna_wp_translate_no_display"></div>
	
	<div id="{{ id }}_permalinks_buttons" class="prisna_wp_translate_no_display">
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<input name="reset" type="button" value="Cancel &amp; close" class="button submit-button reset-button cancel-n-close-translations" onclick="PrisnaWPTranslateAdmin.resetPermalinksTranslations(); return false;" />
				</td>
				<td>&nbsp;&nbsp;&nbsp;</td>
				<td>
					<input class="button-primary save-translations" type="button" name="save" value="Save translations" onclick="PrisnaWPTranslateAdmin.savePermalinksTranslations(); return false;" />
				</td>
				<td>&nbsp;&nbsp;&nbsp;</td>
				<td id="{{ id }}_permalinks_loading"></td>
			</tr>
		</table>
		<div class="prisna_wp_translate_permalinks_translations_saved prisna_wp_translate_message prisna_wp_translate_no_display">
			<p>{{ permalinks_translations_saved_message }}</p>
		</div>
	</div>

	<div class="prisna_wp_translate_clear"></div>

{{ permalink_structure.empty.true:begin }}
	<div>
	{{ permalink_structure_empty_message }}
	</div>
{{ permalink_structure.empty.true:end }}
	
	{{ has_dependence.true:begin }}
	<input type="hidden" name="{{ id }}_dependence" id="{{ id }}_dependence" value="{{ formatted_dependence }}" />
	<input type="hidden" name="{{ id }}_dependence_show_value" id="{{ id }}_dependence_show_value" value="{{ formatted_dependence_show_value }}" />
	{{ has_dependence.true:end }}	
	<div class="prisna_wp_translate_clear"></div>
	
</div>
