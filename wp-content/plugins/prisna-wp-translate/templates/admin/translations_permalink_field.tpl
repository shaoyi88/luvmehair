				<tr>
					<td>{{ pre_url }}</td>
					<td>&nbsp;</td>
					<td>
						<input type="text" name="{{ id }}_{{ from }}_{{ to }}_translation" id="{{ id }}_{{ from }}_{{ to }}_translation" class="prisna_wp_translate_input" spellcheck="false" value="{{ translation }}" placeholder="{{ placeholder }}" onkeypress="return PrisnaWPTranslateAdmin.adjustPost(event{{ has_post_url.true:begin }}, this{{ has_post_url.true:end }});" onkeydown="return PrisnaWPTranslateAdmin.adjustPost(event{{ has_post_url.true:begin }}, this{{ has_post_url.true:end }});" onkeyup="return PrisnaWPTranslateAdmin.adjustPost(event{{ has_post_url.true:begin }}, this{{ has_post_url.true:end }});" />
						<input type="hidden" name="{{ id }}_{{ from }}_{{ to }}_translation_original" id="{{ id }}_{{ from }}_{{ to }}_translation_original" value="{{ translation }}" />
					</td>
					{{ has_post_url.true:begin }}
					<td>&nbsp;</td>
					<td id="{{ id }}_{{ from }}_{{ to }}_translation_post">{{ post_url }}</td>
					{{ has_post_url.true:end }}
					<td class="prisna_wp_translate_cached_translation_gt">&nbsp;</td>
					<td>
						{{ to_formatted }}{{ language_enabled.false:begin }} <span class="prisna_wp_translate_validate_warning">(Not enabled)</span>{{ language_enabled.false:end }}
					</td>
				</tr>