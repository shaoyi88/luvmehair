<?php
/*
 * Plugin Name:Wordpress Keyword Tool 
 * Plugin URI: http://codecanyon.net/item/wordpress-keyword-tool-plugin/2840111?ref=ValvePress 
 * Description: Keyword tool directly to your wordpress 
 * Version: 2.1.0
 * Author: Atef  
 * URI: http://codecanyon.net/user/ValvePress/portfolio?ref=ValvePress
 */

/*  Copyright 2012-2014  Wordpress Keyword Tool  (email : sweetheatmn@gmail.com) */

/* Add a new meta box to the admin menu. */
	add_action ( 'admin_menu', 'wp_keyword_tool_create_meta_box' );

/**
 * Function for adding meta boxes to the admin.
 */
function wp_keyword_tool_create_meta_box() {
	add_meta_box ( 'wp_keyword_tool-meta-boxes', __('关键词分析工具' ,'wp_keyword_tool'), 'wp_keyword_tool_meta_boxes', 'post', 'side', 'high' );
	
	add_meta_box ( 'wp_keyword_tool-meta-boxes', __('关键词分析工具' ,'wp_keyword_tool'), 'wp_keyword_tool_meta_boxes', 'page', 'side', 'high' );
	
}
function wp_keyword_tool_meta_boxes() {
	
	 global $post;
	 $pid=$post->ID;
	
	 ?>
注: 工具直接通过Google Adwords API、Google Trends等获取相关关键词列表，所以需要翻墙才能使用。
<hr>
	<input id="wp_keyword_tool_ajax_src" type="hidden" value="<?php echo site_url('/?wp_keyword_tool=ajax&pid='.$pid)  ?>"> <input type="text" value="" autocomplete="off" placeholder=<?php _e( 'Keyword...','wp_keyword_tool' ) ?> size="14" class="newtag form-input-tip" id="wp_keyword_tool_search_txt"> 
	<input type="button" tabindex="3" value="<?php _e('Search','wp_keyword_tool') ?>" class="button" id="wp_keyword_tool_more">
	<input type="button" tabindex="3" value="x" class="button tagadd" id="wp_keyword_tool_clean">
	 
	
	
<div id="wp_keyword_tool_body">
	
	
	<div id="wp_keyword_tool_keywords" class="wp-tab-panel"></div>
	
	<div style="margin-bottom:10px;padding-left:5px"><label><input type="checkbox" id="wp_keyword_tool_check" value="s"><?php _e('Check/uncheck all','wp_keyword_tool') ?></label></div>
	
	<input type="button"   value="<?php _e('添加到标签','wp_keyword_tool') ?>" class="button" id="wp_keyword_tool_tag_btn"> 
	<input type="button"   value="<?php _e('查看关键词密度','wp_keyword_tool') ?>" class="button" id="wp_keyword_tool_density_btn">
	
	<p>
		<?php _e('长尾关键词数量：','wp_keyword_tool') ?><span class="wp_keyword_tool_count"></span> <?php _e('搜索关键词：','wp_keyword_tool') ?><span class="wp_keyword_tool_keyword_status"></span>
	
	
	</p>
	
</div>

<div  style="display: none"  id="wp-keyword-tool-list-wrap">
	<textarea style="width:100%;height: 300px;" id="wp-keyword-tool-list"></textarea>
</div>




<?php
}
function wp_keyword_tool_meta_boxes2() {
	global $post;
	$pid=$post->ID;
	$oldkeys=get_post_meta($pid,'wp_keyword_tool_density',1 );
	
	if(! is_array($oldkeys)) $oldkeys=array();
	
	$display= ' style="display:none" ';
	if(count($oldkeys) >0) $display = "";
	
	echo '<div id="wp_keyword_tool_density_head" '.$display.' class="wp_keyword_tool_itm noborder"><div class="wp_keyword_tool_keyword"><strong>'.__('Keyword','wp_keyword_tool').'</strong></div><div class="wp_keyword_tool_volume"><strong>'.__('Density','wp_keyword_tool').'</strong></div><div class="clear"></div></div>';
	echo '<div id="wp_keyword_tool_keywords_density">'; 
	
	foreach($oldkeys as $key){
		?>
		<div class="wp_keyword_tool_itm tagchecklist"><span><a   class="ntdelbutton">X</a></span><div class="wp_keyword_tool_keyword"><?php echo $key ?></div><div class="wp_keyword_tool_volume">-</div><div class="clear"></div></div>
		<?php 
	}
	
	echo '</div>';
	?>

<p>
	<a id="wp_keyword_tool_density_info" href="#"><?php _e('What should density equal ?','wp_keyword_tool') ?></a>
<p style="display: none" class="the-tagcloud" id="wp_keyword_tool_density_info_box" style="display: block;">
	<?php _e('Ideal Keyword density for single keyword is','wp_keyword_tool') ?> <a href="http://www.submitedge.com/blog/ideal-keyword-density/">1-2%</a>
</p>
</p>

<?php
}

/*
 * settings menu
 */
add_action('admin_menu', 'wp_keyword_tool_control_menu');

function wp_keyword_tool_control_menu() {

	$page_hook_suffix = add_submenu_page( 'options-general.php', __('Keyword Tool','wp_keyword_tool'), 'Keyword tool', 'administrator', 'wp_keyword_tools_settings', 'wp_keword_tool_fn' );
	add_action('admin_print_scripts-' . $page_hook_suffix, 'wp_keyword_tool_options_scripts');

}

require_once 'options-keyword-tool.php';

function wp_keyword_tool_options_scripts(){
	wp_enqueue_script ( 'wp_keyword_tool_options_main', plugins_url ( '/js/options.js', __FILE__ ) );
	wp_enqueue_style ( 'wp-jquery-ui-dialog' );
	wp_enqueue_script ( 'jquery-ui-dialog' );
}	



/**
 * Function for adding header style sheets and js
 */

add_action ( 'admin_print_scripts-' . 'post-new.php', 'wp_keyword_tool_admin_scripts' );
add_action ( 'admin_print_scripts-' . 'post.php', 'wp_keyword_tool_admin_scripts' );
function wp_keyword_tool_admin_scripts() {
	
	wp_enqueue_style ( 'wp-jquery-ui-dialog' );
	wp_enqueue_script ( 'jquery-ui-dialog' );


	//load letters and google source to js

	$wp_keyword_tool_alphabets=get_option('wp_keyword_tool_alphabets','a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z');	

	$letters_arr=explode(',', trim($wp_keyword_tool_alphabets));
	$letters=array_filter($letters_arr);
	$wp_keyword_tool_google = trim( get_option('wp_keyword_tool_google','google.com'));
	
	?> <script type="text/javascript">
			
			var wp_keyword_tool_letters=<?php echo json_encode($letters) ; ?>;
			var wp_keyword_tool_google = '<?php echo ($wp_keyword_tool_google) ; ?>';
			</script>
	<?php 
	// jquery main
	wp_enqueue_script ( 'wp_keyword_tool_jquery_main', plugins_url ( '/js/main.js', __FILE__ ) );
	
	// jquery gcomplete main
	wp_enqueue_script ( 'wp_keyword_tool_jquery_gcomplete', plugins_url ( '/js/jquery.gcomplete.0.1.2.js', __FILE__ ) );
	
	wp_enqueue_style ( 'wp_keyword_tool-admin-style', plugins_url ( 'css/style.css', __FILE__ ) );
	wp_enqueue_style ( 'wp_keyword_tool-admin-style-gcomplete', plugins_url ( 'css/jquery.gcomplete.default-themes.css', __FILE__ ) );
}

/**
 * custom request for fetch boards
 */
function wp_keyword_tool_parse_request($wp) {
	
	// only process requests with "my-plugin=ajax-handler"
	if (array_key_exists ( 'wp_keyword_tool', $wp->query_vars )) {
		
		if ($wp->query_vars ['wp_keyword_tool'] == 'ajax') {
			
			require_once ('wp_keyword_ajax.php');
			exit ();
		}
	}
}
add_action ( 'parse_request', 'wp_keyword_tool_parse_request' );
function wp_keyword_tool_query_vars($vars) {
	$vars [] = 'wp_keyword_tool';
	return $vars;
}
add_filter ( 'query_vars', 'wp_keyword_tool_query_vars' );


/* ------------------------------------------------------------------------*
 * Function Selected
* ------------------------------------------------------------------------*/
if(! function_exists('opt_selected')){
	function opt_selected($src,$val){
		if (trim($src)==trim($val)) echo ' selected="selected" ';
	}
}

/*
 * widget
 */
require_once 'widget.php';
 

require_once 'updated.php';

//translating the plugin
require_once 'ptranslation.php';

 