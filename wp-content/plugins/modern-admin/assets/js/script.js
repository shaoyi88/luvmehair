(function($) {
    $(document).ready( function() {

        if ($(window).height() > $('body').height())
            $('body').css({'min-height':$(window).height()})

        if($("body").hasClass("modern-admin-hover")) {
            $("#adminmenu li.wp-has-submenu:not(.wp-has-current-submenu)").mouseenter(function(){
                $(this).addClass('modern-admin-hover')
                $(this).find('.wp-submenu').show()
            }).mouseleave(function(){
                $(this).removeClass('modern-admin-hover')
                $(this).find('.wp-submenu').hide()
            });
        } else {
            $("#adminmenu a.wp-has-submenu").click(function(e) {
                if ($('body').hasClass("folded")) {

                } else {
                    e.preventDefault();
                    var $li = $(this).parent();
                    if($li.data("slide") !== true) {
                        $li.data("slide", true);
                        if($li.hasClass('wp-active-submenu')) {
                            $("ul.wp-submenu", $li).slideUp(function() {
                                $li.removeClass('wp-active-submenu');
                                $li.data("slide", false);
                            });
                        } else {
							$('li.wp-active-submenu ul.wp-submenu').slideUp().parent().removeClass('wp-active-submenu wp-has-current-submenu');
                            $("ul.wp-submenu", $li).slideDown(function() {
                                $li.addClass('wp-active-submenu');
                                $li.data("slide", false);
                            });
                        }
                        return false;
                    }
                }
            });
        }
		$('.wp-submenu .current').parent().show().parent().addClass('wp-active-submenu');

        $("#collapse-menu").click(function(e) {
            if ($('body').hasClass("folded")) {
            } else {
                var $ul = $(this).parent();
                $("li.wp-active-submenu > ul", $ul).hide();
                $ul.find('li.wp-active-submenu').removeClass('wp-active-submenu');
            }
        });

        // Enable custom login
        $("input[name='login_screen[active]']").change(function() {
            if (!$(this).is(':checked')) {
                $('#enable_custom_login').hide();
            } else {
                $('#enable_custom_login').show();
            }
        }).trigger("change");

        // Equal height icon list
        _tableHeight = $('#mordern-admin-icons-table').height();
        _iconHeight = $('#mordern-admin-icons-list').height();
        if (_tableHeight > _iconHeight)
            $('#mordern-admin-icons-list').height(_tableHeight);

        $("#mordern-admin-icons-table a").click(function() {
            if(!$(this).parent().hasClass('active')) {
                $("#mordern-admin-icons-table a.active").removeClass('active');
                $(this).addClass('active');
                $("#mordern-admin-icons-list").data("target", this);

            }


            return false;
        });
        $("#mordern-admin-icons-list a i").click(function() {
            //icon = $(this).find("i");
            var target = $("#mordern-admin-icons-list").data("target");
            console.log(target);
            if($(target).is("a")) {
                var val = window.getComputedStyle(this,':before').content;
                val = escape(val).replace(/%22/g,"").replace("%u","").toLowerCase();
                // if ($("input", target).hasClass("customicon"))
                // {
                //     $("input", target).val($(this).attr("class"));
                // }else{    
                // if ( ! $("input", target).hasClass("customname") )
                // {
                    $("input", target).val(val);
                // }

                $("i", target).attr("class", $(this).attr("class"));
            }
            return false;
        });
        $("#mordern-admin-icons-list a").click(function() {
            $(this).find("i").trigger("click");
            return false;
        });

        // Dashboard setting - tab
        $(".dashboard-tab a").click(function(event){
           event.preventDefault();
          if(!$(this).hasClass("active")) {
              $(".dashboard-tab a.active").removeClass("active");
              if($(this).attr("href")=='#dashboard_widget'){
                  $("#dashboard_widget").fadeIn();
                  $("#dashboard_icons").hide();
                  $("#dashboard_rss_widget").hide();
              }else if($(this).attr("href")=='#dashboard_rss_widget'){
                  $("#dashboard_widget").hide();
                  $("#dashboard_icons").hide();
                  $("#dashboard_rss_widget").fadeIn();
              }else{
                  $("#dashboard_widget").hide();
                  $("#dashboard_icons").fadeIn();
                  $("#dashboard_rss_widget").hide();
              };
              $(this).addClass("active");
          }
        });



    });

})(jQuery);
