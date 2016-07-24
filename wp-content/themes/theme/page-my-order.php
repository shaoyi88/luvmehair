<?php
/*
Template Name: my order
*/
?>  
<?php if( is_user_logged_in() ) : ?>
<?php get_header();?>
<section class="layout">
   <nav class="path-bar">
      <ul class="path-nav">
         <li><a itemprop="breadcrumb" href="<?php echo home_url(); ?>/">Home</a></li><li><a href="#"><?php wp_title(); ?></a></li>
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

<iframe id="iframepage" style="overflow-x: hidden;" name="iframepage" src="<?php echo home_url(); ?>/wp-admin/profile.php?page=my-orders.php" height="700" width="100%" frameborder="0"></iframe>
 
      </article>
   </section>
   <!--// main end -->
</section>
<?php get_footer();?>
<?php else: ?>
<meta http-equiv="refresh" content="0;url=<?php echo home_url(); ?>/register">
<?php endif; ?> 