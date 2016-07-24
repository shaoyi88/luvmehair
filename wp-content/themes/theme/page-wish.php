<?php
/*
Template Name: wishlist
*/
?>  
<?php
$product=get_post_meta($post->ID,'_eshop_product');			
$post->saleprice=get_currency_price($product[0][products][1][saleprice]);
$post->price=get_currency_price($product[0][products][1][price]);
?>
<?php if( is_user_logged_in() ) : ?>
<?php get_header();?>
<section class="layout">
   <nav class="path-bar">
      <ul class="path-nav">
         <li><?php if(function_exists('cmp_breadcrumbs')) cmp_breadcrumbs();?></li>
      </ul>
   </nav>
</section>
<section class="layout">
  <?php get_sidebar(wish);?>
   <!-- main begin -->
   <section class="main">
      <div class="main-tit-bar">
         <h1 class="title"><?php wp_title(); ?></h1>
         <div class="share-this"><div class="addthis_sharing_toolbox"></div><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-542380e974172b9d" async="async"></script></div>
      </div>   


      <section class="product-list">
         <ul>
<?php $favorite_post_ids = wpfp_get_user_meta() ?>
		<?php if ($favorite_post_ids):
			$favorite_post_ids = array_reverse($favorite_post_ids);
			$post_per_page = 20;
			$page = intval(get_query_var('paged'));
			query_posts(array('post__in' => $favorite_post_ids, 'posts_per_page'=> $post_per_page, 'orderby' => 'post__in', 'paged' => $page)); ?>
<?php while ( have_posts() ) : the_post(); 
			$product=get_post_meta($post->ID,'_eshop_product');			
	        $post->saleprice=get_currency_price($product[0][products][1][saleprice]);
            $post->price=get_currency_price($product[0][products][1][price]);
							?>
            <li class="product-item">
              <div class="item-wrap">
            <div class="pd-img">
               <a href="<?php the_permalink() ?>">
                 <img src="<?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "thumbnail");echo $img_src[0];?>" alt="<?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 300,"..."); ?>">
                 <?php $image = get_field('2_img');$size = 'thumbnail';$thumb = $image['sizes'][ $size ];if( !empty($image) ): ?><figure class="img-hover"><span><img src="<?php echo $thumb; ?>" alt="<?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 300,"..."); ?>"></span></figure><?php endif; ?>
               </a>
               <?php if( get_field('yes_price') ){ ?><span class="discount"><b></b><i>%</i><em>OFF</em></span><?php } ?>
            </div>
            <div class="pd-info">
               <h3 class="pd-name"><a href="<?php the_permalink() ?>"><?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 50,"..."); ?></a></h3>
               <div class="pd-price">
                  <?php if( get_field('yes_price') ){ ?><del><?php echo get_currency_symbol();?><i><?php echo number_format($post->price,2);?></i></del><?php } ?>
                  <b><?php echo get_currency_symbol();?><i><?php echo number_format($post->saleprice,2);?></i></b>
               </div>

            </div>
         </div>
		 <center>>> <?php wpfp_link() ?> <<</center>
            </li>
			              
			<?php endwhile; ?>

			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else {
					$imageloc = get_bloginfo('template_directory');
					next_posts_link( __( '<div class="nav-previous"><img src="' . $imageloc . '/images/next.png"></div>', 'thisis' ) );
					previous_posts_link( __( '<div class="nav-next"><img src="' . $imageloc . '/images/previous.png"></div>', 'thisis' ) );
			}
			wp_reset_query();
		else: ?>
			<div class="entry-text">
				<?php echo $wpfp_options['favorites_empty']; ?>
			</div>
		<?php endif; ?>
         </ul>
	<?php wpfp_cookie_warning();wp_reset_postdata(); ?>
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
<?php else: ?>
<meta http-equiv="refresh" content="0;url=<?php echo home_url(); ?>/register">
<?php endif; ?>  