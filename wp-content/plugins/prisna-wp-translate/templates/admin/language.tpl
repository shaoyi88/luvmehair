<div class="prisna_wp_translate_section prisna_wp_translate_{{ type }}{{ dependence.show.false:begin }} prisna_wp_translate_no_display{{ dependence.show.false:end }}{{ has_dependence.true:begin }} prisna_wp_translate_section_tabbed_{{ dependence_count }}{{ has_dependence.true:end }}" id="section_{{ id }}">
	
	<div class="prisna_wp_translate_tooltip"></div>
	<div class="prisna_wp_translate_description prisna_wp_translate_no_display">{{ description_message }}</div>
		
	<div class="prisna_wp_translate_title_container prisna_wp_translate_icon prisna_wp_translate_icon_grid2"><h3 class="prisna_wp_translate_title">{{ title_message }}</h3></div>
	<div class="prisna_wp_translate_setting">
		<div class="prisna_wp_translate_field">

{{ collection_formatted }}

		</div>
		
		<div class="prisna_wp_translate_clear"></div>
	
	</div>
</div>

{{ order.show.true:begin }}

<div class="prisna_wp_translate_section prisna_wp_translate_{{ type }}{{ dependence.show.false:begin }} prisna_wp_translate_no_display{{ dependence.show.false:end }}{{ has_dependence.true:begin }} prisna_wp_translate_section_tabbed_{{ dependence_count }}{{ has_dependence.true:end }}" id="section_{{ id }}_order">
	<div class="prisna_wp_translate_tooltip"></div>
	<div class="prisna_wp_translate_description prisna_wp_translate_no_display">{{ description_order_message }}</div>
		
	<div class="prisna_wp_translate_title_container prisna_wp_translate_icon prisna_wp_translate_icon_grid2"><h3 class="prisna_wp_translate_title">{{ title_order_message }}</h3></div>
	<div class="prisna_wp_translate_setting">
		<div class="prisna_wp_translate_field">

{{ collection_order_formatted }}

		</div>

		<input name="{{ id }}_order" id="{{ id }}_order" type="hidden" value="{{ value_order }}" />
		
		<div class="prisna_wp_translate_clear"></div>

	</div>
</div>

{{ order.show.true:end }}