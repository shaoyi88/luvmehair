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
            	<h2 class="share-title">Video > <?php wp_title(); ?> </h2>
                <!-- <a href="" class="shopping">SHOPPING NOW</a> -->
            </div>
           
	<div class="entry">

	<?php the_field('video_youtube'); ?>
	<br />
	<?php the_field('video_text'); ?>
	
	
	
	</div>	   
		   
		   
		   
		   
		   
        </section>
    </section>
	 
	 
	 
    </section>

<?php get_footer();?>