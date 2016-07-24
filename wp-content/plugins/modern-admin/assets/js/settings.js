
jQuery(document).ready(function($){

    $("input[name=admin_upload]").live('click', function(event) {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        wp.media.editor.send.attachment = function(props, attachment) {
            var image_size =  props.size;
            var image_url = attachment.sizes[image_size].url;
            $("input[name='settings[admin_logo_image]']").val(image_url);
            wp.media.editor.send.attachment = send_attachment_bkp;

        }
        wp.media.editor.open();
        event.preventDefault();
        return false;
    });

    //Login screen
    $("input[name=bg_upload]").live('click', function(event) {
        
        $(this).siblings()
        var send_attachment_bkp = wp.media.editor.send.attachment;
        wp.media.editor.send.attachment = function(props, attachment) {
            var image_size =  props.size;
            var image_url = attachment.sizes[image_size].url;
            $("input[name='login_screen[background]']").val(image_url);
            wp.media.editor.send.attachment = send_attachment_bkp;
           
        }
        wp.media.editor.open();
        event.preventDefault();
        return false;
    });
    $("input[name=ls_upload]").live('click', function(event) {
        var _self = $(this); 
        $(this).siblings()
        var send_attachment_bkp = wp.media.editor.send.attachment;
        wp.media.editor.send.attachment = function(props, attachment) {
            var image_size =  props.size;
            var image_url = attachment.sizes[image_size].url;
            $("input[name='login_screen[image]']").val(image_url);

            wp.media.editor.send.attachment = send_attachment_bkp;
            //console.log(attachment);
             _self.next().val(attachment.height);
        }
        wp.media.editor.open();
        event.preventDefault();
        return false;
    });
    $("input[name='settings[color]']").each(function(){
        if($(this).is(':checked') && $(this).val()=='custom') $(".custom-color").fadeIn();
    });
    $("input[name='settings[color]']").click(function(){
        if($(this).is(':checked')) var m_color=$(this).val();
        if(m_color=='custom') $(".custom-color").fadeIn();
        else $(".custom-color").fadeOut();
    });
    var options = {
        mode: 'hsv',
        controls: { strip: 'h', horiz: 's', vert: 'v' },
        change: function(event, ui){
            var convertCl = convert_color(ui.color.toHsv());
            $(this).parent().parent().next().val(convertCl);
            var field = $(this).attr("id");
            applyChangeColor(field, ui.color.toString(), convertCl);
        }
    };
    if ($(".choosecolor").length) { $(".choosecolor").wpColorPicker(options); }
    function applyChangeColor(field, color, convertCl) {
        switch (field) {
            case "main_color":
                if ($('head').find('style#main_color').length < 1){
                    $('head').append('<style id="main_color" type="text/css"></style>');
                }
                $('style#main_color').html("#wpadminbar{background-color:" + color + " !important;}#adminmenu li.menu-top:hover > a, #adminmenu li.menu-top.focused > a, #adminmenu li.menu-top > a:focus, #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, #adminmenu li.current a.menu-top, #adminmenu li.opensub > a.menu-top, #adminmenu li > a.menu-top:focus, #adminmenu li.wp-active-submenu > a{background-color:" + color + " !important;} .submitbox .submitdelete:hover, .submitbox .submitdelete:focus, .submitbox .submitdelete:active, .submitbox .submitdelete.active, .submitbox .submitdelete.disabled, .submitbox .submitdelete[disabled], .wrap .add-new-h2:hover, .wrap .add-new-h2:focus, .wrap .add-new-h2:active, .wrap .add-new-h2.active, .wrap .add-new-h2.disabled, .wrap .add-new-h2[disabled], #wpadminbar .ab-top-menu > li:hover > .ab-item, #wpadminbar .ab-top-menu > li.hover > .ab-item, #wpadminbar .ab-top-menu > li > .ab-item:focus, #wpadminbar.nojq .quicklinks .ab-top-menu > li > .ab-item:focus, #wpadminbar.nojs .ab-top-menu > li.menupop:hover > .ab-item, #wpadminbar .ab-top-menu > li.menupop.hover > .ab-item, #wpadminbar .quicklinks .menupop .ab-item:focus, #wpadminbar .quicklinks .ab-top-menu .menupop .ab-item:focus, div#add_fields div#floatMenu ul#sidebarmenu1.menu li.add_field_button_container ul li.add-buttons ol.field_type li input.button:hover {background-color: "+convertCl+" !important} #adminmenu li.menu-top:hover > a, #adminmenu li.menu-top.focused > a, #adminmenu li.menu-top > a:focus, #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, #adminmenu li.current a.menu-top, #adminmenu li.opensub > a.menu-top, #adminmenu li > a.menu-top:focus, #adminmenu li.wp-active-submenu > a, .postbox .hndle, div.sidebar-name {border-color:"+convertCl+" !important}");
                break;
            /*case "text_color":
                if ($('head').find('style#text_color').length < 1){
                    $('head').append('<style id="text_color" type="text/css"></style>');
                }
                $('style#text_color').html("body {color:"+color+" !important}");
                break;*/
            case "link_color":
                if ($('head').find('style#link_color').length < 1){
                    $('head').append('<style id="link_color" type="text/css"></style>');
                }
                $('style#link_color').html(".wp-submenu a {color:"+color+" !important}");
                break;
            case "link_active_color":
                if ($('head').find('style#link_active_color').length < 1){
                    $('head').append('<style id="link_active_color" type="text/css"></style>');
                }
                $('style#link_active_color').html(".wp-submenu a:hover{color:"+color+" !important}");
                break;
            case "admin_bar_bg_color":
                if ($('head').find('style#admin_bar_bg_color').length < 1){
                    $('head').append('<style id="admin_bar_bg_color" type="text/css"></style>');
                }
                $('style#admin_bar_bg_color').html("#adminmenuback, #adminmenuwrap{background-color:"+color+" !important}#adminmenu li.wp-menu-separator{background-color:"+convertCl+" !important} #adminmenu > li > a.menu-top, #adminmenu {border-color: "+convertCl+" !important}");
                break;
            case "admin_bar_text_color":
                if ($('head').find('style#admin_bar_text_color').length < 1){
                    $('head').append('<style id="admin_bar_text_color" type="text/css"></style>');
                }
                $('style#admin_bar_text_color').html("#adminmenu li.menu-top > a, .wp-menu-image:before, #adminmenu li.menu-top > a{color:"+color+" !important}");
                break;
            case "button_bg_color":
                if ($('head').find('style#button_bg_color').length < 1){
                    $('head').append('<style id="button_bg_color" type="text/css"></style>');
                }
                $('style#button_bg_color').html('.button.media-button, .wp-core-ui .button, .wp-core-ui .button-primary, #side-sortables #mp-single-statuses span.current, #side-sortables #mp-single-statuses span a, #wpadminbar #wp-admin-bar-top-secondary li#wp-admin-bar-pro-site a span, .plugins a.delete, #all-plugins-table .plugins a.delete, #search-plugins-table .plugins a.delete, .submitbox .submitdelete, input.button-primary, button.button-primary, a.button-primary, .button, a.button, input[type="file"], input[type="image"], input[type="submit"], input[type="reset"], input[type="button"], .wrap .add-new-h2, input.button, input.button[type="file"], input.button[type="image"], input.button[type="submit"], input.button[type="reset"], input.button[type="button"] {background-color:'+color+" !important}");
                break;
            case "button_text_color":
                if ($('head').find('style#button_text_color').length < 1){
                    $('head').append('<style id="button_text_color" type="text/css"></style>');
                }
                $('style#button_text_color').html('.button.media-button, .wp-core-ui .button, .wp-core-ui .button-primary, #side-sortables #mp-single-statuses span.current, #side-sortables #mp-single-statuses span a, #wpadminbar #wp-admin-bar-top-secondary li#wp-admin-bar-pro-site a span, .plugins a.delete, #all-plugins-table .plugins a.delete, #search-plugins-table .plugins a.delete, .submitbox .submitdelete, input.button-primary, button.button-primary, a.button-primary, .button, a.button, input[type="file"], input[type="image"], input[type="submit"], input[type="reset"], input[type="button"], .wrap .add-new-h2, input.button, input.button[type="file"], input.button[type="image"], input.button[type="submit"], input.button[type="reset"], input.button[type="button"] {color:'+color+" !important}");
                break;
        }
    }

    function convert_color(hsv) {
        var h = hsv.h;
        var s = hsv.s;
        var v = hsv.v - 15;
		if(v < 0) v = 0;
		h = h / 360 * 6;
        s = s / 100;
        v = v / 100;

		var i = Math.floor(h),
			f = h - i,
			p = v * (1 - s),
			q = v * (1 - f * s),
			t = v * (1 - (1 - f) * s),
			mod = i % 6,
			r = [v, q, p, p, t, v][mod],
			g = [t, v, v, q, p, p][mod],
			b = [p, p, t, v, v, q][mod];
        return "#" + ((1 << 24) + (Math.round(r * 255) << 16) + (Math.round(g * 255) << 8) + Math.round(b * 255)).toString(16).slice(1);
    }

});
