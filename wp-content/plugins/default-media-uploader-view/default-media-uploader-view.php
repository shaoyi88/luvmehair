<?php
/*
  Plugin Name: Default Media Uploader View
  Plugin URI: http://wordpress.org/plugins/default-media-uploader-view/
  Description: Sets "Uploaded to this post" instead of "All media items" as the default view in the media uploader
  Version: 1.0.1
  Author: leemon
  License: GPLv2 or later

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class DefaultMediaUploaderView {  

    function __construct() {  
  
        add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue_scripts') );

    }  
 
	/**
	 * Enqueues scripts in the backend.
	 *
	 * @since 1.0
	 *
	 */
    function admin_enqueue_scripts(){  

		wp_enqueue_script( 'default-media-uploader-view', plugins_url( '/default-media-uploader-view.js', __FILE__ ), array( 'jquery' ) );
		
    }

}

$default_media_uploader_view = new DefaultMediaUploaderView;

?>