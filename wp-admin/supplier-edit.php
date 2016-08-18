<?php
/**
 * Edit user administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
require_once('./admin-user.php');

wp_reset_vars( array( 'action', 'user_id', 'wp_http_referer' ) );

$user_id = (int) $user_id;
$current_user = wp_get_current_user();
if ( ! defined( 'IS_PROFILE_PAGE' ) )
	define( 'IS_PROFILE_PAGE', ( $user_id == $current_user->ID ) );

if ( ! $user_id && IS_PROFILE_PAGE )
	$user_id = $current_user->ID;
elseif ( ! $user_id && ! IS_PROFILE_PAGE )
	wp_die(__( 'Invalid user ID.' ) );
elseif ( ! get_userdata( $user_id ) )
	wp_die( __('Invalid user ID.') );

wp_enqueue_script('user-profile');

$title = IS_PROFILE_PAGE ? __('Profile') : __('Edit User');
if ( current_user_can('edit_users') && !IS_PROFILE_PAGE )
	$submenu_file = 'users.php';
else
	$submenu_file = 'profile.php';

if ( current_user_can('edit_users') && !is_user_admin() )
	$parent_file = 'users.php';
else
	$parent_file = 'profile.php';

$profile_help = '';



get_current_screen()->set_help_sidebar(
    ''
);

$wp_http_referer = remove_query_arg(array('update', 'delete_count'), $wp_http_referer );

$user_can_edit = current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' );

/**
 * Optional SSL preference that can be turned on by hooking to the 'personal_options' action.
 *
 * @since 2.7.0
 *
 * @param object $user User data object
 */
function use_ssl_preference($user) {
?>
	<tr>
		<th scope="row"><?php _e('Use https')?></th>
		<td><label for="use_ssl"><input name="use_ssl" type="checkbox" id="use_ssl" value="1" <?php checked('1', $user->use_ssl); ?> /> <?php _e('Always use https when visiting the admin'); ?></label></td>
	</tr>
<?php
}

// Only allow super admins on multisite to edit every user.
if ( is_multisite() && ! current_user_can( 'manage_network_users' ) && $user_id != $current_user->ID && ! apply_filters( 'enable_edit_any_user_configuration', true ) )
	wp_die( __( 'You do not have permission to edit this user.' ) );

// Execute confirmed email change. See send_confirmation_on_profile_email().
if ( is_multisite() && IS_PROFILE_PAGE && isset( $_GET[ 'newuseremail' ] ) && $current_user->ID ) {
	$new_email = get_option( $current_user->ID . '_new_email' );
	if ( $new_email[ 'hash' ] == $_GET[ 'newuseremail' ] ) {
		$user = new stdClass;
		$user->ID = $current_user->ID;
		$user->user_email = esc_html( trim( $new_email[ 'newemail' ] ) );
		if ( $wpdb->get_var( $wpdb->prepare( "SELECT user_login FROM {$wpdb->signups} WHERE user_login = %s", $current_user->user_login ) ) )
			$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->signups} SET user_email = %s WHERE user_login = %s", $user->user_email, $current_user->user_login ) );
		wp_update_user( $user );
		delete_option( $current_user->ID . '_new_email' );
		wp_redirect( add_query_arg( array('updated' => 'true'), self_admin_url( 'profile.php' ) ) );
		die();
	}
} elseif ( is_multisite() && IS_PROFILE_PAGE && !empty( $_GET['dismiss'] ) && $current_user->ID . '_new_email' == $_GET['dismiss'] ) {
	delete_option( $current_user->ID . '_new_email' );
	wp_redirect( add_query_arg( array('updated' => 'true'), self_admin_url( 'profile.php' ) ) );
	die();
}

switch ($action) {
case 'update':

check_admin_referer('update-user_' . $user_id);

if ( !current_user_can('edit_user', $user_id) )
	wp_die(__('You do not have permission to edit this user.'));

if ( IS_PROFILE_PAGE )
	do_action('personal_options_update', $user_id);
else
	do_action('edit_user_profile_update', $user_id);

if ( !is_multisite() ) {
	$errors = edit_user($user_id);
} else {
	$user = get_userdata( $user_id );

	// Update the email address in signups, if present.
	if ( $user->user_login && isset( $_POST[ 'email' ] ) && is_email( $_POST[ 'email' ] ) && $wpdb->get_var( $wpdb->prepare( "SELECT user_login FROM {$wpdb->signups} WHERE user_login = %s", $user->user_login ) ) )
		$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->signups} SET user_email = %s WHERE user_login = %s", $_POST[ 'email' ], $user_login ) );

	// WPMU must delete the user from the current blog if WP added him after editing.
	$delete_role = false;
	$blog_prefix = $wpdb->get_blog_prefix();
	if ( $user_id != $current_user->ID ) {
		$cap = $wpdb->get_var( "SELECT meta_value FROM {$wpdb->usermeta} WHERE user_id = '{$user_id}' AND meta_key = '{$blog_prefix}capabilities' AND meta_value = 'a:0:{}'" );
		if ( !is_network_admin() && null == $cap && $_POST[ 'role' ] == '' ) {
			$_POST[ 'role' ] = 'contributor';
			$delete_role = true;
		}
	}
	if ( !isset( $errors ) || ( isset( $errors ) && is_object( $errors ) && false == $errors->get_error_codes() ) )
		$errors = edit_user($user_id);
	if ( $delete_role ) // stops users being added to current blog when they are edited
		delete_user_meta( $user_id, $blog_prefix . 'capabilities' );

	if ( is_multisite() && is_network_admin() && !IS_PROFILE_PAGE && current_user_can( 'manage_network_options' ) && !isset($super_admins) && empty( $_POST['super_admin'] ) == is_super_admin( $user_id ) )
		empty( $_POST['super_admin'] ) ? revoke_super_admin( $user_id ) : grant_super_admin( $user_id );
}

if ( !is_wp_error( $errors ) ) {
	$redirect = add_query_arg( 'updated', true, get_edit_supplier_link( $user_id ) );
	if ( $wp_http_referer )
		$redirect = add_query_arg('wp_http_referer', urlencode($wp_http_referer), $redirect);
	wp_redirect($redirect);
	exit;
}

default:
$profileuser = get_user_to_edit($user_id);

if ( !current_user_can('edit_user', $user_id) )
	wp_die(__('You do not have permission to edit this user.'));

include (ABSPATH . 'wp-admin/admin-header.php');
?>

<?php if ( !IS_PROFILE_PAGE && is_super_admin( $profileuser->ID ) && current_user_can( 'manage_network_options' ) ) { ?>
	<div class="updated"><p><strong><?php _e('Important:'); ?></strong> <?php _e('This user has super admin privileges.'); ?></p></div>
<?php } ?>
<?php if ( isset($_GET['updated']) ) : ?>
<div id="message" class="updated">
	<?php if ( IS_PROFILE_PAGE ) : ?>
	<p><strong><?php _e('Profile updated.') ?></strong></p>
	<?php else: ?>
	<p><strong><?php _e('User updated.') ?></strong></p>
	<?php endif; ?>
	<?php if ( $wp_http_referer && !IS_PROFILE_PAGE ) : ?>
	<p><a href="<?php echo esc_url( $wp_http_referer ); ?>"><?php _e('&larr; Back to Users'); ?></a></p>
	<?php endif; ?>
</div>
<?php endif; ?>
<?php if ( isset( $errors ) && is_wp_error( $errors ) ) : ?>
<div class="error"><p><?php echo implode( "</p>\n<p>", $errors->get_error_messages() ); ?></p></div>
<?php endif; ?>

<div class="wrap" id="profile-page">
<?php screen_icon(); ?>
<h2>
<?php
echo esc_html( '编辑供应商' );
if ( ! IS_PROFILE_PAGE ) {
	if ( current_user_can( 'create_users' ) ) { ?>
		<a href="supplier-new.php" class="add-new-h2">添加供应商</a>
	<?php } elseif ( is_multisite() && current_user_can( 'promote_users' ) ) { ?>
		<a href="supplier-new.php" class="add-new-h2">添加供应商</a>
	<?php }
} ?>
</h2>

<form id="your-profile" action="<?php echo esc_url( self_admin_url( IS_PROFILE_PAGE ? 'profile.php' : 'supplier-edit.php' ) ); ?>" method="post"<?php do_action('user_edit_form_tag'); ?>>
<?php wp_nonce_field('update-user_' . $user_id) ?>
<?php if ( $wp_http_referer ) : ?>
	<input type="hidden" name="wp_http_referer" value="<?php echo esc_url($wp_http_referer); ?>" />
<?php endif; ?>
<p>
<input type="hidden" name="from" value="profile" />
<input type="hidden" name="checkuser_id" value="<?php echo $user_ID ?>" />
</p>

<hr>

<table class="form-table" style="display:none;">
<?php if ( rich_edit_exists() && !( IS_PROFILE_PAGE && !$user_can_edit ) ) : // don't bother showing the option if the editor has been removed ?>
	<tr>
		<th scope="row"><?php _e('Visual Editor')?></th>
		<td><label for="rich_editing"><input name="rich_editing" type="checkbox" id="rich_editing" value="false" <?php checked('false', $profileuser->rich_editing); ?> /> <?php _e('Disable the visual editor when writing'); ?></label></td>
	</tr>
<?php endif; ?>
<?php if ( count($_wp_admin_css_colors) > 1 && has_action('admin_color_scheme_picker') ) : ?>
<tr>
<th scope="row"><?php _e('Admin Color Scheme')?></th>
<td><?php do_action( 'admin_color_scheme_picker' ); ?></td>
</tr>
<?php
endif; // $_wp_admin_css_colors
if ( !( IS_PROFILE_PAGE && !$user_can_edit ) ) : ?>
<?php endif; ?>
<?php do_action('personal_options', $profileuser); ?>
</table>
<?php
	if ( IS_PROFILE_PAGE )
		do_action('profile_personal_options', $profileuser);
?>
<table class="form-table">
	<tr>
		<th><label for="user_login"><?php _e('Username'); ?></label></th>
		<td><input type="text" name="user_login" id="user_login" value="<?php echo esc_attr($profileuser->user_login); ?>" disabled="disabled" class="regular-text" /> <span class="description"><?php _e('Usernames cannot be changed.'); ?></span></td>
	</tr>
	<tr>
	<th><label for="email"><?php _e('E-mail'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
	<td><input type="text" name="email" id="email" value="<?php echo esc_attr($profileuser->user_email) ?>" class="regular-text" />
	<?php
	$new_email = get_option( $current_user->ID . '_new_email' );
	if ( $new_email && $new_email['newemail'] != $current_user->user_email && $profileuser->ID == $current_user->ID ) : ?>
	<div class="updated inline">
	<p><?php printf( __('There is a pending change of your e-mail to <code>%1$s</code>. <a href="%2$s">Cancel</a>'), $new_email['newemail'], esc_url( self_admin_url( 'profile.php?dismiss=' . $current_user->ID . '_new_email' ) ) ); ?></p>
	</div>
	<?php endif; ?>
	</td>
</tr>
<?php if ( !IS_PROFILE_PAGE && !is_network_admin() ) : ?>

<?php endif; //!IS_PROFILE_PAGE

if ( is_multisite() && is_network_admin() && ! IS_PROFILE_PAGE && current_user_can( 'manage_network_options' ) && !isset($super_admins) ) { ?>
<tr><th><?php _e('Super Admin'); ?></th>
<td>
<?php if ( $profileuser->user_email != get_site_option( 'admin_email' ) || ! is_super_admin( $profileuser->ID ) ) : ?>
<p><label><input type="checkbox" id="super_admin" name="super_admin"<?php checked( is_super_admin( $profileuser->ID ) ); ?> /> <?php _e( 'Grant this user super admin privileges for the Network.' ); ?></label></p>
<?php else : ?>
<p><?php _e( 'Super admin privileges cannot be removed because this user has the network admin email.' ); ?></p>
<?php endif; ?>
</td></tr>
<?php } ?>

<tr>
	<th><label for="display_name">公司名<span class="description"><?php _e('(required)'); ?></span></label></th>
	<td>
		<input type="text" name="display_name" id="display_name" value="<?php echo esc_attr($profileuser->display_name) ?>" class="regular-text code" />
	</td>
</tr>
</table>
<table class="form-table">

<tr>
	<th><label for="url"><?php _e('Website') ?><span class="description"><?php _e('(required)'); ?></span></label></th>
	<td><input type="text" name="url" id="url" value="<?php echo esc_attr($profileuser->user_url) ?>" class="regular-text code" /></td>
</tr>
</table>
<table class="form-table">
<?php
$show_password_fields = apply_filters('show_password_fields', true, $profileuser);
if ( $show_password_fields ) :
?>
<tr id="password">
	<th><label for="pass1"><?php _e('New Password'); ?></label></th>
	<td>
		<input class="hidden" value=" " /><!-- #24364 workaround -->
		<input type="password" name="pass1" id="pass1" size="16" value="" autocomplete="off" /> <span class="description"><?php _e("If you would like to change the password type a new one. Otherwise leave this blank."); ?></span>
	</td>
</tr>
<tr>
	<th scope="row"><label for="pass2"><?php _e('Repeat New Password'); ?></label></th>
	<td>
	<input name="pass2" type="password" id="pass2" size="16" value="" autocomplete="off" /> <span class="description" for="pass2"><?php _e("Type your new password again."); ?></span>
	<br />
	<div id="pass-strength-result"><?php _e('Strength indicator'); ?></div>
	<p class="description indicator-hint"><?php _e('Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).'); ?></p>
	</td>
</tr>
<?php endif; ?>
</table>



<?php if ( count( $profileuser->caps ) > count( $profileuser->roles ) && apply_filters( 'additional_capabilities_display', true, $profileuser ) ) : ?>
<h3><?php _e( 'Additional Capabilities' ); ?></h3>
<table class="form-table">
<tr>
	<th scope="row"><?php _e( 'Capabilities' ); ?></th>
	<td>
<?php
	$output = '';
	foreach ( $profileuser->caps as $cap => $value ) {
		if ( ! $wp_roles->is_role( $cap ) ) {
			if ( '' != $output )
				$output .= ', ';
			$output .= $value ? $cap : sprintf( __( 'Denied: %s' ), $cap );
		}
	}
	echo $output;
?>
	</td>
</tr>
</table>
<?php endif; ?>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr($user_id); ?>" />

<?php submit_button( '更新供应商' ); ?>

</form>
</div>
<?php
break;
}
?>
<script type="text/javascript">
	if (window.location.hash == '#password') {
		document.getElementById('pass1').focus();
	}
</script>
<?php
include( ABSPATH . 'wp-admin/admin-footer.php');
