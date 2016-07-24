<?php


$field = "main_color";
$main_color = (isset($Options['settings']['custom_color_'.$field]))?$Options['settings']['custom_color_'.$field]:'';
$main_color2 = (isset($Options['settings']['custom_color_'.$field.'_d']))?$Options['settings']['custom_color_'.$field.'_d']:'';
$main_rgb = $this->hex2rgb($main_color);
$field = "link_color";
$link_color = (isset($Options['settings']['custom_color_'.$field]))?$Options['settings']['custom_color_'.$field]:'';
$link_color2 = (isset($Options['settings']['custom_color_'.$field.'_d']))?$Options['settings']['custom_color_'.$field.'_d']:'';
$field = "link_active_color";
$link_active_color = (isset($Options['settings']['custom_color_'.$field]))?$Options['settings']['custom_color_'.$field]:'';
$link_active_color2 = (isset($Options['settings']['custom_color_'.$field.'_d']))?$Options['settings']['custom_color_'.$field.'_d']:'';
$field = "admin_bar_bg_color";
$admin_bar_bg_color = (isset($Options['settings']['custom_color_'.$field]))?$Options['settings']['custom_color_'.$field]:'';
$admin_bar_bg_color2 = (isset($Options['settings']['custom_color_'.$field.'_d']))?$Options['settings']['custom_color_'.$field.'_d']:'';
$field = "admin_bar_text_color";
$admin_bar_text_color = (isset($Options['settings']['custom_color_'.$field]))?$Options['settings']['custom_color_'.$field]:'';
$admin_bar_text_color2 = (isset($Options['settings']['custom_color_'.$field.'_d']))?$Options['settings']['custom_color_'.$field.'_d']:'';
$field = "button_bg_color";
$button_bg_color = (isset($Options['settings']['custom_color_'.$field]))?$Options['settings']['custom_color_'.$field]:'';
$button_bg_color2 = (isset($Options['settings']['custom_color_'.$field.'_d']))?$Options['settings']['custom_color_'.$field.'_d']:'';
$field = "button_text_color";
$button_text_color = (isset($Options['settings']['custom_color_'.$field]))?$Options['settings']['custom_color_'.$field]:'';
$button_text_color2 = (isset($Options['settings']['custom_color_'.$field.'_d']))?$Options['settings']['custom_color_'.$field.'_d']:'';

$css="<style>";
$css.="
#wpadminbar,
#adminmenu li.menu-top:hover > a,
#adminmenu li.menu-top.focused > a,
#adminmenu li.menu-top > a:focus,
#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu,
#adminmenu li.current a.menu-top,
#adminmenu li.opensub > a.menu-top,
#adminmenu li > a.menu-top:focus,
#adminmenu li.wp-active-submenu > a,
.postbox .hndle,
div.sidebar-name,
strong .post-com-count span,
.submitbox .submitdelete,
.wrap .add-new-h2,
.modern-table-left a.active,
.modern-table-left a:hover,
.button-title-link div.add-buttons-title,
div#add_fields div#floatMenu ul#sidebarmenu1.menu li.add_field_button_container ul li.add-buttons ol.field_type li input.button,
.catalyst-core-options-wrap h3, .catalyst-dynamik-options-wrap h3, .catalyst-advanced-options-wrap h3, .catalyst-uploader-inner-1col h3, #catalyst-custom-css-builder h3,
.catalyst-font-option-desc,
.catalyst-bg-option-desc,
.catalyst-border-option-desc,
.catalyst-dynamik-option-desc,
.catalyst-custom-fonts-button,
.catalyst-optionbox-inner-2col h4,
.metabox-holder h3.accordion-section-title {
	background: $main_color !important
}
.submitbox .submitdelete:hover,
.submitbox .submitdelete:focus,
.submitbox .submitdelete:active,
.submitbox .submitdelete.active,
.submitbox .submitdelete.disabled,
.submitbox .submitdelete[disabled],
.wrap .add-new-h2:hover,
.wrap .add-new-h2:focus,
.wrap .add-new-h2:active,
.wrap .add-new-h2.active,
.wrap .add-new-h2.disabled,
.wrap .add-new-h2[disabled],
#wpadminbar .ab-top-menu > li:hover > .ab-item,
#wpadminbar .ab-top-menu > li.hover > .ab-item,
#wpadminbar .ab-top-menu > li > .ab-item:focus,
#wpadminbar.nojq .quicklinks .ab-top-menu > li > .ab-item:focus,
#wpadminbar.nojs .ab-top-menu > li.menupop:hover > .ab-item,
#wpadminbar .ab-top-menu > li.menupop.hover > .ab-item,
#wpadminbar .quicklinks .menupop .ab-item:focus,
#wpadminbar .quicklinks .ab-top-menu .menupop .ab-item:focus,
div#add_fields div#floatMenu ul#sidebarmenu1.menu li.add_field_button_container ul li.add-buttons ol.field_type li input.button:hover {
	background: $main_color2 !important
}
#adminmenu li.menu-top:hover > a,
#adminmenu li.menu-top.focused > a,
#adminmenu li.menu-top > a:focus,
#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu,
#adminmenu li.current a.menu-top,
#adminmenu li.opensub > a.menu-top,
#adminmenu li > a.menu-top:focus,
#adminmenu li.wp-active-submenu > a,
.postbox .hndle,
div.sidebar-name {
	border-color: $main_color2
}
a,
#adminmenu a,
#the-comment-list p.comment-author strong a,
#media-upload a.del-link,
#media-items a.delete,
#media-items a.delete-permanently,
.plugins a.delete,
.ui-tabs-nav a,
#wpadminbar .quicklinks .menupop ul li a,
#wpadminbar .quicklinks .menupop ul li a strong,
#wpadminbar .quicklinks .menupop.hover ul li a,
#wpadminbar.nojs .quicklinks .menupop:hover ul li a {
	color: $link_color
}
a:hover,
a:focus,
#adminmenu a:hover,
#the-comment-list p.comment-author strong a:hover,
#media-upload a.del-link:hover,
#media-items a.delete:hover,
#media-items a.delete-permanently:hover,
.plugins a.delete:hover,
.ui-tabs-nav a:hover,
#adminmenu .wp-submenu a:hover,
#adminmenu .wp-submenu a:focus,
#adminmenu li.menu-top.wp-not-current-submenu li a:hover {
	color: $link_active_color
}
/* Login */
.wp-core-ui .button-primary {
	background: $button_bg_color;
	border: 1px solid $button_bg_color2;
}
.wp-core-ui .button-primary:hover,
.wp-core-ui .button-primary.active,
.wp-core-ui .button-primary.active:hover,
.wp-core-ui .button-primary.active:focus,
.wp-core-ui .button-primary:active,
.wp-core-ui .button-primary.focus,
.wp-core-ui .button-primary:focus {
	background: $button_bg_color2 !important;
	border-color: $button_bg_color2 !important
}
/* button */
button.media-button.button-primary,
.wp-core-ui .button-primary,
a.button-primary.welcome-button,
input[type=\"submit\"],
input[type=\"submit\"].button-primary,
#side-sortables #mp-single-statuses span a,
input.button-primary,
button.button-primary,
input.button.button-primary,
a.button-primary,
.show-hide-custom-css-builder-styles {
	border-color: $button_bg_color2 !important;
	background-color: $button_bg_color !important;
}
button.media-button.button-primary:hover,
button.media-button.button-primary:focus,
button.media-button.button-primary:active,
button.media-button.button-primary.active,
button.media-button.button-primary.disabled,
button.media-button.button-primary[disabled],
.wp-core-ui .button-primary:hover,
.wp-core-ui .button-primary:focus,
.wp-core-ui .button-primary:active,
.wp-core-ui .button-primary.active,
.wp-core-ui .button-primary.disabled,
.wp-core-ui .button-primary[disabled],
a.button-primary.welcome-button:hover,
a.button-primary.welcome-button:focus,
a.button-primary.welcome-button:active,
a.button-primary.welcome-button.active,
a.button-primary.welcome-button.disabled,
a.button-primary.welcome-button[disabled],
input[type=\"submit\"]:hover,
input[type=\"submit\"]:focus,
input[type=\"submit\"]:active,
input[type=\"submit\"].active,
input[type=\"submit\"].disabled,
input[type=\"submit\"][disabled],
input[type=\"submit\"].button-primary:hover,
input[type=\"submit\"].button-primary:focus,
input[type=\"submit\"].button-primary:active,
input[type=\"submit\"].button-primary.active,
input[type=\"submit\"].button-primary.disabled,
input[type=\"submit\"].button-primary[disabled],
#side-sortables #mp-single-statuses span a:hover,
#side-sortables #mp-single-statuses span a:focus,
#side-sortables #mp-single-statuses span a:active,
#side-sortables #mp-single-statuses span a.active,
#side-sortables #mp-single-statuses span a.disabled,
#side-sortables #mp-single-statuses span a[disabled],
input.button-primary:hover,
input.button-primary:focus,
input.button-primary:active,
input.button-primary.active,
input.button-primary.disabled,
input.button-primary[disabled],
button.button-primary:hover,
button.button-primary:focus,
button.button-primary:active,
button.button-primary.active,
button.button-primary.disabled,
button.button-primary[disabled],
input.button.button-primary:hover,
input.button.button-primary:focus,
input.button.button-primary:active,
input.button.button-primary.active,
input.button.button-primary.disabled,
input.button.button-primary[disabled],
a.button-primary:hover,
a.button-primary:focus,
a.button-primary:active,
a.button-primary.active,
a.button-primary.disabled,
a.button-primary[disabled],
.show-hide-custom-css-builder-styles:hover {
	border-color: $button_bg_color2 !important;
	background-color: $button_bg_color2 !important;
}
/* form */
textarea:focus,
input[type=\"text\"]:focus,
input[type=\"password\"]:focus,
input[type=\"datetime\"]:focus,
input[type=\"datetime-local\"]:focus,
input[type=\"date\"]:focus,
input[type=\"month\"]:focus,
input[type=\"time\"]:focus,
input[type=\"week\"]:focus,
input[type=\"number\"]:focus,
input[type=\"email\"]:focus,
input[type=\"url\"]:focus,
input[type=\"search\"]:focus,
input[type=\"tel\"]:focus,
input[type=\"color\"]:focus,
.uneditable-input:focus {
	border-color: rgba(".$main_rgb[0].",".$main_rgb[1].",".$main_rgb[2].",0.8);
}

#adminmenuback, #adminmenuwrap {
	background: $admin_bar_bg_color
}

#adminmenu li.wp-menu-separator {
	background: $admin_bar_bg_color2
}

.wp-menu-image:before,
#adminmenu li.menu-top > a {
	color: $admin_bar_text_color
}";
$css.="</style>";
echo $css;
?>