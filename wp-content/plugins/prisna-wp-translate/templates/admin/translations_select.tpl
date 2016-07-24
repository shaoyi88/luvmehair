			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<div class="prisna_wp_translate_setting_aux">

						</div>
					</td>
					<td>&nbsp;&nbsp;&nbsp;</td>
					<td>
						<input class="button submit-button reset-button" type="button" value="Select" onclick="PrisnaWPTranslateAdmin.selectResource(); return false;" />
					</td>
					<td>&nbsp;&nbsp;&nbsp;</td>
					<td>
						<input class="button submit-button reset-button" type="button" value="Reset" onclick="PrisnaWPTranslateAdmin.resetResource(); return false;" />
					</td>
					<td id="{{ id }}_remove" class="prisna_wp_translate_no_display_important">
						<input class="button submit-button reset-button" type="button" value="Remove" onclick="PrisnaWPTranslateAdmin.removeResource('All the cached translations for the selected Resource will be removed. This operation cannot be undone. Do you want to continue?'); return false;" />
					</td>
					<td>&nbsp;&nbsp;&nbsp;</td>
					<td id="{{ id }}_loading"></td>
				</tr>
			</table>