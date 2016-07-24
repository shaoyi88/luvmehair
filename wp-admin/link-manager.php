<?php
/**
 * Link Management Administration Screen.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** Load WordPress Administration Bootstrap */
require_once ('admin.php');
if ( ! current_user_can( 'manage_links' ) )
	wp_die( __( 'You do not have sufficient permissions to edit the links for this site.' ) );

$wp_list_table = _get_list_table('WP_Links_List_Table');

// Handle bulk deletes
$doaction = $wp_list_table->current_action();

if ( $doaction && isset( $_REQUEST['linkcheck'] ) ) {
	check_admin_referer( 'bulk-bookmarks' );

	if ( 'delete' == $doaction ) {
		$bulklinks = (array) $_REQUEST['linkcheck'];
		foreach ( $bulklinks as $link_id ) {
			$link_id = (int) $link_id;

			wp_delete_link( $link_id );
		}

		wp_redirect( add_query_arg('deleted', count( $bulklinks ), admin_url( 'link-manager.php' ) ) );
		exit;
	}
} elseif ( ! empty( $_GET['_wp_http_referer'] ) ) {
	 wp_redirect( remove_query_arg( array( '_wp_http_referer', '_wpnonce' ), wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
	 exit;
}

$wp_list_table->prepare_items();

$title = __('Links');
$this_file = $parent_file = 'link-manager.php';


include_once ('./admin-header.php');

if ( ! current_user_can('manage_links') )
	wp_die(__("You do not have sufficient permissions to edit the links for this site."));

?>

<div class="wrap nosubsub">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?> <a href="link-add.php" class="add-new-h2"><?php echo esc_html_x('Add New', 'link'); ?></a> <?php
if ( !empty($_REQUEST['s']) )
	printf( '<span class="subtitle">' . __('Search results for &#8220;%s&#8221;') . '</span>', esc_html( wp_unslash($_REQUEST['s']) ) ); ?>
</h2>

<?php
if ( isset($_REQUEST['deleted']) ) {
	echo '<div id="message" class="updated"><p>';
	$deleted = (int) $_REQUEST['deleted'];
	printf(_n('%s link deleted.', '%s links deleted', $deleted), $deleted);
	echo '</p></div>';
	$_SERVER['REQUEST_URI'] = remove_query_arg(array('deleted'), $_SERVER['REQUEST_URI']);
}
?>

<form id="posts-filter" action="" method="get">

<?php $wp_list_table->search_box( __( 'Search Links' ), 'link' ); ?>

<?php $wp_list_table->display(); ?>

<div id="ajax-response"></div>
</form>

</div>

<?php
include('./admin-footer.php');
