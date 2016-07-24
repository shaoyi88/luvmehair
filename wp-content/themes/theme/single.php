<?php
	$default_single = explode(',',$options["style_blog"]);

	if( in_category($default_single) )
		include(TEMPLATEPATH . '/single-blog.php');
	else
		include(TEMPLATEPATH . '/single-product.php');	
?>
