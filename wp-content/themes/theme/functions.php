<?php 
require_once(TEMPLATEPATH . '/theme_setup.php');	
add_theme_support('post-thumbnails');
show_admin_bar(false);
 function tj_custom_post_type() {
    register_post_type( 'admin', tj_custom_post_type_args("admin"));
    register_post_type( 'ad_img', tj_custom_post_type_args("ad_img"));
    register_post_type( 'sns', tj_custom_post_type_args("sns"));
    register_post_type( '3code', tj_custom_post_type_args("3code"));
    register_post_type( 'lianxi', tj_custom_post_type_args("lianxi"));
    register_post_type( 'about', tj_custom_post_type_args("about"));
    register_post_type( 'skype', tj_custom_post_type_args("skype"));
    register_post_type( 'ico01', tj_custom_post_type_args("ico01"));
    register_post_type( 'ico02', tj_custom_post_type_args("ico02"));
    register_post_type( 'ad01', tj_custom_post_type_args("ad01"));
    register_post_type( 'ad02', tj_custom_post_type_args("ad02"));
    register_post_type( 'ad03', tj_custom_post_type_args("ad03"));
    register_post_type( 'download', tj_custom_post_type_args("download"));
    register_post_type( 'pdf', tj_custom_post_type_args("pdf"));
    register_post_type( 'certificate', tj_custom_post_type_args("certificate"));
    register_post_type( 'article', tj_custom_post_type_args("article"));
    register_post_type( 'productitems', tj_custom_post_type_args("productitems"));
}
function tj_cutom_post_type_label_args($typeName){
    return $labels = array(
        'name' => $typeName,
        'singular_name' => $typeName,
        'add_new' => 'Add New',
        'add_new_item' => 'Add New '.$typeName,
        'edit_item' => 'Edit '.$typeName,
        'new_item' => 'New '.$typeName,
        'all_items' => 'All '.$typeName,
        'view_item' => 'View '.$typeName,
        'search_items' => 'Search '.$typeName,
        'not_found' =>  'No '.$typeName.' found',
        'not_found_in_trash' => 'No '.$typeName.' found in Trash', 
        'parent_item_colon' => '',
        'menu_name' => $typeName
    );
}
function tj_custom_post_type_args($typeName,$postType="post",$public=true,$queryable=true,$show_ui=true,$show_menu=true,$query_var=true,$has_archive = true, $hierarchical = false,$menu_position = null){
    return $args = array(
        'labels' => tj_cutom_post_type_label_args($typeName),
        'public' => $public,
        'publicly_queryable' => $queryable,
        'show_ui' => $show_ui, 
        'show_in_menu' => $show_menu, 
        'query_var' => $query_var,
        'rewrite' => array( 'slug' => strtolower($typeName)),
        'capability_type' => $postType,
        'has_archive' => $has_archive, 
        'hierarchical' => $hierarchical,
        'menu_position' => $menu_position,
        'supports' => array( 'title', 'thumbnail')
    );
}
function custom_post_help() {
	$labels = array(
		'name'               => _x( '相关页面', 'post type general name' ),
		'singular_name'      => _x( '相关页面', 'post type singular name' ),
		'add_new'            => _x( '新建', 'book' ),
		'add_new_item'       => __( '新建 相关页面' ),
		'edit_item'          => __( '修改 相关页面' ),
		'new_item'           => __( '新建 相关页面' ),
		'all_items'          => __( '所有 相关页面' ),
		'view_item'          => __( '查看 相关页面' ),
		'search_items'       => __( '搜索 相关页面' ),
		'not_found'          => __( '无 相关页面 内容' ),
		'not_found_in_trash' => __( '无 相关页面 内容' ), 
		'parent_item_colon'  => '',
		'menu_name'          => '相关页面'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our product and product specific data',
		'public'        => true,
		'menu_position' => 10,
		'supports'      => array( 'title', 'editor', 'thumbnail'),
		'has_archive'   => true,
	);
	register_post_type( 'help', $args );	
}
add_action( 'init', 'custom_post_help' );




function custom_post_video() {
	$labels = array(
		'name'               => _x( 'Video', 'post type general name' ),
		'singular_name'      => _x( 'Video', 'post type singular name' ),
		'add_new'            => _x( '新建', 'book' ),
		'add_new_item'       => __( '新建 Video' ),
		'edit_item'          => __( '修改 Video' ),
		'new_item'           => __( '新建 Video' ),
		'all_items'          => __( '所有 Video' ),
		'view_item'          => __( '查看 Video' ),
		'search_items'       => __( '搜索 Video' ),
		'not_found'          => __( '无 Video 内容' ),
		'not_found_in_trash' => __( '无 Video 内容' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Video'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our product and product specific data',
		'public'        => true,
		'menu_position' => 10,
		'supports'      => array( 'title', 'editor', 'thumbnail'),
		'has_archive'   => true,
	);
	register_post_type( 'video', $args );	
}
add_action( 'init', 'custom_post_video' );



function custom_post_gallery() {
	$labels = array(
		'name'               => _x( 'Gallery', 'post type general name' ),
		'singular_name'      => _x( 'Gallery', 'post type singular name' ),
		'add_new'            => _x( '新建', 'book' ),
		'add_new_item'       => __( '新建 Gallery' ),
		'edit_item'          => __( '修改 Gallery' ),
		'new_item'           => __( '新建 Gallery' ),
		'all_items'          => __( '所有 Gallery' ),
		'view_item'          => __( '查看 Gallery' ),
		'search_items'       => __( '搜索 Gallery' ),
		'not_found'          => __( '无 Gallery 内容' ),
		'not_found_in_trash' => __( '无 Gallery 内容' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Gallery'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our product and product specific data',
		'public'        => true,
		'menu_position' => 10,
		'supports'      => array( 'title', 'editor', 'thumbnail'),
		'has_archive'   => true,
	);
	register_post_type( 'gallery', $args );	
}
add_action( 'init', 'custom_post_gallery' );




function custom_post_blog() {
	$labels = array(
		'name'               => _x( 'Blog', 'post type general name' ),
		'singular_name'      => _x( '博客', 'post type singular name' ),
		'add_new'            => _x( '新建', 'book' ),
		'add_new_item'       => __( '新建 博客' ),
		'edit_item'          => __( '修改 博客' ),
		'new_item'           => __( '新建 博客' ),
		'all_items'          => __( '所有 博客' ),
		'view_item'          => __( '查看 博客' ),
		'search_items'       => __( '搜索 博客' ),
		'not_found'          => __( '无 博客 内容' ),
		'not_found_in_trash' => __( '无 博客 内容' ), 
		'parent_item_colon'  => '',
		'menu_name'          => '博客'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our product and product specific data',
		'public'        => true,
		'menu_position' => 10,
		'supports'      => array( 'title', 'editor', 'thumbnail'),
		'has_archive'   => true,
	);
	register_post_type( 'blog', $args );	
}
add_action( 'init', 'custom_post_blog' );

function taxonomies_blog() {
	$labels = array(
		'name'              => _x( '博客分类', 'taxonomy general name' ),
		'singular_name'     => _x( '博客分类', 'taxonomy singular name' ),
		'search_items'      => __( '搜索博客分类' ),
		'all_items'         => __( '博客分类' ),
		'parent_item'       => __( '博客分类' ),
		'parent_item_colon' => __( '博客分类:' ),
		'edit_item'         => __( '博客分类修改' ), 
		'update_item'       => __( '博客分类更新' ),
		'add_new_item'      => __( '新增博客分类' ),
		'new_item_name'     => __( '新博客分类' ),
		'menu_name'         => __( '博客分类' ),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
	);
	register_taxonomy( 'blog_catalog', 'blog', $args );
}
add_action( 'init', 'taxonomies_blog', 0 );
function custom_post_news() {
	$labels = array(
		'name'               => _x( 'News', 'post type general name' ),
		'singular_name'      => _x( 'news', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'book' ),
		'add_new_item'       => __( 'Add New news' ),
		'edit_item'          => __( 'Edit news' ),
		'new_item'           => __( 'New news' ),
		'all_items'          => __( 'All news' ),
		'view_item'          => __( 'View news' ),
		'search_items'       => __( 'Search news' ),
		'not_found'          => __( 'No news found' ),
		'not_found_in_trash' => __( 'No news found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'news'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our product and product specific data',
		'public'        => true,
		'menu_position' => 10,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'has_archive'   => true,
	);
	register_post_type( 'news', $args );	
}
add_action( 'init', 'custom_post_news' );


//Custom Taxonomies (news Categories)
function taxonomies_news() {
	$labels = array(
		'name'              => _x( '新闻分类', 'taxonomy general name' ),
		'singular_name'     => _x( '新闻分类', 'taxonomy singular name' ),
		'search_items'      => __( '搜索新闻分类' ),
		'all_items'         => __( '新闻分类' ),
		'parent_item'       => __( '新闻分类' ),
		'parent_item_colon' => __( '新闻分类:' ),
		'edit_item'         => __( '新闻分类修改' ), 
		'update_item'       => __( '新闻分类更新' ),
		'add_new_item'      => __( '新增新闻分类' ),
		'new_item_name'     => __( '新新闻分类' ),
		'menu_name'         => __( '新闻分类' ),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
	);
	register_taxonomy( 'news_catalog', 'news', $args );
}
add_action( 'init', 'taxonomies_news', 0 );

function email_address_login($username) {
$user = get_user_by_email($username);
if(!empty($user->user_login))
$username = $user->user_login;
return $username;
}

add_action( 'user_register', 'auto_login_new_user');
/**
只搜索文章的标题
 */
function __search_by_title_only( $search, &$wp_query )
{
	global $wpdb;
 
	if ( empty( $search ) )
        return $search; // skip processing - no search term in query
 
    $q = $wp_query->query_vars;    
    $n = ! empty( $q['exact'] ) ? '' : '%';
 
    $search =
    $searchand = '';
 
    foreach ( (array) $q['search_terms'] as $term ) {
    	$term = esc_sql( like_escape( $term ) );
    	$search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
    	$searchand = ' AND ';
    }
 
    if ( ! empty( $search ) ) {
    	$search = " AND ({$search}) ";
    	if ( ! is_user_logged_in() )
    		$search .= " AND ($wpdb->posts.post_password = '') ";
    }
 
    return $search;
}
add_filter( 'posts_search', '__search_by_title_only', 500, 2 );
function get_referrer_category() {
    global $posts;

    if ( ! $referrer_url = get_referrer_url( false ) )
        return false;

    foreach ( get_the_category( $posts[0]->ID ) as $cat ) {
        $cat_link = get_category_link( $cat->term_id );

        if ( false !== strpos( $referrer_url, $cat_link ) )
            return $cat;
    }

    foreach ( get_the_tags( $posts[0]->ID ) as $tag ) {
        $tag_link = get_tag_link( $tag->term_id );

        if ( false !== strpos( $referrer_url, $tag_link ) )
            return $tag;
    }

    foreach ( get_the_terms( $posts[0]->ID, 'color' ) as $term ) {
        $term_link = get_term_link( $term->term_id );

        if ( false !== strpos( $referrer_url, $term_link ) )
            return $term;
    }

    return false;
}

add_filter( 'post_thumbnail_html', 'remove_wps_width', 10 );
add_filter( 'image_send_to_editor', 'remove_wps_width', 10 );
  
function remove_wps_width( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

add_action( 'init', 'tj_custom_post_type' );
function get_category_root_id($cat)   
{   
$this_category = get_category($cat); // 取得当前分类   
while($this_category->category_parent) // 若当前分类有上级分类时，循环   
{   
$this_category = get_category($this_category->category_parent); // 将当前分类设为上级分类（往上爬）   
}   
return $this_category->term_id; // 返回根分类的id号   
} 
add_filter( 'gettext_with_context', 'wpdx_disable_open_sans', 888, 4 );
function wpdx_disable_open_sans( $translations, $text, $context, $domain ) {
  if ( 'Open Sans font: on or off' == $context && 'on' == $text ) {
    $translations = 'off';
  }
  return $translations;
}
remove_action('pre_post_update','wp_save_post_revision' );
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);
function my_css_attributes_filter($var) {
	return is_array($var) ? array_intersect($var, array('current-menu-item','current-post-ancestor','current-menu-ancestor','current-menu-parent')) : '';
}
add_action('login_head', 'my_custom_login_logo');
function my_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_bloginfo('template_directory').'/images/custom-login-logo.png) !important; }
    </style>';
}
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'locale_stylesheet' );
remove_action( 'publish_future_post', 'check_and_publish_future_post', 10, 1 );
remove_action( 'wp_head', 'noindex', 1 );
remove_action( 'wp_head', 'wp_print_styles', 8 );
remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rel_canonical' );
remove_action( 'wp_footer', 'wp_print_footer_scripts' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action( 'template_redirect', 'wp_shortlink_header', 11, 0 );
remove_action( 'wp_head', 'index_rel_link' ); // Removes the index link   
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // Removes the prev link   
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // Removes the start link   
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Removes the relational links for the posts adjacent to the current post. 
add_action('widgets_init', 'my_remove_recent_comments_style');
if ( !is_admin() ) { 
function my_init_method() {
wp_deregister_script( 'jquery' ); 
}
add_action('init', 'my_init_method'); 
}
wp_deregister_script( 'l10n' );

function wpdx_change_role_name() {
    global $wp_roles;
 
    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();
    $wp_roles->roles['administrator']['name'] = '超级管理员';
    $wp_roles->role_names['administrator'] = '超级管理员';           
    $wp_roles->roles['editor']['name'] = '网站编辑';
    $wp_roles->role_names['editor'] = '网站编辑';                    
    $wp_roles->roles['yewu']['name'] = '网站业务员';
    $wp_roles->role_names['yewu'] = '网站业务员';                    
    $wp_roles->roles['kefu']['name'] = '网站客服';
    $wp_roles->role_names['kefu'] = '网站客服';                    
    $wp_roles->roles['VipCustomer']['name'] = 'Vip用户';
    $wp_roles->role_names['VipCustomer'] = 'Vip用户';           
    $wp_roles->roles['Customer']['name'] = '注册用户';
    $wp_roles->role_names['Customer'] = '注册用户';           
}
add_action('init', 'wpdx_change_role_name');
remove_role( 'author' );
remove_role( 'sc_chat_op' );
remove_role( 'pending' );
remove_role( 'contributor' );
remove_role( 'subscriber' );



function my_remove_recent_comments_style() {
global $wp_widget_factory;
remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}
if ( function_exists('register_sidebar') ) {
	register_sidebar( array(
		'name' => 'inquiry',
		'id' => 'inquiry',
		) );
}

if ( function_exists('register_sidebar') ) {
	register_sidebar( array(
		'name' => 'newsletter',
		'id' => 'newsletter',
		) );
}

function cut_str($sourcestr,$cutlength)
{
	$returnstr='';
	$i=0;
	$n=0;
	$str_length=strlen($sourcestr);
	while (($n<$cutlength) and ($i<=$str_length))
	{
		$temp_str=substr($sourcestr,$i,1);
		$ascnum=Ord($temp_str);
		if ($ascnum>=224)
		{
			$returnstr=$returnstr.substr($sourcestr,$i,3);
			$i=$i+3;
			$n++;
		}
		elseif ($ascnum>=192)
		{
			$returnstr=$returnstr.substr($sourcestr,$i,2);
			$i=$i+2;
			$n++;
		}
		elseif ($ascnum>=65 && $ascnum<=90)
		{
			$returnstr=$returnstr.substr($sourcestr,$i,1);
			$i=$i+1;
			$n++;
		}
		else
		{
			$returnstr=$returnstr.substr($sourcestr,$i,1);
			$i=$i+1;
			$n=$n+0.5;
		}
	}
	if (mb_strlen($sourcestr)>$cutlength){
		$returnstr = $returnstr . "…";
	}
	return $returnstr;
}
function get_the_thumb($id) {
	$post=get_post($id);
	$first_img = '';

	$first_img = get_post_meta($post->ID, "zuluo_thumbnail", true);
	if ($first_img != '') return $first_img;

	if ( has_post_thumbnail($id) ) {
		$imgstr = explode('src="', get_the_post_thumbnail($id,'thumbnail'));
		$img = explode('"', $imgstr[1]);
		$first_img = $img[0];
		return $first_img;
	} 
	else {
		$args = array(
			'post_type' => 'attachment',
			'post_mime_type'	=> 'image',
			'numberposts'		=> -1,
			'post_status'		=> null,
			'post_parent'		=> $id,
			'orderby'			=> 'post_date',
			'order'				=> 'DESC'
		);
		$attachments = get_posts( $args );
		if ( $attachments ) {
			foreach ( $attachments as $attachment ) {
				$imgstr = explode('src="', wp_get_attachment_image( $attachment->ID, 'thumbnail' ));
				$img = explode('"', $imgstr[1]);
				$first_img = $img[0];
				return $first_img;
			}
		}
		else {
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches); 
			if ( $matches[1] )
				$first_img = $matches[1][0];
			if ($first_img=='') {
				$first_img = get_template_directory_uri() . "/images/thumb/". rand(1,3) .".jpg";
			}
			return $first_img;
		}
	}	
}
function my_profile( $contactmethods ) {
	$contactmethods['phone'] = 'Phone';   
	$contactmethods['add1'] = 'Address';
	$contactmethods['add2'] = 'Address (continued)';   
	$contactmethods['city'] = 'City or town';
	$contactmethods['state'] = 'State/County/Province if not listed above';   
	$contactmethods['zip'] = 'Zip/Post code';
	$contactmethods['country'] = 'Country';   
	unset($contactmethods['aim']);   
	unset($contactmethods['yim']);
	unset($contactmethods['jabber']);
	return $contactmethods;
}
add_filter('user_contactmethods','my_profile');		
function zuluo_pagination($range = 11){
	global $paged, $wp_query;
	if ( !$max_page ) {
		$max_page = $wp_query->max_num_pages;
	}
	if($max_page > 1){
		if(!$paged){
			$paged = 1;
		}
		if($paged != 1){
			echo "<a href='" . get_pagenum_link(1) . "' title='First'>First</a>";
		}
		previous_posts_link('Previous');
		if($max_page > $range){
			if($paged < $range){
				for($i = 1; $i <= $range; $i++){
					echo "<a href='" . get_pagenum_link($i) ."'";
					if($i==$paged)
						echo " class='current'";
					echo ">$i</a>";
				}
			}
			elseif($paged >= ($max_page - ceil(($range/2)))){
				for($i = $max_page - $range + 1; $i <= $max_page; $i++){
					echo "<a href='" . get_pagenum_link($i) ."'";
					if($i==$paged)
						echo " class='current'";
					echo ">$i</a>";
				}
			}
			elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){
				for($i = ($paged - ceil($range/2)) + 1; $i < ($paged + ceil(($range/2))); $i++){
					echo "<a href='" . get_pagenum_link($i) ."'";
					if($i==$paged)
						echo " class='current'";
					echo ">$i</a>";
				}
			}
		}
		else{
			for($i = 1; $i <= $max_page; $i++){
				echo "<a href='" . get_pagenum_link($i) ."'";
				if($i==$paged)
					echo " class='current'";
				echo ">$i</a>";
			}
		}
		next_posts_link('Next');
		if($paged != $max_page){
			echo "<a href='" . get_pagenum_link($max_page) . "' title='Last'>Last</a>";
		}
	}
}

function custom_excerpt_more($more) {
return '...';
}
add_filter('excerpt_more', 'custom_excerpt_more');
function custom_excerpt_length($length) {
return 70;
}
add_filter('excerpt_length', 'custom_excerpt_length');

class zuluo_Catpost_Widget extends WP_Widget {
	function zuluo_Catpost_Widget() {
		$widget_ops = array('description' => '分类文章列表', 'description' => '分类文章列表');
		$control_ops = array('width' => 200, 'height' => 300);
		parent::WP_Widget(false,$name='分类文章列表（zuluo）',$widget_ops,$control_ops); 
	}
	function form($instance) {
		$catposts = isset($instance['catposts']) ? esc_attr($instance['catposts']) : '1';
		$number = isset($instance['number']) ? absint($instance['number']) : 8;
?>

	<p><label for="<?php echo $this->get_field_id('catposts'); ?>">分类ID：</label><br>
		<input id="<?php echo $this->get_field_id('catposts'); ?>" name="<?php echo $this->get_field_name('catposts'); ?>" type="text" value="<?php echo $catposts; ?>" size="35" /></p>

	<p><label for="<?php echo $this->get_field_id('number'); ?>">文章列表数目：</label><br>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
    }
    function update($new_instance, $old_instance) { // 更新保存
	    return $new_instance;
    }

	function widget($args, $instance) { // 输出显示在页面上
		extract( $args );
		if ( empty( $instance['catposts'] ) || ! $catposts = esc_attr( $instance['catposts'] ) )
 			$catposts = '1';
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 8;
		//按照列表输入分类标题和副标题链接
		$sidebar_cats1 = explode(',',$catposts);
		$i = 1;
		foreach( $sidebar_cats1 as $catid1 ) {
			$title = get_the_category_by_ID($catid1);
			echo '<li>';
			echo '<h2>'. $title. '<a class="more" href="'.get_category_link($catid1).'">'.'</a></h2>'; 
?>
			<ul>

		<?php
			$popular = new WP_Query( array(
				'cat' => $catid1,
				'showposts' => $number,
				'orderby' => 'date',
				'order' => 'ASC',
			) );	
			while ($popular->have_posts()) : $popular->the_post();
		?>
				<li><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php echo cut_str(get_the_title(),14); ?></a></li>
		<?php	
			endwhile;
				// Reset Query
			wp_reset_query();
		?>
			</ul> 
<?php	echo '</li>'; ?>
<?php
		}
    }
}
register_widget('zuluo_Catpost_Widget');
function cmp_breadcrumbs() {
	$delimiter = '</li><li>'; // 分隔符
	$before = '<a href="#">'; // 在当前链接前插入
	$after = '</a>'; // 在当前链接后插入
	if ( !is_home() && !is_front_page() || is_paged() ) {
		echo ''.__( '' , 'cmp' );
		global $post;
		$homeLink = home_url();
		echo ' <a itemprop="breadcrumb" href="' . $homeLink . '">' . __( 'Home' , 'cmp' ) . '</a>' . $delimiter . ' ';
		if ( is_category() ) { // 分类 存档
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$thisCat = $cat_obj->term_id;
			$thisCat = get_category($thisCat);
			$parentCat = get_category($thisCat->parent);
			if ($thisCat->parent != 0){
				$cat_code = get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' ');
				echo $cat_code = str_replace ('<a','<a itemprop="breadcrumb"', $cat_code );
			}
			echo $before . '' . single_cat_title('', false) . '' . $after;
		} elseif ( is_day() ) { // 天 存档
			echo '<a itemprop="breadcrumb" href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo '<a itemprop="breadcrumb"  href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('d') . $after;
		} elseif ( is_month() ) { // 月 存档
			echo '<a itemprop="breadcrumb" href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('F') . $after;
		} elseif ( is_year() ) { // 年 存档
			echo $before . get_the_time('Y') . $after;
		} elseif ( is_single() && !is_attachment() ) { // 文章
			if ( get_post_type() != 'post' ) { // 自定义文章类型
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				echo '<a itemprop="breadcrumb" href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
				echo $before . get_the_title() . $after;
			} else { // 文章 post
				$cat = get_the_category(); $cat = $cat[0];
				$cat_code = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
				echo $cat_code = str_replace ('<a','<a itemprop="breadcrumb"', $cat_code );
				echo $before . get_the_title() . $after;
			}
		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;
		} elseif ( is_attachment() ) { // 附件
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			echo '<a itemprop="breadcrumb" href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;
		} elseif ( is_page() && !$post->post_parent ) { // 页面
			echo $before . get_the_title() . $after;
		} elseif ( is_page() && $post->post_parent ) { // 父级页面
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a itemprop="breadcrumb" href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;
		} elseif ( is_search() ) { // 搜索结果
			echo $before ;
			printf( __( 'Search Results for: %s', 'cmp' ),  get_search_query() );
			echo  $after;
		} elseif ( is_tag() ) { //标签 存档
			echo $before ;
			printf( __( 'Tag Archives: %s', 'cmp' ), single_tag_title( '', false ) );
			echo  $after;
		} elseif ( is_author() ) { // 作者存档
			global $author;
			$userdata = get_userdata($author);
			echo $before ;
			printf( __( 'Author Archives: %s', 'cmp' ),  $userdata->display_name );
			echo  $after;
		} elseif ( is_404() ) { // 404 页面
			echo $before;
			_e( 'Not Found', 'cmp' );
			echo  $after;
		}
		if ( get_query_var('paged') ) { // 分页
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
				echo sprintf( __( '( Page %s )', 'cmp' ), get_query_var('paged') );
		}
		echo '';
	}
}
function af_titledespacer($title) {
return trim($title);
}
add_filter('wp_title', 'af_titledespacer');
$keywords = substr($keywords,0,-2);

class RRHE {
	// Register the column - Registered
	public static function registerdate($columns) {
		$columns['registerdate'] = __('注册时间', 'registerdate');
		return $columns;
	}
 
	// Display the column content
	public static function registerdate_columns( $value, $column_name, $user_id ) {
		if ( 'registerdate' != $column_name )
			return $value;
		$user = get_userdata( $user_id );
		$registerdate = get_date_from_gmt($user->user_registered);
		return $registerdate;
	}
 
	public static function registerdate_column_sortable($columns) {
		$custom = array(
		  // meta column id => sortby value used in query
			'registerdate'    => 'registered',
			);
		return wp_parse_args($custom, $columns);
	}
 
	public static function registerdate_column_orderby( $vars ) {
		if ( isset( $vars['orderby'] ) && 'registerdate' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'registerdate',
				'orderby' => 'meta_value'
				) );
		}
		return $vars;
	}

	// Register the column - Registered
	public static function listorder($columns) {
		$columns['listorder'] = __('排序', 'listorder');
		return $columns;
	}
 
}
 
// Actions
add_filter( 'manage_users_columns', array('RRHE','registerdate'));
add_action( 'manage_users_custom_column',  array('RRHE','registerdate_columns'), 15, 3);
add_filter( 'manage_users_sortable_columns', array('RRHE','registerdate_column_sortable') );
add_filter( 'request', array('RRHE','registerdate_column_orderby') );

add_filter( 'manage_edit_columns', array('RRHE','listorder'));

class zuluo_Catlist_Widget extends WP_Widget {
	function zuluo_Catlist_Widget() {
		$widget_ops = array('description' => '分类标题列表', 'description' => '分类标题列表');
		$control_ops = array('width' => 200, 'height' => 300);
		parent::WP_Widget(false,$name='分类标题列表（zuluo）',$widget_ops,$control_ops); 
	}
	function form($instance) {
		$catparent = isset($instance['catparent']) ? esc_attr($instance['catparent']) : '1';
?>

	<p><label for="<?php echo $this->get_field_id('catparent'); ?>">父分类ID：</label><br>
		<input id="<?php echo $this->get_field_id('catparent'); ?>" name="<?php echo $this->get_field_name('catparent'); ?>" type="text" value="<?php echo $catparent; ?>" size="35" /></p>
<?php
    }
    function update($new_instance, $old_instance) { // 更新保存
	    return $new_instance;
    }

	function widget($args, $instance) { // 输出显示在页面上
		extract( $args );
		if ( empty( $instance['catparent'] ) || ! $catparent = esc_attr( $instance['catparent'] ) )
 			$catparent = '1';
		//显示父分类标题和子分类列表
		$title = get_the_category_by_ID($catparent);
		$titlestr = '<li>';
		$titlestr .= '<h2>'. $title; 
		$titlestr .= '<a class="more" href="'.get_category_link($catparent).'">'.'</a>'; 
		$titlestr .= '</h2><ul>';
		echo $titlestr;
		//$variable = wp_list_categories( array( 
		wp_list_categories( array( 
			'child_of' => $catparent,
			'orderby'	=> 'slug',
			'order'		=> 'ASC',
			'title_li' => '',
			'hide_empty' =>	0,
			'depth' =>	4,
			'hierarchical' => true,
			'current_category' => 0,
			'show_option_none' =>''
			//'echo'	=> 0
		) );
		//echo preg_replace('/title=\"(.*?)\"/','',$variable);
		echo '</ul>';
		echo '</li>'; 
    }
}
register_widget('zuluo_Catlist_Widget');

class zuluo_Cattree_Widget extends WP_Widget {
	function zuluo_Cattree_Widget() {
		$widget_ops = array('description' => '分类目录树', 'description' => '分类目录树');
		$control_ops = array('width' => 200, 'height' => 300);
		parent::WP_Widget(false,$name='分类目录树（zuluo）',$widget_ops,$control_ops); 
	}
	function form($instance) {
		$catparent = isset($instance['catparent']) ? esc_attr($instance['catparent']) : '1';
?>

	<p><label for="<?php echo $this->get_field_id('catparent'); ?>">父分类ID：</label><br>
		<input id="<?php echo $this->get_field_id('catparent'); ?>" name="<?php echo $this->get_field_name('catparent'); ?>" type="text" value="<?php echo $catparent; ?>" size="35" /></p>
<?php
    }
    function update($new_instance, $old_instance) { // 更新保存
	    return $new_instance;
    }

	function widget($args, $instance) { // 输出显示在页面上
		extract( $args );
		if ( empty( $instance['catparent'] ) || ! $catparent = esc_attr( $instance['catparent'] ) )
 			$catparent = '1';
		//显示父分类标题和子分类列表
		$title = get_the_category_by_ID($catparent);
		$titlestr = '<li class="cattree">';
		$titlestr .= '<h2>'. $title;
		$titlestr .= '<a class="more" href="'.get_category_link($catparent).'">'.'</a>'; 
		$titlestr .= '</h2><ul>';
		echo $titlestr;
		//$variable = wp_list_categories( array( 
		wp_list_categories( array( 
			'child_of' => $catparent,
			'orderby'	=> 'slug',
			'order'		=> 'ASC',
			'title_li' => '',
			'hide_empty' =>	0,
			'depth' =>	4,
			'hierarchical' => true,
			'current_category' => 0,
			'show_option_none' =>''
			//'echo'	=> 0
		) );

		//echo preg_replace('/title=\"(.*?)\"/','',$variable);
		echo '</ul>';
		echo '</li>'; 
    }
}
register_widget('zuluo_Cattree_Widget');


add_filter( 'manage_media_columns', 'wpdaxue_media_column' );
function wpdaxue_media_column( $columns ) {
	$columns["media_url"] = "URL";
	return $columns;
}
add_action( 'manage_media_custom_column', 'wpdaxue_media_value', 10, 2 );
function wpdaxue_media_value( $column_name, $id ) {
	if ( $column_name == "media_url" ) echo '<input type="text" style="width:100%;" onclick="jQuery(this).select();" value="'. wp_get_attachment_url( $id ). '" />';
}
		function wt_get_category_count($input = '') {
    global $wpdb;

    if($input == '') {
        $category = get_the_category();
        return $category[0]->category_count;
    }
    elseif(is_numeric($input)) {
        $SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->term_taxonomy.term_id=$input";
        return $wpdb->get_var($SQL);
    }
    else {
        $SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->terms.slug='$input'";
        return $wpdb->get_var($SQL);
    }
}
		function wt_get_category_count_g($input = '') {
    global $wpdb;

    if($input == '') {
        $category = get_the_category();
        return $category[2]->category_count;
    }
    elseif(is_numeric($input)) {
        $SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->term_taxonomy.term_id=$input";
        return $wpdb->get_var($SQL);
    }
    else {
        $SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->terms.slug='$input'";
        return $wpdb->get_var($SQL);
    }
}

//-------------------------------------------------------------------------------------------分类/标签等存档页也能置顶文章
function curPageURL()
{
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on")
    {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    $this_page = $_SERVER["REQUEST_URI"];   
    // 只取 ? 前面的内容
    if (strpos($this_page, "?") !== false)
        $this_page = reset(explode("?", $this_page));
 
    if ($_SERVER["SERVER_PORT"] != "80")
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $this_page;
    }
    else
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . $this_page;
    }
    return $pageURL;
}
add_filter('the_posts',  'putStickyOnTop' );


function putStickyOnTop( $posts ) {
  if(is_home() || !is_main_query() || !is_archive())
    return $posts;
 
  global $wp_query;
 
  $sticky_posts = get_option('sticky_posts');
 
  if ( $wp_query->query_vars['paged'] <= 1 && is_array($sticky_posts) && !empty($sticky_posts) && !get_query_var('ignore_sticky_posts') ) {        $stickies1 = get_posts( array( 'post__in' => $sticky_posts ) );
    foreach ( $stickies1 as $sticky_post1 ) {
      if($wp_query->is_category == 1 && !has_category($wp_query->query_vars['cat'], $sticky_post1->ID)) {
        $offset1 = array_search($sticky_post1->ID, $sticky_posts);
        unset( $sticky_posts[$offset1] );
      }
      if($wp_query->is_tag == 1 && has_tag($wp_query->query_vars['tag'], $sticky_post1->ID)) {
        $offset1 = array_search($sticky_post1->ID, $sticky_posts);
        unset( $sticky_posts[$offset1] );
      }
      if($wp_query->is_year == 1 && date_i18n('Y', strtotime($sticky_post1->post_date))!=$wp_query->query['m']) {
        $offset1 = array_search($sticky_post1->ID, $sticky_posts);
        unset( $sticky_posts[$offset1] );
      }
      if($wp_query->is_month == 1 && date_i18n('Ym', strtotime($sticky_post1->post_date))!=$wp_query->query['m']) {
        $offset1 = array_search($sticky_post1->ID, $sticky_posts);
        unset( $sticky_posts[$offset1] );
      }
      if($wp_query->is_day == 1 && date_i18n('Ymd', strtotime($sticky_post1->post_date))!=$wp_query->query['m']) {
        $offset1 = array_search($sticky_post1->ID, $sticky_posts);
        unset( $sticky_posts[$offset1] );
      }
      if($wp_query->is_author == 1 && $sticky_post1->post_author != $wp_query->query_vars['author']) {
        $offset1 = array_search($sticky_post1->ID, $sticky_posts);
        unset( $sticky_posts[$offset1] );
      }
    }
 
    $num_posts = count($posts);
    $sticky_offset = 0;
    // Loop over posts and relocate stickies to the front.
    for ( $i = 0; $i < $num_posts; $i++ ) {
      if ( in_array($posts[$i]->ID, $sticky_posts) ) {
        $sticky_post = $posts[$i];
        // Remove sticky from current position
        array_splice($posts, $i, 1);
        // Move to front, after other stickies
        array_splice($posts, $sticky_offset, 0, array($sticky_post));
        // Increment the sticky offset. The next sticky will be placed at this offset.
        $sticky_offset++;
        // Remove post from sticky posts array
        $offset = array_search($sticky_post->ID, $sticky_posts);
        unset( $sticky_posts[$offset] );
      }
    }
 
    // If any posts have been excluded specifically, Ignore those that are sticky.
    if ( !empty($sticky_posts) && !empty($wp_query->query_vars['post__not_in'] ) )
      $sticky_posts = array_diff($sticky_posts, $wp_query->query_vars['post__not_in']);
 
    // Fetch sticky posts that weren't in the query results
    if ( !empty($sticky_posts) ) {
      $stickies = get_posts( array(
        'post__in' => $sticky_posts,
        'post_type' => $wp_query->query_vars['post_type'],
        'post_status' => 'publish',
        'nopaging' => true
      ) );
 
      foreach ( $stickies as $sticky_post ) {
        array_splice( $posts, $sticky_offset, 0, array( $sticky_post ) );
        $sticky_offset++;
      }
    }
  }
 
  return $posts;
}

add_filter( 'flash_uploader', 'disable_flash_uploader', 7 ); 
function izt_pagenavi($range = 5){  
    global $paged, $wp_query;  
    if ( !$max_page ) {$max_page = $wp_query->max_num_pages;}  
    if($max_page > 1){
		echo '';
		if(!$paged){$paged = 1;}  
        if($paged != 1){echo "<a href='" . get_pagenum_link(1) . "' class='extend' title='The First Page'><<</a>";}  
        previous_posts_link(' < Previous ');  
        if($max_page > $range){  
            if($paged < $range){for($i = 1; $i <= ($range + 1); $i++){echo "<a href='" . get_pagenum_link($i) ."'";  
                if($i==$paged)echo " class='current'";echo ">$i</a>";}}  
            elseif($paged >= ($max_page - ceil(($range/2)))){  
                for($i = $max_page - $range; $i <= $max_page; $i++){echo "<a href='" . get_pagenum_link($i) ."'";  
                    if($i==$paged)echo " class='current'";echo ">$i</a>";}}  
            elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){  
                for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++){echo "<a href='" . get_pagenum_link  
  
($i) ."'";if($i==$paged) echo " class='current'";echo ">$i</a>";}}}  
        else{for($i = 1; $i <= $max_page; $i++){echo "<a href='" . get_pagenum_link($i) ."'";  
            if($i==$paged)echo " class='current'";echo ">$i</a>";}}  
        next_posts_link(' Next > ');  
        if($paged != $max_page){echo "<a href='" . get_pagenum_link($max_page) . "' class='extend' title='The Last Page'>>></a> <span class='current2'>Page ".$paged." / ".$max_page."</span>";}}  
}  

if ( !function_exists('fb_AddThumbColumn') && function_exists('add_theme_support') ) {
// for post and page
add_theme_support('post-thumbnails', array( 'post', 'page' ) );
function fb_AddThumbColumn($cols) {
$cols['thumbnail'] = __('Thumbnail');
return $cols;
}
function fb_AddThumbValue($column_name, $post_id) {
$width = (int) 50;
if ( 'thumbnail' == $column_name ) {
// thumbnail of WP 2.9
$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
// image from gallery
$attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
if ($thumbnail_id)
$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
elseif ($attachments) {
foreach ( $attachments as $attachment_id => $attachment ) {
$thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
}
}
if ( isset($thumb) && $thumb ) {
echo $thumb;
} else {
echo __('None');
}
}
}
// for posts
add_filter( 'manage_posts_columns', 'fb_AddThumbColumn' );
add_action( 'manage_posts_custom_column', 'fb_AddThumbValue', 10, 2 );
// for pages
add_filter( 'manage_pages_columns', 'fb_AddThumbColumn' );
add_action( 'manage_pages_custom_column', 'fb_AddThumbValue', 10, 2 );
}
// Return the total amount of items in the shopping cart
function get_myeshop_cart_itemcount(){
	global $blog_id;
	$total_items_in_cart = 0;
	if(isset($_SESSION['eshopcart'.$blog_id])) {
		$item_array = $_SESSION['eshopcart'.$blog_id];
		
		foreach($item_array as $item) {
			$total_items_in_cart = $total_items_in_cart + $item['qty'];
		}
	}
	return $item_array;
}
/**
function reset_password_message( $message, $key ) {
	if ( strpos($_POST['user_login'], '@') ) {
		$user_data = get_user_by('email', trim($_POST['user_login']));
	} else {
		$login = trim($_POST['user_login']);
		$user_data = get_user_by('login', $login);
	}
	$user_login = $user_data->user_login;
	$msg = __('Someone requested that the password be reset for the following account:：'). "\r\n\r\n";
	$msg .= network_site_url() . "\r\n\r\n";
	$msg .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
	$msg .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
	$msg .= __('To reset your password, visit the following address:'). "\r\n\r\n";
	$msg .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') ;
	return $msg;
}
add_filter('retrieve_password_message', reset_password_message, null, 2); */



function display_my_cart_items() {
	$item = "";
	$cart_item_count = get_myeshop_cart_itemcount();
	if ($cart_item_count >0){
		$total = $sub_total=0;		 
		foreach($cart_item_count as $itm){
			$item .='<div class="head-cartlist">
                  <dl>
                     <dt>'.$itm["pname"].'</dt>
                     <dd class="num">Qty: '.$itm["qty"].'</dd>
                     <dd class="price">'.get_currency_symbol().' '.get_currency_price($itm["new_price"]).'</dd>
                  </dl></div>
               ';
			   $total += $itm["qty"];
			   $sub_total += $itm["new_price"]*$itm["qty"];
			   $sub_total = get_currency_price($sub_total);
			}
			$item .='<div class="head-cartlist"><dl style="text-align: right;">Total：<span style="margin-right:20px;">'.$total.'</span>Sub-Total : '.get_currency_symbol().' '.$sub_total.'</dl>
               </div>';
		}else{
			$item ='<div class="head-cartlist">
                  <dl>
                     You have no items in your Shopping Cart!
                  </dl>
               </div>';
			};
	echo $item;
}

function display_my_cart_items_no() {
	$item = "";
	$cart_item_count = get_myeshop_cart_itemcount();
	if ($cart_item_count >0){
		$total = $sub_total=0;
		foreach($cart_item_count as $itm){			
			$item .='';
			   $total = $total+$itm["qty"];
			   $sub_total = $sub_total+$itm["price"];
			}
			$item .=$total;
		}else{
			$item ='0';
			
			};
	echo $item;
}
function display_my_cart_items_price() {
	$item = "";
	$cart_item_count = get_myeshop_cart_itemcount();
	if ($cart_item_count >0){
		$total = $sub_total=0;
		foreach($cart_item_count as $itm){			
			$item .='';
			   $total += $itm["qty"];
			   $sub_total += $itm["new_price"]*$itm["qty"];
			   $sub_total = get_currency_price($sub_total);
			}
			$item .=$sub_total;
		}else{
			$item ='0.00';
			
			};
	echo $item;
}	
	function Reviews_num(){
		global $wpdb;
		$id = get_post()->ID;  
		//var_dump(the_ID());	
		echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments where comment_post_ID =".$id);
	
		}
		
function catch_that_image() { 

 global $post, $posts; 

 $first_img = ''; 

 ob_start(); 

 ob_end_clean(); 

 $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches); 

 $first_img = $matches [1] [0]; 

if(empty($first_img)){  

 $first_img = bloginfo('template_url'). '/images/default-thumb.jpg'; 

 } 

 return $first_img; 

 } 
//end
function make_get($arr){
	if(!is_array($arr)){
		return '';
	}
	$str = '?';
	$s = array();
	foreach($arr as $a=>$v){
		$s[] = $a.'='.$v;
	}
	$str .= implode('&',$s);
	return $str;
}

function attr($name,$value=''){
	
	if($value){
		update_option($name,$value);
	}else{
		return get_option($name);
	}
}

add_action( 'init', 'create_colors_nonhierarchical_taxonomy', 0 );
function create_colors_nonhierarchical_taxonomy() {
$str =  dopt('d_description'); 
$arr = explode(',',$str);
foreach($arr as $as){
  $labels = array(
    'name' => _x( $as, 'taxonomy general name' ),
    'singular_name' => _x( $as, 'taxonomy singular name' ),
    'search_items' =>  __( 'Search '.$as ),
    'popular_items' => __( 'Popular '.$as ),
    'all_items' => __( 'All '.$as ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit '.$as ),
    'update_item' => __( 'Update '.$as ),
    'add_new_item' => __( 'Add New '.$as ),
    'new_item_name' => __( 'New '.$as.' Name' ),
    'separate_items_with_commas' => __( 'Separate '.$as.' with commas' ),
    'add_or_remove_items' => __( 'Add or remove '.$as ),
    'choose_from_most_used' => __( 'Choose from the most used '.$as ),
    'menu_name' => __( $as ),
  ); 

  register_taxonomy($as,'post',array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => $as ),
  ));


}

}


function ashu_add_cat_field(){   
    echo '<div class="form-field">';   
    echo '<label for="xiaoxixi" >调用筛选</label>';   
    echo '<input type="text" size="" value="" id="xiaoxixi" name="xiaoxixi"/>';   
    echo '<p>输入筛选项目名称，逗号分隔</p>';   
    echo '</div>';   
}   
add_action('category_add_form_fields','ashu_add_cat_field', 10, 2);   
  
function ashu_edit_cat_field($tag){   
    echo '<table class="form-table"><tr class="form-field">
			<th scope="row" valign="top"><label for="xiaoxixi" >调用筛选</label></th>
			<td><input  type="text" value="';
	echo attr($tag->term_id.'xiaoxixi');
	echo '" id="xiaoxixi" name="xiaoxixi" size="40" />
			<p class="description">输入筛选项目名称，逗号分隔</p></td>
		</tr></table>';   
}   
add_action('category_edit_form_fields','ashu_edit_cat_field', 10, 2);    
add_action('created_category', 'ashu_taxonomy_metadata', 10, 1);   
add_action('edited_category','ashu_taxonomy_metadata', 10, 1);


function ashu_taxonomy_metadata($term_id){   
    if(isset($_POST['xiaoxixi'])){   
        if(!current_user_can('manage_categories')){   
            return $term_id ;   
        }   
           
        $data = $_POST['xiaoxixi'];   
           
       
            attr($term_id .'xiaoxixi', $data);   
    }   
}  
function dopt($e){
		return stripslashes(get_option($e));
	}
$dname = '过滤';
$themename = $dname.'设置';

$options = array(
    "d_description"
);



function mytheme_add_admin() {
    global $themename, $options;
    if ( $_GET['page'] == basename(__FILE__) ) {
        if ( 'save' == $_REQUEST['action'] ) {
            foreach ($options as $value) {
                update_option( $value, $_REQUEST[ $value ] ); 
            }
            header("Location: admin.php?page=functions.php&saved=true");
            die;
        }
    }
    add_theme_page($themename." Options", $themename."设置", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

function mytheme_admin() {
    global $themename, $options;
    $i=0;
    if ( $_REQUEST['saved'] ) echo '<div class="updated settings-error"><p>'.$themename.'修改已保存</p></div>';
?>

<div class="wrap d_wrap entry">
 

<form method="post" class="d_formwrap">
    <table style="padding:20px 0 0 0;">

	<tr>
        <td style="color:red;">
<b>第一步</b>：输入筛选项目名称，逗号分隔；注：名称用全小写，空格用减号 - 代替；例如：price,color,size,sleeve-style
        </td>
    </tr>
    <tr>
        <td>
<input class="ipt-b" type="text" id="d_description" name="d_description" value="<?php echo dopt('d_description'); ?>" style="width:600px;float:left;margin:10px 10px 10px 0;">
<div style="margin:6px 10px;"class="d_desc">
<input class="button-primary" name="save" type="submit" value="保存筛选项目">
</div>
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="page" value="functions.php">
        </td>
    </tr>
    <tr>
        <td>
<b>第二步</b>：保存后会显示每个筛选项目，点击下面的项目名称，添加每个筛选项目的具体参数：例如：点击Color，添加Red,Blue,Yellow.......
        </td>
    </tr>
    <tr>
        <td>
	<?php   
$str=dopt('d_description');
$keywords=array_filter(explode(",",$str));
foreach($keywords as $v){
echo "<li style='float:left;margin:10px 10px 10px 0px;text-transform:capitalize;'><a href='edit-tags.php?taxonomy=$v'>○ $v</a> </li>";
}?>

        </td>
    </tr>	
	
    <tr>
        <td>
<b>第三步</b>：在需要显示筛选的<a href="edit-tags.php?taxonomy=category">产品分类目录</a>下添加筛选项目名称；
        </td>
    </tr>	
	

	
    </table>
</form>
</div>
<script>
var aaa = []
jQuery('.d_wrap input, .d_wrap textarea').each(function(e){
    if( jQuery(this).attr('id') ) aaa.push( jQuery(this).attr('id') )
})
console.log( aaa )
</script>
<?php } ?>
<?php add_action('admin_menu', 'mytheme_add_admin');?>
<?php
	function get_currency(){
		$currency=$_COOKIE['currency'];
		return $currency;
	}
	function get_currency_symbol(){
		if (!isset($_COOKIE['currency'])) {        
			setcookie('currency', 'USD', time()+3600*24*30, COOKIEPATH, COOKIE_DOMAIN, false);
		 }		 
		 $currency=$_COOKIE['currency'];
		 if($currency=='EUR'){
			 $currency_symbol="€";
		 }else if($currency=='CAD'){
			 $currency_symbol="CAD$";
		 }else if($currency=='GBP'){
			 $currency_symbol="£";
		 }else if($currency=='AUD'){
			 $currency_symbol="AUD$";
		 }else if($currency=='HK'){
			 $currency_symbol="HK$";
		 }else if($currency=='JPY'){
			 $currency_symbol="円";
		 }else if($currency=='RUB'){
			 $currency_symbol="руб.";
		 }else if($currency=='CHF'){
			 $currency_symbol="CHF";
		 }else if($currency=='MXN'){
			 $currency_symbol="MXN";
		 }else if($currency=='NOK'){
			 $currency_symbol="Kr";
		 }else if($currency=='CZK'){
			 $currency_symbol="Kč";
		 }else if($currency=='BRL'){
			 $currency_symbol="R$";
		 }else if($currency=='ARS'){
			 $currency_symbol="$";
		 }else{
			 $currency_symbol="USD$";
		 }
		 return $currency_symbol;
	}

	function get_currency_name(){
		 $currency=$_GET['currency']?$_GET['currency']:$_COOKIE['currency'];
		 if($currency=='EUR'){
			 $currency_name="Currency: <a rel='nofollow' href='?currency=EUR'>EUR€</a>";
		 }else if($currency=='CAD'){
			 $currency_name="Currency: <a rel='nofollow' href='?currency=CAD'>CAD$</a>";
		 }else if($currency=='GBP'){
			 $currency_name="Currency: <a rel='nofollow' href='?currency=GBP'>GBP£</a>";
		 }else if($currency=='AUD'){
			 $currency_name="Currency: <a rel='nofollow' href='?currency=AUD'>AUD$</a>";
		 }else if($currency=='HK'){
			 $currency_name="Currency: <a rel='nofollow' href='?currency=HK'>HK$</a>";
		 }else if($currency=='JPY'){
			 $currency_name="Currency: <a rel='nofollow' href='?currency=JPY'>JPY円</a>";
		 }else if($currency=='RUB'){
			 $currency_name="Currency: <a rel='nofollow' href='?currency=RUB'>руб.</a>";
		 }else if($currency=='CHF'){
			 $currency_name="Currency: <a rel='nofollow' href='?currency=CHF'>CHF</a>";
		 }else if($currency=='CHF'){
			 $currency_name="Currency: <a rel='nofollow' href='?currency=MXN'>$MXN</a>";
		 }else if($currency=='NOK'){
			 $currency_name="Currency: <a rel='nofollow' href='?currency=NOK'>Kr</a>";
		 }else if($currency=='CZK'){
			 $currency_name="Currency: <a rel='nofollow' href='?currency=CZK'>Kč</a>";
		 }else if($currency=='BRL'){
			 $currency_name="Currency: <a rel='nofollow' href='?currency=BRL'>BRL$</a>";
		 }else if($currency=='ARS'){
			 $currency_name="Currency: <a rel='nofollow' href='?currency=ARS'>ARS$</a>";
		 }else{
			 $currency_name="Currency: <a rel='nofollow' href='?currency=USD'>USD$</a>";
		 }
		 return $currency_name;
	}

	function get_currency_price($price){
	     $currency_setting=get_option('currency_setting');	
		 $currency=$_COOKIE['currency'];
		 if($currency=='EUR'){
			 $currency_symbol_price=$price*$currency_setting['euro'];
		 }else if($currency=='CAD'){
			 $currency_symbol_price=$price*$currency_setting['canadian'];
		 }else if($currency=='GBP'){
			 $currency_symbol_price=$price*$currency_setting['british'];
		 }else if($currency=='AUD'){
			 $currency_symbol_price=$price*$currency_setting['australian'];
		 }else if($currency=='HK'){
			 $currency_symbol_price=$price*$currency_setting['HK'];
		 }else if($currency=='JPY'){
			 $currency_symbol_price=$price*$currency_setting['JPY'];
		 }else if($currency=='RUB'){
			 $currency_symbol_price=$price*$currency_setting['RUB'];
		 }else if($currency=='CHF'){
			 $currency_symbol_price=$price*$currency_setting['CHF'];
		 }else if($currency=='MXN'){
			 $currency_symbol_price=$price*$currency_setting['MXN'];
		 }else if($currency=='NOK'){
			 $currency_symbol_price=$price*$currency_setting['NOK'];
		 }else if($currency=='CZK'){
			 $currency_symbol_price=$price*$currency_setting['CZK'];
		 }else if($currency=='BRL'){
			 $currency_symbol_price=$price*$currency_setting['BRL'];
		 }else if($currency=='ARS'){
			 $currency_symbol_price=$price*$currency_setting['ARS'];
		 }else{
			 $currency_symbol_price=$price*1;
		 }
		 return round($currency_symbol_price,2);
	}

function custom_posts_per_page($query){ 
     if($query->query['blog_catalog']!=''||$query->query['post_type']=='blog'){
		 $query->set('posts_per_page',8);
	 }
	 
	      if($query->query['video_catalog']!=''||$query->query['post_type']=='video'){
		 $query->set('posts_per_page',100);
	 }
	 
	 
	      if($query->query['gallery_catalog']!=''||$query->query['post_type']=='gallery'){
		 $query->set('posts_per_page',100);
	 }
	 
	 
	 
}

// 排序
if (!function_exists('eshop_listorderColumn')) {
	function eshop_listorderColumn($cols) {
		$cols['listorder'] = __('排序');
		return $cols;
	} 
	function eshop_listorderValue($column_name, $post_id) {
		if ( 'listorder' == $column_name ) {
		    $listorder = get_post_meta($post_id, '_listorder', true);
		    if(!$listorder){
				update_post_meta($post_id, "_listorder", $post_id);
				$listorder=$post_id;
			}
		    echo '<input type="text" size="4" id="listorder_'.$post_id.'_val" name="listorder_post['.$post_id.'][listorder]" value="'.$listorder.'"><a class="listorder_edit" href="javascript:void(0);" id="listorder_'.$post_id.'" data-pid="'.$post_id.'"><img src="/wp-content/plugins/all-in-one-seo-pack/images/accept.png" border="0" alt="" title="修改"></a>';
		}
	} 
}
// for posts
add_filter( 'manage_posts_columns', 'eshop_listorderColumn' );
add_action( 'manage_posts_custom_column', 'eshop_listorderValue', 10, 2 );

function edit_listorder() {
    global $current_user;
    $post_id = $_POST['post_id'];
	$listorder = $_POST['listorder']?intval($_POST['listorder']):0;
    update_post_meta($post_id, "_listorder", $listorder);
    exit();
} 
add_action('wp_ajax_edit_listorder', "edit_listorder");

if ( !function_exists( 'listorder_admin_head' ) ) {
	function listorder_admin_head() {
?>

<script type="text/javascript">
$('.listorder_edit').click(function(){
	  var post_id = $(this).attr("data-pid");
	  var listorder = $('#listorder_'+post_id+'_val').val();
	  $.post("/wp-admin/admin-ajax.php", {action: 'edit_listorder', post_id: post_id, listorder:listorder },function(data){
		 alert("修改成功！ ");
	   });
})
	 
</script>
<?php
	}
}
add_action( 'admin_footer', 'listorder_admin_head' );

function save_listorder( $post_id ) {
    $listorder = get_post_meta($post_id, '_listorder', true);
    if($listorder == "")
      update_post_meta($post_id, '_listorder', $post_id);
}
add_action('save_post', 'save_listorder');
?>