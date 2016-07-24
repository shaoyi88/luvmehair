<?php get_header();?>
<!--	<section class="slide-banners-wrap111">
<section class="slide-banners">
<ul class="slides">
<?php query_posts(array( 'post_type' => 'ad_img','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>
<?php $images = get_field('ad_index_banner'); if( $images ): foreach( $images as $image ): ?>
<div class="slide-item"><a href="<?php echo $image['alt']; ?>"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['description']; ?>" /></a></div>
<?php endforeach; endif; ?>
<?php endwhile; wp_reset_query();  ?>
</ul>
   </section>
    </section>-->
    <section class="slide-banners-wrap">
        <section class="slide-banners">
            <ul class="slides">
            <?php query_posts(array( 'post_type' => 'ad_img','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>
<?php $images = get_field('ad_index_banner'); if( $images ): foreach( $images as $image ): ?>
                <li class="slide-item" style="background-image:url(<?php echo $image['url']; ?>)"><a href="<?php echo $image['alt']; ?>"><img src="<?php echo $image['url']; ?>"></a></li>
               <?php endforeach; endif; ?>
<?php endwhile; wp_reset_query();  ?>
            </ul>        
        </section>
    </section>
    <section class="ideal-set">
        <section class="layout">
<?php query_posts(array( 'post_type' => 'ad_img','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>
             <h2 class="ideal-set-tit"><?php the_field('ad_banner_bottom_title'); ?></h2>
            <h3 class="ideal-set-sub-tit"><?php the_field('ad_banner_bottom_text'); ?></h3>
<?php endwhile; wp_reset_query();  ?>
            <section class="ideal-set-product">
<?php 
$args = array(
    'showposts' => 3, 
	'post_type' => 'post',
	'meta_query' => array(
	'relation' => 'OR',
		array(
			'key' => 'special',
			'value' => 'Feature Products',
			'compare' => 'LIKE'
		)
	)
);
$the_query = new WP_Query( $args );
?>
<?php if( $the_query->have_posts() ): ?>
<?php while ( $the_query->have_posts() ) : $the_query->the_post(); 
$product=get_post_meta($post->ID,'_eshop_product');			
$post->saleprice=get_currency_price($product[0][products][1][saleprice]);
$post->price=get_currency_price($product[0][products][1][price]);?>
                <div class="ideal-set-item">
                    <div class="ideal-set-item-wrap">
                        <h2 class="ideal-set-name"><a href="<?php the_permalink() ?>"><?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 60,"..."); ?></a></h2>
                        <div class="ideal-set-img"> 
						<a href="<?php the_permalink() ?>">
                 <img src="<?php $images = get_field('product_gallery'); if( $images ): for($x=0;$x<1; $x++){ ?><?php echo $images[0]['sizes']['thumbnail']; ?><?php } endif; ?>" alt="<?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 300,"..."); ?>">
                        </a></div>
                        <div class="ideal-set-price">
                  <?php if( get_field('yes_price') ){ ?><del><?php echo get_currency_symbol();?><i><?php echo number_format($post->price,2);?></i></del><?php } ?>                  
                  <b><?php echo get_currency_symbol();?><i><?php echo number_format($post->saleprice,2);?></i></b>                            
                        </div>
                        <a href="<?php the_permalink() ?>" class="ideal-set-view">VIEW ALL</a>
                    </div>
                </div>
<?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_query(); ?>
            </section>
        </section>
    </section>
    
    <section class="video-tuto-wrap">
        <section class="video-tuto">
        	<div class="video-tuto-titbar">
        		<h2 class="video-tuto-tit">Video Tutorials</h2>
                <h3 class="video-tuto-subtit"><a href="<?php echo home_url("/"); ?>video">BROWSE ALL VIDEO TUTORIALS</a></h3>
            </div>
            <div class="video-tuto-panel-wrap">
<?php 
$args = array(
    'showposts' => 1,
	'post_type' => 'video',
	'meta_query' => array(
	'relation' => 'OR',
		array(
			'key' => 'video_index',
			'value' => '首页大图展示调用',
			'compare' => 'LIKE'
		)
	)
);
$the_query = new WP_Query( $args );
?>
<?php if( $the_query->have_posts() ): ?>
<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
            <div class="video-tuto-panel">
            	<div class="video-tuto-big-pic"><a href="<?php the_permalink() ?>"><img src="<?php $image = get_field('video_img');if( !empty($image) ): ?><?php echo $image['url']; ?><?php endif; ?>" alt="<?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 100,"..."); ?>"></a></div>
                <div class="video-tuto-con">
                	<h3 class="video-tuto-con-title"><a href="<?php the_permalink() ?>"><?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 100,"..."); ?></a></h3>
                    <div class="video-tuto-con-detail"><?php the_field('video_text'); ?></div>
                </div>
            </div>
<?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_query(); ?>
            </div>
            <div class="video-tuto-tabs">
<?php query_posts(array( 'post_type' => 'video','showposts' => 3,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>
                <li><a href="<?php the_permalink() ?>"><div class="video-tuto-tabs-pic"><img src="<?php $image = get_field('video_img');if( !empty($image) ): ?><?php echo $image['url']; ?><?php endif; ?>" alt="<?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 100,"..."); ?>"></div><div class="video-tuto-tabs-text"><?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 100,"..."); ?></div></a></li>
<?php endwhile; wp_reset_query();  ?>
            </div>
        </section>
    </section>
    <section class="product-slides-wrap">
        <section class="layout">
            <div class="index-tit-bar">
              <h2 class="title">Best Sellers</h2>
           </div>
            <section class="product-slides">
			
			<?php 
$args = array(
    'showposts' => 99999, 
	'post_type' => 'post',
	'meta_query' => array(
	'relation' => 'OR',
		array(
			'key' => 'special',
			'value' => 'Best Sellers',
			'compare' => 'LIKE'
		)
	)
);
$the_query = new WP_Query( $args );
?>
<?php if( $the_query->have_posts() ): ?>
<?php while ( $the_query->have_posts() ) : $the_query->the_post(); 
$product=get_post_meta($post->ID,'_eshop_product');			
$post->saleprice=get_currency_price($product[0][products][1][saleprice]);
$post->price=get_currency_price($product[0][products][1][price]);?>
			
            	<div class="product-item">
                 <div class="item-wrap">
                    <div class="pd-img">              
					<a href="<?php the_permalink() ?>">
                 <img src="<?php $images = get_field('product_gallery'); if( $images ): for($x=0;$x<1; $x++){ ?><?php echo $images[0]['sizes']['thumbnail']; ?><?php } endif; ?>" alt="<?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 300,"..."); ?>">
               </a></div>
                    <div class="pd-info">
               <h3 class="pd-name"><a href="<?php the_permalink() ?>"><?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 50,"..."); ?></a></h3>
                       <div class="pd-price"><b><?php echo get_currency_symbol();?><i><?php echo number_format($post->saleprice,2);?></i></b></div>
                       <a href="<?php the_permalink() ?>" class="pd-cart"></a>
                       <a href="<?php the_permalink() ?>" class="pd-wishlist"></a>
                    </div>
                 </div>
              </div>
<?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_query(); ?>
              
                 
            </section>  
        </section>
    </section>
    <section class="banner-list-wrap">
<?php query_posts(array( 'post_type' => 'ad_img','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>
<?php $image = get_field('ad_index_01');if( !empty($image) ): ?><section class="banner-list" style="background-image:url(<?php echo $image['url']; ?>)">
             <li><a href="<?php echo $image['alt']; ?>"></a></li>
            <li><a href="<?php echo $image['alt']; ?>"></a></li>
</section><?php endif; ?>
<?php endwhile; wp_reset_query();  ?>
    </section>
    <section class="share-slide-wrap">
        <section class="layout">
        	<div class="share-title-bar">
            	<h2 class="share-title">Share Your New Looking With Us</h2>
                <!-- <a href="" class="shopping">SHOPPING NOW</a> -->
                <a href="<?php echo home_url("/"); ?>gallery" class="view-gallery">VIEW GALLERY</a>
            </div>
            <section class="share-slide">
			
<?php query_posts(array( 'post_type' => 'gallery','showposts' => 12,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>
            	<div class="share-item">
                	<div class="share-item-wrap">
                    	<div class="share-img"><a href="<?php the_permalink() ?>"><img src="<?php $images = get_field('gallery_img'); if( $images ): for($x=0;$x<1; $x++){ ?><?php echo $images[0]['sizes']['thumbnail']; ?><?php } endif; ?>" alt="<?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 200,"..."); ?>"></a></div>
                	</div>
                </div>
<?php endwhile; wp_reset_query();  ?>
				</section>
        </section>
    </section>
	
	<?php get_footer();?>