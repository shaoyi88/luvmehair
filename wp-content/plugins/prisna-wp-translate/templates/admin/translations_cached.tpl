	<div class="prisna_wp_translate_title_container prisna_wp_translate_float_right prisna_wp_translate_icon prisna_wp_translate_icon_search">
		<h3 class="prisna_wp_translate_title prisna_wp_translate_float_left">
			<span class="prisna_wp_translate_cached_translations_search_container">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td><input class="prisna_wp_translate_input" name="prisna_translations_search" id="prisna_translations_search" type="text" value="" onkeypress="return PrisnaWPTranslateAdmin.preSearchTranslation(event);" spellcheck="false" /></td>
						<td><input class="button submit-button reset-button" type="button" value="Search" onclick="PrisnaWPTranslateAdmin.searchTranslation(); return false;">
						<td><input class="button submit-button reset-button" type="button" value="Reset" onclick="PrisnaWPTranslateAdmin.resetSearchTranslation(true); return false;">
					</tr>
				</table>
			</span>
		</h3>
	</div>
	<div class="prisna_wp_translate_title_container prisna_wp_translate_icon prisna_wp_translate_icon_grid2">
		<h3 class="prisna_wp_translate_title">
			Cached translations (<span class="prisna_wp_translate_selected_label">{{ from_language }} &gt; {{ to_language }}</span>)
		</h3>
	</div>
	<div class="prisna_wp_translate_setting">
		<div class="prisna_wp_translate_field prisna_wp_translate_cached_translations_container">
			<table border="0" cellpadding="0" cellspacing="0">
{{ cached_translations_fields_formatted }}
			</table>
		</div>	
	</div>
