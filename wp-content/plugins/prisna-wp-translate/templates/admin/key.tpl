<div class="prisna_wp_translate_section prisna_wp_translate_{{ type }}{{ dependence.show.false:begin }} prisna_wp_translate_no_display{{ dependence.show.false:end }}{{ has_dependence.true:begin }} prisna_wp_translate_section_tabbed_{{ dependence_count }}{{ has_dependence.true:end }}" id="section_{{ id }}">

	<div class="prisna_wp_translate_tooltip"></div>
	<div class="prisna_wp_translate_description prisna_wp_translate_no_display">{{ description_message }}</div>

	<div class="prisna_wp_translate_title_container prisna_wp_translate_icon prisna_wp_translate_icon_key"><h3 class="prisna_wp_translate_title">{{ title_message }}</h3></div>
	<div class="prisna_wp_translate_setting">
		<div class="prisna_wp_translate_field">
			<input class="prisna_wp_translate_input" name="{{ id }}" id="{{ id }}" type="text" value="{{ value }}" onfocus="return PrisnaWPTranslateAdmin.enableField(this);" spellcheck="false" />
		</div>
	</div>

{{ empty_validate.false:begin }}
<div class="prisna_wp_translate_api_key_empty_validate prisna_wp_translate_message prisna_wp_translate_warning_message">
	<p>{{ empty_validate_message }}</p>
</div>
{{ empty_validate.false:end }}

{{ validate.false:begin }}
<div class="prisna_wp_translate_api_key_validate prisna_wp_translate_message prisna_wp_translate_warning_message">
	<p>{{ validate_message }}</p>
</div>
{{ validate.false:end }}

{{ test_validate.true:begin }}
<div class="prisna_wp_translate_api_key_test_validate prisna_wp_translate_message prisna_wp_translate_warning_message">
	<p>{{ test_message }}</p>
</div>
{{ test_validate.true:end }}

<input type="hidden" name="{{ id }}_test" id="{{ id }}_test" type="text" value="{{ test }}" />

	<div class="prisna_wp_translate_clear"></div>

</div>
