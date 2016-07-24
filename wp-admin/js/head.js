
//menu scroll
(function($){
	$.extend($.easing,{
		easeInSine: function (x, t, b, c, d) {
			return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
		}
	});

	$.fn.Xslider=function(settings){
		settings=$.extend({},$.fn.Xslider.sn.defaults,settings);
		this.each(function(){
			var scrollobj=settings.scrollobj ? $(this).find(settings.scrollobj) : $(this).find("ul"),
			    viewedSize=settings.viewedSize || (settings.dir=="H" ? scrollobj.parent().width() : scrollobj.parent().height()),//length of the wrapper visible;
			    scrollunits=scrollobj.find("li"),//units to move;
			    unitlen=settings.unitlen || (settings.dir=="H" ? scrollunits.eq(0).outerWidth() : scrollunits.eq(0).outerHeight()),
			    unitdisplayed=settings.unitdisplayed,//units num displayed;
				numtoMove=settings.numtoMove > unitdisplayed ? unitdisplayed : settings.numtoMove,
			    scrollobjSize=settings.scrollobjSize || scrollunits.length*unitlen,//length of the scrollobj;
			    offset=0,//max width to move;
			    offsetnow=0,//scrollobj now offset;
			    movelength=unitlen*numtoMove,
				pos=settings.dir=="H" ? "left" : "top",
			    moving=false,//moving now?;
			    btnright=$(this).find("a.menu-next"),
			    btnleft=$(this).find("a.menu-prev");
			
			btnright.unbind("click");
			btnleft.unbind("click");
					
			settings.dir=="H" ? scrollobj.css("left","0px") : scrollobj.css("top","0px");
							
			if(scrollobjSize>viewedSize){
				if(settings.loop=="cycle"){
					btnleft.removeClass("menu-prev-gray");
					if(scrollunits.length<2*numtoMove+unitdisplayed-numtoMove){
						scrollobj.find("li").clone().appendTo(scrollobj);	
					}
				}else{
					btnleft.addClass("menu-prev-gray");
					offset=scrollobjSize-viewedSize;
				}
				btnright.removeClass("menu-next-gray");
			}else{
				btnleft.addClass("menu-prev-gray");
				btnright.addClass("menu-next-gray");
			}

			btnleft.click(function(){
				if($(this).is("[class*='menu-prev-gray']")){return false;}
				
				if(!moving){
					moving=true;
					
					if(settings.loop=="cycle"){
						scrollobj.find("li:gt("+(scrollunits.length-numtoMove-1)+")").prependTo(scrollobj);
						scrollobj.css(pos,"-"+movelength+"px");
						$.fn.Xslider.sn.animate(scrollobj,0,settings.dir,settings.speed,function(){moving=false;});
					}else{
						offsetnow-=movelength;
						if(offsetnow>unitlen*unitdisplayed-viewedSize){
							$.fn.Xslider.sn.animate(scrollobj,-offsetnow,settings.dir,settings.speed,function(){moving=false;});
						}else{
							$.fn.Xslider.sn.animate(scrollobj,0,settings.dir,settings.speed,function(){moving=false;});
							offsetnow=0;
							$(this).addClass("menu-prev-gray");
						}
						btnright.removeClass("menu-next-gray");
					}
				}

				return false;
			});
			btnright.click(function(){
				if($(this).is("[class*='menu-next-gray']")){return false;}
				
				if(!moving){
					moving=true;
					
					if(settings.loop=="cycle"){
						var callback=function(){
							scrollobj.find("li:lt("+numtoMove+")").appendTo(scrollobj);
							scrollobj.css(pos,"0px");
							moving=false;
						}
						$.fn.Xslider.sn.animate(scrollobj,-movelength,settings.dir,settings.speed,callback);
					}else{
						offsetnow+=movelength;
						if(offsetnow<offset-(unitlen*unitdisplayed-viewedSize)){
							$.fn.Xslider.sn.animate(scrollobj,-offsetnow,settings.dir,settings.speed,function(){moving=false;});
						}else{
							$.fn.Xslider.sn.animate(scrollobj,-offset,settings.dir,settings.speed,function(){moving=false;});//滚动到最后一个位置;
							offsetnow=offset;
							$(this).addClass("menu-next-gray");
						}
						btnleft.removeClass("menu-prev-gray");
					}
				}
				
				return false;
			});
			
			if(settings.autoscroll){
				$.fn.Xslider.sn.autoscroll($(this),settings.autoscroll);
			}
		})
	}
	
	$.fn.Xslider.sn={
		defaults:{
			dir:"H",
			speed:500
		},
		animate:function(obj,w,dir,speed,callback){
			if(dir=="H"){
				obj.animate({
					left:w
				},speed,"easeInSine",callback);
			}else if(dir=="V"){
				obj.animate({
					top:w
				},speed,"easeInSine",callback);	
			}	
		},
		autoscroll:function(obj,time){
			var  vane="right";
			function autoscrolling(){
				if(vane=="right"){
					if(!obj.find("a.menu-next-gray").length){
						obj.find("a.menu-next").trigger("click");
					}else{
						vane="left";
					}
				}
				if(vane=="left"){
					if(!obj.find("a.menu-prev-gray").length){	
						obj.find("a.menu-prev").trigger("click");
					}else{
						vane="right";
					}
				}
			}
			var scrollTimmer=setInterval(autoscrolling,time);
			obj.hover(function(){
				clearInterval(scrollTimmer);
			},function(){
				scrollTimmer=setInterval(autoscrolling,time);
			});
		}
	}
})(jQuery);


//drop-down menu
var mouseover_tid = [];
var mouseout_tid = [];
$(document).ready(function(){
	$('.menu-bar li .menu-item').each(function(index){
		$(this).hover( 
			function(){
				var _self = this;
				clearTimeout(mouseout_tid[index]);
				mouseover_tid[index] = setTimeout(function() {
					$(_self).parents('li').find('.sub-menu').slideDown(200);
					$(_self).parents('li').addClass("hover")
				}, 100);
			},
 			function(){
				var _self = this;
				clearTimeout(mouseover_tid[index]);
				mouseout_tid[index] = setTimeout(function() {
					$(_self).parents('li').find('.sub-menu').slideUp(100);
					$(_self).parents('li').removeClass("hover")
				}, 50);
			}
		);
	});
});
$(document).ready(function(){
   $('.menu-bar li .menu-item').hover(function(){
	   $(this).parents('.menu-scroll').addClass('z-index-2000')
   },function(){
	  $(this).parents('.menu-scroll').removeClass('z-index-2000')  
   })

})