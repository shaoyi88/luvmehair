			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>{{ site_url }}</td>
					<td>&nbsp;</td>
					<td>
						<div class="prisna_wp_translate_setting_aux">
							<select class="prisna_wp_translate_select" name="{{ id }}" id="{{ id }}">
{{ collection_formatted }}
							</select>
						</div>
					</td>
					<td>&nbsp;&nbsp;&nbsp;</td>
					<td>
						<input class="button submit-button reset-button" type="button" value="Select" onclick="PrisnaWPTranslateAdmin.selectPermalinkResource(); return false;" />
					</td>
					<td>&nbsp;&nbsp;&nbsp;</td>
					<td>
						<input class="button submit-button reset-button" type="button" value="Reset" onclick="PrisnaWPTranslateAdmin.resetPermalinkResource(); return false;" />
					</td>
					<td>&nbsp;&nbsp;&nbsp;</td>
					<td id="{{ id }}_loading"></td>
				</tr>
			</table>