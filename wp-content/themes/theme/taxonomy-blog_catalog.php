<?php get_header();?>
<section class="layout">
   <nav class="path-bar">
      <ul class="path-nav">
         <li> <a itemprop="breadcrumb" href="<?php echo home_url(); ?>/">Home</a></li><li> <a href="<?php echo home_url(); ?>/blog">Blog</a></li><li> <a href="#"><?php wp_title(); ?></a></li>
      </ul>
   </nav>
</section>
<section class="layout">
   <!-- aside begin -->
    <?php get_sidebar(blog);?>
   <!--// aside end -->
   
   <!-- main begin -->
   <section class="main">
      <div class="main-tit-bar">
         <h1 class="title"><?php wp_title(); ?></h1>
         <div class="share-this"><div class="addthis_sharing_toolbox"></div><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-542380e974172b9d" async="async"></script></div>
      </div>
      <section class="blog-list">
         <ul>
<?php while ( have_posts() ) : the_post(); ?>
            <li class="blog-item">
               <a href="<?php the_permalink() ?>"><img class="blog-img" src="<?php $image = get_field('blog_img');if( !empty($image) ): ?><?php echo $image['url']; ?><?php endif; ?>" alt="<?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 200,"..."); ?>"></a>
               <div class="blog-tit"><a href="<?php the_permalink() ?>"><?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 200,"..."); ?></a></div>
               <div class="blog-meta">Post time: <?php the_time('m-d-Y') ?></div>
               <p class="blog-summary"><?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 300,"..."); ?><span class="readmore"><a href="<?php the_permalink() ?>">Read more <i>&raquo;</i></a></span></p>
            </li>
<?php endwhile; wp_reset_query();  ?>
         </ul>
      </section>
      <section class="page-bar">
         <div class="pages"><?php echo izt_pagenavi();?></div>
      </section>
   </section>
   <!--// main end -->
   
</section>
<!-- js for blog list -->
<script src="<?php echo home_url(); ?>/e-theme/js/marquee.js"></script>
<script>
(function($){ 
$(document).ready(function(){
	//aside image scroll
	$('.products-scroll-list').kxbdSuperMarquee({
		isMarquee:true,
		isEqual:false,
		scrollDelay:40,
		direction:'up'
	});	
})
})(jQuery);
</script>
<!--// js for blog list -->
   
<?php get_footer();?>