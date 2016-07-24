<?php
$product=get_post_meta($post->ID,'_eshop_product');			
$post->saleprice=get_currency_price($product[0][products][1][saleprice]);
$post->price=get_currency_price($product[0][products][1][price]);
?>
<?php get_header();?>

<section class="layout">
   <nav class="path-bar">
      <ul class="path-nav">
         <li><?php if(function_exists('cmp_breadcrumbs')) cmp_breadcrumbs();?></li>
      </ul>
   </nav>
</section>
<section class="layout">
  <?php get_sidebar(products);?>
   <!-- main begin -->
   <section class="main">
      <div class="main-tit-bar">
         <h1 class="title"><?php
$category_id = get_query_var('cat');
$category_link = get_category_link( $category_id );
if( is_category()){
	$cat = get_query_var('cat');
    $yourcat = get_category($cat);
	$str = attr($yourcat->term_id.'xiaoxixi');
	$arr = explode(',',$str); 
	$str1 = dopt('d_description');
	$arr1 = explode(',',dopt('d_description'));	
	foreach($arr as $xiao){ 
		if(in_array($xiao,$arr1)){
			$args = array(
			'taxonomy' =>$xiao
			);
			$terms = get_categories($args);
			$count = count($terms);
			$home_url = home_url();
			if ( $count > 0 && $xiao){ ?><?php
				if($_GET[$xiao]){
					$gets = $_GET;
					unset($gets[$xiao]);
					$gets = array_filter($gets);
					$get = make_get($gets);
					echo "";
					foreach ( $terms as $term ) {
						if($_GET[$xiao] == $term->slug)
						echo ''.$xiao.'(' . $term->name . ') - ';
					}
				}else{
					foreach ( $terms as $term ) {
						$gets = $_GET;
						$gets = array_filter($gets);
						$gets[$xiao] = $term->slug;
						$get = make_get($gets);
					}
				}
			} 
		}
	}
}
	?><?php wp_title(); ?> (<?php echo get_category($cat)->count; ?>)</h1>
         <div class="share-this"><div class="addthis_sharing_toolbox"></div><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-542380e974172b9d" async="async"></script></div>
      </div>   
      <section class="main-banner">
<?php if(z_taxonomy_image_url($cat->term_id)): ?> <img width="830px;" src="<?php echo z_taxonomy_image_url($cat->term_id); ?>" alt="<?php wp_title(); ?>"><?php endif; ?>
<?php echo category_description(get_the_category()->cat_ID); ?>
      </section>
      
<?php
$order=$_GET['order'];
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>
	  <section class="page-bar">
         <nav class="sort-by">
            <h5>Sorted By</h5>
            <ul>
               <li class="selected"><a href="<?php echo curPageURL();?>?order=pubtime">New<b class="arrow-down"></b></a></li>
               <li><a href="<?php echo curPageURL();?>?order=purchases">Sales<b class="arrow-down"></b></a></li>
               <li><a href="<?php echo curPageURL();?>?order=price">Price<b class="arrow-down"></b></a></li>
               <li><a href="<?php echo curPageURL();?>?order=pricea">Price<b class="arrow-up"></b></a></li>
            </ul>
         </nav>
         <div class="pages"><?php echo izt_pagenavi();?></div>
      </section>
      <section class="product-list">
         <ul>
<?php
   if($order=='pubtime'||$order=='price'||$order=='pricea'||$order=='purchases'||$order=='a_z'){
	   if($order=='pubtime'){
				$args = array(
				'cat'=>$cat_ID,
				'order'=>'ASC',
				'orderby' => 'date',
				'paged' => $paged
			);
			query_posts($args);
		}elseif($order=='a_z'){
				$args = array(
				'cat'=>$cat_ID,
				'order'=>'ASC',
				'orderby' => 'name',
				'paged' => $paged
			);
			query_posts($args);
		}else{
			$mpost = new WP_Query('cat='.$cat_ID.'&posts_per_page=-1');
            $posts_2 = $mpost->posts;
			foreach($posts_2 as $key=>$v){
				$eshop_product=get_post_meta($v->ID,'_eshop_product');
				$posts_2[$key]->saleprice=$eshop_product[0][products][1][saleprice];
				$eshop_stock= $wpdb->get_row("SELECT purchases FROM wp_eshop_stock WHERE post_id =".$v->ID);
				if(!$eshop_stock){
					$posts_2[$key]->purchases=0;
				}else{
					$posts_2[$key]->purchases=$eshop_stock->purchases;
				}		    
				$purchases[$key]  = $posts_2[$key]->purchases;
				$saleprice[$key] = $posts_2[$key]->saleprice;
			}
			if($order=='price'){
				array_multisort($saleprice, SORT_DESC, $posts_2);
			 }else if($order=='pricea'){
				array_multisort($saleprice, SORT_ASC, $posts_2);
			 }else if($order=='purchases'){
				array_multisort($purchases, SORT_ASC, $posts_2);
			 }
			$posts=array();
			$posts = array_slice($posts_2,($paged-1)*$posts_per_page,$posts_per_page);	 
		}
	}else{
		$args = array(
				'cat'=>$cat_ID,
				'meta_key' => '_listorder',
				'orderby'   => 'meta_value_num', 
				'order' => DESC,
				'paged' => $paged
			);
			query_posts($args);
	}
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
         <nav class="sort-by">
            <h5>Sorted By</h5>
            <ul>
               <li class="selected"><a href="<?php echo curPageURL();?>?order=pubtime">New<b class="arrow-down"></b></a></li>
               <li><a href="<?php echo curPageURL();?>?order=purchases">Sales<b class="arrow-down"></b></a></li>
               <li><a href="<?php echo curPageURL();?>?order=pricea">Price<b class="arrow-down"></b></a></li>
               <li><a href="<?php echo curPageURL();?>?order=price">Price<b class="arrow-up"></b></a></li>
            </ul>
         </nav>
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