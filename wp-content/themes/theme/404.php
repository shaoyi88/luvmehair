<?php
file_put_contents(ESHOP_PATH.'rc_get_VERIFIED.txt', print_r($_GET, true));
file_put_contents(ESHOP_PATH.'rc_post_VERIFIED.txt', print_r($_POST, true));
?>
<?php get_header();?>
<section class="layout">
   <nav class="path-bar">
      <ul class="path-nav">
         <li> <a itemprop="breadcrumb" href="<?php echo home_url(); ?>/">Home</a></li><li> <a href="#"><?php wp_title(); ?></a></li>
      </ul>
   </nav>
</section>
<section class="layout">
   <!-- aside begin -->
    <?php get_sidebar(user);?>
   <!--// aside end -->
   <!-- main begin -->
   <section class="main">
      <div class="main-tit-bar">
         <h1 class="title"><?php wp_title(); ?> </h1>
         <div class="share-this"><div class="addthis_sharing_toolbox"></div><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-542380e974172b9d" async="async"></script></div>
      </div>
      <article class="entry blog-article">
The Page You Requested Seems To Be Missing, Please back to <a href="<?php echo home_url(); ?>/">Home</a>
      </article>
   </section>
   <!--// main end -->
</section>

<!-- js for blog -->
<script src="template/js/marquee.js"></script>
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
})(jQuery);
</script>
<!--// js for blog -->
<?php get_footer();?>