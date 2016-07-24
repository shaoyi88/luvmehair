 <!-- aside begin -->

   <aside class="aside">

      <section class="side-widget">

         <div class="side-tit-bar">

            <h4 class="side-tit">BLOG</h4>

         </div>

         <div class="side-cate side-hide">

            <ul>

<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('menu' => 68, 'echo' => false)) ));?>

            </ul>

         </div>

      </section>

<?php query_posts(array( 'post_type' => 'ad_img','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>

<?php $images = get_field('ad_sidebar_banner'); if( $images ): foreach( $images as $image ): ?>

      <div class="side-bn"><a href="<?php echo $image['alt']; ?>"><img width="207px;" src="<?php echo $image['url']; ?>" alt="<?php echo $image['description']; ?>  "/></a></div><br />

<?php endforeach; endif; ?>

<?php endwhile; wp_reset_query();  ?>       

   </aside>

   <!--// aisde end -->