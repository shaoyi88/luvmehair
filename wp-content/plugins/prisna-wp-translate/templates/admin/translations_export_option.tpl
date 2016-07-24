	<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			{{ indent.true:begin }}
			<td style="padding-left: {{ indent }}px;" class="prisna_wp_translate_transexport_parent">
				<input type="checkbox" name="{{ name }}[]" value="{{ option }}" id="{{ id }}" class="prisna_wp_translate_checkbox" />
				<label for="{{ id }}">{{ value }}</label>
			</td>
			{{ indent.true:end }}
			{{ indent.false:begin }}
			<td>
				{{ value }}
			</td>			
			{{ indent.false:end }}
		</tr>
	</table>