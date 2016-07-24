<?php
/*
Template Name: thanks
*/
?>  
<?php
if(is_page('thank-you')&&$_REQUEST['order_no']){
	include_once(ESHOP_PATH.'dhpay/config.php');
	$slink=add_query_arg('eshopaction','success',get_permalink($eshopoptions['cart_success']));
    $return_url=apply_filters('eshop_paypal_return_link',$slink); 
	$order_no = isset($_REQUEST['order_no'])?$_REQUEST['order_no']:0;
	$order_data = $wpdb->get_row("SELECT * FROM wp_eshop_orders WHERE checkid = '".$order_no."'");
	if($_REQUEST['invoice_id']==$order_data->custom_field){
		switch ($_GET['status']) {
		case '00':			
		    $url = $_SERVER['HTTP_HOST']."/shopping-cart/thank-you?res=Processing";		    
			break;
		case '01':			
			$table = $wpdb->prefix.'eshop_orders';
			$data = array('status' =>"Completed");
			$where = array('checkid' =>$_GET['order_no']);
			$format = array('%s');
			$where_format = array('%s');
			$wpdb->update($table, $data, $where, $format, $where_format);
			$checked=$_GET['order_no'];
            eshop_send_customer_email($checked, '3');
			$url = $_SERVER['HTTP_HOST']."/shopping-cart/thank-you?res=success";		
			break;
		case '02':			
		    $url = $_SERVER['HTTP_HOST']."/shopping-cart/thank-you?res=failure&failure_reason=".$_GET['failure_reason'];	
			break;
		default:
			break;
	   }
	}else{
		$url = $_SERVER['HTTP_HOST']."/shopping-cart/thank-you?res=error";		
	}
	header('Location: http://'.$url);
	exit();
}
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
<span style="color: #ff0000; font-size: medium; font-weight: bold;">
<?php

while ( have_posts() ) : the_post(); 
if(is_page('thank-you')&&$_REQUEST['res']){
	switch ($_GET['res']) {
		case 'Processing':
			$post->post_content = 'Processing…';		    
			break;
		case 'success':
			$post->post_content = 'Success Payments';	
			break;
		case 'failure':
			$post->post_content = 'Payment failed because of: ' . $_GET['failure_reason'];
			break;
		case 'error':
			$post->post_content = 'Error';
			break;
		default:
			break;
	   }
	   echo $post->post_content;
} 
 ?></span>
<?php the_content(); ?> 
<?php endwhile; ?>  
 
      </article>
   </section>
   <!--// main end -->
</section>

<!--// js for blog -->
<?php get_footer();?>