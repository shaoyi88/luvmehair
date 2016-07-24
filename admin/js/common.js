
(function($){
	
   $(document).ready(function(){
	 $('.side-nav').children('li').each(function(){
	   if($(this).find('ul').length>0){
	     $(this).find('li a').append("<span class='ico-box'><i></i></span>")
	   }
	 })
   })


   //左侧菜单
   $(function(){
	$('.side-nav').children('li').children('a').click(function(){
	   
	   if($(this).parent('li').find('ul').length>0){
		  if($(this).parent('li').find('ul').is(":hidden")){
			  
	         $('.sub-menu').slideUp(200) 
	         $('.side-nav').children('li').children('a').removeClass('active')
	         $(this).next(".sub-menu").slideDown(200)/*.siblings(".sub-menu").slideUp(200)*/;
	         $(this).addClass('active').siblings().removeClass('active')
		  }
		  else{
		     $(this).next(".sub-menu").slideUp(200)
	         $(this).removeClass('active')     
		  }
	   }
	   
	})
   })
   $(document).ready(function(){
      $('.side-nav').children('li').each(function(){
		 if($(this).find('ul').length>0){
	        $(this).children('a').append('<i class="ico-menu-arrow"></i>')
		 }
	     if($(this).hasClass('current')){
	        $(this).children('a').addClass('active')
		 }
	  })
	  $('.sub-menu li').click(function(){
		  $(this).parents('.side-nav').find('li').removeClass('active')
		  $(this).addClass('active').siblings().removeClass('active')
		  $('.path-bar').find('.cur').text($(this).find('a').text())		     
	  })
   })

   	
})(jQuery);





