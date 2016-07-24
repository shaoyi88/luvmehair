
/* 删除-图片浏览相关 - 2015-05-24

// jqZoom version 2.2
(function($,g){var h={},id=1,etid=g+'ETID';$.fn[g]=function(e,f){id++;f=f||this.data(etid)||id;e=e||150;if(f===id)this.data(etid,f);this._hover=this.hover;this.hover=function(c,d){c=c||$.noop;d=d||$.noop;this._hover(function(a){var b=this;clearTimeout(h[f]);h[f]=setTimeout(function(){c.call(b,a)},e)},function(a){var b=this;clearTimeout(h[f]);h[f]=setTimeout(function(){d.call(b,a)},e)});return this};return this};$.fn[g+'Pause']=function(){clearTimeout(this.data(etid));return this};$[g]={get:function(){return id++},pause:function(a){clearTimeout(h[a])}}})(jQuery,'mouseDelay');
// jqZoom version 2.2
(function($){$.fn.jqueryzoom=function(options){var settings={xzoom:200,yzoom:200,offset:10,position:"right",lens:1,preload:1};if(options){$.extend(settings,options)}var noalt='';$(this).mouseDelay(200).hover(function(){var imageLeft=$(this).offset().left;var imageTop=$(this).offset().top;var imageWidth=$(this).children('img').get(0).offsetWidth;var imageHeight=$(this).children('img').get(0).offsetHeight;noalt=$(this).children("img").attr("alt");var bigimage=$(this).children("img").attr("jqimg");if(bigimage=="")return false;$(this).children("img").attr("alt",'');if($("div.zoomdiv").get().length==0){$(this).after("<div class='zoomdiv'><img class='bigimg' src='"+bigimage+"'/></div>");$(this).append("<div class='jqZoomPup'>&nbsp;</div>")}if(settings.position=="right"){if(imageLeft+imageWidth+settings.offset+settings.xzoom>screen.width){leftpos=imageLeft-settings.offset-settings.xzoom}else{leftpos=imageLeft+imageWidth+settings.offset}}else{leftpos=imageLeft-settings.xzoom-settings.offset;if(leftpos<0){leftpos=imageLeft+imageWidth+settings.offset}}$("div.zoomdiv").css({top:0,left:imageWidth+0});$("div.zoomdiv").width(settings.xzoom);$("div.zoomdiv").height(settings.yzoom);$("div.zoomdiv").show();if(!settings.lens){$(this).css('cursor','crosshair')}$(document.body).mousemove(function(e){mouse=new MouseEvent(e);var bigwidth=$(".bigimg").get(0).offsetWidth;var bigheight=$(".bigimg").get(0).offsetHeight;var scaley='x';var scalex='y';if(isNaN(scalex)|isNaN(scaley)){var scalex=(bigwidth/imageWidth);var scaley=(bigheight/imageHeight);$("div.jqZoomPup").width((settings.xzoom)/scalex);$("div.jqZoomPup").height((settings.yzoom)/scaley);if(settings.lens){$("div.jqZoomPup").css('visibility','visible')}}xpos=mouse.x-$("div.jqZoomPup").width()/2-imageLeft;ypos=mouse.y-$("div.jqZoomPup").height()/2-imageTop;if(settings.lens){xpos=(mouse.x-$("div.jqZoomPup").width()/2<imageLeft)?0:(mouse.x+$("div.jqZoomPup").width()/2>imageWidth+imageLeft)?(imageWidth-$("div.jqZoomPup").width()-2):xpos;ypos=(mouse.y-$("div.jqZoomPup").height()/2<imageTop)?0:(mouse.y+$("div.jqZoomPup").height()/2>imageHeight+imageTop)?(imageHeight-$("div.jqZoomPup").height()-2):ypos}if(settings.lens){$("div.jqZoomPup").css({top:ypos,left:xpos})}scrolly=ypos;$("div.zoomdiv").get(0).scrollTop=scrolly*scaley;scrollx=xpos;$("div.zoomdiv").get(0).scrollLeft=(scrollx)*scalex})},function(){$(this).children("img").attr("alt",noalt);$(document.body).unbind("mousemove");if(settings.lens){$("div.jqZoomPup").remove()}$("div.zoomdiv").remove()});count=0;if(settings.preload){$('body').append("<div style='display:none;' class='jqPreload"+count+"'>sdsdssdsd</div>");$(this).each(function(){var imagetopreload=$(this).children("img").attr("jqimg");var content=jQuery('div.jqPreload'+count+'').html();jQuery('div.jqPreload'+count+'').html(content+'<img src=\"'+imagetopreload+'\">')})}}})(jQuery);function MouseEvent(e){this.x=e.pageX;this.y=e.pageY}



(function($){$.extend($.fn,{livequery:function(type,fn,fn2){var self=this,q;if($.isFunction(type))
fn2=fn,fn=type,type=undefined;$.each($.livequery.queries,function(i,query){if(self.selector==query.selector&&self.context==query.context&&type==query.type&&(!fn||fn.$lqguid==query.fn.$lqguid)&&(!fn2||fn2.$lqguid==query.fn2.$lqguid))
return(q=query)&&false;});q=q||new $.livequery(this.selector,this.context,type,fn,fn2);q.stopped=false;$.livequery.run(q.id);return this;},expire:function(type,fn,fn2){var self=this;if($.isFunction(type))
fn2=fn,fn=type,type=undefined;$.each($.livequery.queries,function(i,query){if(self.selector==query.selector&&self.context==query.context&&(!type||type==query.type)&&(!fn||fn.$lqguid==query.fn.$lqguid)&&(!fn2||fn2.$lqguid==query.fn2.$lqguid)&&!this.stopped)
$.livequery.stop(query.id);});return this;}});$.livequery=function(selector,context,type,fn,fn2){this.selector=selector;this.context=context||document;this.type=type;this.fn=fn;this.fn2=fn2;this.elements=[];this.stopped=false;this.id=$.livequery.queries.push(this)-1;fn.$lqguid=fn.$lqguid||$.livequery.guid++;if(fn2)fn2.$lqguid=fn2.$lqguid||$.livequery.guid++;return this;};$.livequery.prototype={stop:function(){var query=this;if(this.type)
this.elements.unbind(this.type,this.fn);else if(this.fn2)
this.elements.each(function(i,el){query.fn2.apply(el);});this.elements=[];this.stopped=true;},run:function(){if(this.stopped)return;var query=this;var oEls=this.elements,els=$(this.selector,this.context),nEls=els.not(oEls);this.elements=els;if(this.type){nEls.bind(this.type,this.fn);if(oEls.length>0)
$.each(oEls,function(i,el){if($.inArray(el,els)<0)
$.event.remove(el,query.type,query.fn);});}
else{nEls.each(function(){query.fn.apply(this);});if(this.fn2&&oEls.length>0)
$.each(oEls,function(i,el){if($.inArray(el,els)<0)
query.fn2.apply(el);});}}};$.extend($.livequery,{guid:0,queries:[],queue:[],running:false,timeout:null,checkQueue:function(){if($.livequery.running&&$.livequery.queue.length){var length=$.livequery.queue.length;while(length--)
$.livequery.queries[$.livequery.queue.shift()].run();}},pause:function(){$.livequery.running=false;},play:function(){$.livequery.running=true;$.livequery.run();},registerPlugin:function(){$.each(arguments,function(i,n){if(!$.fn[n])return;var old=$.fn[n];$.fn[n]=function(){var r=old.apply(this,arguments);$.livequery.run();return r;}});},run:function(id){if(id!=undefined){if($.inArray(id,$.livequery.queue)<0)
$.livequery.queue.push(id);}
else
$.each($.livequery.queries,function(id){if($.inArray(id,$.livequery.queue)<0)
$.livequery.queue.push(id);});if($.livequery.timeout)clearTimeout($.livequery.timeout);$.livequery.timeout=setTimeout($.livequery.checkQueue,20);},stop:function(id){if(id!=undefined)
$.livequery.queries[id].stop();else
$.each($.livequery.queries,function(id){$.livequery.queries[id].stop();});}});$.livequery.registerPlugin('append','prepend','after','before','wrap','attr','removeAttr','addClass','removeClass','toggleClass','empty','remove');$(function(){$.livequery.play();});var init=$.prototype.init;$.prototype.init=function(a,c){var r=init.apply(this,arguments);if(a&&a.selector)
r.context=a.context,r.selector=a.selector;if(typeof a=='string')
r.context=c||document,r.selector=a;return r;};$.prototype.init.prototype=$.prototype;})(jQuery);

*/



/* 删除-图片浏览相关 - 2015-05-24
//图片预览
$(function(){
    $(".small-img-scroll li img").livequery("click",function(){ 
        var imgSrc = $(this).attr("src");
        var i = imgSrc.lastIndexOf(".");
        var unit = imgSrc.substring(i);
        imgSrc = imgSrc.substring(0,i);
        var imgSrc_small = $(this).attr("src_mid");
        var imgSrc_big = $(this).attr("src_big");
        $("#bigImg").attr({"src": imgSrc_small ,"jqimg": imgSrc_big });
    });
	$(".small-img-scroll li:first-child").addClass('current')
	$(".small-img-scroll li").click(function(){
	   $(this).addClass('current').siblings().removeClass('current')
	})
    
    $(".small-img-scroll ul li img").livequery("mouseout",function(){ 
    });
	
	
    //使用jqzoom
    $(".jqzoom").jqueryzoom({
        xzoom: 350, //放大图的宽度(默认是 200)
        yzoom: 350, //放大图的高度(默认是 200)
        offset: 1, //离原图的距离(默认是 10)
        position: "right", //放大图的定位(默认是 "right")
        preload:1   
    });
	
	
    $('.small-img-slide').owlCarousel({
	      autoplay:false,
	      loop:true,
	      margin:0,
	      dots: false,
	      nav: true,
	      smartSpeed:100,
	      items:4
	   });	
	   $('.small-img-item').click(function() {
          $('.small-img-slide').trigger('next.owl.carousel', [300]);
	   })
	
});
*/

/* ----------------------------------------------------------- 以上代码为旧版 "商品图片浏览" , 全删除 */





(function($){
	
//图片预览 -2015-05-25
$(function(){
	$('.small-img-item').click(function() {
		$('.small-img-scroll').trigger('next.owl.carousel', [500]);
	})	
	$(".small-img-scroll li:first-child").addClass('current')
	$(".small-img-scroll li").click(function(){
	   $(this).addClass('current').siblings().removeClass('current')
	})
	
	//点击小图切换大图
	$('.small-img-item').click(function(){
	   var src_mid=$(this).find('img').attr('src_mid')
	   var src_big=$(this).find('img').attr('src_big')
	   $('#bigImg').attr('src',src_mid)
	   $('#bigImg').attr('jqimg',src_big)
	})

	$('#bigImg').click(function(){
	   $('.container').addClass('container-for-gallery')
	   $('<h2 class="gallery-photo-title"></h2><section class="gallery-main"><div class="gallery-photo"></div><div class="gallery-small-imgs"></div></section>').appendTo('.photos-gallery')
	   $('.gallery-body-mask').fadeIn()
	   
	   $('.gallery-photo-title').html($('.product-title').text())
	   

	   //生成弹窗图片
	   var bigImgUrl=$(this).attr("jqimg")
	   $('<div class="photo-box"><span class="photo-prev">prev</span><span class="photo-next">next</span><img src='+bigImgUrl+'></div>').appendTo('.gallery-photo')
	   $('.small-img-scroll').find('ul').clone().appendTo('.gallery-small-imgs')
	   $('.gallery-small-imgs ul').attr('style','')
	   $('.gallery-small-imgs li').attr('style','')
	   if($('.gallery-small-imgs li').hasClass('disabled')){
	      $('.gallery-small-imgs li').removeClass('disabled')
	   }
	   
	   
	   //弹窗居中 - 图片加载完毕之后才执行高度判断
	   $(".photo-box img").load(function(){   
	   var gTop = ($(window).height() - $('.photos-gallery').height())/2;   
       var gLeft = ($(window).width() - $('.photos-gallery').width())/2;   
       var scrollTop = $(document).scrollTop();   
       var scrollLeft = $(document).scrollLeft();   
       $('.photos-gallery').css( { position : 'absolute', 'top' : gTop + scrollTop, left : gLeft + scrollLeft } ).fadeIn(); 
	   });
	   	  
	   
	   //点击小图 
	   $('.gallery-small-imgs .small-img-item').click(function(){
	      var curPhotoSrc=$(this).find('img').attr('src_big')
	      $('.gallery-photo').find('img').attr('src',curPhotoSrc)
	   })
	   $('.gallery-small-imgs .owl-item').click(function(){
		  $(this).addClass('current').siblings().removeClass('current')	   
	   })
	   
	   
	   //button-prev
	   $('.photo-prev').click(function(){
		   var smallItem=$('.gallery-small-imgs li')
		   var imgNum=$('.gallery-small-imgs li').length
		   imgI=$('.gallery-small-imgs .current').index();	
		   if(imgI>0){
		      var curPhotoSrc=smallItem.eq(imgI-1).find('img').attr('src_big')
		      smallItem.removeClass('current')
		      smallItem.eq(imgI-1).addClass('current')
	          $('.gallery-photo').find('img').attr('src',curPhotoSrc)			   
		   }
	       else{
		      var curPhotoSrc=smallItem.eq(imgNum-1).find('img').attr('src_big')
		      smallItem.removeClass('current')
		      smallItem.eq(imgNum-1).addClass('current')
	          $('.gallery-photo').find('img').attr('src',curPhotoSrc)	
		   }

	   })	   
	   
	   //button-next
	   $('.photo-next').click(function(){
		   var smallItem=$('.gallery-small-imgs li')
		   var imgNum=$('.gallery-small-imgs li').length
		   imgI=$('.gallery-small-imgs .current').index();		   
	       if(imgI<imgNum-1){
		      var curPhotoSrc=smallItem.eq(imgI+1).find('img').attr('src_big')
		      smallItem.removeClass('current')
		      smallItem.eq(imgI+1).addClass('current')
	          $('.gallery-photo').find('img').attr('src',curPhotoSrc)
		   }
		   else{
		      var curPhotoSrc=smallItem.eq(0).find('img').attr('src_big')
		      smallItem.removeClass('current')
		      smallItem.eq(0).addClass('current')
	          $('.gallery-photo').find('img').attr('src',curPhotoSrc)		   
		   }
	   })
	   
	   
	   //关闭弹窗
	   $('.close-gallery,.gallery-body-mask').click(function(){
	      $('.photos-gallery').find('.gallery-main,.gallery-photo-title').remove()
		  $('.photos-gallery').hide()
		  $('.gallery-body-mask').fadeOut()
	      $('.container').removeClass('container-for-gallery')
	   })
	   
	})
	

})





//tab
$(function(){
    $('.product-detail .detail-tabs h2').click(function(){
        i=$(this).index();
        $(this).addClass('current').siblings().removeClass('current');
        $('.product-detail .detail-panel').eq(i).show();
        $('.product-detail .detail-panel').not($('.product-detail .detail-panel').eq(i)).hide();
    })   
   
});


$(document).ready(function(){
   //hide scroll button
   var imgCount=$('.small-img-scroll ul li').length
   if(imgCount<=5){
      $('.small-btn-prev,.small-btn-next').hide()
   }
   else{
	  $('.small-btn-prev,.small-btn-next').show()
   }
      
   //show custom size
   $(".size-form-check").click(function(){
   if($(this).attr("checked")){
       $('.size-form').show()
	   $(this).attr("checked");   	   
   }
   else{
	   $(this).removeAttr("checked",'true');   
	   $('.size-form').hide()
   }
   })  
   
   //select qty
   /*
   $(function(){
   var t=$('.ipt-qty')   
   $(".btn-plus").click(function () {
	   t.val(parseInt(t.val())+1)
   })
   $('.btn-minus').click(function(){
     if(t.val()>=2){
        t.val(parseInt(t.val())-1)
	 }
   })
   })*/
   

   //select qty 2015-04-01
   $(function(){
   var t=$('.ipt-qty')
   $('.ipt-qty').blur(function(){
	  var tValue=$(this).val()
      if(tValue=='' || isNaN(tValue)){
	     $(this).val('1')
	  }
	  else if(!isNaN(tValue) && tValue<1){
		 $(this).val('1')
	  }	
	  else{
		  $(this).val(parseInt(tValue)) 
	  }
    })
	var t=$('.ipt-qty')	
          $(".btn-plus").click(function () {
	         t.val(parseInt(t.val())+1)
          })
          $('.btn-minus').click(function(){
          if(t.val()>=2){
           t.val(parseInt(t.val())-1)
	      }
    })  	
	}) 

   
 
  //discount for product
   var curPrice=parseFloat($('.product-summary').find('.special-price i').text())
   var oPrice=parseFloat($('.product-summary').find('.old-price i').text())  
   if(curPrice<oPrice)
   {
      var discount=Math.round((1-curPrice/oPrice)*100)
      $('.product-summary').find('.discount b').html(discount)
   }
   else{
	  //$('.product-summary').find('.discount b').html('100')
	  $('.product-summary').find('.discount').hide()//2015-02-15
   } 
   
   $('.current-goods').each(function(){
   var curPrice=parseFloat($(this).parents('.detail-wrap').find('.product-summary').find('.special-price i').text())
   var oPrice=parseFloat($(this).parents('.detail-wrap').find('.product-summary').find('.old-price i').text())   
   if(curPrice<oPrice)
   {
      var discount=Math.round((1-curPrice/oPrice)*100)
      $(this).find('.discount b').html(discount)
   }
   else{
	  //$(this).find('.discount b').html('100')
	  $(this).find('.discount').hide()//2015-02-15
   }
   })   
   
   //change currency
   $('.change-currency').hover(function(){
     $(this).toggleClass('currency-show')
   }) 
   
   
 /*  
   var goods_width=$('.related-list li').length*134
   $('.related-list ul').css({
      'width':goods_width+'px'
   })
  */  
     
})

})(jQuery);