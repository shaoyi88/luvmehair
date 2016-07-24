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
            	<h2 class="share-title">Gallery > <?php wp_title(); ?> </h2>
                <!-- <a href="" class="shopping">SHOPPING NOW</a> -->
            </div>
           
	<div class="products-img entry">

	<?php the_field('gallery_text'); ?>

<?php if( get_field('gallery_img') ){ ?>
	<hr>
<?php 
$images = get_field('gallery_img');
if( $images ): ?>
        <?php foreach( $images as $image ): ?>
		<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"><br /><br />
        <?php endforeach; ?>
<?php endif; ?>

<?php } ?>
	
	
	
	
	</div>	   
		   
		   
		   
		   
		   
        </section>
    </section>
	 
	 
	 
    </section>

<?php get_footer();?>