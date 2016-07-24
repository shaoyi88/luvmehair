
	
    <footer class="foot-wrapper">
    	<section class="social-bar">
          <section class="social-layout">
          	<div class="subscribe">
                <h4>Newsletter</h4>
                <div class="subscribe-form">
<?php echo do_shortcode( '[contact-form-7 id="1046" title="Subscribe"]' ); ?>
                </div>
             </div>
            <div class="foot-social">
                <h4>Follow Us</h4>
                <ul>
<?php query_posts(array( 'post_type' => 'ad_img','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>
<?php $images = get_field('sns_gallery'); if( $images ): foreach( $images as $image ): ?>
<li><a href="<?php echo $image['alt']; ?>"><img height="20px" src="<?php echo $image['url']; ?>" alt="<?php echo $image['description']; ?>"></a></li>
<?php endforeach; endif; ?>
<?php endwhile; wp_reset_query();?> 
                </ul>
             </div>
          </section>
       </section>
	   
	   
	   
       	<section class="bottom-service">
          <section class="service-items">
             <nav class="service-item">
                <h3>Company Info</h3>
                <div class="service-hide">
                    <ul>
<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('menu' => 61, 'echo' => false)) ));?>
                    </ul>
                </div>
             </nav>
             <nav class="service-item">
                <h3>Customer Service</h3>
                <div class="service-hide">
                    <ul>
<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('menu' => 60, 'echo' => false)) ));?>
                    </ul>
                </div>
             </nav>
             <nav class="service-item">
                <h3>Payment & Shipping</h3>
                <div class="service-hide">
                    <ul>
<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('menu' => 305, 'echo' => false)) ));?>
                    </ul>
                </div>
             </nav>
             <nav class="service-item service-contact">
                <h3>Contact Us</h3>
                <div class="service-hide">
<ul>
<?php query_posts(array( 'post_type' => 'ad_img','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>
<?php if( get_field('ad_phone') ){ ?><li class="foot-tel"><?php the_field('ad_phone'); ?></li><?php } ?>
<?php if( get_field('ad_email') ){ ?><li class="foot-email">Email: <?php the_field('ad_email'); ?></li><?php } ?>
<?php if( get_field('ad_website') ){ ?><li class="foot-fax">Website: <?php the_field('ad_website'); ?></li><?php } ?>
<?php if( get_field('ad_ad') ){ ?><li class="foot-add">ADD: <?php the_field('ad_ad'); ?></li>        <?php } ?>                         
<?php endwhile; wp_reset_query();  ?>
</ul>
                </div>
             </nav>      
          </section>
      
   </section>
   		<section class="footer">
<?php query_posts(array( 'post_type' => 'ad_img','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>
<?php $image = get_field('ad_payimg');if( !empty($image) ): ?><div class="foot-img"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['description']; ?>"></div><?php endif; ?>
      <div class="copyright">
<?php the_field('ad_copyr'); ?> <?php the_field('3code_an'); ?> <?php the_field('3code_qt'); ?>
<?php endwhile; wp_reset_query();  ?></div>       </section>
    </footer>
    




<span style="display:none;" id="my_cart_items_get">
<?php display_my_cart_items(); ?>
</span>
<script type="text/javascript"> 
$(function() { 
	$("#my_cart_items").html($("#my_cart_items_get").html());	
});
</script>
<!--// online start -->
<aside class="scrollsidebar" id="scrollsidebar">
  <section class="side_content">
    <div class="side_list">
    	<header class="hd"><img src="<?php bloginfo( 'template_url' ); ?>/img/custom_service/title_pic.png" alt=""/></header>
        <div class="cont">
		<li><a class="email" href="<?php echo home_url(); ?>/contact-us">Send Email</a></li>
<?php query_posts(array( 'post_type' => 'skype','showposts' => 5,'orderby' => 'post_date','order'=> 'DESC') );  ?>
<?php while (have_posts()) : the_post();?>
		<li><a class="skype" href="skype:<?php the_field('skype_id'); ?>?chat"><?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 200,"..."); ?></a></li>
<?php endwhile; wp_reset_query();  ?>
	     </div>
<?php query_posts(array( 'post_type' => 'ad_img','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>
      <?php $image = get_field('ad_android');if( !empty($image) ): ?><div class="t-code"><a href="<?php echo $image['alt']; ?>"><img width="120px" src="<?php echo $image['url']; ?>" alt="<?php echo $image['description']; ?>"></a><br/><center>Android</center></div><?php endif; ?>
      <?php $image = get_field('ad_ios');if( !empty($image) ): ?><div class="t-code"><a href="<?php echo $image['alt']; ?>"><img width="120px" src="<?php echo $image['url']; ?>" alt="<?php echo $image['description']; ?>"></a><br/><center>IOS</center></div></div><?php endif; ?>
<?php endwhile; wp_reset_query();  ?>
        <div class="side_title">LiveChat<a  class="close_btn"><span>x</span></a></div>
    </div>
  </section>
  <div class="show_btn"></div>
</aside>
<script type="text/javascript"> 
$(function() { 
	$("#scrollsidebar").fix({
		float : 'right',
		durationTime : 400
	});
});
</script>
<?php wp_footer();?>
<script type="text/javascript">
/* <![CDATA[ */
var ratingsL10n = {"plugin_url":"http:\/\/<?php echo str_replace("http://", "",home_url()); ?>\/wp-content\/plugins\/wp-postratings","ajax_url":"http:\/\/<?php echo str_replace("http://", "",home_url()); ?>\/wp-admin\/admin-ajax.php","text_wait":"Please rate only 1 post at a time.","image":"stars","image_ext":"gif","max":"5","show_loading":"1","show_fading":"1","custom":"0"};
var ratings_mouseover_image=new Image();ratings_mouseover_image.src=ratingsL10n.plugin_url+"/images/"+ratingsL10n.image+"/rating_over."+ratingsL10n.image_ext;;
/* ]]> */
</script>
<script type="text/javascript" src="<?php echo home_url(); ?>/wp-content/plugins/wp-postratings/postratings-js.js?ver=1.63"></script>  
</section>
</body>
</html>