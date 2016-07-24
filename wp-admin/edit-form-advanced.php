<?php
/**
 * Post advanced form for inclusion in the administration panels.
 *
 * @package WordPress
 * @subpackage Administration
 */

// don't load directly
if ( !defined('ABSPATH') )
	die('-1');

wp_enqueue_script('post');

if ( wp_is_mobile() )
	wp_enqueue_script( 'jquery-touch-punch' );

/**
 * Post ID global
 * @name $post_ID
 * @var int
 */
$post_ID = isset($post_ID) ? (int) $post_ID : 0;
$user_ID = isset($user_ID) ? (int) $user_ID : 0;
$action = isset($action) ? $action : '';

if ( post_type_supports($post_type, 'editor') || post_type_supports($post_type, 'thumbnail') ) {
	add_thickbox();
	wp_enqueue_media( array( 'post' => $post_ID ) );
}

// Add the local autosave notice HTML
add_action( 'admin_footer', '_local_storage_notice' );

$messages = array();
$messages['post'] = array(
	 0 => '', // Unused. Messages start at index 1.
	 1 => sprintf( __('更新已保存. <a target="_blank" href="%s">点击查看</a>'), esc_url( get_permalink($post_ID) ) ),
	 2 => __('Custom field updated.'),
	 3 => __('Custom field deleted.'),
	 4 => __('Post updated.'),
	/* translators: %s: date and time of the revision */
	 5 => isset($_GET['revision']) ? sprintf( __('恢复自动存档: %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
	 6 => sprintf( __('发布成功. <a target="_blank" href="%s">点击查看</a>'), esc_url( get_permalink($post_ID) ) ),
	 7 => __('Post saved.'),
	 8 => sprintf( __('提交成功. <a target="_blank" href="%s">预览</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	 9 => sprintf( __('定时发布: <strong>%1$s</strong>. <a target="_blank" href="%2$s">预览</a>'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
	10 => sprintf( __('草稿已保存. <a target="_blank" href="%s">点击查看</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
);
$messages['page'] = array(
	 0 => '', // Unused. Messages start at index 1.
	 1 => sprintf( __('更新已保存. <a target="_blank" href="%s">点击查看</a>'), esc_url( get_permalink($post_ID) ) ),
	 2 => __('Custom field updated.'),
	 3 => __('Custom field deleted.'),
	 4 => __('Page updated.'),
	 5 => isset($_GET['revision']) ? sprintf( __('恢复自动存档: %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
	 6 => sprintf( __('发布成功. <a href="%s">View page</a>'), esc_url( get_permalink($post_ID) ) ),
	 7 => __('Page saved.'),
	 8 => sprintf( __('提交成功. <a target="_blank" href="%s">预览</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	 9 => sprintf( __('定时发布: <strong>%1$s</strong>. <a target="_blank" href="%2$s">预览</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
	10 => sprintf( __('草稿已保存. <a target="_blank" href="%s">点击查看</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
);
$messages['attachment'] = array_fill( 1, 10, __( '媒体已更新.' ) ); // Hack, for now.

$messages = apply_filters( 'post_updated_messages', $messages );

$message = false;
if ( isset($_GET['message']) ) {
	$_GET['message'] = absint( $_GET['message'] );
	if ( isset($messages[$post_type][$_GET['message']]) )
		$message = $messages[$post_type][$_GET['message']];
	elseif ( !isset($messages[$post_type]) && isset($messages['post'][$_GET['message']]) )
		$message = $messages['post'][$_GET['message']];
}

$notice = false;
$form_extra = '';
if ( 'auto-draft' == $post->post_status ) {
	if ( 'edit' == $action )
		$post->post_title = '';
	$autosave = false;
	$form_extra .= "<input type='hidden' id='auto_draft' name='auto_draft' value='1' />";
} else {
	$autosave = wp_get_post_autosave( $post_ID );
}

$form_action = 'editpost';
$nonce_action = 'update-post_' . $post_ID;
$form_extra .= "<input type='hidden' id='post_ID' name='post_ID' value='" . esc_attr($post_ID) . "' />";

// Detect if there exists an autosave newer than the post and if that autosave is different than the post
if ( $autosave && mysql2date( 'U', $autosave->post_modified_gmt, false ) > mysql2date( 'U', $post->post_modified_gmt, false ) ) {
	foreach ( _wp_post_revision_fields() as $autosave_field => $_autosave_field ) {
		if ( normalize_whitespace( $autosave->$autosave_field ) != normalize_whitespace( $post->$autosave_field ) ) {
			$notice = sprintf( __( 'There is an autosave of this post that is more recent than the version below. <a href="%s">View the autosave</a>' ), get_edit_post_link( $autosave->ID ) );
			break;
		}
	}
	// If this autosave isn't different from the current post, begone.
	if ( ! $notice )
		wp_delete_post_revision( $autosave->ID );
	unset($autosave_field, $_autosave_field);
}

$post_type_object = get_post_type_object($post_type);

// All meta boxes should be defined and added before the first do_meta_boxes() call (or potentially during the do_meta_boxes action).
require_once('./includes/meta-boxes.php');


$publish_callback_args = null;
if ( post_type_supports($post_type, 'revisions') && 'auto-draft' != $post->post_status ) {
	$revisions = wp_get_post_revisions( $post_ID );

	// Check if the revisions have been upgraded
	if ( ! empty( $revisions ) && _wp_get_post_revision_version( end( $revisions ) ) < 1 )
		_wp_upgrade_revisions_of_post( $post, $revisions );

	// We should aim to show the revisions metabox only when there are revisions.
	if ( count( $revisions ) > 1 ) {
		reset( $revisions ); // Reset pointer for key()
		$publish_callback_args = array( 'revisions_count' => count( $revisions ), 'revision_id' => key( $revisions ) );
		add_meta_box('revisionsdiv', __('Revisions'), 'post_revisions_meta_box', null, 'normal', 'core');
	}
}

if ( 'attachment' == $post_type ) {
	wp_enqueue_script( 'image-edit' );
	wp_enqueue_style( 'imgareaselect' );
	add_meta_box( 'submitdiv', __('Save'), 'attachment_submit_meta_box', null, 'side', 'core' );
	add_action( 'edit_form_after_title', 'edit_form_image_editor' );
} else {
	add_meta_box( 'submitdiv', __( 'Publish' ), 'post_submit_meta_box', null, 'side', 'core', $publish_callback_args );
}

if ( current_theme_supports( 'post-formats' ) && post_type_supports( $post_type, 'post-formats' ) )
	add_meta_box( 'formatdiv', _x( 'Format', 'post format' ), 'post_format_meta_box', null, 'side', 'core' );

// all taxonomies
foreach ( get_object_taxonomies( $post ) as $tax_name ) {
	$taxonomy = get_taxonomy($tax_name);
	if ( ! $taxonomy->show_ui )
		continue;

	$label = $taxonomy->labels->name;

	if ( !is_taxonomy_hierarchical($tax_name) )
		add_meta_box('tagsdiv-' . $tax_name, $label, 'post_tags_meta_box', null, 'side', 'core', array( 'taxonomy' => $tax_name ));
	else
		add_meta_box($tax_name . 'div', $label, 'post_categories_meta_box', null, 'side', 'core', array( 'taxonomy' => $tax_name ));
}

if ( post_type_supports($post_type, 'page-attributes') )
	add_meta_box('pageparentdiv', 'page' == $post_type ? __('Page Attributes') : __('Attributes'), 'page_attributes_meta_box', null, 'side', 'core');

$audio_post_support = $video_post_support = false;
$theme_support = current_theme_supports( 'post-thumbnails', $post_type ) && post_type_supports( $post_type, 'thumbnail' );
if ( 'attachment' === $post_type && ! empty( $post->post_mime_type ) ) {
	$audio_post_support = 0 === strpos( $post->post_mime_type, 'audio/' ) && current_theme_supports( 'post-thumbnails', 'attachment:audio' ) && post_type_supports( 'attachment:audio', 'thumbnail' );
	$video_post_support = 0 === strpos( $post->post_mime_type, 'video/' ) && current_theme_supports( 'post-thumbnails', 'attachment:video' ) && post_type_supports( 'attachment:video', 'thumbnail' );
}

if ( $theme_support || $audio_post_support || $video_post_support )
	add_meta_box('postimagediv', __('产品封面图'), 'post_thumbnail_meta_box', null, 'side', 'low');

if ( post_type_supports($post_type, 'excerpt') )
	add_meta_box('postexcerpt', __('Excerpt'), 'post_excerpt_meta_box', null, 'normal', 'core');

if ( post_type_supports($post_type, 'trackbacks') )
	add_meta_box('trackbacksdiv', __('Send Trackbacks'), 'post_trackback_meta_box', null, 'normal', 'core');

if ( post_type_supports($post_type, 'custom-fields') )
	add_meta_box('postcustom', __('Custom Fields'), 'post_custom_meta_box', null, 'normal', 'core');

do_action('dbx_post_advanced', $post);
if ( post_type_supports($post_type, 'comments') )
	add_meta_box('commentstatusdiv', __('Discussion'), 'post_comment_status_meta_box', null, 'normal', 'core');

if ( ( 'publish' == get_post_status( $post ) || 'private' == get_post_status( $post ) ) && post_type_supports($post_type, 'comments') )
	add_meta_box('commentsdiv', __('Comments'), 'post_comment_meta_box', null, 'normal', 'core');

if ( ! ( 'pending' == get_post_status( $post ) && ! current_user_can( $post_type_object->cap->publish_posts ) ) )
	add_meta_box('slugdiv', __('Slug'), 'post_slug_meta_box', null, 'normal', 'core');

if ( post_type_supports($post_type, 'author') ) {
	if ( is_super_admin() || current_user_can( $post_type_object->cap->edit_others_posts ) )
		add_meta_box('authordiv', __('Author'), 'post_author_meta_box', null, 'normal', 'core');
}

do_action('add_meta_boxes', $post_type, $post);
do_action('add_meta_boxes_' . $post_type, $post);

do_action('do_meta_boxes', $post_type, 'normal', $post);
do_action('do_meta_boxes', $post_type, 'advanced', $post);
do_action('do_meta_boxes', $post_type, 'side', $post);

add_screen_option('layout_columns', array('max' => 2, 'default' => 2) );

if ( 'post' == $post_type ) {
} elseif ( 'page' == $post_type ) {
} elseif ( 'attachment' == $post_type ) {
}
if ( 'post' == $post_type || 'page' == $post_type ) {
}
if ( 'post' == $post_type ) {
} elseif ( 'page' == $post_type ) {
}
require_once('./admin-header.php');
?>

<div class="wrap">

<?php if ( $post_type == 'ad_img' | $post_type == 'about' | $post_type == 'lianxi' | $post_type == 'productitems' | $post_type == 'sns'  | $post_type == 'transall' | $post_type == '3code' | $post_type == 'productsxm' | $post_type == 'home')  : ?>
<?php else: ?>
<?php screen_icon(); ?>
<h2>


<?php
echo '正在编辑...';
if ( isset( $post_new_file ) && current_user_can( $post_type_object->cap->create_posts ) )
	echo ' <a href="' . esc_url( $post_new_file ) . '" class="add-new-h2">新建</a>';
?>
 <?php
    if( empty( $original ) ) {
        $class = ' class="button"';
        $title = PNV_STR_COPY_BUTTON;
    }
    else {
        $class = '';
        $title = PNV_STR_ADD_NEW_FROM_BUTTON;
    }
    ?>
    <a class="add-new-h2" href="<?php echo add_query_arg( PNV_ACTION_NAME, PNV_COPY_ACTION , PNV::get_action_url( $post, PNV_COPY_ACTION ) ); ?>" id="copy"<?php echo $class; ?>>复制</a>

</h2>



<?php if ( $notice ) : ?>
<div id="notice" class="error"><p id="has-newer-autosave"><?php echo $notice ?></p></div>
<?php endif; ?>
<?php if ( $message ) : ?>
<div id="message" class="updated"><p><?php echo $message; ?></p></div>
<?php endif; ?>
<div id="lost-connection-notice" class="error hidden">
	<p><span class="spinner"></span> <?php _e( '<strong>Connection lost.</strong> Saving has been disabled until you&#8217;re reconnected.' ); ?>
	<span class="hide-if-no-sessionstorage"><?php _e( 'We&#8217;re backing up this post in your browser, just in case.' ); ?></span>
	</p>
</div>

<?php endif; ?>

<form name="post" action="post.php" method="post" id="post"<?php do_action('post_edit_form_tag', $post); ?>>
<?php wp_nonce_field($nonce_action); ?>
<input type="hidden" id="user-id" name="user_ID" value="<?php echo (int) $user_ID ?>" />
<input type="hidden" id="hiddenaction" name="action" value="<?php echo esc_attr( $form_action ) ?>" />
<input type="hidden" id="originalaction" name="originalaction" value="<?php echo esc_attr( $form_action ) ?>" />
<input type="hidden" id="post_author" name="post_author" value="<?php echo esc_attr( $post->post_author ); ?>" />
<input type="hidden" id="post_type" name="post_type" value="<?php echo esc_attr( $post_type ) ?>" />
<input type="hidden" id="original_post_status" name="original_post_status" value="<?php echo esc_attr( $post->post_status) ?>" />
<input type="hidden" id="referredby" name="referredby" value="<?php echo esc_url(wp_get_referer()); ?>" />
<?php if ( ! empty( $active_post_lock ) ) { ?>
<input type="hidden" id="active_post_lock" value="<?php echo esc_attr( implode( ':', $active_post_lock ) ); ?>" />
<?php
}
if ( 'draft' != get_post_status( $post ) )
	wp_original_referer_field(true, 'previous');

echo $form_extra;

wp_nonce_field( 'autosave', 'autosavenonce', false );
wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
?>

<div id="poststuff">
<div id="post-body" class="metabox-holder columns-<?php echo 1 == get_current_screen()->get_columns() ? '1' : '2'; ?>">
<div id="post-body-content">

<?php if ( post_type_supports($post_type, 'title') ) { ?>
<?php if ( $post_type == 'ad_img' | $post_type == 'about' | $post_type == 'lianxi' | $post_type == 'productitems' | $post_type == 'sns'  | $post_type == 'transall' | $post_type == '3code' | $post_type == 'home')  : ?>
<?php else: ?>
<div id="titlediv">


<div id="titlewrap">
	<label class="screen-reader-text" id="title-prompt-text" for="title"><?php echo apply_filters( 'enter_title_here', __( 'Enter title here' ), $post ); ?></label>
	<input type="text" name="post_title" size="30" value="<?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?>" id="title" autocomplete="off" />
</div>


<div class="inside">
<?php
$sample_permalink_html = $post_type_object->public ? get_sample_permalink_html($post->ID) : '';
$shortlink = wp_get_shortlink($post->ID, 'post');
if ( !empty($shortlink) )
    $sample_permalink_html .= '<input id="shortlink" type="hidden" value="' . esc_attr($shortlink) . '" /><a href="#" class="button button-small" onclick="prompt(&#39;URL:&#39;, jQuery(\'#shortlink\').val()); return false;">' . __('Get Shortlink') . '</a>';

if ( $post_type_object->public && ! ( 'pending' == get_post_status( $post ) && !current_user_can( $post_type_object->cap->publish_posts ) ) ) {
	$has_sample_permalink = $sample_permalink_html && 'auto-draft' != $post->post_status;
?>
	<div id="edit-slug-box" class="hide-if-no-js">
	<?php
		if ( $has_sample_permalink )
			echo $sample_permalink_html;
	?>
	</div>
<?php
}
?>
</div>
<?php
wp_nonce_field( 'samplepermalink', 'samplepermalinknonce', false );
?>
</div><!-- /titlediv -->
<?php endif; ?>
<?php
}

do_action( 'edit_form_after_title', $post );

if ( post_type_supports($post_type, 'editor') ) {
?>
<div id="postdivrich" class="postarea edit-form-section">

<?php wp_editor( $post->post_content, 'content', array(
	'dfw' => true,
	'tabfocus_elements' => 'insert-media-button,save-post',
	'editor_height' => 360,
) ); ?>
<table id="post-status-info" cellspacing="0"><tbody><tr>
	<td id="wp-word-count"><?php printf( __( 'Word count: %s' ), '<span class="word-count">0</span>' ); ?></td>
	<td class="autosave-info">
	<span class="autosave-message">&nbsp;</span>
<?php
	if ( 'auto-draft' != $post->post_status ) {
		echo '<span id="last-edit">';
		if ( $last_id = get_post_meta($post_ID, '_edit_last', true) ) {
			$last_user = get_userdata($last_id);
			printf(__('Last edited by %1$s on %2$s at %3$s'), esc_html( $last_user->display_name ), mysql2date(get_option('date_format'), $post->post_modified), mysql2date(get_option('time_format'), $post->post_modified));
		} else {
			printf(__('Last edited on %1$s at %2$s'), mysql2date(get_option('date_format'), $post->post_modified), mysql2date(get_option('time_format'), $post->post_modified));
		}
		echo '</span>';
	} ?>
	</td>
</tr></tbody></table>

</div>
<?php }

do_action( 'edit_form_after_editor', $post );
?>
</div><!-- /post-body-content -->

<div id="postbox-container-1" class="postbox-container">

<?php

if ( 'page' == $post_type )
	do_action('submitpage_box', $post);
else
	do_action('submitpost_box', $post);

do_meta_boxes($post_type, 'side', $post);

?>

</div>




<div id="postbox-container-2" class="postbox-container">






<!--// 形象广告 -->


<?php if ( $post_type == 'ad_img' ) : ?>

<style type="text/css">
.edit-detail-change{width:100%; float:left;}
.edit-detail-tabs:after{content:"";display:block;clear:both;visibility:hidden;height:0;}
.edit-detail-tabs{*zoom:1;}
.edit-detail-tabs {height:35px;line-height:35px;border-bottom:1px solid #6f6f6f;font-size:16px;margin:0 auto 10px;}
.edit-detail-tabs li{float:left;padding:0 8px;background:#6f6f6f;border-radius:3px 3px 0 0;font-size:12px;margin:0 2px -2px 0;position:relative;z-index:22;cursor:pointer; }
.edit-detail-tabs li,.edit-detail-tabs li a{color:#fff;}
.edit-detail-tabs li.current{background:#42586f;}
.edit-detail-tabs li.current,.edit-detail-tabs li.current a{color:#fff;}
#acf_1272{margin-top:-10px;}
#acf_1273,#acf_1274,#acf_1229,#acf_1276,#acf_1275,#acf_1278,#acf_1277,#acf_1299,#acf_1433,#acf_1230 ,#xxxxx ,#xxxxx ,#xxxxx ,#xxxxx {display:none;margin-top:-10px;}
#acf_1272 h3, #acf_1273 h3 ,#acf_1274 h3 ,#acf_1229 h3 ,#acf_1276 h3 ,#acf_1275 h3 ,#acf_1278 h3 ,#acf_1277 h3 ,#acf_1299 h3 ,#acf_1433 h3 ,#acf_1230 h3 ,#xxxxx h3 ,#xxxxx h3 ,#xxxxx h3 ,#xxxxx h3 {display:none;}
</style>
<script>
$(document).ready(function(){
$('#acf_1272,#acf_1273,#acf_1274,#acf_1229,#acf_1276,#acf_1275,#acf_1278,#acf_1277,#acf_1299,#acf_1433,#acf_1230 ,#xxxxx ,#xxxxx ,#xxxxx ,#xxxxx ').addClass('edit-detail-panel')

})
</script>
<script>
$(document).ready(function(){
   $('.edit-detail-tabs li').click(function(){
      $(this).addClass('current').siblings().removeClass('current')
	  $('.edit-detail-panel').hide()
	  var activeClass=$(this).attr('class').split(" ")[0]
	  var activeCont='#'+activeClass
	  $(activeCont).show()
   })
})
</script>
<script>
$(document).ready(function(){
$('#acf_1230').appendTo('#acf_1230_show')
})
</script>


         <ul class="edit-detail-tabs">
            <li class="acf_1272 current">网站形象</li>
            <li class="acf_1275">首页广告图</li>
            <li class="acf_1274">侧栏广告</li>
            <li class="acf_1229">SNS设置</li>
            <li class="acf_1433">折扣信息</li>
            <li class="acf_1277">二维码</li>
            <li class="acf_1230">第三方代码</li>
            <li class="acf_1299">自定义字段</li>
			
         </ul>
		 	 

<div id="acf_1230_show"></div>


<?php endif; ?>











<!--// 产品信息切换 -->
<?php if ( $post_type == 'post' ) : ?>

<style type="text/css">
.edit-detail-change{width:100%; float:left;}
.edit-detail-tabs:after{content:"";display:block;clear:both;visibility:hidden;height:0;}
.edit-detail-tabs{*zoom:1;}
.edit-detail-tabs {height:35px;line-height:35px;border-bottom:1px solid #6f6f6f;font-size:16px;margin:0 auto 10px;}
.edit-detail-tabs li{float:left;padding:0 8px;background:#6f6f6f;border-radius:3px 3px 0 0;font-size:12px;margin:0 2px -2px 0;position:relative;z-index:22;cursor:pointer; }
.edit-detail-tabs li,.edit-detail-tabs li a{color:#fff;}
.edit-detail-tabs li.current{background:#42586f;}
.edit-detail-tabs li.current,.edit-detail-tabs li.current a{color:#fff;}
#acf_1139{margin-top:-10px;}
#commentsdiv,#sc_chat_opts,#pnv_duplicata_meta_box,#tagsdiv-post_tag,#combination_sale_box,#postimagediv,#epagepostcustom,#acf_45052,#acf_1102,#aiosp,#acf_1298,#wp_keyword_tool-meta-boxes ,#postdivrich ,#xxxxx ,#xxxxx ,#xxxxx ,#xxxxx{display:none;margin-top:-10px;}
#commentsdiv h3,#tagsdiv-post_tag h3,#combination_sale_box h3,#postimagediv h3,#epagepostcustom h3,#acf_1139 h3,#acf_45052 h3,#acf_1102 h3,#aiosp h3,#acf_1298 h3,#wp_keyword_tool-meta-boxes h3 ,#postdivrich h3 ,#xxxxx h3 ,#xxxxx h3 ,#xxxxx h3 ,#xxxxx h3 {display:none;}
</style>
<script>
$(document).ready(function(){
$('#commentsdiv,#tagsdiv-post_tag,#combination_sale_box,#postimagediv,#epagepostcustom,#acf_1139,#acf_45052,#acf_1102,#aiosp,#acf_1298,#wp_keyword_tool-meta-boxes ,#postdivrich ,#xxxxx ,#xxxxx ,#xxxxx ,#xxxxx ').addClass('edit-detail-panel')

})
</script>
<script>
$(document).ready(function(){
   $('.edit-detail-tabs li').click(function(){
      $(this).addClass('current').siblings().removeClass('current')
	  $('.edit-detail-panel').hide()
	  var activeClass=$(this).attr('class').split(" ")[0]
	  var activeCont='#'+activeClass
	  $(activeCont).show()
   })
})
</script>

<script>
$(document).ready(function(){
$('#postimagediv').appendTo('#postimagediv_show')
})
</script>
<script>
$(document).ready(function(){
$('#tagsdiv-post_tag').appendTo('#tagsdiv-post_tag_show')
})
</script>
<script>
$(document).ready(function(){
$('#combination_sale_box').appendTo('#combination_sale_box_show')
})
</script>

<script>
$(document).ready(function(){
$('#wp_keyword_tool-meta-boxes').appendTo('#wp_keyword_tool-meta-boxes_show')
})
</script>
<script>
$(document).ready(function(){
$('#postdivrich').appendTo('#postdivrich_show')
})
</script>

         <ul class="edit-detail-tabs">
            <li class="acf_1139 current">产品图片</li>
            <li class="epagepostcustom">产品参数</li>
            <li class="postdivrich">产品短描述</li>
            <li class="acf_1298">产品图文描述</li>
            <li class="acf_1102">显示选项</li>
 <!--   <li class="combination_sale_box">组合销售</li>  -->
            <li class="tagsdiv-post_tag">标签设置</li>
            <li class="commentsdiv">评论管理</li>
            <li class="wp_keyword_tool-meta-boxes">关键词分析</li>
            <li class="aiosp">SEO功能</li>
			
         </ul>
		 
<div id="postdivrich_show"></div>
<div id="postimagediv_show"></div>
<div id="combination_sale_box_show"></div>
<div id="tagsdiv-post_tag_show"></div>
<div id="wp_keyword_tool-meta-boxes_show"></div>
<?php endif; ?>






<?php

do_meta_boxes(null, 'normal', $post);

if ( 'page' == $post_type )
	do_action('edit_page_form', $post);
else
	do_action('edit_form_advanced', $post);

do_meta_boxes(null, 'advanced', $post);

?>
</div>
<?php

do_action('dbx_post_sidebar', $post);

?>
</div><!-- /post-body -->
<br class="clear" />
<style type="text/css">
.pnv_duplicata_meta_box_display,.sc_chat_opts_display{display:none;}
</style>
</div><!-- /poststuff -->
</form>
</div>

<?php
if ( post_type_supports( $post_type, 'comments' ) )
	wp_comment_reply();
?>

<?php if ( (isset($post->post_title) && '' == $post->post_title) || (isset($_GET['message']) && 2 > $_GET['message']) ) : ?>
<script type="text/javascript">
try{document.post.title.focus();}catch(e){}
</script>
<?php endif; ?>
