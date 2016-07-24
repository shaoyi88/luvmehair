<div class="prisna_wp_translate_section prisna_wp_translate_{{ type }}{{ dependence.show.false:begin }} prisna_wp_translate_no_display{{ dependence.show.false:end }}{{ has_dependence.true:begin }} prisna_wp_translate_section_tabbed_{{ dependence_count }}{{ has_dependence.true:end }}" id="section_{{ id }}">

	<div class="prisna_wp_translate_tooltip"></div>
	<div class="prisna_wp_translate_description prisna_wp_translate_no_display">{{ description_message }}</div>

	<div class="prisna_wp_translate_title_container prisna_wp_translate_icon prisna_wp_translate_icon_paint"><h3 class="prisna_wp_translate_title">{{ title_message }}</h3></div>
	<div class="prisna_wp_translate_setting">
		<div class="prisna_wp_translate_field">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input class="prisna_wp_translate_color_picker_view" name="{{ id }}_view" id="{{ id }}_view" type="text" value="" readonly="readonly" style="background-color: {{ value }};" /></td>
					<td><input class="prisna_wp_translate_color_picker" name="{{ id }}" id="{{ id }}" type="text" value="{{ value }}" onfocus="return PrisnaWPTranslateAdmin.enableField(this);" spellcheck="false" /></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="prisna_wp_translate_clear"></div>

</div>
