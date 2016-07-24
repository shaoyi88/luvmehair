 <!-- aside begin -->
   <aside class="aside">
<?php
$category_id = get_query_var('cat');
$category_link = get_category_link( $category_id );
if( is_category()){
	$cat = get_query_var('cat');
    $yourcat = get_category($cat);
	$str = attr($yourcat->term_id.'xiaoxixi');
	$arr = explode(',',$str); 
	$str1 = dopt('d_description');
	$arr1 = explode(',',dopt('d_description'));	
	if($arr[0]!=''){
?> 
<?php
}
}	
?>
      <section class="side-widget">
         <div class="side-tit-bar">
            <h4 class="side-tit"><?php
$category = get_the_category();
$parent = get_cat_name($category[0]->category_parent);
if (!empty($parent)) {
echo $parent;
} else {
echo $category[0]->cat_name;
}
?></h4>
         </div>
         <div class="side-cate side-hide">
            <ul>
<?php 
$category_id;

if(is_single()||is_category())   
{   
if(get_category_children($category_id)!= "" ) {
    echo wp_list_categories("child_of=".$category_id."&show_count =1&hierarchical=1&number=100&depth=10&hide_empty=0&title_li=&orderby=name&order=ASC");   
}  
else {
	if(get_category_children(get_category_root_id($category_id))!= "" ){   
	    echo wp_list_categories("child_of=".get_category_root_id($category_id). "&depth=100&hide_empty=0&title_li=&orderby=name&order=ASC");   
	}   
}
}
?>
             </ul>
         </div>
      </section>
	 <section class="side-widget narrow-by">
         <div class="side-tit-bar">
            <h4 class="side-tit">Narrow By</h4>
         </div>
         <div class="side-cont side-hide">
		 <ul class="narrow-list">	 
<?php
	foreach($arr as $xiao){ 
		if(in_array($xiao,$arr1)){
			$args = array(
			'taxonomy' =>$xiao
			);
			$terms = get_categories($args);
			$count = count($terms);
			$home_url = home_url();
			if ( $count > 0 && $xiao){ ?>
               <li>
                  <a href="#"><?php echo $xiao; ?></a>
						<?php		
				if($_GET[$xiao]){
					$gets = $_GET;
					unset($gets[$xiao]);
					$gets = array_filter($gets);
					$get = make_get($gets);
					echo "<ul>";
					foreach ( $terms as $term ) {
						if($_GET[$xiao] == $term->slug)
						echo '<li><a class="selected" title="Click to clear" href="'.$home_url.'/'.$yourcat->slug.$get.'">Currency: ' . $term->name . ' - Click to clear</a></li>
						';
					}
					echo "</ul>
               </li>";
				}else{

					echo "<ul>";
					foreach ( $terms as $term ) {
						$gets = $_GET;
						$gets = array_filter($gets);
						$gets[$xiao] = $term->slug;
						$get = make_get($gets);
						echo '<li><a href="'.$home_url.'/'.$yourcat->slug.$get.'">' . $term->name . '</a></li>';
					}
					echo "</ul>
               </li>";
				}
				echo '';
			} 
		}
	}
	?>
         </ul>
         </div>
</section>
     <!-- <section class="side-widget side-products">
         <div class="side-tit-bar">
            <h4 class="side-tit">Best Sellers</h4>
         </div>
         <div class="side-cont side-hide">
            <div class="products-scroll-list">
            <ul>
<?php 
$args = array(
	'numberposts' => -1,
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
               <li >
                  <a href="<?php the_permalink() ?>"><img width="180px;" src="<?php $images = get_field('product_gallery'); if( $images ): for($x=0;$x<1; $x++){ ?><?php echo $images[0]['sizes']['thumbnail']; ?><?php } endif; ?>" alt="<?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 200,"..."); ?>"></a>
                  <p><a href="<?php the_permalink() ?>"><?php echo mb_strimwidth(strip_tags(apply_filters('the_title',$post->post_title)), 0, 40,""); ?> - <?php echo get_currency_symbol();?><?php echo number_format($post->saleprice,2);?></a></p>
               </li>
<?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_query(); ?>
			</ul>
            </div>
         </div>
      </section> -->
<?php query_posts(array( 'post_type' => 'ad_img','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>
<?php $images = get_field('ad_sidebar_banner'); if( $images ): foreach( $images as $image ): ?>
      <div class="side-bn"><a href="<?php echo $image['alt']; ?>"><img width="207px;" src="<?php echo $image['url']; ?>" alt="<?php echo $image['description']; ?>  "/></a></div><br />
<?php endforeach; endif; ?>
<?php endwhile; wp_reset_query();  ?>       
   </aside>
   <!--// aisde end -->