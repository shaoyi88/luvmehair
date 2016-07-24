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
    <?php get_sidebar(blog);?>
   <!--// aside end -->
   <!-- main begin -->
   <section class="main">
      <div class="main-tit-bar">
         <h1 class="title"><?php wp_title(); ?> </h1>
      </div>
      <article class="entry blog-article">
<?php while ( have_posts() ) : the_post(); ?>
<?php the_content(); ?> 
<?php endwhile; ?>
<hr>
         <div class="share-this"><div class="addthis_sharing_toolbox"></div><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-542380e974172b9d" async="async"></script></div>
Post time: <?php the_time('m-d-Y') ?>

      </article>
   </section>
   <!--// main end -->
</section>


<?php get_footer();?>