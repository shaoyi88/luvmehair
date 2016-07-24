<?php
/**
 * Reading settings administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
require_once( './admin.php' );

if ( ! current_user_can( 'manage_options' ) )
	wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );

$title = __( 'Reading Settings' );
$parent_file = 'options-general.php';

/**
 * Display JavaScript on the page.
 *
 * @since 3.5.0
 */
function options_reading_add_js() {
?>
<script type="text/javascript">
//<![CDATA[
	jQuery(document).ready(function($){
		var section = $('#front-static-pages'),
			staticPage = section.find('input:radio[value="page"]'),
			selects = section.find('select'),
			check_disabled = function(){
				selects.prop( 'disabled', ! staticPage.prop('checked') );
			};
		check_disabled();
 		section.find('input:radio').change(check_disabled);
	});
//]]>
</script>
<?php
}
add_action('admin_head', 'options_reading_add_js');

/**
 * Render the blog charset setting.
 *
 * @since 3.5.0
 */


include( './admin-header.php' );
?>

<div class="wrap" style="background:#fff;margin:-20px 0 -500px -20px;padding:30px;height:500px;">

<form method="post" action="options.php">
<?php
settings_fields( 'reading' );

if ( ! in_array( get_option( 'blog_charset' ), array( 'utf8', 'utf-8', 'UTF8', 'UTF-8' ) ) )
	add_settings_field( 'blog_charset', __( 'Encoding for pages and feeds' ), 'options_reading_blog_charset', 'reading', 'default', array( 'label_for' => 'blog_charset' ) );
?>

<?php if ( ! get_pages() ) : ?>
<input name="show_on_front" type="hidden" value="posts" />
<table class="form-table">
<?php
	if ( 'posts' != get_option( 'show_on_front' ) ) :
		update_option( 'show_on_front', 'posts' );
	endif;

else :
	if ( 'page' == get_option( 'show_on_front' ) && ! get_option( 'page_on_front' ) && ! get_option( 'page_for_posts' ) )
		update_option( 'show_on_front', 'posts' );
?>
<table class="form-table">
<tr valign="top" style="display:none;visible:hidden;">
<th scope="row"><?php _e( 'Front page displays' ); ?></th>
<td id="front-static-pages"><fieldset><legend class="screen-reader-text"><span><?php _e( 'Front page displays' ); ?></span></legend>
	<p><label>
		<input name="show_on_front" type="radio" value="posts" class="tog" <?php checked( 'posts', get_option( 'show_on_front' ) ); ?> />
		<?php _e( 'Your latest posts' ); ?>
	</label>
	</p>
	<p><label>
		<input name="show_on_front" type="radio" value="page" class="tog" <?php checked( 'page', get_option( 'show_on_front' ) ); ?> />
		<?php printf( __( 'A <a href="%s">static page</a> (select below)' ), 'edit.php?post_type=page' ); ?>
	</label>
	</p>
<ul>
	<li><label for="page_on_front"><?php printf( __( 'Front page: %s' ), wp_dropdown_pages( array( 'name' => 'page_on_front', 'echo' => 0, 'show_option_none' => __( '&mdash; Select &mdash;' ), 'option_none_value' => '0', 'selected' => get_option( 'page_on_front' ) ) ) ); ?></label></li>
	<li><label for="page_for_posts"><?php printf( __( 'Posts page: %s' ), wp_dropdown_pages( array( 'name' => 'page_for_posts', 'echo' => 0, 'show_option_none' => __( '&mdash; Select &mdash;' ), 'option_none_value' => '0', 'selected' => get_option( 'page_for_posts' ) ) ) ); ?></label></li>
</ul>
<?php if ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) == get_option( 'page_on_front' ) ) : ?>
<div id="front-page-warning" class="error inline"><p><?php _e( '<strong>Warning:</strong> these pages should not be the same!' ); ?></p></div>
<?php endif; ?>
</fieldset></td>
</tr>
<?php endif; ?>
<tr valign="top" style="display:none;visible:hidden;">
<th scope="row"><label for="posts_per_page"><?php _e( '产品列表页显示数量：' ); ?></label></th>
<td>
<input name="posts_per_page" type="number" step="1" min="1" id="posts_per_page" value="<?php form_option( 'posts_per_page' ); ?>" class="small-text" />
</td>
</tr>
<tr valign="top" style="display:none;visible:hidden;">
<th scope="row"><label for="posts_per_rss"><?php _e( 'Feed订阅产品显示数量' ); ?></label></th>
<td><input name="posts_per_rss" type="number" step="1" min="1" id="posts_per_rss" value="<?php form_option( 'posts_per_rss' ); ?>" class="small-text" /></td>
</tr>
<tr valign="top"  style="display:none;visible:hidden;">
<th scope="row"><?php _e( 'For each article in a feed, show' ); ?> </th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e( 'For each article in a feed, show' ); ?> </span></legend>
<p><label><input name="rss_use_excerpt" type="radio" value="0" <?php checked( 0, get_option( 'rss_use_excerpt' ) ); ?>	/> <?php _e( 'Full text' ); ?></label><br />
<label><input name="rss_use_excerpt" type="radio" value="1" <?php checked( 1, get_option( 'rss_use_excerpt' ) ); ?> /> <?php _e( 'Summary' ); ?></label></p>
</fieldset></td>
</tr>

<tr valign="top" class="option-site-visibility"  style="visible:hidden;">
<th scope="row">Google搜索引擎收录</th>
<td><fieldset><legend class="screen-reader-text"><span><?php has_action( 'blog_privacy_selector' ) ? _e( 'Site Visibility' ) : _e( 'Search Engine Visibility' ); ?> </span></legend>
<?php if ( has_action( 'blog_privacy_selector' ) ) : ?>
	<input id="blog-public" type="radio" name="blog_public" value="1" <?php checked('1', get_option('blog_public')); ?> />
	<label for="blog-public"><?php _e( '允许Google收录网站' );?></label><br/>
	<input id="blog-norobots" type="radio" name="blog_public" value="0" <?php checked('0', get_option('blog_public')); ?> />
	<label for="blog-norobots"><?php _e( '阻止Google收录网站' ); ?></label>
	<p class="description"><?php _e( 'Note: 测试网站时可阻止Google收录！' ); ?></p>
	<?php do_action('blog_privacy_selector'); ?>
<?php else : ?>
	<label for="blog_public"><input name="blog_public" type="checkbox" id="blog_public" value="0" <?php checked( '0', get_option( 'blog_public' ) ); ?> />
	<?php _e( '阻止Google收录网站' ); ?></label>
	<p class="description"><?php _e( 'Note: 测试网站时可阻止Google收录！' ); ?></p>
<?php endif; ?>
</fieldset></td>
</tr>

<?php do_settings_fields( 'reading', 'default' ); ?>
</table>

<?php do_settings_sections( 'reading' ); ?>

<?php submit_button(); ?>
</form>
</div></div>
<?php include( './admin-footer-no.php' ); ?>
