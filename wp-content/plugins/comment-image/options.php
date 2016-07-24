<?php
$options = get_option('commentimage');

if (isset($_POST['save'])) {
    if (!check_admin_referer()) die('No hacking please');
    $options = stripslashes_deep($_POST['options']);
    update_option('commentimage', $options);
}
?>
<div class="wrap">

    <div id="satollo-header">
        <a href="http://www.satollo.net/plugins/comment-image" target="_blank">Get Help</a>
        <a href="http://www.satollo.net/forums" target="_blank">Forum</a>

        <form style="display: inline; margin: 0;" action="http://www.satollo.net/wp-content/plugins/newsletter/do/subscribe.php" method="post" target="_blank">
            Subscribe to satollo.net <input type="email" name="ne" required placeholder="Your email">
            <input type="hidden" name="nr" value="comment-image">
            <input type="submit" value="Go">
        </form>
        <!--
        <a href="https://www.facebook.com/satollo.net" target="_blank"><img style="vertical-align: bottom" src="http://www.satollo.net/images/facebook.png"></a>
        -->
        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5PHGDGNHAYLJ8" target="_blank"><img style="vertical-align: bottom" src="http://www.satollo.net/images/donate.png"></a>
        <a href="http://www.satollo.net/donations" target="_blank">Even <b>2$</b> helps: read more</a>
    </div>

    <form method="post">
        <?php wp_nonce_field(); ?>

        <h2>Comment Image</h2>
        
        <p>
            Come to see <a target="_blank" href="http://www.satollo.net/plugins/commant-plus">Comment Plus</a> a new plugin to attach images to comment with watermark, moderation control and all
            the features of <a target="_blank" href="http://www.satollo.net/plugins/commant-notifier">Comment Notifier</a>.
        </p>

        <table class="form-table">
            <tr>
                <th>Image selection field</th>
                <td>
                    <select name="options[field]">
                        <option value="0" <?php echo $options['field'] == '0' ? 'selected' : ''; ?>>Inject via WordPress hook</option>
                        <option value="1" <?php echo $options['field'] == '1' ? 'selected' : ''; ?>>Inject via Javascript</option>
                        <option value="2" <?php echo $options['field'] == '2' ? 'selected' : ''; ?>>Do not inject, manually added</option>
                    </select>
                    <br />
                    <strong>Inject via WordPress hook</strong>: the input field that let a user to choose an image is added
                    using a specific WordPress feature. The field will be added AFTER the submit button and
                    it may not work if the theme is poorly coded.
                    <br />
                    <strong>Inject via Javascript</strong>: the input field is added with Javascript page manipulation. The field
                    is added after the comment textarea (for a better layout) but it may work or not. Just try.
                    <br />
                    <strong>Do not inject, manually added</strong>: input field for image selection has to be added
                    directly on the theme source file. Check the
                    <a href="http://www.satollo.net/plugins/comment-image">documentation</a>.
                </td>
            </tr>
            <tr>
                <th>Image field label</th>
                <td>
                    <input type="text" size="20" name="options[label]" value="<?php echo htmlspecialchars($options['label']); ?>"/>
                    <br />
                    The label you want to be displayed near the image selection field
                </td>
            </tr>
            <tr>
                <th>Thumbnail width</th>
                <td>
                    <input type="text" size="5" name="options[width]" value="<?php echo htmlspecialchars($options['width']); ?>"/>
                </td>
            </tr>

        </table>

        <?php if (defined('COMMENT_IMAGE_EXTRAS')) comment_image_extra_options(); ?>

        <p class="submit"><input type="submit" name="save" value="Save" class="button button-submit"></p>

    </form>
</div>
