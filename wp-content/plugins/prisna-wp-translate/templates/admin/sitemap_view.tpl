<div class="prisna_wp_translate_section prisna_wp_translate_{{ type }}{{ dependence.show.false:begin }} prisna_wp_translate_no_display{{ dependence.show.false:end }}{{ has_dependence.true:begin }} prisna_wp_translate_section_tabbed_{{ dependence_count }}{{ has_dependence.true:end }}" id="section_{{ id }}">
{{ description.true:begin }}
	<div class="prisna_wp_translate_tooltip"></div>
	<div class="prisna_wp_translate_description prisna_wp_translate_no_display">{{ description_message }}</div>
{{ description.true:end }}
	<div class="prisna_wp_translate_title_container prisna_wp_translate_icon prisna_wp_translate_icon_grid2"><h3 class="prisna_wp_translate_title">{{ title_message }}</h3></div>
	<div class="prisna_wp_translate_setting">
		<div class="prisna_wp_translate_field">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>XML:&nbsp;</td>
					<td><a href="{{ xml_url }}" target="_blank">{{ xml_url }}</a></td>
				</tr>
				<tr>
					<td>CSV:&nbsp;</td>
					<td><a href="{{ csv_url }}" target="_blank">{{ csv_url }}</a></td>
				</tr>
				<tr>
					<td class="prisna_translations_vertical_align_top">robots.txt:&nbsp;</td>
					<td>
						<code>Sitemap: {{ xml_url }}</code>
					</td>
				</tr>
{{ permalink_structure.empty.true:begin }}
				<tr>
					<td colspan="2">
						{{ permalink_structure_empty_message }}
					</td>
				</tr>
{{ permalink_structure.empty.true:end }}
			</table>
		</div>
	</div>

	<div class="prisna_wp_translate_clear"></div>

</div>
