<?php get_header();?>
<section class="layout">
 <nav class="path-bar">
          <ul class="path-nav">
             <h2>You are here: </h2>
         <li><?php if(function_exists('cmp_breadcrumbs')) cmp_breadcrumbs();?></li>            
          </ul>
       </nav>
     
	 
	     <section class="share-slide-wrap">
        <section class="layout">
        	<div class="share-title-bar">
            	<h2 class="share-title">Video</h2>
                <!-- <a href="" class="shopping">SHOPPING NOW</a> -->
            </div>
            <section class="share-slide1 ">
			
<?php while ( have_posts() ) : the_post(); ?>
            	<div class="share-item"  style="margin-right:10px; width:200px;height:113px;" >
                	<div class="share-item-wrap">
                    	<div class="share-img1"><a href="<?php the_permalink() ?>"><img width="200px;" src="<?php $image = get_field('video_img');if( !empty($image) ): ?><?php echo $image['url']; ?><?php endif; ?>" alt="<?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 200,"..."); ?>"></a></div>
                	</div>
                </div>
<?php endwhile; wp_reset_query();  ?>
				</section>
        </section>
    </section>
	 
	 
	 
    </section>

<?php get_footer();?>