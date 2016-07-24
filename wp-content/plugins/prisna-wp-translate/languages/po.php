<?php
/*
 * Source: /wp-admin/plugins.php?page=prisna-translate-settings&prisna-po=1
 */


echo _('Prisna Translate Settings');
echo _('Settings saved.');
echo _('Layout changed.');
echo _('Translations saved.');
echo _('Translations saved.');
echo _('Settings and translations succesfully imported.');
echo _('There was a problem while importing the settings and the translations.');
echo _('Settings succesfully imported.');
echo _('There was a problem while importing the settings. Please make sure the exported string is complete. Changes weren\'t saved.');
echo _('Settings reseted.');
echo _('All the settings will be reseted and restored to their default values. Do you want to continue?');
echo _('Save changes');
echo _('Reset settings');
echo _('Please provide an <b>API key</b> for the <a href="https://code.google.com/apis/console">Google Translation Service</a>.');
echo _('Please provide the <b>Client Id</b> for the <a href="https://datamarket.azure.com/dataset/1899a118-d202-492c-aa16-ba21c33c06cb" target="_blank">Microsoft Translation Service</a>. Register an <a href="https://datamarket.azure.com/developer/applications/" target="_blank">application</a>.');
echo _('Please provide the <b>Client Secret</b> for the <a href="https://datamarket.azure.com/dataset/1899a118-d202-492c-aa16-ba21c33c06cb" target="_blank">Microsoft Translation Service</a>. Register an <a href="https://datamarket.azure.com/developer/applications/" target="_blank">application</a>.');
echo _('The folder [0] isn\'t writable.');
echo _('There\'s at least one cache file that isn\'t writable, ie: <b>[0]</b>');
echo _('The following image file isn\'t writable: <b>[0]</b>');
echo _('The OpenSSL module isn\'t installed on this server, which is required by the Google Translate API.');
echo _('The <b>fsockopen</b> function isn\'t enabled on this server.');
echo _('The <b>hash</b> function isn\'t enabled on this server.');
echo _('The <b>DOMDocument</b> class isn\'t enabled on this server.');
echo _('The <b>Mcrypt</b> module isn\'t enabled on this server.');
echo _('Enabling SEO requires the <b>mb_convert_encoding</b> function, which isn\'t enabled on this server.');
echo _('Widget enabled. However, it isn\'t assigned to a widget area (see <a href="[0]">Appearance > Widgets</a>).');
echo _('The <b>WP Super Cache</b> plugin is installed. The "<b>Don\'t cache pages with GET parameters&hellip;</b>" setting must be enabled for SEO to work properly.');
echo _('The <b>GD</b> library isn\'t enabled on this server, which is needed to change images\' colors.');
echo _('Layout');
echo _('General');
echo _('Advanced');
echo _('General');
echo _('Settings Access');
echo _('Import / Export');
echo _('Cached Translations');
echo _('General');
echo _('Automate');
echo _('Import');
echo _('Export');
echo _('General');
echo _('Permalinks');
echo _('Sitemap');
echo _('Logs');
echo _('SEO');
echo _('Styling');
echo _('Responsive');
echo _('Settings');
echo _('Prisna WP Translate');
echo _('Ajust settings <a href="[0]">here</a>');
echo _('Style');
echo _('Size');
echo _('API key');
echo _('
			Sets the Key for the Prisna Translate API.<br />
			<a href="http://www.prisna.net/account/" target="_blank">Sign up for an API key</a>
		');
echo _('The entered API key appears to be invalid.<br /><a href="http://www.prisna.net/account/" target="_blank">Sign up for an API key</a>, or to see how the translator looks like, use the following test API key:<br /><br /><a href="javascript:;" onclick="PrisnaWPTranslateAdmin.useTestAPIkey();">[0]</a>');
echo _('<a href="http://www.prisna.net/account/" target="_blank">Sign up for an API key</a>, or to see how the translator looks like, use the following test API key:<br /><br /><a href="javascript:;" onclick="PrisnaWPTranslateAdmin.useTestAPIkey();">[0]</a>');
echo _('The current API key is for testing the translator looks only. It\'s not possible to make translations. <a href="http://www.prisna.net/account/" target="_blank">Sign up for an API key now</a>.[0]');
echo _('<br /><br />Consider enabling the <b>Test mode</b> option: Advanced &gt; General &gt; Test mode &gt; Enable');
echo _('Translation service');
echo _('Sets the translation service to perform the translations.');
echo _('Client Id');
echo _('Sets the <div class="prisna_wp_translate_code_container"><code>Client Id</code></div> for the <a href="https://datamarket.azure.com/dataset/1899a118-d202-492c-aa16-ba21c33c06cb" target="_blank">Microsoft Translation Service</a>. After signing up for the service, register an <a href="https://datamarket.azure.com/developer/applications/" target="_blank">application</a> to generate both Client Id and Client Secret.');
echo _('Client Secret');
echo _('Sets the <div class="prisna_wp_translate_code_container"><code>Client Secret</code></div> for the <a href="https://datamarket.azure.com/dataset/1899a118-d202-492c-aa16-ba21c33c06cb" target="_blank">Microsoft Translation Service</a>. After signing up for the service, register an <a href="https://datamarket.azure.com/developer/applications/" target="_blank">application</a> to generate both Client Id and Client Secret.');
echo _('Google API key');
echo _('Sets the <div class="prisna_wp_translate_code_container"><code>Google API key</code></div> for the <a href="https://code.google.com/apis/console" target="_blank">Google Translation Service</a>.');
echo _('Auto select language');
echo _('
			Automatically selects the page\'s language when it\'s loaded, just to provide visual aids.
		');
echo _('Yes, auto select the language option');
echo _('No, don\'t auto select the language option');
echo _('Completed image');
echo _('Sets whether the completed class should be set, or not. If it\'s set, a style class (defined in the <div class="prisna_wp_translate_code_container"><code>Completed class</code></div> setting) will be added to the clicked language. By default, the class displays an image indicating the end of the translation process.');
echo _('Yes, display the completed image');
echo _('No, hide the completed image');
echo _('Auto highlight the selected language');
echo _('
			Automatically highlight the page\'s language when it\'s loaded, just to provide visual aids.
		');
echo _('Yes, auto highlight the language option');
echo _('No, don\'t auto highlight the language option');
echo _('Highlight the selected language');
echo _('Sets whether the completed class should be set, or not. If it\'s set, a style class (defined in the <div class="prisna_wp_translate_code_container"><code>Completed class</code></div> setting) will be added to the clicked language. By default, the class highlights the selected language at the end of the translation process.');
echo _('Yes, highlight the selected language');
echo _('No, don\'t highlight the selected language');
echo _('Completed class');
echo _('Sets the style class to be added to the clicked language\'s link when the translation is completed.');
echo _('Sticky class');
echo _('Sets the style class to be added to the translator\'s container when the Sticky mode is enabled.');
echo _('Container class');
echo _('Sets the style class to be added to the translator\'s container.');
echo _('Container class (custom location)');
echo _('Sets the style class to be added to the translator\'s container. Only applies if Custom Location is set.');
echo _('Container class (fixed location)');
echo _('Sets the style class to be added to the translator\'s container. Only applies if Fixed Location is set.');
echo _('RTL class');
echo _('Sets the style class to be added to the body for right-to-left languages.');
echo _('Hide current selected language');
echo _('Sets whether to hide the current selected language from the drop down, or not.');
echo _('Yes, hide current selected language');
echo _('No, don\'t hide current selected language');
echo _('Align mode');
echo _('Sets the alignment mode of the languages.');
echo _('Left');
echo _('Center');
echo _('Right');
echo _('Align left class');
echo _('Sets the style class to be added to the translator\'s container when the <div class="prisna_wp_translate_code_container"><code>Align mode</code></div> setting is set to <div class="prisna_wp_translate_code_container"><code>Left</code></div>.');
echo _('Align right class');
echo _('Sets the style class to be added to the translator\'s container when the <div class="prisna_wp_translate_code_container"><code>Align mode</code></div> setting is set to <div class="prisna_wp_translate_code_container"><code>Right</code></div>.');
echo _('Round corners');
echo _('Sets whether to round the corners of the main container, or not.');
echo _('Yes, round the corners of the main container');
echo _('No, don\'t round the corners of the main container');
echo _('Enable scroll');
echo _('Sets whether the scroll functionality should be enabled, or not.');
echo _('Yes, enable the scroll functionality');
echo _('No, disable the scroll functionality');
echo _('Languages quantity');
echo _('Sets how many languages will be visible within the scrolling viewport.');
echo _('Scroll bar width');
echo _('Sets the scroll bar width.');
echo _('Scroll bar opacity');
echo _('Sets the scroll bar opacity.');
echo _('Mouse wheel step');
echo _('Sets the mouse wheel step.');
echo _('Remember the selected language for auto-translate');
echo _('Sets whether the selected language should be remembered (in a cookie) after a page is refreshed, or not. If it\'s set and the visitor continues browsing, the website will be automatically translated.');
echo _('Yes, remember the selected language to auto-translate');
echo _('No, don\'t remember the selected language and don\'t auto-translate');
echo _('Remember even after the browser is closed');
echo _('Sets whether the <div class="prisna_wp_translate_code_container"><code>Remember the selected language for auto-translate</code></div> should be kept after the visitor\'s browser is closed, or not.');
echo _('Yes, remember even after the browser is closed');
echo _('No, don\'t remember after the browser is closed');
echo _('Requests');
echo _('Sets the maximum number of requests sent to the API at the same time. A high number of requests will translate the page faster, but might hang or even crash the internet browser.');
echo _('RTL languages');
echo _('Defines a list with the right-to-left language codes. After a translation is made, the body will look like:<br /><br />
			<div class="prisna_wp_translate_code_container"><code>&lt;body class="<b>prisna-wp-translate-rtl</b>"&gt;</code></div>');
echo _('Exclude selector (jQuery)');
echo _('Select those elements to NOT be translated. In jQuery format. For more info, check the <a href="http://api.jquery.com/category/selectors/" target="_blank">jQuery selector guide</a>.');
echo _('Exclude paragraphs (regular expression)');
echo _('Defines a set of rules to exclude paragraphs from translations.<br /><br />
		
		A rule is defined as <a href="http://www.php.net/manual/en/reference.pcre.pattern.syntax.php" target="_blank">a regular expression</a> to match the paragraph. <a href="http://www.vijayforvictory.com/wp-content/gallery/ngen_gallery/regular-expressions-cheat-sheet.png" target="_blank">Cheat sheet</a>.<br />
		
		One rule per line. For instance:<br /><br />

		/mysite\.com/<br /><br />
		
		Invalid rules will be silently ignored.');
echo _('Flag template');
echo _('Sets the language\'s flag template. New templates can be created if the provided one doesn\'t fit the web page requirements.');
echo _('Flags');
echo _('Sets whether the languages flags should be displayed, or not.');
echo _('Yes, display the images flags');
echo _('No, hide the images flags');
echo _('Test mode');
echo _('
			Sets whether the translator is in test mode, or not. In "test mode", the translator will be displayed only if the current logged in user has admin privileges.<br />
			Is useful for setting up the translator without letting visitors to see the changes while the plugin is being implemented.
		');
echo _('Yes, enable test mode');
echo _('No, disable test mode');
echo _('Shortcode usage');
echo _('Custom CSS');
echo _('Defines custom CSS rules.');
echo _('Enable attributes translation');
echo _('Sets whether the elements\' attributes: <div class="prisna_wp_translate_code_container"><code>title</code></div>, <div class="prisna_wp_translate_code_container"><code>alt</code></div> and <div class="prisna_wp_translate_code_container"><code>placeholder</code></div>, should be translated, or not.');
echo _('Yes, translate the elements\' attributes');
echo _('No, don\'t translate the elements\' attributes');
echo _('Translate the <em>title</em> attribute');
echo _('Sets whether the <div class="prisna_wp_translate_code_container"><code>title</code></div> attribute should be translated, or not.');
echo _('Yes, translate the <em>title</em> attribute');
echo _('No, don\'t translate the <em>title</em> attribute');
echo _('Translate the <em>alt</em> attribute');
echo _('Sets whether the <div class="prisna_wp_translate_code_container"><code>alt</code></div> attribute should be translated, or not.');
echo _('Yes, translate the <em>alt</em> attribute');
echo _('No, don\'t translate the <em>alt</em> attribute');
echo _('Translate the <em>placeholder</em> attribute');
echo _('Sets whether the <div class="prisna_wp_translate_code_container"><code>placeholder</code></div> attribute should be translated, or not.');
echo _('Yes, translate the <em>placeholder</em> attribute');
echo _('No, don\'t translate the <em>placeholder</em> attribute');
echo _('Translate meta tags <em>content</em> attribute');
echo _('Sets whether the <div class="prisna_wp_translate_code_container"><code>content</code></div> attribute of meta tags should be translated, or not.');
echo _('Yes, translate the <em>content</em> attribute of <em>meta tags</em>');
echo _('No, don\'t translate the <em>content</em> attribute of <em>meta tags</em>');
echo _('Meta tags kinds');
echo _('Specifies attributes used to select meta tags to translate.');
echo _('Insert widget');
echo _('Don\'t translate');
echo _('Show / hide content');
echo _('Default behavior:');
echo _('Show');
echo _('Hide');
echo _('Except for:');
echo _('Add');
echo _('Define custom flags');
echo _('Defines alternative flags to languages. Click on a language to remove it.<br /><a href="https://www.prisna.net/contact-us/" target="_blank">Contact us</a> for additional countries.');
echo _('Add');
echo _('Enable local storage');
echo _('Sets whether the translations should be stored in the visitor\'s browser to speed up the plugin, or not. This feature is available on modern browsers only, it won\'t cause any impact on old browsers. However, it forces the visitor\'s browser to use an extra amount of memory, therefore, it might slow it down depending on how many translations are being stored.');
echo _('Yes, enable local storage');
echo _('No, disable local storage');
echo _('Expiration period');
echo _('Sets an expiration period for the stored translations, in days.');
echo _('Clear local storage');
echo _('Sets whether to force the visitor\'s browser to clear up the stored translations and retrieve them again from the server, or not. This setting is useful when writing custom translations.');
echo _('Yes, force browsers to clear up the stored translations');
echo _('No, don\'t force browsers to clear up the stored translations');
echo _('Location');
echo _('
			Sets translator location.
		');
echo _('Widget (see <a href="[0]">Appearance > Widgets</a>)');
echo _('Custom');
echo _('Shortcode');
echo _('Fixed');
echo _('On top');
echo _('Custom location (jQuery)');
echo _('Specifies a location to place the translator. In jQuery format. For more info, check the <a href="http://api.jquery.com/category/selectors/" target="_blank">jQuery selector guide</a>.');
echo _('Widget class');
echo _('Sets the style class used on the widget\'s placeholder.');
echo _('Widget container id');
echo _('Sets the internal widget\'s container <div class="prisna_wp_translate_code_container"><code>id</code></div>.');
echo _('Widget container id');
echo _('Sets the internal widget\'s container <div class="prisna_wp_translate_code_container"><code>id</code></div>.');
echo _('Sticky mode');
echo _('Sets whether to display the translator in sticky mode or not. In "Sticky mode", the translator will remain visible at all times, even when scrolling pages down.');
echo _('Yes, enable the sticky mode');
echo _('No, disable the sticky mode');
echo _('Vertical distance');
echo _('
			Specifies the distance between the top/bottom margin edge of the translator and the top/bottom edge of its parent.<br /><br />
			For instance:<br /><br />
			top: 20px<br />
			bottom: -20px<br />
			top: 2.5em<br />
			bottom: 10%<br />
			top: auto<br />
			bottom: inherit
		');
echo _('top');
echo _('bottom');
echo _('Horizontal distance');
echo _('
			Specifies the distance between the left/right margin edge of the translator and the left/right edge of its parent.<br /><br />
			For instance:<br /><br />
			left: 20px<br />
			right: -20px<br />
			left: 2.5em<br />
			right: 10%<br />
			left: auto<br />
			right: inherit
		');
echo _('left');
echo _('right');
echo _('Parent (jQuery)');
echo _('Specifies a parent element container (or set) to hold the translator. In jQuery format. For more info, check the <a href="http://api.jquery.com/category/selectors/" target="_blank">jQuery selector guide</a>.');
echo _('Custom parent');
echo _('Specifies a custom parent element container (or set) to hold the translator.');
echo _('Insert mode');
echo _('Specifies how the translator (or the <div class="prisna_wp_translate_code_container"><code>Custom parent</code></div>) will be inserted into the <div class="prisna_wp_translate_code_container"><code>Custom location</code></div>.');
echo _('Flags and names class');
echo _('Adds a style class to the translator\'s main container when is showing languages flags and names.');
echo _('Flags and short names class');
echo _('Adds a style class to the translator\'s main container when is showing languages flags and short names.');
echo _('Flags class');
echo _('Adds a style class to the translator\'s main container when is showing only languages flags.');
echo _('Website\'s language');
echo _('Sets the website\'s source language.');
echo _('Hide class');
echo _('Sets the style class used to hide elements.');
echo _('Id');
echo _('
			Sets the internal <div class="prisna_wp_translate_code_container"><code>id</code></div> unique value. 
			It could also be used for custom styling purposes, since the translator id will be placed in the container\'s class attribute:<br /><br />
			<div class="prisna_wp_translate_code_container"><code>&lt;div class="translator translator-container <b>&lt;id&gt;</b>"&gt;</code></div>
		');
echo _('Language selector class');
echo _('
			Sets the style class used to identify the selected language. The language code will be concatenated:<br />
			<div class="prisna_wp_translate_code_container"><code>&lt;a class="<b>translator-language-</b>en" title="English" href="javascript:;"&gt;&lt;img alt="English" src="../translator/images/English.gif"&gt;&lt;span&gt;English&lt;/span&gt;&lt;/a&gt;</code></div>
		');
echo _('Translated to class');
echo _('Sets the prefix of the style class appended to the main body HTML element. After a translation is made, the body will look like:<br />
			<div class="prisna_wp_translate_code_container"><code>&lt;body class="<b>prisna-wp-translate-translated-to-</b>es"&gt;</code></div>');
echo _('Flags images class');
echo _('Sets the style class used to identify flags images when the <div class="prisna_wp_translate_code_container"><code>Combine flags images files into a single image file</code></div> setting is enabled.');
echo _('Available languages');
echo _('Sets the available languages.');
echo _('Languages order');
echo _('Defines the order to display the languages.');
echo _('Languages in their own language');
echo _('Sets whether to display the languages names in their own language, or not. To define custom names, use the following setting:<br /><br /><div class="prisna_wp_translate_code_container"><code>Advanced &gt; Other customizations &gt; Custom languages names</code></div>');
echo _('Yes, display languages in their own language');
echo _('No, display languages in English');
echo _('Link template');
echo _('Sets the language\'s link template. New templates can be created if the provided one doesn\'t fit the web page requirements.');
echo _('Links container template');
echo _('Sets the languages links container template. New templates can be created if the provided one doesn\'t fit the web page requirements.');
echo _('Loading image');
echo _('Sets whether the loading class should be set, or not. If it\'s set, a style class (defined in the <div class="prisna_wp_translate_code_container"><code>Loading class</code></div> setting) will be added to the clicked language\'s link. By default, the class displays an animated image indicating the loading.');
echo _('Yes, display the loading animated image');
echo _('No, hide the loading animated image');
echo _('Loading class');
echo _('Sets the style class to be added to the clicked language\'s link while the translation takes place.');
echo _('Glowing class');
echo _('Sets the style class to be added to the translator\'s main container when the glowing option is enabled.');
echo _('Round corners class');
echo _('Sets the style class to be added to the translator\'s main container when the corners are rounded.');
echo _('Name template');
echo _('Sets the language\'s name template. New templates can be created if the provided one doesn\'t fit the web page requirements.');
echo _('Names');
echo _('Sets whether the languages names should be displayed, or not.');
echo _('Yes, display the languages names');
echo _('No, hide the languages names');
echo _('Names class');
echo _('Adds a style class to the translator\'s main container when is showing only languages names.');
echo _('On before initialize callback');
echo _('Sets a callback function that runs before the translator is initialized. Receives two arguments: <div class="prisna_wp_translate_code_container"><code>translator, options</code></div>.');
echo _('On initialize callback');
echo _('Sets a callback function that runs when the translator is being initialized. Receives two arguments: <div class="prisna_wp_translate_code_container"><code>translator, options</code></div>.');
echo _('On complete callback');
echo _('Sets a callback function that runs when the translation is completed. Receives seven arguments: <div class="prisna_wp_translate_code_container"><code>filtered_elements, translation, source, from, to, options, restore</code></div>.');
echo _('On start callback');
echo _('Sets a callback function that runs when the translation starts. Receives five arguments: <div class="prisna_wp_translate_code_container"><code>filtered_elements, source, from, to, options</code></div>.');
echo _('On before load');
echo _('Defines a javascript routine that runs before the translator is loaded.');
echo _('Restore button');
echo _('
			Sets whether the restore button should be displayed, or not. By clicking the <div class="prisna_wp_translate_code_container"><code>Restore</code></div> button, all the selected text will be restored to their original content, and will clear the <div class="prisna_wp_translate_code_container"><code>Remember (cookie)</code></div> setting too.
		');
echo _('Yes, display the restore button');
echo _('No, hide the restore button');
echo _('Restore class');
echo _('Sets the style class to be added to the restore button.');
echo _('Restore container class');
echo _('Sets the style class to be added to the restore button\'s container.');
echo _('Restore template');
echo _('Sets the restore button\'s template. New templates can be created if the provided one doesn\'t fit the web page requirements.');
echo _('Languages separator');
echo _('
			Sets a separator between the languages options.<br />
			In order to optimize browser compatibility, the translator is built based on a table, so the separator will usually be a table cell (unless the templates are changed).<br />
			For instance:<br /><br />
			<div class="prisna_wp_translate_code_container"><code>&lt;td&gt;|&lt;/td&gt;</code></div><br /><br />
			Or:<br /><br />
			<div class="prisna_wp_translate_code_container"><code>&lt;td&gt;·&lt;/td&gt;</code></div>
		');
echo _('Adjust vertical position');
echo _('Some websites with special styles (body having relative positioning) will found the translation bar not placed at the very top. To correct that issue, enable this option to override the <div class="prisna_wp_translate_code_container"><code>Container class</code></div>.');
echo _('Yes, adjust the position');
echo _('No, the current position is fine');
echo _('Override container class');
echo _('Sets the style class to override the translator\'s container class defined in <div class="prisna_wp_translate_code_container"><code>Container class</code></div>.');
echo _('Short names');
echo _('Sets whether the languages names should be displayed in short mode, or not.<br />For instance: EN, ES, DA.');
echo _('Yes, display the languages names in short mode');
echo _('No, display the languages full names');
echo _('Short names class');
echo _('Adds a style class to the translator\'s main container when is showing only languages short names.');
echo _('Sub container class');
echo _('Sets the style class to be added to the translator\'s sub container.');
echo _('Floating left class');
echo _('Sets the style class to be added to the translator\'s container when the <div class="prisna_wp_translate_code_container"><code>Floating mode</code></div> setting is set to <div class="prisna_wp_translate_code_container"><code>Float left</code></div>.');
echo _('Floating right class');
echo _('Sets the style class to be added to the translator\'s container when the <div class="prisna_wp_translate_code_container"><code>Floating mode</code></div> setting is set to <div class="prisna_wp_translate_code_container"><code>Float right</code></div>.');
echo _('Hide selected language class');
echo _('Sets the style class to be added to the translator\'s container when the <div class="prisna_wp_translate_code_container"><code>Hide current selected language</code></div> setting is enabled.');
echo _('Body class');
echo _('Sets the style class to be added to the translator\'s body.');
echo _('Current language container class');
echo _('Sets the style class to be added to the current selected language.');
echo _('Current language arrow container class');
echo _('Sets the style class to be added to the arrow container.');
echo _('Language list class');
echo _('Sets the style class to be added to the languages list container.');
echo _('Language opened list class');
echo _('Sets the style class to be added to the languages list container when is unfolded.');
echo _('Scroll enabled class');
echo _('Sets the style class to be added to the translator\'s container, if the <div class="prisna_wp_translate_code_container"><code>Scroll</code></div> setting is enabled.');
echo _('Hover enabled class');
echo _('Sets the style class to be added to the translator\'s container, if the visitor\'s browser supports hovering, unlike a touch device.');
echo _('Language list scroll class');
echo _('Sets the style class to be added to the languages list container parent, if the <div class="prisna_wp_translate_code_container"><code>Scroll</code></div> setting is enabled.');
echo _('Language list scroll bar class');
echo _('Sets the style class to be added to the scroll bar, if the <div class="prisna_wp_translate_code_container"><code>Scroll</code></div> setting is enabled.');
echo _('Target selector (jQuery)');
echo _('Select those elements to be translated. In jQuery format. For more info, check the <a href="http://api.jquery.com/category/selectors/" target="_blank">jQuery selector guide</a>.<br /><br />To translate the title of the pages, make sure to add it: <div class="prisna_wp_translate_code_container"><code>body, title</code></div> ');
echo _('Custom HTML');
echo _('
			Specifies a custom HTML to represent the translator.
			If it doesn\'t find at least one element which <div class="prisna_wp_translate_code_container"><code>class</code></div> attribute contains the value: <div class="prisna_wp_translate_code_container"><code>Language selector class</code></div> + <div class="prisna_wp_translate_code_container"><code>&lt;language_code&gt;</code></div>, the content of the container element will be replaced by the translator\'s structure.<br />
			In order to have the <div class="prisna_wp_translate_code_container"><code>Restore</code></div> button working, the element <div class="prisna_wp_translate_code_container"><code>class</code></div> attribute should contain the <div class="prisna_wp_translate_code_container"><code>Restore class</code></div> value and its main parent should contain <div class="prisna_wp_translate_code_container"><code>Restore container class</code></div> value too.<br />
			For instance:<br /><br />
			<div class="prisna_wp_translate_code_container">
				<div class="prisna_wp_translate_code_container"><code>
					&lt;div class="translator"&gt;<br />
					&nbsp;&lt;a href="#" class="translator-language-<b>es</b>"&gt;<br />
					&nbsp;&nbsp;Spanish<br />
					&nbsp;&lt;/a&gt;<br />

					&nbsp;&lt;a href="#" class="translator-language-<b>en</b>"&gt;<br />
					&nbsp;&nbsp;English<br />
					&nbsp;&lt;/a&gt;<br />

					&nbsp;&lt;a href="#" class="translator-language-<b>da</b>"&gt;<br />
					&nbsp;&nbsp;Danish<br />
					&nbsp;&lt;/a&gt;<br />

					&nbsp;&lt;span class="translator-hidden translator-restore-container"&gt;<br />
					&nbsp;&nbsp;&lt;a href="#" class="restore"&gt;<br />
					&nbsp;&nbsp;&nbsp;Restore<br />
					&nbsp;&nbsp;&lt;/a&gt;<br />
					&nbsp;&lt;/span&gt;<br />
					&lt;/div&gt;
				</code></div>
			</div>
		');
echo _('Auto translate by parameter');
echo _('Sets whether to enable the auto translation by query string parameter functionality, or not.');
echo _('Yes, enable auto translate by parameter');
echo _('No, disable auto translate by parameter');
echo _('Parameter name');
echo _('Defines the parameter name to perform the auto translation. In order to use it, assign the language code desired to translate to. For instance:<br /><br />http://www.yoursite.com/?<b>translate-to=ja</b><br />http://www.yoursite.com/page.php?location=home&<b>translate-to=ja</b>');
echo _('Detect browser\'s language');
echo _('
			Sets whether to enable the vistiror browser\'s language, or not.<br /><br />
			
			<b>All visits</b>: The browser\'s language detection mechanism will be performed everytime a visitor loads a page, regardless of whether the visitor has selected another language, or not.<br />
			<b>First visit only</b>: The browser\'s language detection mechanism will be performed only the first time a visitor loads a page. If the visitor selects a different language, upcoming pages will be translated to the selected language.
			
		');
echo _('All visits');
echo _('First visit only');
echo _('Don\'t detect the browser\'s language');
echo _('Detect browser\'s language action');
echo _('
			Sets the action to be performed when detecting the visitor browser\'s language.<br /><br />
			
			<b>Automatic translation</b>: The page will be automatically translated to the detected language.<br />
			<b>Show or hide translator</b>: The translator will be shown if the detected language is different than the <div class="prisna_wp_translate_code_container"><code>General &gt; Website\'s language</code></div>. The translator will be hidden if the detected language is the same.
			
		');
echo _('Automatic translation');
echo _('Show or hide translator');
echo _('Override settings');
echo _('Defines a javascript object to override the current settings.');
echo _('Custom languages names');
echo _('Defines a javascript object to override the current languages names. For instance:<br /><code><br />{<br />&nbsp;&nbsp;&nbsp;&nbsp;"pt": "Português",<br />&nbsp;&nbsp;&nbsp;&nbsp;"ja": "日本語"<br />}</code>');
echo _('SEO available languages');
echo _('Sets the available languages to be indexed by the search engines.<br /><br /><div class="prisna_wp_translate_code_container"><code>Only cached translations can be indexed.</code></div><br /><br /><b>Important</b>: This is a machine translation plugin, it\'s your sole responsibility to verify the translated text is correct, and relevant to the purpose of this site. Use the <div class="prisna_wp_translate_code_container"><code>Custom Translations</code></div> tab to verify and to adjust the cached translations.');
echo _('Chinese ISO 639-1 language');
echo _('Selects which Chinese variation will be assigned to the <div class="prisna_wp_translate_code_container"><code>zh</code></div> ISO 639-1 language code.');
echo _('URL modification mode');
echo _('Sets the URL modification mode.<br /><br />Pre path and Subdomain modes will only work with mod_rewrite/pretty permalinks. The next tab <div class="prisna_wp_translate_code_container"><code>Sitemap &gt; Access</code></div> links should work if mod_rewrite/pretty permalinks is enabled.<br /><br />The <div class="prisna_wp_translate_code_container"><code>Subdomain</code></div> mode requires to properly set a CNAME (Alias) record for each enabled language. The name of the record should be the language code.');
echo _('Query string (?lang=en)');
echo _('Pre path (/en/ in front of URL)');
echo _('Subdomain (en.yoursite.com)');
echo _('Parameter name');
echo _('Defines a query string parameter to be used to specify the language of pages indexed by search engines.<br />It\'s recommended to not change this parameter after the <div class="prisna_wp_translate_code_container"><code>SEO</code></div> setting has been enabled, as search engines might have indexed pages already.');
echo _('Maximum log size');
echo _('Defines the maximum number of entries the log can hold. Changes will take effect next time a log entry is created.');
echo _('Enable glowing');
echo _('Sets whether a glowing effect should be applied to the languages, or not.');
echo _('Yes, enable the glowing effect');
echo _('No, disable the glowing effect');
echo _('Background color');
echo _('Sets the background color.');
echo _('Font color');
echo _('Sets the font color.');
echo _('Background color (expanded view)');
echo _('Sets the background color of the expanded list view.');
echo _('Font color (expanded view)');
echo _('Sets the font color of the expanded list view.');
echo _('Background color (hover)');
echo _('Sets the background color of the language on mouse hover.');
echo _('Font color (hover)');
echo _('Sets the font color of the language on mouse hover.');
echo _('Scroll bar color');
echo _('Sets the color of the scroll bar.');
echo _('Arrow color');
echo _('Sets the color of the arrow.');
echo _('Loading image color');
echo _('Sets the color of the animated image indicating the loading process. Make sure to clear the browser\'s cache (or to force to releoad all the page resources by pressing F5), otherwise the image might not be retrieved from the server and it\'ll look as it hasn\'t been changed.');
echo _('Completed and Restore images color');
echo _('Sets the color of both the completed and restore images. Make sure to clear the browser\'s cache (or to force to releoad all the page resources by pressing F5), otherwise the image might not be retrieved from the server and it\'ll look as it hasn\'t been changed.');
echo _('Hide language name or language flag');
echo _('Sets whether to hide the language name or the language flag for lower resolutions, or not.');
echo _('Yes, hide the language name');
echo _('Yes, hide the language flag');
echo _('No, don\'t hide anything');
echo _('Low resolution');
echo _('Defines a media query to be used by the above setting.');
echo _('Low resolution hide language class');
echo _('Sets the style class to be added to the translator\'s container when the <div class="prisna_wp_translate_code_container"><code>Responsive &gt; Hide language name or language flag</code></div> setting is disabled.');
echo _('Languages names class');
echo _('Sets the style class used to identify languages names.');
echo _('Responsive rules');
echo _('
		Responsive web design is a web design approach aimed at crafting sites to provide an optimal viewing experience — easy reading and navigation across a wide range of devices (from desktop computer monitors to mobile phones).<br /><br />
		Media query: Consists of a one or more expressions that check for the conditions of particular media features.');
echo _('Add new');
echo _('Remove');
echo _('Show');
echo _('Hide');
echo _('Logs');
echo _('Displays the latest activity.');
echo _('There are no entries in the log.');
echo _('Empty response, there is no further information.');
echo _('The HTML code of <a href="[0]" target="_blank">[0]</a> has serious problems. Refer to the <a href="http://validator.w3.org/check?uri=[1]&charset=%28detect+automatically%29&doctype=Inline&group=0" target="_blank">Markup Validation Service</a> for more information.');
echo _('<a href="[0]" target="_blank">[0]</a> ([1]) parsed correctly.');
echo _('<a href="[0]" target="_blank">[0]</a> Sitemap accessed.');
echo _('Enable permalink translations');
echo _('Sets whether to enable permalink translations, or not. It requires Permalinks enabled:<br /><br /><div class="prisna_wp_translate_code_container"><code>Settings > Permalinks</code></div>');
echo _('Yes, enable permalink translations');
echo _('No, disable permalink translations');
echo _('Auto translate permalinks');
echo _('Sets whether to automatically attempt to translate permalinks, or not. Since URLs aren\'t regular plain text, translations might need to be modified. Permalinks translations can be modified below.');
echo _('Yes, auto translate permalinks');
echo _('No, don\'t auto translate permalinks');
echo _('Exclude permalinks (regular expression)');
echo _('Defines a set of rules to exclude permalinks from translations.<br /><br />
		
		A rule is defined as <a href="http://www.php.net/manual/en/reference.pcre.pattern.syntax.php" target="_blank">a regular expression</a> to match the full URL. <a href="http://www.vijayforvictory.com/wp-content/gallery/ngen_gallery/regular-expressions-cheat-sheet.png" target="_blank">Cheat sheet</a>.<br />
		
		One rule per line. For instance:<br /><br />

		/slider\-revolution/i<br /><br />
		
		Invalid rules will be silently ignored.');
echo _('Permalink');
echo _('Modifies permalinks. 
			<ol>
				<li>Select the <div class="prisna_wp_translate_code_container"><code>Permalink</code></div> to modify (only <div class="prisna_wp_translate_code_container"><code>Permalinks</code></div> from cached translations will be listed).</li>
				<li>Modify the <div class="prisna_wp_translate_code_container"><code>Permalinks</code></div> at will.</li>
			</ol>');
echo _('
		<div class="prisna_wp_translate_permalink_structure_empty prisna_wp_translate_validate_warning">
			<h3 class="prisna_wp_translate_validate_warning">Important notice:</h3>
			Permalinks aren\'t enabled (Settings > Permalinks).<br />
			Consider enable Permalinks or modify the main .htaccess to redirect all requests to be handled by WordPress, for instance:
			<pre>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</pre></div>');
echo _('Sitemaps are an easy way for webmasters to inform search engines about pages on their sites that are available for crawling. In its simplest form, a Sitemap is an XML file that lists URLs for a site along with additional metadata about each URL (when it was last updated, how often it usually changes, and how important it is, relative to other URLs in the site) so that search engines can more intelligently crawl the site.<br /><br />
Web crawlers usually discover pages from links within the site and from other sites. Sitemaps supplement this data to allow crawlers that support Sitemaps to pick up all URLs in the Sitemap and learn about those URLs using the associated metadata. Using the Sitemap protocol does not guarantee that web pages are included in search engines, but provides hints for web crawlers to do a better job of crawling your site. <br/><br/>Remember to submit the XML Sitemap to the search engines.<br />
<a href="http://www.google.com/webmasters/tools/" target="_blank">Google Webmaster Tools</a><br />
<a href="http://www.bing.com/toolbox/webmaster/" target="_blank">Bing Webmaster Tools</a><br /><br />

The Sitemap could be added to the robots.txt file to allow search engines to auto descovery it.');
echo _('Default entry settings');
echo _('Sets the default Frequency and Priority.<br />
		Frequency: How frequently the page is likely to change.<br />
		Priority: The priority of this URL relative to other URLs on the site.<br />
		More information at <a href="http://www.sitemaps.org/protocol.html" target="_blank">http://www.sitemaps.org/protocol.html</a>
		');
echo _('Frecuency');
echo _('Priority');
echo _('Exceptions');
echo _('Define a set of exceptions rules to override default entry settings. A rule must have the following form:<br /><br />
		
		[expression],[frecuency],[priority],[date]<br /><br />
		
		[expression]: <a href="http://www.php.net/manual/en/reference.pcre.pattern.syntax.php" target="_blank">A regular expression</a> to match the URL. <a href="http://www.vijayforvictory.com/wp-content/gallery/ngen_gallery/regular-expressions-cheat-sheet.png" target="_blank">Cheat sheet</a>.<br />
		[frecuency]: always, hourly, daily, weekly, monthly, yearly or never.<br />
		[priority]: A numeric value from 0 to 1.<br />
		[date]: The date of last modification of the file. This date should be in <a href="http://www.w3.org/TR/NOTE-datetime" target="_blank">W3C Datetime</a> format. Optional.<br /><br />
		
		One rule per line. For instance:<br /><br />

		/posts\/.*/,daily,0.6,2014-08-10T12:51:10+00:00<br />
		/tags\/.*/,monthly,0.3<br /><br />
		
		Invalid rules will be silently ignored.');
echo _('Pages');
echo _('Selects the pages where the translator should not be displayed.');
echo _('Posts');
echo _('Selects the posts where the translator should not be displayed.');
echo _('Categories');
echo _('Selects the categories where the translator should not be displayed.');
echo _('Grant access to a non admin user (User ID)');
echo _('Selects a non admin user to grant access to these settings.');
echo _('Language');
echo _('Selects a language to translate the specified resources below.');
echo _('Sitemap URL');
echo _('Specifies the location of the sitemap. If the website doesn\'t currently have a sitemap, there are a number of plugins to create one:<br/><br /><a href="https://wordpress.org/plugins/search.php?q=sitemap" target="_blank">https://wordpress.org/plugins/search.php?q=sitemap</a>');
echo _('URL list');
echo _('Defines a list of the URLs to be automatically translated. One URL per line. URLs can be either absolute or relative path.');
echo _('Category');
echo _('Specifies a category to select the resources to translate.');
echo _('Already translated URL behavior');
echo _('Sets what kind of operation will be performed if a URL has been translated before. If <em>re-translate</em> is selected, then only non translated strings will translated.');
echo _('Re-translate');
echo _('Skip');
echo _('Resources');
echo _('Sets what kind of source will be used identify the list of URLs to translate.');
echo _('Sitemap');
echo _('URL list');
echo _('Category');
echo _('Import all');
echo _('Import a previously exported <em>xml</em> file containing all the settings and all the cached translations. Existent <em>xml</em> files containing cached translations won\'t be removed, they will be renamed instead.');
echo _('File');
echo _('Select');
echo _('Import all settings and translations');
echo _('Empty file.');
echo _('The file is not a valid <em>xml</em> file or it\'s corrupted.');
echo _('Export all');
echo _('Exports a xml file containing all the settings and all the cached translations.');
echo _('Export all settings and translations');
echo _('Import settings');
echo _('Imports previously exported settings. Paste the previously exported settings in the field. If the data\'s structure is correct, it will overwrite the current settings.');
echo _('Export settings');
echo _('Exports the current settings to make a backup or to transfer the settings from the development server to the production server. Triple click on the field to select all the content.');
echo _('Resource');
echo _('Modifies cached translations. 
			<ol>
				<li>Select the <div class="prisna_wp_translate_code_container"><code>Resource</code></div> to modify (only cached <div class="prisna_wp_translate_code_container"><code>Resources</code></div> will be listed).</li>
				<li>Select an <div class="prisna_wp_translate_code_container"><code>Available language</code></div> (only cached <div class="prisna_wp_translate_code_container"><code>Languages</code></div> will be listed).</li>
				<li>Modify <div class="prisna_wp_translate_code_container"><code>Cached translations</code></div> at will. In order to delete an entry, remove the content for that particular entry.</li>
			</ol>');
echo _('Import translations');
echo _('Import translations from a csv formatted file. The csv file must be UTF-8 encoded.');
echo _('Import');
echo _('CSV file');
echo _('Select');
echo _('From');
echo _('To');
echo _('Resource');
echo _('
			Selects what resources will be affected by the current import operation.<br /><br />
			There are 2 levels of cached translations. The translator first checks for the resource specific cache file, if the file exists, then it\'ll check if the requested translation has been made. If not, it\'ll check the Upcoming translations file. If the translation isn\'t there, then it\'ll contact the translation server.<br /><br />
			The Upcoming translation files contains all the translations for all the pages for a specific pair of source and destination languages.
		');
echo _('All');
echo _('Upcoming');
echo _('Action');
echo _('Sets what kind of operation will be performed during the import process.');
echo _('Add and replace');
echo _('Add only');
echo _('Replace only');
echo _('Simulate');
echo _('Sets whether a simulation will be performed, or not.');
echo _('Yes, perform a simulation, don\'t import anything');
echo _('No, don\'t perform a simulation, import everything');
echo _('Imported translations log');
echo _('Empty file');
echo _('The file is not a valid comma-separated values (csv) file');
echo _('Empty language');
echo _('Invalid resource');
echo _('Invalid value');
echo _('Invalid value');
echo _('No translations have been imported');
echo _('Added');
echo _('Replaced');
echo _('Removed');
echo _('Omitted');
echo _('File created');
echo _('Yes');
echo _('No');
echo _('This is a simulation, no changes have been made');
echo _('The uploaded file exceeds the upload_max_filesize directive in php.ini');
echo _('The uploaded file exceeds the MAX_FILE_SIZE directive');
echo _('The uploaded file was only partially uploaded');
echo _('No file was uploaded');
echo _('Missing a temporary folder');
echo _('Failed to write file to disk');
echo _('A PHP extension stopped the file upload');
echo _('An unknown error occurred during the file upload');
echo _('Export translations');
echo _('Selects what resources, and their languages, to export. All the selected translations will be exported into one single csv file.');
echo _('Export');
echo _('Upcoming');
echo _('There are no cache files yet. Cached files will appear here either after translations are either made or imported.');
echo _('Enable SEO');
echo _('Sets whether the search engines can index the cached translations, or not.<br />Fairly valid HTML code is required. Fault pages won\'t be indexded.<br />Refer to the <a href="http://validator.w3.org/" target="_blank">Markup Validation Service</a> for a quick online check.<br /><br /><div class="prisna_wp_translate_code_container"><code>Only cached translations can be indexed.</code></div><br /><br />To translate pages\' titles, make sure to change the default value of the<br /><div class="prisna_wp_translate_code_container"><code>Target selector (jQuery)</code></div> setting to <div class="prisna_wp_translate_code_container"><code>html</code></div> or to <div class="prisna_wp_translate_code_container"><code>body, title</code></div>.<br /><br />See <div class="prisna_wp_translate_code_container"><code>General &gt; Select and exclude sections &gt; Target selector (jQuery)</code></div>.');
echo _('Yes, enable SEO');
echo _('No, disable SEO');
echo _('No settings to export. The current settings are the default ones.');
echo _('entries');
echo _('requests');
echo _('languages');
echo _('pixels');
echo _('%');
echo _('units');
echo _('days');
echo _('Always');
echo _('Hourly');
echo _('Daily');
echo _('Weekly');
echo _('Monthly');
echo _('Yearly');
echo _('Never');
echo _('Select and exclude sections');
echo _('Hide on pages, posts and categories');
echo _('Interface');
echo _('Translate attributes');
echo _('Custom flags');
echo _('Local storage');
echo _('Style classes');
echo _('Templates');
echo _('Javascript callbacks');
echo _('Other customizations');
echo _('Access');
echo _('
		<div class="prisna_wp_translate_permalink_structure_empty prisna_wp_translate_validate_warning">
			<h3 class="prisna_wp_translate_validate_warning">Important notice:</h3>
			Permalinks aren\'t enabled (Settings > Permalinks), make sure the above Sitemap URLs work.<br />
			If they don\'t work, consider enable Permalinks or modify the main .htaccess to redirect all requests to be handled by WordPress, for instance:
			<pre>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</pre></div>');
echo _('General');
echo _('Menus (alias)');
echo _('Styles');
echo _('Sliders');
echo _('Import / Export');
echo _('<span style="color: red;">Message for "[0]" not found!</span>');

?>