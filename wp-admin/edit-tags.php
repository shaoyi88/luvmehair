<?php
/**
 * Edit Tags Administration Screen.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
require_once('./admin.php');

if ( ! $taxnow )
	wp_die( __( 'Invalid taxonomy' ) );

$tax = get_taxonomy( $taxnow );

if ( ! $tax )
	wp_die( __( 'Invalid taxonomy' ) );

if ( ! current_user_can( $tax->cap->manage_terms ) )
	wp_die( __( 'Cheatin&#8217; uh?' ) );

$wp_list_table = _get_list_table('WP_Terms_List_Table');
$pagenum = $wp_list_table->get_pagenum();

$title = $tax->labels->name;

if ( 'post' != $post_type ) {
	$parent_file = ( 'attachment' == $post_type ) ? 'upload.php' : "edit.php?post_type=$post_type";
	$submenu_file = "edit-tags.php?taxonomy=$taxonomy&amp;post_type=$post_type";
} else if ( 'link_category' == $tax->name ) {
	$parent_file = 'link-manager.php';
	$submenu_file = 'edit-tags.php?taxonomy=link_category';
} else {
	$parent_file = 'edit.php';
	$submenu_file = "edit-tags.php?taxonomy=$taxonomy";
}

add_screen_option( 'per_page', array( 'label' => $title, 'default' => 20, 'option' => 'edit_' . $tax->name . '_per_page' ) );

switch ( $wp_list_table->current_action() ) {

case 'add-tag':

	check_admin_referer( 'add-tag', '_wpnonce_add-tag' );

	if ( !current_user_can( $tax->cap->edit_terms ) )
		wp_die( __( 'Cheatin&#8217; uh?' ) );

	$ret = wp_insert_term( $_POST['tag-name'], $taxonomy, $_POST );
	$location = 'edit-tags.php?taxonomy=' . $taxonomy;
	if ( 'post' != $post_type )
		$location .= '&post_type=' . $post_type;

	if ( $referer = wp_get_original_referer() ) {
		if ( false !== strpos( $referer, 'edit-tags.php' ) )
			$location = $referer;
	}

	if ( $ret && !is_wp_error( $ret ) )
		$location = add_query_arg( 'message', 1, $location );
	else
		$location = add_query_arg( 'message', 4, $location );
	wp_redirect( $location );
	exit;
break;

case 'delete':
	$location = 'edit-tags.php?taxonomy=' . $taxonomy;
	if ( 'post' != $post_type )
		$location .= '&post_type=' . $post_type;
	if ( $referer = wp_get_referer() ) {
		if ( false !== strpos( $referer, 'edit-tags.php' ) )
			$location = $referer;
	}

	if ( !isset( $_REQUEST['tag_ID'] ) ) {
		wp_redirect( $location );
		exit;
	}

	$tag_ID = (int) $_REQUEST['tag_ID'];
	check_admin_referer( 'delete-tag_' . $tag_ID );

	if ( !current_user_can( $tax->cap->delete_terms ) )
		wp_die( __( 'Cheatin&#8217; uh?' ) );

	wp_delete_term( $tag_ID, $taxonomy );

	$location = add_query_arg( 'message', 2, $location );
	wp_redirect( $location );
	exit;

break;

case 'bulk-delete':
	check_admin_referer( 'bulk-tags' );

	if ( !current_user_can( $tax->cap->delete_terms ) )
		wp_die( __( 'Cheatin&#8217; uh?' ) );

	$tags = (array) $_REQUEST['delete_tags'];
	foreach ( $tags as $tag_ID ) {
		wp_delete_term( $tag_ID, $taxonomy );
	}

	$location = 'edit-tags.php?taxonomy=' . $taxonomy;
	if ( 'post' != $post_type )
		$location .= '&post_type=' . $post_type;
	if ( $referer = wp_get_referer() ) {
		if ( false !== strpos( $referer, 'edit-tags.php' ) )
			$location = $referer;
	}

	$location = add_query_arg( 'message', 6, $location );
	wp_redirect( $location );
	exit;

break;

case 'edit':
	$title = $tax->labels->edit_item;

	$tag_ID = (int) $_REQUEST['tag_ID'];

	$tag = get_term( $tag_ID, $taxonomy, OBJECT, 'edit' );
	if ( ! $tag )
		wp_die( __( 'You attempted to edit an item that doesn&#8217;t exist. Perhaps it was deleted?' ) );
	require_once ( 'admin-header.php' );
	include( './edit-tag-form.php' );

break;

case 'editedtag':
	$tag_ID = (int) $_POST['tag_ID'];
	check_admin_referer( 'update-tag_' . $tag_ID );

	if ( !current_user_can( $tax->cap->edit_terms ) )
		wp_die( __( 'Cheatin&#8217; uh?' ) );

	$tag = get_term( $tag_ID, $taxonomy );
	if ( ! $tag )
		wp_die( __( 'You attempted to edit an item that doesn&#8217;t exist. Perhaps it was deleted?' ) );

	$ret = wp_update_term( $tag_ID, $taxonomy, $_POST );

	$location = 'edit-tags.php?taxonomy=' . $taxonomy;
	if ( 'post' != $post_type )
		$location .= '&post_type=' . $post_type;

	if ( $referer = wp_get_original_referer() ) {
		if ( false !== strpos( $referer, 'edit-tags.php' ) )
			$location = $referer;
	}

	if ( $ret && !is_wp_error( $ret ) )
		$location = add_query_arg( 'message', 3, $location );
	else
		$location = add_query_arg( 'message', 5, $location );

	wp_redirect( $location );
	exit;
break;

default:
if ( ! empty($_REQUEST['_wp_http_referer']) ) {
	$location = remove_query_arg( array('_wp_http_referer', '_wpnonce'), wp_unslash($_SERVER['REQUEST_URI']) );

	if ( ! empty( $_REQUEST['paged'] ) )
		$location = add_query_arg( 'paged', (int) $_REQUEST['paged'] );

	wp_redirect( $location );
	exit;
}

$wp_list_table->prepare_items();
$total_pages = $wp_list_table->get_pagination_arg( 'total_pages' );

if ( $pagenum > $total_pages && $total_pages > 0 ) {
	wp_redirect( add_query_arg( 'paged', $total_pages ) );
	exit;
}

wp_enqueue_script('admin-tags');
if ( current_user_can($tax->cap->edit_terms) )
	wp_enqueue_script('inline-edit-tax');



require_once ('admin-header.php');

if ( !current_user_can($tax->cap->edit_terms) )
	wp_die( __('You are not allowed to edit this item.') );

$messages[1] = __('Item added.');
$messages[2] = __('Item deleted.');
$messages[3] = __('Item updated.');
$messages[4] = __('Item not added.');
$messages[5] = __('Item not updated.');
$messages[6] = __('Items deleted.');

?>

<div class="wrap nosubsub">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title );
if ( !empty($_REQUEST['s']) )
	printf( '<span class="subtitle">' . __('Search results for &#8220;%s&#8221;') . '</span>', esc_html( wp_unslash($_REQUEST['s']) ) ); ?>
</h2>

<?php if ( isset($_REQUEST['message']) && ( $msg = (int) $_REQUEST['message'] ) ) : ?>
<div id="message" class="updated"><p><?php echo $messages[$msg]; ?></p></div>
<?php $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
endif; ?>
<div id="ajax-response"></div>

<form class="search-form" action="" method="get">
<input type="hidden" name="taxonomy" value="<?php echo esc_attr($taxonomy); ?>" />
<input type="hidden" name="post_type" value="<?php echo esc_attr($post_type); ?>" />

<?php $wp_list_table->search_box( $tax->labels->search_items, 'tag' ); ?>

</form>
<br class="clear" />

<div id="col-container">

<div id="col-right">
<div class="col-wrap">
<form id="posts-filter" action="" method="post">
<input type="hidden" name="taxonomy" value="<?php echo esc_attr($taxonomy); ?>" />
<input type="hidden" name="post_type" value="<?php echo esc_attr($post_type); ?>" />

<?php $wp_list_table->display(); ?>

<br class="clear" />
</form>

<?php if ( 'category' == $taxonomy ) : ?>
<div class="form-wrap">
<?php if ( current_user_can( 'import' ) ) : ?>
<?php endif; ?>
</div>
<?php elseif ( 'post_tag' == $taxonomy && current_user_can( 'import' ) ) : ?>
<div class="form-wrap">
</div>
<?php endif;
do_action('after-' . $taxonomy . '-table', $taxonomy);
?>

</div>
</div><!-- /col-right -->

<div id="col-left">
<div class="col-wrap">

<?php

if ( !is_null( $tax->labels->popular_items ) ) {
	if ( current_user_can( $tax->cap->edit_terms ) )
		$tag_cloud = wp_tag_cloud( array( 'taxonomy' => $taxonomy, 'echo' => false, 'link' => 'edit' ) );
	else
		$tag_cloud = wp_tag_cloud( array( 'taxonomy' => $taxonomy, 'echo' => false ) );

	if ( $tag_cloud ) :
	?>
<div class="tagcloud">
<h3><?php echo $tax->labels->popular_items; ?></h3>
<?php echo $tag_cloud; unset( $tag_cloud ); ?>
</div>
<?php
endif;
}

if ( current_user_can($tax->cap->edit_terms) ) {
	// Back compat hooks. Deprecated in preference to {$taxonomy}_pre_add_form
	if ( 'category' == $taxonomy )
		do_action('add_category_form_pre', (object)array('parent' => 0) );
	elseif ( 'link_category' == $taxonomy )
		do_action('add_link_category_form_pre', (object)array('parent' => 0) );
	else
		do_action('add_tag_form_pre', $taxonomy);

	do_action($taxonomy . '_pre_add_form', $taxonomy);
?>

<div class="form-wrap">
<h3><?php echo $tax->labels->add_new_item; ?></h3>
<form id="addtag" method="post" action="edit-tags.php" class="validate">
<input type="hidden" name="action" value="add-tag" />
<input type="hidden" name="screen" value="<?php echo esc_attr($current_screen->id); ?>" />
<input type="hidden" name="taxonomy" value="<?php echo esc_attr($taxonomy); ?>" />
<input type="hidden" name="post_type" value="<?php echo esc_attr($post_type); ?>" />
<?php wp_nonce_field('add-tag', '_wpnonce_add-tag'); ?>

<div class="form-field form-required">
	<label for="tag-name"><?php _ex('Name', 'Taxonomy Name'); ?></label>
	<input name="tag-name" id="tag-name" type="text" value="" size="40" aria-required="true" />
	<p><?php _e('The name is how it appears on your site.'); ?></p>
</div>
<?php if ( ! global_terms_enabled() ) : ?>
<div class="form-field">
	<label for="tag-slug"><?php _ex('Slug', 'Taxonomy Slug'); ?></label>
	<input name="slug" id="tag-slug" type="text" value="" size="40" />
	<p><?php _e('The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.'); ?></p>
</div>
<?php endif; // global_terms_enabled() ?>
<?php if ( is_taxonomy_hierarchical($taxonomy) ) : ?>
<div class="form-field">
	<label for="parent"><?php _ex('Parent', 'Taxonomy Parent'); ?></label>
	<?php wp_dropdown_categories(array('hide_empty' => 0, 'hide_if_empty' => false, 'taxonomy' => $taxonomy, 'name' => 'parent', 'orderby' => 'name', 'hierarchical' => true, 'show_option_none' => __('None'))); ?>
	<?php if ( 'category' == $taxonomy ) : // @todo: Generic text for hierarchical taxonomies ?>
		<p><?php _e('Categories, unlike tags, can have a hierarchy. You might have a Jazz category, and under that have children categories for Bebop and Big Band. Totally optional.'); ?></p>
	<?php endif; ?>
</div>
<?php endif; // is_taxonomy_hierarchical() ?>
<div class="form-field">
	<label for="tag-description"><?php _ex('Description', 'Taxonomy Description'); ?></label>
	<textarea name="description" id="tag-description" rows="5" cols="40"></textarea>
	<p><?php _e('The description is not prominent by default; however, some themes may show it.'); ?></p>
</div>

<?php
if ( ! is_taxonomy_hierarchical($taxonomy) )
	do_action('add_tag_form_fields', $taxonomy);
do_action($taxonomy . '_add_form_fields', $taxonomy);

submit_button( $tax->labels->add_new_item );

// Back compat hooks. Deprecated in preference to {$taxonomy}_add_form
if ( 'category' == $taxonomy )
	do_action('edit_category_form', (object)array('parent' => 0) );
elseif ( 'link_category' == $taxonomy )
	do_action('edit_link_category_form', (object)array('parent' => 0) );
else
	do_action('add_tag_form', $taxonomy);

do_action($taxonomy . '_add_form', $taxonomy);
?>
</form></div>
<?php } ?>

</div>
</div><!-- /col-left -->

</div><!-- /col-container -->
</div><!-- /wrap -->
<script type="text/javascript">
try{document.forms.addtag['tag-name'].focus();}catch(e){}
</script>
<?php $wp_list_table->inline_edit(); ?>

<?php
break;
}

include('./admin-footer.php');
