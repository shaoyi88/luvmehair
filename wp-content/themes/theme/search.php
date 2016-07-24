<?php
$product=get_post_meta($post->ID,'_eshop_product');			
$post->saleprice=get_currency_price($product[0][products][1][saleprice]);
$post->price=get_currency_price($product[0][products][1][price]);
?>
<?php get_header();?>

<section class="layout">
   <nav class="path-bar">
      <ul class="path-nav">
 <li> <a itemprop="breadcrumb" href="http://www.luvmehair.com">Home</a></li><li> <a href="#"><?php wp_title(); ?></a></li>
      </ul>
   </nav>
</section>
<section class="layout">
  <?php get_sidebar(products);?>
   <!-- main begin -->
   <section class="main">
      <div class="main-tit-bar">
         <h1 class="title"><?php wp_title(); ?></h1>
      </div>   

      

      <section class="product-list">
         <ul>
<?php
   while (have_posts()) : the_post(); 
	        $product=get_post_meta($post->ID,'_eshop_product');			
	        $post->saleprice=get_currency_price($product[0][products][1][saleprice]);
            $post->price=get_currency_price($product[0][products][1][price]);
?>		 
            <li class="product-item">
              <div class="item-wrap">
            <div class="pd-img">
               <a href="<?php the_permalink() ?>">
                 <img src="<?php $images = get_field('product_gallery'); if( $images ): for($x=0;$x<1; $x++){ ?><?php echo $images[0]['sizes']['thumbnail']; ?><?php } endif; ?>" alt="<?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 300,"..."); ?>">
                 <?php $image = get_field('product_img_b');$size = 'thumbnail';$thumb = $image['sizes'][ $size ];if( !empty($image) ): ?><figure class="img-hover"><span><img src="<?php echo $thumb; ?>" alt="<?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 300,"..."); ?>"></span></figure><?php endif; ?>
               </a>
               <?php if( get_field('yes_price') ){ ?><span class="discount"><b></b><i>%</i><em>OFF</em></span><?php } ?>
            </div>
            <div class="pd-info">
               <h3 class="pd-name"><a href="<?php the_permalink() ?>"><?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 50,"..."); ?></a></h3>
               <div class="pd-price">
                  <?php if( get_field('yes_price') ){ ?><del><?php echo get_currency_symbol();?><i><?php echo number_format($post->price,2)?></i></del><?php } ?>
                  <b><?php echo get_currency_symbol();?><i><?php echo number_format($post->saleprice,2);?></i></b>
               </div>
               <?php if( get_field('yes_reviews') ){ ?><div class="pd-review"><?php if(function_exists('the_ratings')) { echo expand_ratings_template('<span>%RATINGS_IMAGES%</span>', get_the_ID()); } ?> <span>Reviews(<?php echo Reviews_num();?>)</span></div><?php } ?>
            </div>
         </div>
            </li>
<?php endwhile; wp_reset_query(); ?>  
         </ul> 
      </section>     
      <section class="page-bar">

         <div class="pages"><?php echo izt_pagenavi();?></div>
      </section>
   </section>
   <!--// main end -->
</section>
<!-- js for list -->
<script src="<?php bloginfo( 'template_url' ); ?>/js/marquee.js"></script>
<script src="<?php bloginfo( 'template_url' ); ?>/js/lazyload.js"></script>
<script>
(function($){ 
   $(document).ready(function(){
	 //aside image scroll
	 $('.products-scroll-list').kxbdSuperMarquee({
		isMarquee:true,
		isEqual:false,
		scrollDelay:20,
		direction:'up'
	 });	
   })
	// slide banner
	$('.slide-banners').owlCarousel({
		autoplay:true,
		loop:true,
		margin:0,
		nav: false,
		dots:true,
		smartSpeed:800,
		items:1
	});		
	$(function() {  
      //图片懒加载   
      $("img.lazy").lazyload({
	     loading:true,
	     effectspeed:200,
		 threshold:200,
	     effect:"fadeIn"
	  });
	});	
		
})(jQuery);
</script> 
<!--// js for list -->
<?php get_footer();?>