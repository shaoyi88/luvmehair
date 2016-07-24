var winWidth = 0;
var winHeight = 0;

	if (window.innerWidth)
		winWidth = window.innerWidth;
	else if ((document.body) && (document.body.clientWidth))
		winWidth = document.body.clientWidth;
	if (window.innerHeight)
		winHeight = window.innerHeight;
	else if ((document.body) && (document.body.clientHeight))
		winHeight = document.body.clientHeight;
	if (document.documentElement  && document.documentElement.clientHeight && document.documentElement.clientWidth)
	{
        winHeight = document.documentElement.clientHeight;
        winWidth = document.documentElement.clientWidth;
	}
	if(winWidth<640){
		$(document).ready(function(){
				$('.nav-bar').appendTo('.mobile-nav-bar .mobile-head-hide')
				$('.change-currency').appendTo('.mobile-change-currency .mobile-head-hide')
				$('.head-search').appendTo('.mobile-head-search .mobile-head-hide')
				$('.head-shopcart').appendTo('.mobile-head-shopcart .mobile-head-hide')
				$('.top-menu').appendTo('.header')
			})
		$(document).click(function(){
				   $('.mobile-nav-bar .mobile-head-hide').hide()
				   $('.mobile-change-currency .mobile-head-hide').hide()
				   $('.mobile-head-shopcart .mobile-head-hide').hide()
				})	
		$(document).ready(function(){
				$('.mobile-head-wrapper .mobile-serve').each(function(){
					$(this).find('.title-ico').click(function(e){
					if($(this).parents('.mobile-serve').find('.mobile-head-hide').is(":hidden")){
						$(this).parents('.mobile-serve').find('.mobile-head-hide').show();
						$('.mobile-head-wrapper').find('.mobile-serve .mobile-head-hide').not($(this).parents('.mobile-serve').find('.mobile-head-hide')).hide();
						}else{
							$(this).parents('.mobile-serve').find('.mobile-head-hide').hide();
							}
							e.stopPropagation();
					})
					})
				
			})
		$(document).ready(function(){
				$('.nav li').each(function(){
					if($(this).find('ul').length>0){
						$(this).append("<div class='li-ico li-ico-up'></div>")
						$(this).children('.li-ico').click(function(e){
							if($(this).parent('li').children('ul').is(':hidden')){
								$(this).parent('li').children('ul').show()
								$(this).removeClass('li-ico-up')
								$(this).addClass('li-ico-down')
								}else{
									$(this).parent('li').children('ul').hide();
									$(this).addClass('li-ico-up')
									$(this).removeClass('li-ico-down')
								
									}
									e.stopPropagation();
							})
						}
					})
				})
			$(document).ready(function(){
				$('.bottom-service .service-item .service-hide').hide()
				   $('.bottom-service .service-item').each(function(){
					   var svMenu=$(this).parents('.service-item').find('.service-hide')
					   $(this).find('h3').click(function(){
						  if($(this).parents('.service-item').find('.service-hide').is(':hidden')){
							 $(this).parents('.service-item').addClass('service-show')
							 $(this).parents('.service-item').find('.service-hide').show()
						  }
						  else{
							 $(this).parents('.service-item').removeClass('service-show')
							 $(this).parents('.service-item').find('.service-hide').hide()
						  }			   
					  })
				   })
				})
			$(document).ready(function(e){
				$('.side-widget .side-tit-bar').click(function(e){
					if($(this).parents('.side-widget').find('.side-hide').is(':hidden')){
						$(this).parents('.side-widget').find('.side-hide').show();
						$(this).css('border-bottom','1px solid #DDDDDD');
					
						}else{
							$(this).parents('.side-widget').find('.side-hide').hide()
							$(this).css('border-bottom','none');
							}
							e.stopPropagation();	
					})
				})				
			$(document).ready(function(){
				$('.label_md ul').owlCarousel({
					autoplay:true,
					loop:true,
					margin:10,
					dots:true,
					nav: false,
					autoplayTimeout:30000,
					smartSpeed:180,
					items:2,
					lazyLoad:true,
					slideBy:2
				});
				$('.ideal-set-product').owlCarousel({
					autoplay:true,
					loop:true,
					margin:10,
					dots:true,
					nav: false,
					autoplayTimeout:30000,
					smartSpeed:180,
					items:1,
					lazyLoad:true,
					slideBy:1
				});
				$('.product-slides').owlCarousel({
					autoplay:true,
					loop:true,
					margin:10,
					dots: true,
					nav: false,
					autoplayTimeout:30000,
					smartSpeed:180,
					items:2,
					lazyLoad:true,
					slideBy:2
				});
				$('.small-img-scroll ul').owlCarousel({
					autoplay:true,
					loop:true,
					margin:10,
					dots: true,
					nav: false,
					autoplayTimeout:30000,
					smartSpeed:180,
					items:1,
					lazyLoad:true,
					slideBy:1
				});
				$('.mobile-pd-pic ul').owlCarousel({
					autoplay:true,
					loop:true,
					margin:10,
					dots: true,
					nav: false,
					autoplayTimeout:30000,
					smartSpeed:180,
					items:1,
					lazyLoad:true,
					slideBy:1
				});
				$('.share-slide').owlCarousel({
					autoplay:true,
					loop:true,
					margin:10,
					dots: true,
					nav: false,
					autoplayTimeout:30000,
					smartSpeed:180,
					items:2,
					lazyLoad:true,
					slideBy:2
				});		
			})		
		}
	else{
		var mouseover_tid = [];
var mouseout_tid = [];
$(document).ready(function(){
	//nav
	$('.nav').children('li').each(function(){
			if($(this).find('ul').length>0){
			$(this).addClass('nav-first-li')
			$('.nav-first-li').append("<div class='nav-ico'></div>")
			$('.nav-first-li').find('ul').children('li').each(function(){
				if($(this).find('ul').length>0){
				$(this).children('a').append("<div class='nav-li-ico'></div>")
				}
				})
			
			}
		})
	
	$('.nav li').each(function(index){
	if($(this).find('ul').length>0){
		$(this).hover( 
			function(){
				var _self = this;
				clearTimeout(mouseout_tid[index]);
				mouseover_tid[index] = setTimeout(function() {
					$(_self).children('ul').slideDown(200);
					$(_self).addClass("li-hover")
					$(_self).children().addClass("hover")
					$(_self).parents('.nav-bar').addClass('z9999')
				}, 100);
			},
 			function(){
				var _self = this;
				clearTimeout(mouseover_tid[index]);
				mouseout_tid[index] = setTimeout(function() {
					$(_self).children('ul').slideUp(50);
					$(_self).removeClass("li-hover")
					$(_self).children().removeClass("hover")
					$(_self).parents('.nav-bar').removeClass('z9999')
			  }, 50);
			}
		);
	 }
	});
	$('.nav li li:last-child').addClass('last')
   //dropmenu
   $('#currency').mouseover(function(){
		$(this).find(".dropdown").addClass('over');
	}).mouseout(function(){
	    $(this).find(".dropdown").removeClass('over');
   });

});
$(document).ready(function(){
		$('.small-img-scroll').each(function(){
		  if($(this).find('li').length>1){
	   
		  $(".small-img-scroll").jCarouselLite({
			 btnPrev: ".small-btn-prev",
			 btnNext: ".small-btn-next,.small-img-scroll li",
			 speed:100,
			 auto:false,
			 scroll:1,
			 visible:4,
			 vertical:false,
			 circular:false,
			 onMouse:true
		  });
		  }
	   })
	})

		}	

$(document).ready(function(){
   /* Categories */
   $('.narrow-by .cont').children('ul').children('li').each(function(){
      if($(this).find('ul').length>0){
         $(this).addClass('with-ul')
	     $(this).children('a').attr('href','javascript:')
	     $(this).children('a').addClass('with-ul-tit')
		 $(this).click(function(){
		   $(this).children('ul').slideToggle(180)
		 })
      }
   })   
});






    $.fn.kxbdMarquee = function(options){
        var opts = $.extend({},$.fn.kxbdMarquee.defaults, options);
        
        return this.each(function(){
            var $marquee = $(this);
            var _scrollObj = $marquee.get(0);
            var scrollW = $marquee.width();
            var scrollH = $marquee.height();
            var $element = $marquee.children(); 
            var $kids = $element.children();
            var scrollSize=0;
            var _type = (opts.direction == 'left' || opts.direction == 'right') ? 1:0;
            $element.css(_type?'width':'height',10000);
            if (opts.isEqual) {
                scrollSize = $kids[_type?'outerWidth':'outerHeight']() * $kids.length;
            }else{
                $kids.each(function(){
                    scrollSize += $(this)[_type?'outerWidth':'outerHeight']();
                });
            }
            if (scrollSize<(_type?scrollW:scrollH)) return; 
            $element.append($kids.clone()).css(_type?'width':'height',scrollSize*2);
            
            var numMoved = 0;
            function scrollFunc(){
                var _dir = (opts.direction == 'left' || opts.direction == 'right') ? 'scrollLeft':'scrollTop';
                if (opts.loop > 0) {
                    numMoved+=opts.scrollAmount;
                    if(numMoved>scrollSize*opts.loop){
                        _scrollObj[_dir] = 0;
                        return clearInterval(moveId);
                    } 
                }
                if(opts.direction == 'left' || opts.direction == 'up'){
                    _scrollObj[_dir] +=opts.scrollAmount;
                    if(_scrollObj[_dir]>=scrollSize){
                        _scrollObj[_dir] = 0;
                    }
                }else{
                    _scrollObj[_dir] -=opts.scrollAmount;
                    if(_scrollObj[_dir]<=0){
                        _scrollObj[_dir] = scrollSize;
                    }
                }
            }
            var moveId = setInterval(scrollFunc, opts.scrollDelay);
            $marquee.hover(
                function(){
                    clearInterval(moveId);
                },
                function(){
                    clearInterval(moveId);
                    moveId = setInterval(scrollFunc, opts.scrollDelay);
                }
            );
        });
    };
    $.fn.kxbdMarquee.defaults = {
        isEqual:true,
        loop: 0,
        direction: 'left',
        scrollAmount:1,
        scrollDelay:20

    };
    $.fn.kxbdMarquee.setDefaults = function(settings) {
        $.extend( $.fn.kxbdMarquee.defaults, settings );
    };



//head shop cart
(function ($, plugin) {
	var data = {}, id = 1, etid = plugin + 'ETID';
	$.fn[plugin] = function (speed, group) {
	id ++;
	group = group || this.data(etid) || id;
	speed = speed || 150;
	if (group === id) this.data(etid, group);
	this._hover = this.hover;
	this.hover = function (over, out) {
	over = over || $.noop;
	out = out || $.noop;
	this._hover(function (event) {
	var elem = this;
	clearTimeout(data[group]);
	data[group] = setTimeout(function () {
	over.call(elem, event);
	}, speed);
	}, function (event) {
	var elem = this;
	clearTimeout(data[group]);
	data[group] = setTimeout(function () {
	out.call(elem, event);
	}, speed);
	});
	return this;
	};
	return this;
	};
	$.fn[plugin + 'Pause'] = function () {
	clearTimeout(this.data(etid));
	return this;
	};
	$[plugin] = {
	get: function () {
	return id ++;
	},
	pause: function (group) {
	clearTimeout(data[group]);
	}
	};
	})(jQuery, 'mouseDelay');
	 
jQuery(function ($) {
   var group = 'menu_1'
	$('.head-shopcart').mouseDelay(false, group).hover(function () {
		$(this).addClass('head-shopcart-show')
		$(this).parents('.header').addClass('z9999')
	},function(){$(this).removeClass('head-shopcart-show')});
	
   var group = 'menu_2'
	$('.hide-cate').mouseDelay(false, group).hover(function () {
		$(this).find('.cate-menu').slideDown(200)
		$(this).addClass('show-cate')
		$(this).parents('.nav-bar').addClass('z9999')
	},function(){
		$(this).find('.cate-menu').slideUp(0)
		$(this).removeClass('show-cate')
		$(this).parents('.nav-bar').removeClass('z9999')
		}
	);	
});

 (function($){
       $('.promote-bar .time-count').append("<span class='time-coming'></span>")
       $(function(){
           //定义时间
           countDown("2015/12/30 23:59:59",".promote-bar  .time-count .day",".promote-bar .time-count .hour",".promote-bar .time-count .minute",".promote-bar .time-count .second");
       });
       function countDown(time,day_elem,hour_elem,minute_elem,second_elem){
        var end_time = new Date(time).getTime(),
        sys_second = (end_time-new Date().getTime())/1000;
        var timer = setInterval(function(){
            if (sys_second > 0) {
                sys_second -= 1;
                var day = Math.floor((sys_second / 3600) / 24);
                var hour = Math.floor((sys_second / 3600) % 24);
                var minute = Math.floor((sys_second / 60) % 60);
                var second = Math.floor(sys_second % 60);
                day_elem && $(day_elem).html(day);
                $(hour_elem).text(hour<10?"0"+hour+'':hour+'');
                $(minute_elem).text(minute<10?"0"+minute+'':minute+'');
                $(second_elem).text(second<10?"0"+second:second);
                $('.promote-bar .time-count p').css({'display':'inline-block'})
            } else { 
                clearInterval(timer);
                $('.promote-bar .time-count').html('<span class="next-time">Next Time！</span>')
            }
            $('.time-coming').remove()
        }, 1000);
        }
        })(jQuery);

//scroll
(function($){$.fn.jCarouselLite=function(o){o=$.extend({btnPrev:null,btnNext:null,btnGo:null,mouseWheel:false,onMouse: false,auto:null,speed:500,easing:null,vertical:false,circular:true,visible:4,start:0,scroll:1,beforeStart:null,afterEnd:null},o||{});return this.each(function(){var b=false,animCss=o.vertical?"top":"left",sizeCss=o.vertical?"height":"width";var c=$(this),ul=$("ul",c),tLi=$("li",ul),tl=tLi.size(),v=o.visible;var TimeID=0;if(o.circular){ul.prepend(tLi.slice(tl-v-1+1).clone()).append(tLi.slice(0,v).clone());o.start+=v}var f=$("li",ul),itemLength=f.size(),curr=o.start;c.css("visibility","visible");f.css({overflow:"",float:o.vertical?"none":"left"});ul.css({position:"relative","list-style-type":"none","z-index":"1"});c.css({overflow:"hidden",position:"relative","z-index":"2",left:"0px"});var g=o.vertical?height(f):width(f);var h=g*itemLength;var j=g*v;f.css({width:f.width(),height:f.height()});ul.css(sizeCss,h+"px").css(animCss,-(curr*g));c.css(sizeCss,j+"px");if(o.btnPrev)$(o.btnPrev).click(function(){return go(curr-o.scroll)});if(o.btnNext)$(o.btnNext).click(function(){return go(curr+o.scroll)});if(o.btnGo)$.each(o.btnGo,function(i,a){$(a).click(function(){return go(o.circular?o.visible+i:i)})});if(o.mouseWheel&&c.mousewheel)c.mousewheel(function(e,d){return d>0?go(curr-o.scroll):go(curr+o.scroll)});if (o.auto)		TimeID=setInterval(function(){	go(curr + o.scroll);},o.auto+o.speed);if(o.onMouse){ul.bind("mouseover",function(){if(o.auto){clearInterval(TimeID);}}),ul.bind("mouseout",function(){if(o.auto){TimeID=setInterval(function(){go(curr+o.scroll);},o.auto+o.speed);}})}function vis(){return f.slice(curr).slice(0,v)};function go(a){if(!b){if(o.beforeStart)o.beforeStart.call(this,vis());if(o.circular){if(a<=o.start-v-1){ul.css(animCss,-((itemLength-(v*2))*g)+"px");curr=a==o.start-v-1?itemLength-(v*2)-1:itemLength-(v*2)-o.scroll}else if(a>=itemLength-v+1){ul.css(animCss,-((v)*g)+"px");curr=a==itemLength-v+1?v+1:v+o.scroll}else curr=a}else{if(a<0||a>itemLength-v)return;else curr=a}b=true;ul.animate(animCss=="left"?{left:-(curr*g)}:{top:-(curr*g)},o.speed,o.easing,function(){if(o.afterEnd)o.afterEnd.call(this,vis());b=false});if(!o.circular){$(o.btnPrev+","+o.btnNext).removeClass("disabled");$((curr-o.scroll<0&&o.btnPrev)||(curr+o.scroll>itemLength-v&&o.btnNext)||[]).addClass("disabled")}}return false}})};function css(a,b){return parseInt($.css(a[0],b))||0};function width(a){return a[0].offsetWidth+css(a,'marginLeft')+css(a,'marginRight')};function height(a){return a[0].offsetHeight+css(a,'marginTop')+css(a,'marginBottom')}})(jQuery);


(function($){
$(document).ready(function(){


//search	
$(function(){
	$(".search-ipt,.ipt-text,.subscribe-ipt").focus(function(){
	$(this).parents('.head-search').addClass("head-search-focus");
	$(this).parents('.head-search').find('.search-btn').addClass("search-btn-focus");
	if($(this).val() ==this.defaultValue){
	$(this).val("");
	}
	}).blur(function(){
    if ($(this).val() == '') {
	$(this).val(this.defaultValue);
	$(this).parents('.head-search').removeClass("head-search-focus");
	$(this).parents('.head-search').find('.search-btn').removeClass("search-btn-focus");
	}
	else{$(this).addClass("ipt-focus");}
	});
})


//discount
$('.product-slides .product-item,.product-items li,.product-list .product-item').each(function(){
   var curPrice=parseFloat($(this).find('.pd-price b i').text())
   var oPrice=parseFloat($(this).find('.pd-price del i').text())   
   if(curPrice<oPrice)
   {
      var discount=Math.round((1-curPrice/oPrice)*100)
      $(this).find('.discount b').html(discount)
   }
   else{
	  $(this).find('.discount b').html('0')
   }
})



/* narrow by */
$('.narrow-list').children('li').each(function(){
   if($(this).find('ul').length>0){
      $(this).addClass('with-ul')
	  $(this).children('a').attr('href','javascript:')
	  $(this).children('a').addClass('with-ul-tit')
	  $(this).children('a').append('<b></b>')
   }
})
$('.with-ul-tit').click(function(){
   if($(this).parent('li').find('ul').is(':hidden')){
      $(this).parent('li').removeClass('with-ul-hide')
      $(this).parent('li').find('ul').slideDown(200)
   }
   else{
      $(this).parent('li').addClass('with-ul-hide')
      $(this).parent('li').find('ul').slideUp(200)		  
   }		  
})


})//ready end



//tab
$(function(){
    $('.product-detail .detail-tabs li').click(function(){
        i=$(this).index();
        $(this).addClass('current').siblings().removeClass('current');
        $('.product-detail .detail-panel').eq(i).show();
        $('.product-detail .detail-panel').not($('.product-detail .detail-panel').eq(i)).hide();
    })   
   
});
/*
$(function(){
    $('.video-tuto .video-tuto-tabs li').click(function(){
        i=$(this).index();
        $(this).addClass('current').siblings().removeClass('current');
        $('.video-tuto .video-tuto-panel-wrap .video-tuto-panel').eq(i).show();
        $('.video-tuto .video-tuto-panel-wrap .video-tuto-panel').not($('.video-tuto .video-tuto-panel-wrap .video-tuto-panel').eq(i)).hide();
    })   
   
});
*/
$(document).ready(function(){
	
	$('.popbox .close').click(function(){
	   $(this).parents('.popbox').hide()
	})
	$('.detail-panel').find('img').parents('a').attr('data-lightbox','lightbox-2')
	$('.blog-article').find('img').parents('a').attr('data-lightbox','lightbox-article')
	
	$('.widget ul li li:last-child').addClass('last-child')
	$('.small-btn-prev').addClass('disabled')
	
	//back to top
   	var mHeadTop=$('.header').offset().top
    var $backToTopTxt="TOP", $backToTopEle = $('<span class="gotop"></span>').appendTo($("body"))
        .text($backToTopTxt).attr("title", $backToTopTxt).click(function() {
            $("html, body").animate({ scrollTop:0 }, 300);
			
    }), $backToTopFun = function() {	
        var st = $(document).scrollTop(), winh = $(window).height();
        (st > 50)? $backToTopEle.show(): $backToTopEle.hide();  	
        if (!window.XMLHttpRequest) {
            $backToTopEle.css("top", st + winh - 210); 
        }
		
    };
    $(window).bind("scroll", $backToTopFun);
    $(function() { $backToTopFun();});
})
$(document).ready(function(){
	$('.wpcf7-response-output').append("<div class='ico'></div>")
	$('.wpcf7-response-output').each(function(){
		$(this).find('.ico').click(function(){
			if($(this).parents('.wpcf7-response-output').is(':hidden')){
			$(this).parents('.wpcf7-response-output').show()
			}else{
				$(this).parents('.wpcf7-response-output').hide()
				}
			})
		
		})
	})
$(document).ready(function(){
	$('.wpcf7-form .inquiry-form ').each(function(){
		 $(this).find('.form-item').eq('1').find('span').append("<div class='aa' style=' color:#F00; display:none;'>formal error</div>")
			
		$(this).find('.form-btn-submit').click(function(){
			 
			var emailSt=$(this).parents('.inquiry-form').find('.form-item').eq('1').find('input').val();
					if(emailSt!='' && emailSt.indexOf("@")<0)
					{
					  $(this).parents('.inquiry-form').find('.form-item').eq('1').find('.aa').show();
					  $(this).parents('.inquiry-form').find('.form-item').eq('1').find('.wpcf7-not-valid-tip-no-ajax').hide();
					  return false; 
					}	else{
						  $(this).parents('.inquiry-form').find('.form-item').eq('1').find('.aa').hide()
						}
			})
		})
	})
/*
$(document).ready(function(){
	$('.product-item .pd-img ').each(function(){
		if(($(this).find('img').length)<=1){
			$(this).find('img').css('opacity','1')
			$(this).parents('.product-item').addClass('ass')
			}
		
		})
	
	})	
*/	
$(document)	.ready(function(){
	$('.side-list').children('li').each(function(){
		$(this).css('border-bottom','1px solid #dadada').css('font-size','14px').css('padding','10px 0 10px 20px')
   if($(this).find('ul').length>0){
	  $(this).find('ul').hide();
      $(this).addClass('with-ul')
	  $(this).children('a').attr('href','javascript:')
	  $(this).children('a').addClass('with-ul-tit')
	  $(this).children('a').append('<b></b>')
   }
})
$('.side-list .with-ul-tit').click(function(){
   if($(this).parent('li').find('ul').is(':hidden')){
      $(this).parent('li').addClass('with-ul-hide')
      $(this).parent('li').find('ul').slideDown(200)
   }
   else{
      $(this).parent('li').removeClass('with-ul-hide')
      $(this).parent('li').find('ul').slideUp(200)		  
   }		  
})
	
	})

$(document)	.ready(function(){	

$('.narrow-by li li')	.click(function(){
	$(this).find('a').css('background-position','-176px -84px')
	})
})
$(document).ready(function(){
	$('.side-widget .side-cate li').each(function(){
		if($(this).find('ul').length>0){
			$(this).append("<div class='icon-cate icon-cate-up '></div>")
			$(this).children('.icon-cate').click(function(e){
							if($(this).parent('li').children('ul').is(':hidden')){
								$(this).parent('li').children('ul').slideDown()
									$(this).removeClass('icon-cate-down')
									$(this).addClass('icon-cate-up')
								
								}else{
									$(this).parent('li').children('ul').slideUp();
									$(this).removeClass('icon-cate-up')
									$(this).addClass('icon-cate-down')
									
									
								
									}
									e.stopPropagation();
							})
			
			}
		})
	})
$(document).ready(function(){
		$('.label_md ul,.ideal-set-product,.product-list ul').contents().filter(function() {
		return this.nodeType === 3;
		}).remove();
	})	
$(document).ready(function(){
	
		
	$('.product-slides').owlCarousel({
		autoplay:true,
		loop:true,
		margin:10,
		dots: false,
		nav: true,
		autoplayTimeout:30000,
		smartSpeed:180,
		items:4,
		lazyLoad:true,
		slideBy:4
	});	
	$('.share-slide').owlCarousel({
		autoplay:true,
		loop:true,
		margin:10,
		dots: false,
		nav: true,
		autoplayTimeout:30000,
		smartSpeed:180,
		items:5,
		lazyLoad:true,
		slideBy:5
	});	
	$('.goods-items').owlCarousel({
		autoplay:true,
		loop:true,
		margin:0,
		dots: false,
		nav: true,
		autoplayTimeout:30000,
		smartSpeed:180,
		items:5,
		lazyLoad:true,
		slideBy:5
	});	
	
	
	$('.products-scroll-list').each(function(){
      if($(this).find('li').length>1){
   
      $(".products-scroll-list").jCarouselLite({
		 btnPrev: ".products-scroll-btn-prev",
		 btnNext: ".products-scroll-btn-next",
		 speed:100,
		 auto:false,
		 scroll:1,
		 visible:6,
		 vertical:true,
		 circular:false,
		 onMouse:true
      });
      }
   })
   
    $(".slide-banners").flexslider({
		animation:"fade",
		direction:"horizontal",
		animationLoop:true,
		slideshow:true,
		slideshowSpeed:7000, 
		animationSpeed: 600, 
		directionNav:true,
		controlNav:false,
		touch: true 
	});	

	})

$(document).ready(function(){
	$('.detail-panel,.blog-article,.product-detail-pic').find('img').parents('a').addClass('lightbox')
	$('.lightbox').lightbox();
	$('.pd-shadow').lightbox();
	}) 

})(jQuery);


