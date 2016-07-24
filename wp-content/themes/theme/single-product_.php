<?php get_header();?>
<?php
$product=get_post_meta($post->ID,'_eshop_product');
$pid=$post->ID;			
$post->saleprice=get_currency_price($product[0][products][1][saleprice]);
$post->price=get_currency_price($product[0][products][1][price]);
$eshop_combination_sale_ids=get_post_meta($post->ID,'_eshop_combination_sale_ids',true);
$eshop_whs_data=maybe_unserialize(get_post_meta( $post->ID, '_eshop_whs',true ));
$eshop_rolesprice_data=maybe_unserialize(get_post_meta( $post->ID, '_eshop_rolesprice',true ));
$stkav = get_post_meta($post->ID, '_eshop_stock', true);
$post->option=$product[0][products][1][option];
?>
<script type="text/javascript">
var relate_json = new Array();
</script>
<section class="layout">
   <nav class="path-bar">
      <ul class="path-nav">
         <li><?php if(function_exists('cmp_breadcrumbs')) cmp_breadcrumbs();?></li>
      </ul>
   </nav>
</section>

<section class="layout">
   <section class="detail-wrap">
      
      <!-- product info -->
      <section class="product-intro">
         <div class="product-view">
            <!-- small img -->
            <div class="small-img-wrap">
               <a class="small-btn-prev" href="javascript:"><b></b></a>
               <div class="small-img-scroll">
                <ul>
<?php 
$images = get_field('product_gallery');
if( $images ): ?>
<?php foreach( $images as $image ): ?>
                <li>
                <a class="small-img-item" href="javascript:" target="_self">
                   <img src="<?php echo $image['sizes']['thumbnail']; ?>" src_big="<?php echo $image['url']; ?>" src_mid="<?php echo $image['url']; ?>">
                </a>
                </li>
<?php endforeach; ?>
<?php endif; ?>
                </ul>
               </div>
               <a class="small-btn-next" href="javascript:"><b></b></a>                        
            </div>
            <!--// small img end -->
            <div class="product-img jqzoom">
<?php $images = get_field('product_gallery'); if( $images ): for($x=0;$x<1; $x++){ ?>
<img id="bigImg" style="cursor:pointer" src="<?php echo $images[0]['url']; ?>" jqimg="<?php echo $images[0]['url']; ?>" alt="<?php wp_title(); ?>" />
<?php } endif; ?>
            </div>
					             <div class="share-this"><div class="addthis_sharing_toolbox"></div><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-542380e974172b9d" async="async"></script></div>

         </div>

         <section class="product-summary">
            <h1 class="product-title"><?php wp_title(); ?></h1>
            <div class="product-meta">
               <span class="product-id">Item ID: <?php the_ID(); ?> - SKU: <?php echo $post->option; ?> - <?php if ( $stkav < '1' ) : ?><span>Out of Stock</span><?php else: ?><span>In Stock</span><?php endif; ?></span>
			   <?php if( get_field('yes_reviews') ){ ?><div class="review-wrap"><?php if(function_exists('the_ratings')) { echo expand_ratings_template('<span>%RATINGS_IMAGES%</span>', get_the_ID()); } ?> <span> Reviews(<?php echo Reviews_num();?>)</span></div><?php } ?>
            </div>
            <div class="price-bar">
               <div class="price-info">
                  <?php if( get_field('yes_price') ){ ?><span class="old-price"><?php echo get_currency_symbol();?><i class="sys_item_mktprice"><?php echo number_format($post->price,2)?></i></span><?php } ?>

                  <span class="special-price"><?php echo get_currency_symbol();?><i class="sys_item_price"><?php echo number_format($post->saleprice,2);?></i></span>
                 <?php if( get_field('yes_price') ){ ?><span class="discount">(<b></b><i>%</i> <em>off</em>)</span><?php } ?>
				 
				 <?php 
				 if( is_user_logged_in()){
			    foreach($eshop_rolesprice_data as $rolesprice){
					if($rolesprice['user_roles'] == $current_user->roles[0]){
				?>
				 <p style="color:red"><?php echo $rolesprice['user_roles']?> Customer,Will Get <b style="color:blue"><?php echo get_currency_symbol();?> <?php echo number_format(get_currency_price($rolesprice['price']),2)?></b> again when you add to your cart</p>
				 <?php 
				   }
				     }
				 }
				 ?>
               </div>
			  <?php if (is_array($eshop_whs_data)){?>
			   <div class="wholesale-info">			   
			   <div id="" class="wholesale-title">
				Wholesale Price:
			   </div>
			   <div id="" class="wholesale-price-info">
				    <table border="1" bordercolor="#ccc" style="border-collapse:collapse;">
						<tr>
							<th width="60">Qty</th>	<th width="60">Price</th>
						</tr>
						<?php foreach($eshop_whs_data as $v){?>
						<tr>
							<td align="center"><?php echo $v['qty_start'];?>-<?php echo $v['qty_end'];?></td>	<td><?php echo get_currency_symbol();?><?php echo number_format(($post->saleprice+$v['price']),2);?></td>
						</tr>
						<?php }?>
				    </table>
			   </div>
			   </div>
			   <?php }?>
               <?php if( get_field('yes_djs') ){ ?><div class="goods-time-count">
               <p><em class="day"></em> day <span class="hour"></span>:<span class="minute"></span>:<span class="second"></span></p>
               </div><?php } ?>
            </div>
    


<?php if ( $stkav < '1' ) : ?>
<div class="clear"></div><br /><span style="font-weight:bold;color:red;font-size:16px;">Out of Stock</span>
<?php else: ?>
	<section class="product-shop">

<script>
$(document).ready(function(){
$('form.addtocart').appendTo('.product-shop')
})
</script>
<script>
$(document).ready(function(){
$('.wishlist_display').appendTo('.wishlist_show')
})
</script>
<div class="wishlist_display">
<?php if( is_user_logged_in() ) : ?>
<?php wpfp_link() ?>
<?php else: ?>
<a class="add-to-wishlist" href="<?php echo home_url(); ?>/register" title="Please Register" rel="nofollow">Login to Add Wishlist</a></li>
<?php endif; ?>
</div>
            </section><?php endif; ?>
			<hr>
<?php query_posts(array( 'post_type' => 'productitems','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>
<?php the_field('add_cart_info'); ?>
<?php endwhile; wp_reset_query();  ?>
			

         </section>
      </section>
      
      <?php if($eshop_combination_sale_ids):?>
<link href="<?php echo home_url(); ?>/wp-content/plugins/eshop/js/dialog.css" rel="stylesheet" />
<script src="<?php echo home_url(); ?>/wp-content/plugins/eshop/js/dialog.min.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/stringOperate.js"></script> 
<input type="hidden" id="combination_sale_ids" name="combination_sale_ids" value='<?php echo $post->ID?>'/>
      <section class="goods-related">
         <div class="detail-tbar">
            <h2 class="current">Frequently Bought Together With</h2>
         </div>
         <div class="clearfix">
            <div class="current-goods">
               <img src="<?php $images = get_field('product_gallery'); if( $images ): for($x=0;$x<1; $x++){ ?><?php echo $images[0]['sizes']['thumbnail']; ?><?php } endif; ?>" alt="Frequently Bought Together With <?php wp_title(); ?>">
            </div>
            <span class="icon-add"></span>
            <div class="related-list">
               <ul>
 
<?php
$eshop_combination_sale_ids_arr=explode(',',$eshop_combination_sale_ids);
query_posts(array('post__in' => $eshop_combination_sale_ids_arr));
while (have_posts()):the_post();
$product=get_post_meta($post->ID,'_eshop_product');			
$post->saleprice=get_currency_price($product[0][products][1][saleprice]);
$post->price=get_currency_price($product[0][products][1][price]);
?>
    <li><div class="pd-img">               <a href="<?php the_permalink() ?>">
                 <img src="<?php $images = get_field('product_gallery'); if( $images ): for($x=0;$x<1; $x++){ ?><?php echo $images[0]['sizes']['thumbnail']; ?><?php } endif; ?>" alt="<?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 300,"..."); ?>">
               </a></div><span class="pd-name"><a href="<?php the_permalink() ?>"><?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 50,"..."); ?></a></span>
			   <div class="pd-price"><p><del><?php echo get_currency_symbol();?> <i><?php echo number_format($post->price,2);?></i></del></p><p><input type="checkbox" name="combination_sale_checkbox" value ="<?php echo $post->ID;?>"><b><?php echo get_currency_symbol();?> <i><?php echo number_format($post->saleprice,2);?></i></b></p></div>
			   
			   
			   </li>
<?php
endwhile;
wp_reset_query();
?>
                </ul>
            </div>
            <section class="buy-act">
               <a class="buy-together" href="javascript:Buy_Together();">Buy Together</a>
            </section>
         </div>
      </section>
<script type="text/javascript">
<!--
    function Jump_to_cart(){
		window.location.href="<?php echo home_url(); ?>/shopping-cart";
	}
    var combination_sale = function() { 
		if ($(this).attr("checked") == "checked") { 
			var val = StringOperate.add($("input[name='combination_sale_ids']").val(),$(this).val());  
            $("input[name='combination_sale_ids']").val(val); 
		}else { 
		    var val = StringOperate.remove($("input[name='combination_sale_ids']").val(),$(this).val());  
            $("input[name='combination_sale_ids']").val(val);  
		} 
	} 
	function Buy_Together(){
       var ids = $("input[name='combination_sale_ids']").val();
	   var postid = '<?php echo $pid;?>'; 
	   if(ids==postid){
		   alert('Please Choose A Product At Least');
		   return;
	   }
	    var a = dialog({
			title: 'Add to shopping cart success',
            content: '<a href="<?php echo home_url(); ?>/shopping-cart"><span style="color:#cb2027;font-weight:bold;">View shopping cart</span></a>',
			okValue: 'Close',
			ok: function () {
				a.close();
			}
		});
		var b = dialog({
			id:"Buy_Together",
			zIndex: 5555,
			title: "Buy Together",
			width:820,
			height:400,
			url: "<?php echo home_url(); ?>/page-combination-sale?ids="+ids,
			okValue: 'Add to shopping cart',
			ok: function () {
				var ids =$("#combination_sale_ids").val();
				var ids_arr = ids.split(",");
				for (i=0;i<ids_arr.length ;i++ ) 
				{ 
				   $("#Buy_Together").contents().find("form[id='eshopprod"+ids_arr[i]+"_post']").submit();
				}
				b.close();
				a.showModal();
				return false;
			},
			cancelValue: 'Cancel',
			cancel: function () {}
		 });
		b.show();
	}
$(document).ready(function(){
  $("input[name='combination_sale_checkbox']").click(combination_sale); 
});
//-->
</script>
<?php endif; ?>   
      
      
     <section class="product-detail">
         <div class="detail-tabs">
            <h2 class="current">Product Detail</h2>
<?php query_posts(array( 'post_type' => 'productitems','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>
<?php if( get_field('shipping_guide') ){ ?><h2>Shipping Guide</h2><?php } ?>
<?php if( get_field('delivery_time') ){ ?><h2>Delivery Time</h2><?php } ?>
<?php if( get_field('return_policy') ){ ?><h2>Return Policy</h2><?php } ?>
<?php endwhile; wp_reset_query();  ?>
            <h2>Product Tags</h2>
         </div>
         <section class="entry detail-panel">
<?php while ( have_posts() ) : the_post(); ?>
<?php the_content(); ?> 
<?php endwhile; ?>
<div class="clear"></div>
<hr>
<?php if( get_field('yes_products_img') ){ ?>
<div class="products-img entry">
<?php 
$images = get_field('product_gallery');
if( $images ): ?>
        <?php foreach( $images as $image ): ?>
		<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"><br />
        <?php endforeach; ?>
<?php endif; ?>
</div>
<?php } ?>


         </section>

<?php query_posts(array( 'post_type' => 'productitems','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>
<?php if( get_field('shipping_guide') ){ ?><section class="entry detail-panel disabled"><?php the_field('shipping_guide'); ?></section><div class="clear"></div><?php } ?>
<?php if( get_field('delivery_time') ){ ?><section class="entry detail-panel disabled"><?php the_field('delivery_time'); ?></section><div class="clear"></div><?php } ?>
<?php if( get_field('return_policy') ){ ?><section class="entry detail-panel disabled"><?php the_field('return_policy'); ?></section><div class="clear"></div><?php } ?>
<?php endwhile; wp_reset_query();  ?>
         <section class="detail-panel disabled">Tags: <?php the_tags(); ?></section>
		 
      </section>

		
      <section class="goods-may-like">
         <div class="detail-tbar">
            <h2 class="current">Customers Also Bought:</h2>
         </div>
         <section class="goods-items">
<?php
$post_num = 8;
$exclude_id = $post->ID;
$posttags = get_the_tags(); $i = 0;
if ( $posttags ) {
	$tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->term_id . ',';
	$args = array(
		'post_status' => 'publish',
		'tag__in' => explode(',', $tags),
		'post__not_in' => explode(',', $exclude_id),
		'caller_get_posts' => 1,
		'orderby' => 'comment_date',
		'posts_per_page' => $post_num,
	);
	query_posts($args);
	while( have_posts() ) { the_post(); $product=get_post_meta($post->ID,'_eshop_product');			
$post->saleprice=get_currency_price($product[0][products][1][saleprice]);
$post->price=get_currency_price($product[0][products][1][price]);?>
            <div class="goods-item">
               <div class="goods-img">
               <a href="<?php the_permalink() ?>">
                 <img src="<?php $images = get_field('product_gallery'); if( $images ): for($x=0;$x<1; $x++){ ?><?php echo $images[0]['sizes']['thumbnail']; ?><?php } endif; ?>" alt="<?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 300,"..."); ?>">
               </a>
               </div>
               <div class="goods-price">
                  
				 <?php if( get_field('yes_price') ){ ?><del><span><?php echo get_currency_symbol();?><i><?php echo number_format($post->price,2);?></i></span></del><?php } ?>
                  <b><span><?php echo get_currency_symbol();?><i><?php echo number_format($post->saleprice,2);?></i></span></b>
               </div>
            </div>

	<?php
		$exclude_id .= ',' . $post->ID; $i ++;
	} wp_reset_query();
}
if ( $i < $post_num ) {
	$cats = ''; foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
	$args = array(
		'category__in' => explode(',', $cats),
		'post__not_in' => explode(',', $exclude_id),
		'caller_get_posts' => 1,
		'orderby' => 'comment_date',
		'posts_per_page' => $post_num - $i
	);
	query_posts($args);
	while( have_posts() ) { the_post(); $product=get_post_meta($post->ID,'_eshop_product');			
$post->saleprice=get_currency_price($product[0][products][1][saleprice]);
$post->price=get_currency_price($product[0][products][1][price]);?>
			
            <div class="goods-item">
               <div class="goods-img">
               <a href="<?php the_permalink() ?>">
                 <img src="<?php $images = get_field('product_gallery'); if( $images ): for($x=0;$x<1; $x++){ ?><?php echo $images[0]['sizes']['thumbnail']; ?><?php } endif; ?>" alt="<?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 300,"..."); ?>">
               </a>
               </div>
               <div class="goods-price">
               <h3 class="pd-name"><a href="<?php the_permalink() ?>"><?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 50,"..."); ?></a></h3>
                 
				 <?php if( get_field('yes_price') ){ ?><del><span><?php echo get_currency_symbol();?><i><?php echo number_format($post->price,2);?></i></span></del><?php } ?>
                  <b><span><?php echo get_currency_symbol();?><i><?php echo number_format($post->saleprice,2);?></i></span></b>
               </div>
            </div>			
			
			<?php $i++;
	} wp_reset_query();
}
if ( $i  == 0 )  echo '<li>No Related Products!</li>';
?>
	
			
			
			
			
			
         </section>
      </section> 
	  
	  
      
	  <section class="product-detail">
	           <div class="detail-tbar">
            <h2 class="current">Reviews<?php if( get_field('yes_reviews') ){ ?>(<?php echo Reviews_num();?>)<?php } ?></h2>
         </div>
	   <!-- comment -->
      <section class="comment-form">
        <?php comments_template(); ?>
      </section>
<!--// comment -->
	  </section>
      
     
   </section>
</section>
<script src="<?php bloginfo( 'template_url' ); ?>/js/view.js"></script>
<script src="<?php bloginfo( 'template_url' ); ?>/js/select-drop.js"></script>

<!-- js for product -->
<script>
(function($){

   //small image scroll
   $(".small-img-scroll").jCarouselLite({
		 btnPrev: ".small-btn-prev",
		 btnNext: ".small-btn-next",
		 speed:100,
		 auto:false,
		 scroll:1,
		 visible:5,
		 vertical:true,
		 circular:false,
		 onMouse:true
   });		
   
   //product slide
	$('.goods-may-like .goods-items').owlCarousel({
		autoplay:true,
		loop:true,
		margin:53,
		dots: false,
		nav: true,
		autoplayTimeout:30000,
		smartSpeed:180,
		items:7,
		slideBy:7
	});		
	
	   
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
   //下拉框美化
   $.fn.clicktoggle = function(a, b) {
	return this.each(function() {
		var clicked = false;
		$(this).click(function() {
			if (clicked) {
				clicked = false;
				return b.apply(this, arguments);
			}
			clicked = true;
			return a.apply(this, arguments);
		});
	});
   };
   $.fn.ready(function() {
    $('.select-box select').dropkick();
   });

	


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
				$('.price-add-list').append('<li>'+(parseFloat(sys_item['sys_attrprice'][_val]['price'])).toFixed(2)+' '+'</li>')			
				$('.mkt-price-add-list').append('<li>'+(parseFloat(sys_item['sys_attrprice'][_val]['mktprice'])).toFixed(2)+' '+'</li>')			
			}
		})
		
		var addPrice=0
		$('.price-add-list li').each(function(){
		   addPrice = addPrice + parseFloat($(this).text());
		})
		var addMktPrice=0
		$('.mkt-price-add-list li').each(function(){
		   addMktPrice = addMktPrice + parseFloat($(this).text());  
		})
		
	  var gNums =$('.ipt-qty').val()
	   _mktprice=(parseFloat(addMktPrice)+parseFloat(oldPrice)).toFixed(2);
	   _price=((parseFloat(addPrice)+parseFloat(curPrice))*gNums).toFixed(2);
		$(_resp.mktprice).text(_mktprice);
		$(_resp.price).text(_price);
				
		$('.product-summary').each(function(){ 
	   var curPrice=parseFloat($('.product-summary').find('.special-price i').text())
	   var oPrice=parseFloat($('.product-summary').find('.old-price i').text())  
	   if(curPrice<oPrice)
	   {
		  var discount=Math.round((1-curPrice/oPrice)*100)
		  $('.product-summary').find('.discount b').html(discount)
	   }
	   else{
		  $('.product-summary').find('.discount').hide()
	   } 
	})

	}
	
	//单选框美化
	$('.color-list li,.size-list li,.keyss-list li').each(function(){
	   var input = $(this).find('input');
	   var option = $(this).find('option');
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

<?php get_footer();?>