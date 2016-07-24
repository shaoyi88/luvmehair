<?php
/*
Plugin Name: Comment Image
Plugin URI: http://www.satollo.net/plugins/comment-image
Description: Attach images to comments and build a new commenting experience.
Version: 1.2.1
Author: Stefano Lissa
Author URI: http://www.satollo.net
Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
*/

/*
    Copyright 2013 Stefano Lissa (email: stefano@satollo.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if (is_file(dirname(dirname(__FILE__)) . '/comment-image-extras.php')) {
    @include(dirname(dirname(__FILE__)) . '/comment-image-extras.php');
}

add_action('admin_head', 'commentimage_admin_head');
function commentimage_admin_head()
{
    if (strpos($_GET['page'], 'comment-image/') === 0) {
        echo '<link type="text/css" rel="stylesheet" href="' .
        get_option('siteurl') . '/wp-content/plugins/comment-image/admin.css"/>';
    }
}

add_filter('comment_text', 'commentimage_comment_text');
function commentimage_comment_text($comment = '')
{
    $options = get_option('commentimage');
    $id = get_comment_ID();

    $images = $options['images'];
    if (!isset($images) || !is_numeric($images)) $images = 1;

    $url = get_option('siteurl');
    for ($i=0; $i<$images; $i++)
    {
        if (file_exists(ABSPATH . 'wp-content/comment-image/' . $id . ($i==0?'':('-'.$i)) . '-tn.jpg'))
        {
            $comment .= '<p><a href="' . $url . '/wp-content/comment-image/' . commentimage_find_original($id, $i) . '"><img src="' . $url . '/wp-content/comment-image/' . $id . ($i==0?'':('-'.$i)) . '-tn.jpg"/></a></p>';
        }
    }
    return $comment;
}


add_action('comment_post', 'commentimage_comment_post');
function commentimage_comment_post($id)
{
    $options = get_option('commentimage');

    $images = $options['images'];
    if (!isset($images) || !is_numeric($images)) $images = 1;

    for ($i=0; $i<$images; $i++)
    {
        $field = 'image' . ($i==0?'':$i);
        if ($_FILES[$field]['name'] != '')
        {
            $name = $id . ($i==0?'':('-'.$i));
            $dest = ABSPATH . 'wp-content/comment-image/' . $name;
            switch($_FILES[$field]['type'])
            {
                case 'image/jpeg':
                case 'image/pjpeg':
                    $dest .= '.jpg';
                    break;
                case 'image/png':
                    $dest .= '.png';
                    break;
                case 'image/gif':
                    $dest .= '.gif';
                    break;
                default:
                    // try with jpg if mime type doen's match
                    $dest .= '.jpg';
            }
            $thumb = ABSPATH . 'wp-content/comment-image/' . $name . '-tn.jpg';
            move_uploaded_file($_FILES[$field]['tmp_name'], $dest);
            $res = commentimage_thumb($dest, $thumb, (int)$options['width'], (int)$options['width'], $_FILES[$field]['type']);
            if (!$res) @unlink($dest);
        }
    }
}


add_action('comment_form', 'commentimage_comment_form', 99);
function commentimage_comment_form()
{
    //if (!is_single() && !is_page()) return;
    if (!is_singular()) {
        return;
    }

    $options = get_option('commentimage');
    if ($options['field'] == 0)
    {
        $images = $options['images'];
        if (!isset($images) || !is_numeric($images)) $images = 1;
        for ($i=0; $i<$images; $i++)
        {
            echo '<li class="form-item"><label class="left-label" for="author"><small>Upload Picture</small></label><p class="comment-img"><input style="width: auto" type="file" name="image' . ($i==0?'':$i) .
                '"/>JPEG only</p></li>';
        }
    }
}


add_action('admin_menu', 'commentimage_admin_menu');
function commentimage_admin_menu()
{
    add_options_page('Comment Image', 'Comment Image', 'manage_options', 'comment-image/options.php');
}

add_filter('delete_comment', 'commentimage_delete_comment');
function commentimage_delete_comment($id)
{
    $options = get_option('commentimage');
    $images = $options['images'];
    if (!isset($images) || !is_numeric($images)) $images = 1;

    for ($i=0; $i<20; $i++)
    {
    // If the thumbnail exists (it's always jpg)...
        if (file_exists(ABSPATH . 'wp-content/comment-image/' . $id . ($i==0?'':('-'.$i)) . '-tn.jpg'))
        {
            @unlink(ABSPATH . 'wp-content/comment-image/' . $id . ($i==0?'':('-'.$i)) . '-tn.jpg');
            @unlink(ABSPATH . 'wp-content/comment-image/' . commentimage_find_original($id, $i));
        }
    }
}

add_filter('comment_notification_text', 'commentimage_comment_notification_text', 10, 2);
add_filter('comment_moderation_text', 'commentimage_comment_notification_text', 10, 2);
function commentimage_comment_notification_text($message, $id)
{
    $options = get_option('commentimage');
    $url = get_option('siteurl');
    $buffer = '';
    for ($i=0; $i<20; $i++)
    {
        if (file_exists(ABSPATH . 'wp-content/comment-image/' . $id . ($i==0?'':('-'.$i)) . '-tn.jpg'))
        {
            $buffer .= "*** This comment has an image: " . $url . "/wp-content/comment-image/" . commentimage_find_original($id, $i) . "\r\n";
        }
    }
    return $buffer . "\r\n" . $message;

}

add_action('wp_footer', 'commentimage_wp_footer');
function commentimage_wp_footer()
{
    if (!is_single() && !is_page()) return;
    $options = get_option('commentimage');
    $images = $options['images'];
    if (!isset($images) || !is_numeric($images)) $images = 1;
    echo
    '
<script type="text/javascript">
for (i=0; i<document.forms.length; i++) {
    var f = document.forms[i];
    if (f.comment_post_ID) {
        f.encoding = "multipart/form-data";
';
    if ($options['field'] == 1)
    {
        echo
        '
        var l = f.getElementsByTagName("textarea");
        l = l[0].parentNode;
        ';
        for ($i=$images-1; $i>=0; $i--)
        {
            echo '
        var p = document.createElement("p");
        var t = document.createElement("input");
        t.setAttribute("name", "image' . ($i==0?'':$i) . '");
        t.setAttribute("type", "file");
        t.setAttribute("style", "width: auto");
        p.appendChild(t);
        p.appendChild(document.createTextNode("' . addslashes($options['label']) . '"));
        l.parentNode.insertBefore(p, l.nextSibling);
';
        }
    }
    echo
    '
        break;
    }
}
</script>
';
}

function commentimage_thumb($file, $thumb, $new_w, $new_h, $type='image/jpeg')
{
    switch ($type)
    {
        case 'image/jpeg':
        case 'image/pjpeg':
            $src_img = imagecreatefromjpeg($file);
            break;
        case 'image/gif':
            $src_img = imagecreatefromgif($file);
            break;
        case 'image/png':
            $src_img = imagecreatefrompng($file);
            break;
        // try with jpg for strange mime types
        default:
            $src_img = imagecreatefromjpeg($file);
    }

    //$src_img = imagecreatefromjpeg($file);

    if ($src_img === false) return false;

    $old_x = imagesx($src_img);
    $old_y = imagesy($src_img);
    if ($new_w == null)
    {
        $thumb_h = $new_h;
        $thumb_w=$old_x*($new_h/$old_y);
    }
    else
    {
        if ($old_x > $old_y)
        {
            $thumb_w=$new_w;
            $thumb_h=$old_y*($new_h/$old_x);
        }
        if ($old_x < $old_y)
        {
            $thumb_w=$old_x*($new_w/$old_y);
            $thumb_h=$new_h;
        }
        if ($old_x == $old_y)
        {
            $thumb_w=$new_w;
            $thumb_h=$new_h;
        }
    }
    $dst_img = ImageCreateTrueColor($thumb_w,$thumb_h);
    imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);

    imagejpeg($dst_img, $thumb, 80);
    imagedestroy($dst_img);
    imagedestroy($src_img);
    return true;
}

register_activation_hook(__FILE__, 'commentimage_activate');
function commentimage_activate()
{
    @mkdir(ABSPATH . 'wp-content/comment-image');

    @include(dirname(__FILE__) . '/languages/en_US_options.php');
    if (WPLANG != '') @include(dirname(__FILE__) . '/languages/' . WPLANG . '_options.php');

    $options = get_option('commentimage');
    if (is_array($options))
    {
        $options = array_merge($default_options, $options);
        update_option('commentimage', $options);
    }
    else
    {
        update_option('commentimage', $default_options);
    }
}

function commentimage_find_original($id, $i)
{
    $name = $id . ($i==0?'':('-'.$i));
    if (is_file(ABSPATH . 'wp-content/comment-image/' . $name . '.jpg')) return $name . '.jpg';
    if (is_file(ABSPATH . 'wp-content/comment-image/' . $name . '.gif')) return $name . '.gif';
    if (is_file(ABSPATH . 'wp-content/comment-image/' . $name . '.png')) return $name . '.png';
}
?>