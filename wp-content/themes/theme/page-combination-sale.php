<?php 
/* Template Name: page-combination-sale */ 
if($_GET[ 'ids']) { 
    $ids = trim($_GET[ 'ids']); 
} 
?>
<?php 
    $options = get_option('EOCMS_options');
      if($_GET['currency']&&$_GET['eshopaction']=='') {
		 setcookie('currency', $_GET['currency'], time()+3600*24*30, COOKIEPATH, COOKIE_DOMAIN, false);
	    $url = home_url(add_query_arg(array()));
		$url = str_replace("?currency=".$_GET['currency'], "", $url);
		header('Location: '.$url);
	}	
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<title><?php wp_title( ' ', true, 'right' );  ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
<link rel="apple-touch-icon-precomposed" href="">
<meta name="format-detection" content="telephone=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link href="<?php bloginfo( 'template_url' ); ?>/style.css" rel="stylesheet">
<link href="<?php bloginfo( 'template_url' ); ?>/lightbox.css" rel="stylesheet">
<link href="<?php bloginfo( 'template_url' ); ?>/mobile.css" rel="stylesheet" media="screen and (max-width:640px)" /><!-- 2015-06-11 -->
<script src="<?php bloginfo( 'template_url' ); ?>/js/jquery.min.js"></script>
<script src="<?php bloginfo( 'template_url' ); ?>/js/lightbox.min.js"></script>
<script src="<?php bloginfo( 'template_url' ); ?>/js/owl.carousel.js"></script>
                    <link href="<?php bloginfo( 'template_url' ); ?>/style-combination-sale.css"  rel="stylesheet">
<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/custom_service.js"></script>
<!--[if lt IE 9]>
<script src="<?php bloginfo( 'template_url' ); ?>/js/html5.js"></script>
<![endif]-->
<?php query_posts(array( 'post_type' => '3code','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') );  while (have_posts()) : the_post();?><?php the_field('3code_gw'); ?><?php endwhile; wp_reset_query();  ?>
<link rel="shortcut icon" href="<?php echo home_url(); ?>/favicon.ico" />
<?php wp_head();?>
					<script type="text/javascript" >
					$(function(){
						
						$('.product-buy').each(function(){
							var t=$(this).find('.ipt-qty')
							   
  $(this).find(".btn-plus").click(function () {
	   t.val(parseInt(t.val())+1)
   })
   $(this).find('.btn-minus').click(function(){
     if(t.val()>=2){
        t.val(parseInt(t.val())-1)
	 }
   })
							
							})

   
   })
 
                    
                    
                    </script>
        </head>
        <body style="background:#ffffff;overflow-x:hidden;">
		<input type="hidden" id="combination-sale-ids" name="combination-sale-ids" value="<?php echo $ids;?>"/>
            <section class="combination-sale">
                <div class="clearfix">

                        <div class="related-list ">
                            <ul class="related-list-ul">
<?php
$eshop_combination_sale_ids_arr=explode(',',$ids);
foreach($eshop_combination_sale_ids_arr as $postid){
	$post->ID =$postid;
	$form[$postid] = eshop_boing_combination_product($pee,$short='no',$postid);
}
$k=1;
$eshop_combination_product = query_posts(array('post__in' => $eshop_combination_sale_ids_arr));
while (have_posts()):the_post();
$product=get_post_meta($post->ID,'_eshop_product');			
$post->saleprice=get_currency_price($product[0][products][1][saleprice]);
$post->price=get_currency_price($product[0][products][1][price]);
?>
                                <li class="related-list-li" style="padding:10px;">
                                    <div class="pd-img" style="padding-right:5px;"><a href="<?php the_permalink() ?>"><img src="<?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "thumbnail");echo $img_src[0];?>" alt="<?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 300,"..."); ?>"></a><span class="pd-name"><a href="<?php the_permalink() ?>"><?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 50,"..."); ?></a></span><div class="pd-price"><p><del><?php echo get_currency_symbol();?> <i><?php echo $post->price?></i></del></p><p><b><?php echo get_currency_symbol();?> <i><?php echo $post->saleprice?></i></b></p></div></div>
                                    <div class="pd-info">
                                        <?php echo $form[$post->ID]?>
										<iframe name="_hiddenframe<?php echo $post->ID;?>" style="display:none;"></iframe>
                                    </div>
                                </li>
<?php
if($k%2==0){
	echo '<div class="clearfix"></div>';
}
$k++;
endwhile;
wp_reset_query();
?>
                            </ul>
                        </div>                        
                </div>
            </section>
			<!-- js for product -->
<script>
(function($){

	   
   $(function(){
	   //定义商品时间
	   countDown("<?php the_field('djs_time'); ?> 23:59:59",".goods-time-count .day",".goods-time-count .hour",".goods-time-count .minute",".goods-time-count .second");
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
			$('.goods-time-count p').css({'display':'inline-block'})
		} else { 
			clearInterval(timer);
			$('.goods-time-count').html('')
		}
		$('.goods-time-count .time-coming').remove()
	}, 1000);
	}
	

   $('.goods-time-count').append("<span class='time-coming'></span>")

   $(document).ready(function(){
	//下拉框--选择第二项,展示自定义
	$('.select-with-custom').change(function(){
	   if(this.selectedIndex==1){   
		  $(this).parents('.form-item').find('.custom-form').show() 
	   }
	   else{
		  $(this).parents('.form-item').find('.custom-form').hide()		   
	   }
	})
   })



$(document).ready(function(){
//价格变动
$(function(){
var triggerBind = $(function(){
	$('body').append('<div style="display:none" class="price-add-list"></div><div style="display:none" class="mkt-price-add-list"></div>')		
	$(".product-shop .form-item").each(function(){
		var i=$(this);
		var p=$(this).find('.price-change');
		function getobjVal(){}
		p.change(function(){
			i.attr("data-attrval",$(this).attr("value"))
			if($(this).parents('dl').hasClass('check-item')){
			   if(!$(this).parents('.check-item').find('input[type="checkbox"]').is(':checked')){
			      $(this).parents('.form-item').attr("data-attrval",0)
		  	   }
			}
			getattrprice()
		})
		p.click(function(){
			p.attr("data-attrval",$(this).attr("value"));
			$("#bigImg").attr({ src: $(this).attr("data-img") });
			$("#bigImg").attr({ jqimg: $(this).attr("data-img") });
			if($(this).parents('dl').hasClass('check-item')){
			   if(!$(this).parents('.check-item').find('input[type="checkbox"]').is(':checked')){
			      $(this).parents('.form-item').attr("data-attrval",0)
		  	   }
			}		
			getattrprice()
		})
	})
	var oldPrice=$('.old-price i').html()
	var curPrice=$('.special-price i').html()
	function getattrprice(){
		var defaultstats=true;
		var _val='';
		var _resp={
			mktprice:".old-price i",
			price:".special-price i"
		}
		$('.price-add-list li,.mkt-price-add-list li').remove()
	   $(".product-shop .form-item").each(function(){
			var i=$(this);
			var v=i.attr("data-attrval");
			if(!v){
				defaultstats=false;				
			}else{
				_val=v;
				$('.price-add-list').append('<li>'+(parseInt(sys_item['sys_attrprice'][_val]['price'])).toFixed(2)+' '+'</li>')			
				$('.mkt-price-add-list').append('<li>'+(parseInt(sys_item['sys_attrprice'][_val]['mktprice'])).toFixed(2)+' '+'</li>')			
			}
		})
		
		var addPrice=0
		$('.price-add-list li').each(function(){
		   addPrice = addPrice + parseInt($(this).text());
		})
		var addMktPrice=0
		$('.mkt-price-add-list li').each(function(){
		   addMktPrice = addMktPrice + parseInt($(this).text());  
		})
		
	   _mktprice=(parseFloat(addMktPrice)+parseFloat(oldPrice)).toFixed(2);
	   _price=(parseFloat(addPrice)+parseFloat(curPrice)).toFixed(2);

		$(_resp.mktprice).text(_mktprice);
		$(_resp.price).text(_price);
	}
	
	//单选框美化
	$('.color-list li,.size-list li').each(function(){
	   if($(this).find('input:checked').length>0){
	      $(this).addClass('checked');
	   }
	   $(this).click(function(){
	      if($(this).find('input').is(':checked')){
	         $(this).addClass('checked').siblings().removeClass('checked');
			 var cat = $(this).attr('data-cat');
			 var relate = $(this).attr('data-relate');
			 var val = $(this).attr('data-val');
			 var in_html='';
			 if(relate!=''){				 
				 $("#form_item_"+relate+"_all").html('');
				 var show_style=$("#form_item_"+relate+"_all").attr('data-style');
				 if(show_style=='select'){
					 in_html += '<dl> <dt>'+relate+': </dt> <dd><div class="select-box change-item"><select id="a'+name_str+'" name="diy_option['+relate+']" class="select-size select-with-custom price-change select-require"><option value="0">--- Please Select ---</option>';
					for(var k in relate_json[cat][val][relate]){
						var name_str = relate_json[cat][val][relate][k];
						var name_arr = name_str.split("@"); 
						in_html += '<option value="'+name_str+'">'+name_arr[0]+'</option>';
					}					
					 in_html += '</select></div><div class="form-error-msg"> --- Please Select ---</div> </dd></dl>';
					 $("#form_item_"+relate+"_all").append(in_html);
				     $('.select-box select').dropkick();
				 }else if(show_style=='checkbox'){
					in_html += '<dl> <dt>'+relate+': </dt> <dd><ul class="check-require tags-for-color">';
					for(var k in relate_json[cat][val][relate]){
						var name_str = relate_json[cat][val][relate][k];
						var name_arr = name_str.split("@"); 
						in_html += '<li><input class="price-change" type="radio" value="'+name_str+'" id="a'+name_str+'" name="diy_option['+relate+']" data-attrval="'+name_str+'"><label for="a'+name_str+'"> <span class="size-value">'+name_arr[0]+'</span> <b class="ico-tick"> </b></label> </li>';
					}					
					 in_html += '</ul><div class="form-error-msg"> --- Please Select ---</div> </dd></dl>';
					 $("#form_item_"+relate+"_all").append(in_html);
				 }else{
					 in_html += '<dl> <dt>'+relate+': </dt> <dd><ul class="size-list check-require tags-for-color">';
					for(var k in relate_json[cat][val][relate]){
						var name_str = relate_json[cat][val][relate][k];
						var name_arr = name_str.split("@"); 
						in_html += '<li><input class="price-change" type="radio" value="'+name_str+'" id="a'+name_str+'" name="diy_option['+relate+']" data-attrval="'+name_str+'"><label for="a'+name_str+'"> <span class="size-value">'+name_arr[0]+'</span> <b class="ico-tick"> </b></label> </li>';
					}					
					 in_html += '</ul><div class="form-error-msg"> --- Please Select ---</div> </dd></dl>';
					 $("#form_item_"+relate+"_all").append(in_html);
				 }				 
					var i=$("#form_item_"+relate+"_all");
					var p=$("#form_item_"+relate+"_all").find('.price-change');
					function getobjVal(){}
					p.change(function(){
						i.attr("data-attrval",$(this).attr("value"))
						if($(this).parents('dl').hasClass('check-item')){
						   if(!$(this).parents('.check-item').find('input[type="checkbox"]').is(':checked')){
							  $(this).parents('.form-item').attr("data-attrval",0)
						   }
						}
						getattrprice()
					})
					p.click(function(){
						$(this).parents('li').addClass('checked');
						$(this).parents('li').addClass('checked').siblings().removeClass('checked');
						p.attr("data-attrval",$(this).attr("value"));
						$("#bigImg").attr({ src: $(this).attr("data-img") });
						$("#bigImg").attr({ jqimg: $(this).attr("data-img") });
						if($(this).parents('dl').hasClass('check-item')){
						   if(!$(this).parents('.check-item').find('input[type="checkbox"]').is(':checked')){
							  $(this).parents('.form-item').attr("data-attrval",0)
						   }
						}		
						getattrprice()
					})
			 }
	      }
		  else{
	         $(this).removeClass('checked')
		  }		
	   })
	})
	
	//客户自定义商品参数-单选框
	$('.radio-custom-set').click(function(){
	   if($(this).find('input:checked').length>0){
	      $(this).prevAll().find('input[type="radio"]').attr({
			  'checked':false,
			  'disabled':'disabled'
		  })
		  $(this).prevAll().removeClass('checked')
		  $(this).prevAll().addClass('radio-disabled')
		  $(this).addClass('checked')
		  $(this).parents('.form-item').find('.custom-form').show()
	   }
	   else {
		  $(this).prevAll().removeClass('radio-disabled')
		  $(this).prevAll().find('input[type="radio"]').removeAttr("disabled")
		  $(this).removeClass('checked')
		  $(this).parents('.form-item').find('.custom-form').hide()
	   }
	})
	
  //弹出颜色图片
   $('.color-list li').each(function(){
	   if(!$(this).hasClass('radio-custom-set')){
	     var colorImg=$(this).find('.color-small-img img').data('big')
	     var colorName=$(this).find('.color-small-img img').data('name')
	     $(this).append('<div class="color-img-pop"><img src='+colorImg+'><span class="color-name">'+colorName+'</span></div>')
	     $(this).hover(function(){
	        $(this).toggleClass('z9999')
	     })
	   }
   })	
   
   
 //浮动小图 
	$('.tags-for-color li').each(function(){
	   if(typeof($(this).find('.size-value').attr("data-big"))!="undefined" && typeof($(this).find('.size-value').attr("data-name"))!="undefined" && !$(this).hasClass('radio-custom-set')){
	     var colorImg=$(this).find('.size-value').data('big')
	     var colorName=$(this).find('.size-value').data('name')
	     $(this).append('<div class="color-img-pop"><img src='+colorImg+'><span class="color-name">'+colorName+'</span></div>')
	     $(this).hover(function(){
	        $(this).toggleClass('z9999')
	     })
	   }		
	})	
	
		
})
})
})//ready	




   //必填(商品参数)
   $('.add-to-cart').click(function(){
	var requireNum=0;
	$(this).parents('form').find("input.ipt-require").each(function(n){
		if($(this).val()=="")
		{
			requireNum++;
			$(this).parents('dl').find('.form-error-msg').show()
		}
		else{
			$(this).parents('dl').find('.form-error-msg').hide()		
		}
	});
	$(this).parents('form').find("input.ipt-require").blur(function(){
		if($(this).val()=="")
		{
			requireNum++;
			$(this).parents('dl').find('.form-error-msg').show()
		}
		else{
			$(this).parents('dl').find('.form-error-msg').hide()		
		}
	});
	
	$(this).parents('form').find(".check-require").each(function(n){
		if($(this).find('input:checked').length<1)
		{
			requireNum++;
			$(this).parents('dl').find('.form-error-msg').show()
		}
		else{
			$(this).parents('dl').find('.form-error-msg').hide()		
		}
	});
	$(this).parents('form').find(".check-require").click(function(){
		if($(this).find('input:checked').length<1)
		{
			requireNum++;
			$(this).parents('dl').find('.form-error-msg').show()
		}
		else{
			$(this).parents('dl').find('.form-error-msg').hide()		
		}
	});	
	
	
	$(this).parents('form').find('.select-require').each(function(){
	  if($(this).val()==$(this).find("option:first").val()){
		  requireNum++
		  $(this).parents('.form-item').find('.form-error-msg').show()
	   }
	   else {
		  $(this).parents('.form-item').find('.form-error-msg').hide()
	   }
	 })
	 $(this).parents('form').find('.select-require').change(function(){
	  if($(this).val()==$(this).find("option:first").val()){
		  $(this).parents('.form-item').find('.form-error-msg').show()
	   }
	   else {
		  $(this).parents('.form-item').find('.form-error-msg').hide()
	   }		 
	 })
	 	 
	if(requireNum>0 )
	{
		return false;
	}
	else{
		return true;
	}	 
	})


})(jQuery);

//reset form
$(window).load(function() {
   $('.product-shop form')[0].reset()
});
</script> 
<!--// js for product -->

			
        </body>
    
    </html>