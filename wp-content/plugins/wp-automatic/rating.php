<?php 


function wp_automatic_rating_notice() {
	
	if(! function_exists('curl_init') ){
		
		?>
		

		
		<?php
		
	}
	
	//if the user ftped the plugin without running the table modification via activation hook
	$tableversion = get_option('wp_automatic_version');
	
	if($tableversion < 15 ) {
		
		?>
		

		
		<?php
	}
	 
	$uri=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	
	if(stristr($uri, '?')){
		$uri.='&wp_automatic_rating=cancel';
	}else{
		$uri.='?wp_automatic_rating=cancel';
	}
	
	if(! stristr($uri,'http')){
		$uri='http://'.$uri;
	}
	
	if  ( isset($_GET['wp_automatic_rating']) ) {
		 update_option('wp_deandev_automatic_rating','cancel');
	 
	}
	
	$wp_automatic_rating=get_option('wp_deandev_automatic_rating','');
	
	if(trim($wp_automatic_rating) == ''){
		//get count of successful pins 
		global $wpdb;
		$query="SELECT count(*) as count FROM {$wpdb->prefix}automatic_log where action like 'Posted:%' and date > '2014-01-12 11:05:27' ";
		$rows=$wpdb->get_results($query);
		$row=$rows[0];
		$count=$row->count;
		
	
		 ;
		 
		if($count > 10 ){
			
			?>

		    <?php
		
		}//count ok
	}//rating yes
	 
}
add_action( 'admin_notices', 'wp_automatic_rating_notice' );


