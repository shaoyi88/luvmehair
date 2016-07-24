<?php
	//得到分类标题但不echo
	$cat_title = single_cat_title("", false);
	//把标题转成ID
	$cat_ID = get_cat_ID($cat_title);	
	if( is_tag() ):
		include(TEMPLATEPATH . '/archive-tags.php');
	else: 
		include(TEMPLATEPATH . '/archive-products.php');

?>
<?php endif; ?>