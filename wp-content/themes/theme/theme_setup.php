<?php
/** EOCMS options */
class EOCMSOptions {
	function getOptions() {
		$options = get_option('EOCMS_Options');
		if (!is_array($options)) {
			update_option('EOCMS_Options', $options);
		}
		return $options;
	}

	function add() {
		if(isset($_POST['zGauge_save'])) {
			$options = EOCMSOptions::getOptions();
			$options['head_featured_no'] = stripslashes($_POST['head_featured_no']);
			$options['head_la_products_no'] = stripslashes($_POST['head_la_products_no']);
			$options['cate_products_no'] = stripslashes($_POST['cate_products_no']);
			$options['head_news_no'] = stripslashes($_POST['head_news_no']);
			$options['ashu_logo'] = stripslashes($_POST['ashu_logo']);
			$options['about_title'] = stripslashes($_POST['about_title']);
			$options['side-bn-1'] = stripslashes($_POST['side-bn-1']);
			$options['side-bn-2'] = stripslashes($_POST['side-bn-2']);
			$options['profile-img'] = stripslashes($_POST['profile-img']);
			$options['side-bn-1-url'] = stripslashes($_POST['side-bn-1-url']);
			$options['side-bn-2-url'] = stripslashes($_POST['side-bn-2-url']);
			$options['profile-img-url'] = stripslashes($_POST['profile-img-url']);
			$options['off_code'] = stripslashes($_POST['off_code']);
			$options['promotion_day'] = stripslashes($_POST['promotion_day']);
			$options['off_text'] = stripslashes($_POST['off_text']);
			$options['shipping_text'] = stripslashes($_POST['shipping_text']);
			
			$options['ad_img_01'] = stripslashes($_POST['ad_img_01']);
			$options['ad_text_01'] = stripslashes($_POST['ad_text_01']);
			$options['ad_url_01'] = stripslashes($_POST['ad_url_01']);
			$options['ad_img_02'] = stripslashes($_POST['ad_img_02']);
			$options['ad_text_02'] = stripslashes($_POST['ad_text_02']);
			$options['ad_url_02'] = stripslashes($_POST['ad_url_02']);
			$options['ad_img_03'] = stripslashes($_POST['ad_img_03']);
			$options['ad_text_03'] = stripslashes($_POST['ad_text_03']);
			$options['ad_url_03'] = stripslashes($_POST['ad_url_03']);
			$options['profile-img-text'] = stripslashes($_POST['profile-img-text']);


			
			$options['meta_title'] = stripslashes($_POST['meta_title']);
			$options['meta_description'] = stripslashes($_POST['meta_description']);
			$options['meta_keywords'] = stripslashes($_POST['meta_keywords']);

			$options['footer_code'] = stripslashes($_POST['footer_code']);

			$options['about_text'] = stripslashes($_POST['about_text']);
			$options['about_img'] = stripslashes($_POST['about_img']);

			$options['reviews_1'] = stripslashes($_POST['reviews_1']);
			$options['reviews_name_1'] = stripslashes($_POST['reviews_name_1']);
			$options['reviews_2'] = stripslashes($_POST['reviews_2']);
			$options['reviews_name_2'] = stripslashes($_POST['reviews_name_2']);
			$options['reviews_3'] = stripslashes($_POST['reviews_3']);
			$options['reviews_name_3'] = stripslashes($_POST['reviews_name_3']);

			$options['company'] = stripslashes($_POST['company']);
			$options['address'] = stripslashes($_POST['address']);
			$options['phone'] = stripslashes($_POST['phone']);
			$options['fax'] = stripslashes($_POST['fax']);
			$options['email'] = stripslashes($_POST['email']);
			$options['msn'] = stripslashes($_POST['msn']);
			$options['skype'] = stripslashes($_POST['skype']);

			$options['head_logo'] = stripslashes($_POST['head_logo']);
			$options['google_wm'] = stripslashes($_POST['google_wm']);

			if ($_POST['head_sns']) {
				$options['head_sns'] = (bool)true;
			} else {
				$options['head_sns'] = (bool)false;
			}

			if ($_POST['head_topnavi']) {
				$options['head_topnavi'] = (bool)true;
			} else {
				$options['head_topnavi'] = (bool)false;
			}
			$options['inquiry_email'] = stripslashes($_POST['inquiry_email']);

			$options['facebook'] = stripslashes($_POST['facebook']);
			$options['twitter'] = stripslashes($_POST['twitter']);
			$options['tumblr'] = stripslashes($_POST['tumblr']);
			$options['youtube'] = stripslashes($_POST['youtube']);
			$options['google'] = stripslashes($_POST['google']);
			$options['pinterest'] = stripslashes($_POST['pinterest']);
			$options['instagram'] = stripslashes($_POST['instagram']);
			$options['rss'] = stripslashes($_POST['rss']);
			$options['google_an'] = stripslashes($_POST['google_an']);

			
			
			
			$options['slider_img1'] = stripslashes($_POST['slider_img1']);
			$options['slider_title1'] = stripslashes($_POST['slider_title1']);
			$options['slider_link1'] = stripslashes($_POST['slider_link1']);
			$options['slider_img2'] = stripslashes($_POST['slider_img2']);
			$options['slider_title2'] = stripslashes($_POST['slider_title2']);
			$options['slider_link2'] = stripslashes($_POST['slider_link2']);
			$options['slider_img3'] = stripslashes($_POST['slider_img3']);
			$options['slider_title3'] = stripslashes($_POST['slider_title3']);
			$options['slider_link3'] = stripslashes($_POST['slider_link3']);
			$options['slider_img4'] = stripslashes($_POST['slider_img4']);
			$options['slider_title4'] = stripslashes($_POST['slider_title4']);
			$options['slider_link4'] = stripslashes($_POST['slider_link4']);
			$options['slider_img5'] = stripslashes($_POST['slider_img5']);
			$options['slider_title5'] = stripslashes($_POST['slider_title5']);
			$options['slider_link5'] = stripslashes($_POST['slider_link5']);

			$options['pay_img'] = stripslashes($_POST['pay_img']);


			$options['slider_pd_img1'] = stripslashes($_POST['slider_pd_img1']);
			$options['slider_pd_title1'] = stripslashes($_POST['slider_pd_title1']);
			$options['slider_pd_link1'] = stripslashes($_POST['slider_pd_link1']);
			$options['slider_pd_img2'] = stripslashes($_POST['slider_pd_img2']);
			$options['slider_pd_title2'] = stripslashes($_POST['slider_pd_title2']);
			$options['slider_pd_link2'] = stripslashes($_POST['slider_pd_link2']);
			$options['slider_pd_img3'] = stripslashes($_POST['slider_pd_img3']);
			$options['slider_pd_title3'] = stripslashes($_POST['slider_pd_title3']);
			$options['slider_pd_link3'] = stripslashes($_POST['slider_pd_link3']);
			$options['slider_pd_img4'] = stripslashes($_POST['slider_pd_img4']);
			$options['slider_pd_title4'] = stripslashes($_POST['slider_pd_title4']);
			$options['slider_pd_link4'] = stripslashes($_POST['slider_pd_link4']);
			$options['slider_pd_img5'] = stripslashes($_POST['slider_pd_img5']);
			$options['slider_pd_title5'] = stripslashes($_POST['slider_pd_title5']);
			$options['slider_pd_link5'] = stripslashes($_POST['slider_pd_link5']);


			if ($_POST['indexad_show']) {
				$options['indexad_show'] = (bool)true;
			} else {
				$options['indexad_show'] = (bool)false;
			}

			if ($_POST['offcode_show']) {
				$options['offcode_show'] = (bool)true;
			} else {
				$options['offcode_show'] = (bool)false;
			}

			if ($_POST['chatonline_show']) {
				$options['chatonline_show'] = (bool)true;
			} else {
				$options['chatonline_show'] = (bool)false;
			}


			
			if ($_POST['show_block1']) {
				$options['show_block1'] = (bool)true;
			} else {
				$options['show_block1'] = (bool)false;
			}
			$options['block1_left_title_cn'] = stripslashes($_POST['block1_left_title_cn']);
			$options['block1_left_title_en'] = stripslashes($_POST['block1_left_title_en']);

			if( is_array($_POST['block1_left_cat']) ) {
				$options['block1_left_cat'] = implode(",", $_POST['block1_left_cat']);		
			}
			else
				$options['block1_left_cat'] = '';

			$options['block1_about_title_cn'] = stripslashes($_POST['block1_about_title_cn']);
			$options['block1_about_title_en'] = stripslashes($_POST['block1_about_title_en']);
			$options['block1_about_img'] = stripslashes($_POST['block1_about_img']);
			$options['block1_about_link'] = stripslashes($_POST['block1_about_link']);
			$options['block1_about_content'] = stripslashes($_POST['block1_about_content']);

			$options['block1_news_title_cn'] = stripslashes($_POST['block1_news_title_cn']);
			$options['block1_news_title_en'] = stripslashes($_POST['block1_news_title_en']);

			if( is_array($_POST['block1_news_cat']) ) {
				$options['block1_news_cat'] = implode(",", $_POST['block1_news_cat']);		
			}
			else
				$options['block1_news_cat'] = '';
			
			if ($_POST['show_reviews']) {
				$options['show_reviews'] = (bool)true;
			} else {
				$options['show_reviews'] = (bool)false;
			}
			$options['block2_img1'] = stripslashes($_POST['block2_img1']);
			$options['block2_title1'] = stripslashes($_POST['block2_title1']);
			$options['block2_link1'] = stripslashes($_POST['block2_link1']);
			$options['block2_content1'] = stripslashes($_POST['block2_content1']);

			$options['block2_img2'] = stripslashes($_POST['block2_img2']);
			$options['block2_title2'] = stripslashes($_POST['block2_title2']);
			$options['block2_link2'] = stripslashes($_POST['block2_link2']);
			$options['block2_content2'] = stripslashes($_POST['block2_content2']);

			$options['block2_img3'] = stripslashes($_POST['block2_img3']);
			$options['block2_title3'] = stripslashes($_POST['block2_title3']);
			$options['block2_link3'] = stripslashes($_POST['block2_link3']);
			$options['block2_content3'] = stripslashes($_POST['block2_content3']);

			if ($_POST['show_block3']) {
				$options['show_block3'] = (bool)true;
			} else {
				$options['show_block3'] = (bool)false;
			}
			$options['block3_title_cn'] = stripslashes($_POST['block3_title_cn']);
			$options['block3_title_en'] = stripslashes($_POST['block3_title_en']);
			$options['block3_posts'] = stripslashes($_POST['block3_posts']);
			
			if( is_array($_POST['block3_cat']) ) {
				$options['block3_cat'] = implode(",", $_POST['block3_cat']);		
			}
			else
				$options['block3_cat'] = '';

			if( is_array($_POST['style_photo']) ) {
				$options['style_photo'] = implode(",", $_POST['style_photo']);		
			}
			else
				$options['style_photo'] = '';


			if( is_array($_POST['style_blog']) ) {
				$options['style_blog'] = implode(",", $_POST['style_blog']);		
			}
			else
				$options['style_blog'] = '';
				
			if( is_array($_POST['style_realwedding']) ) {
				$options['style_realwedding'] = implode(",", $_POST['style_realwedding']);		
			}
			else
				$options['style_realwedding'] = '';
				
			if( is_array($_POST['style_wedding']) ) {
				$options['style_wedding'] = implode(",", $_POST['style_wedding']);		
			}
			else
				$options['style_wedding'] = '';

			if( is_array($_POST['style_dress']) ) {
				$options['style_dress'] = implode(",", $_POST['style_dress']);		
			}
			else
				$options['style_dress'] = '';	
				
				
			if( is_array($_POST['style_sashes']) ) {
				$options['style_sashes'] = implode(",", $_POST['style_sashes']);		
			}
			else
				$options['style_sashes'] = '';	
				
			if( is_array($_POST['style_bra']) ) {
				$options['style_bra'] = implode(",", $_POST['style_bra']);		
			}
			else
				$options['style_bra'] = '';	


				
			if( is_array($_POST['style_jacket']) ) {
				$options['style_jacket'] = implode(",", $_POST['style_jacket']);		
			}
			else
				$options['style_jacket'] = '';	
				
			if( is_array($_POST['style_flower']) ) {
				$options['style_flower'] = implode(",", $_POST['style_flower']);		
			}
			else
				$options['style_flower'] = '';	
				
			if( is_array($_POST['style_shoes']) ) {
				$options['style_shoes'] = implode(",", $_POST['style_shoes']);		
			}
			else
				$options['style_shoes'] = '';	
				
			if( is_array($_POST['style_only_color']) ) {
				$options['style_only_color'] = implode(",", $_POST['style_only_color']);		
			}
			else
				$options['style_only_color'] = '';	

			if( is_array($_POST['style_cat_g']) ) {
				$options['style_cat_g'] = implode(",", $_POST['style_cat_g']);		
			}
			else
				$options['style_cat_g'] = '';	
				
				
				
			if( is_array($_POST['style_lingerie']) ) {
				$options['style_lingerie'] = implode(",", $_POST['style_lingerie']);		
			}
			else
				$options['style_lingerie'] = '';	





				
			if( is_array($_POST['style_featured']) ) {
				$options['style_featured'] = implode(",", $_POST['style_featured']);		
			}
			else
				$options['style_featured'] = '';
				
			if( is_array($_POST['style_latest']) ) {
				$options['style_latest'] = implode(",", $_POST['style_latest']);		
			}
			else
				$options['style_latest'] = '';

			if( is_array($_POST['product_single']) ) {
				$options['product_single'] = implode(",", $_POST['product_single']);		
			}
			else
				$options['product_single'] = '';

			if( is_array($_POST['default_single']) ) {
				$options['default_single'] = implode(",", $_POST['default_single']);		
			}
			else
				$options['default_single'] = '';

			$options['contact_1'] = stripslashes($_POST['contact_1']);
			$options['contact_2'] = stripslashes($_POST['contact_2']);
			$options['contact_3'] = stripslashes($_POST['contact_3']);
			$options['contact_4'] = stripslashes($_POST['contact_4']);
			$options['contact_5'] = stripslashes($_POST['contact_5']);
			$options['contact_6'] = stripslashes($_POST['contact_6']);
			$options['contact_7'] = stripslashes($_POST['contact_7']);
			$options['contact_8'] = stripslashes($_POST['contact_8']);

			if ($_POST['kefu_show']) {
				$options['kefu_show'] = (bool)true;
			} else {
				$options['kefu_show'] = (bool)false;
			}
			$options['kefu_msn1'] = stripslashes($_POST['kefu_msn1']);
			$options['kefu_msn2'] = stripslashes($_POST['kefu_msn2']);
			$options['kefu_skype1'] = stripslashes($_POST['kefu_skype1']);
			$options['kefu_skype2'] = stripslashes($_POST['kefu_skype2']);
			$options['kefu_link_title'] = stripslashes($_POST['kefu_link_title']);
			$options['kefu_link_url'] = stripslashes($_POST['kefu_link_url']);
			$options['kefu_tel1'] = stripslashes($_POST['kefu_tel1']);
			$options['kefu_tel2'] = stripslashes($_POST['kefu_tel2']);

			// foot menu
			if ($_POST['show_footmenu']) {
				$options['show_footmenu'] = (bool)true;
			} else {
				$options['show_footmenu'] = (bool)false;
			}
			// foot content
			$options['footer_content'] = stripslashes($_POST['footer_content']);

			update_option('EOCMS_Options', $options);

		} else {
			EOCMSOptions::getOptions();
		}

		add_theme_page('网站全局设置', '网站全局设置', 'edit_themes', basename(__FILE__), array('EOCMSOptions', 'display'));
	}

	function display() {
		

		$options = EOCMSOptions::getOptions();
		
		
?>

<script language="JavaScript">
//点击标题隐藏下方表格
function hide(num) {
/*	var menuitems = document.getElementsByName("menuitem");
	for(var i=0;i<=menuitems.length;i++) {
		menuitems[i].className="out";
	}
	document.getElementById('block'+num).style.display="block";
	document.getElementById("menuitem"+num).className="current";

	var blocks = document.getElementsByName("block");
	for(var i=0;i<=blocks.length;i++) {
		menuitems[i].style.display="none";
	}*/
	$("#lmenu li a").attr("class","out");
	$("#menuitem"+num).attr("class","current");

	$("#main ul").css("display","none");
	$("#block"+num).css("display","block");}
	jQuery(document).ready(function() {
    jQuery('#upload_image_button').click(function() {
     formfield = jQuery('#upload_image').attr('name');
     // show WordPress' uploader modal box
     tb_show('', '<?php echo admin_url(); ?>media-upload.php?type=image&amp;TB_iframe=true');
     return false;
    });
    window.send_to_editor = function(html) {
     // this will execute automatically when a image uploaded and then clicked to 'insert to post' button
     imgurl = jQuery('img',html).attr('src');
     // put uploaded image's url to #upload_image
     jQuery('#upload_image').val(imgurl);
     tb_remove();
    }
});
	
</Script>
<?php

	//加载upload.js文件   
			wp_enqueue_script('my-upload', get_bloginfo( 'stylesheet_directory' ) . '/js/upload.js');   
			//加载点击上传图片的js(wp自带)   
			wp_enqueue_script('thickbox');   
			//加载css(wp自带)   
			wp_enqueue_style('thickbox');
	$blocks[] = array(
			'block_title'	=>	'首页Meta信息',
			'block_detail'	=>	array(

				'1'		=>	array(
					'type'		=>	'text',
					'title'		=>	'网站描述 Description',
					'label'		=>	'SEO提示: 70至160个字符',
					'name'		=>	'meta_description',
					'value'		=>	$options['meta_description']					
				),
				'2'		=>	array(
					'type'		=>	'text',
					'title'		=>	'网站关键词 Keywords',
					'label'		=>	'SEO提示: 10-20个关键词,勿堆砌,关键词请用英文逗号隔开',
					'name'		=>	'meta_keywords',
					'value'		=>	$options['meta_keywords']					
				)
			)		
		);
	$blocks[] = array(
			'block_title'	=>	'网站LOGO设置',
			'block_detail'	=>	array(
				'0'		=>	array(
 					'type'		=>	'text',
					'title'		=>	'网站logo',
					'label'		=>	'<input type="button" name="upload_button" value="点击上传" class="upbottom"/>',
					'name'		=>	'head_logo',
					'value'		=>	$options['head_logo'],
				)
			)		
		);

	$blocks[] = array(
			'block_title'	=>	'网站形象广告',
			'block_detail'	=>	array(
			   '0'		=>	array(
					'type'		=>	'checkbox',
					'title'		=>	'显示首页所有广告图',
					'name'		=>	'indexad_show',
					'value'		=>	$options['indexad_show']					
				),
				'1'		=>	array(
					'type'		=>	'text',
					'title'		=>	'首页广告图①',
					'label'		=>	'<input type="button" name="upload_button" value="点击上传" class="upbottom"/>',
					'name'		=>	'ad_img_01',
					'value'		=>	$options['ad_img_01']					
				),
				'2'		=>	array(
					'type'		=>	'text',
					'title'		=>	'图① 提示文字',
					'name'		=>	'ad_text_01',
					'value'		=>	$options['ad_text_01']					
				),
				'3'		=>	array(
					'type'		=>	'text',
					'title'		=>	'图① 连接',
					'label'		=>	'请复制需要连接的完整网址(url)',
					'name'		=>	'ad_url_01',
					'value'		=>	$options['ad_url_01']					
				),
				'4'		=>	array(
					'type'		=>	'text',
					'title'		=>	'首页广告图②',
					'label'		=>	'<input type="button" name="upload_button" value="点击上传" class="upbottom"/>',
					'name'		=>	'ad_img_02',
					'value'		=>	$options['ad_img_02']					
				),
				'5'		=>	array(
					'type'		=>	'text',
					'title'		=>	'图② 提示文字',
					'name'		=>	'ad_text_02',
					'value'		=>	$options['ad_text_02']					
				),
				'6'		=>	array(
					'type'		=>	'text',
					'title'		=>	'图② 连接',
					'label'		=>	'请复制需要连接的完整网址(url)',
					'name'		=>	'ad_url_02',
					'value'		=>	$options['ad_url_02']					
				),
				'7'		=>	array(
					'type'		=>	'text',
					'title'		=>	'首页广告图③',
					'label'		=>	'<input type="button" name="upload_button" value="点击上传" class="upbottom"/>',
					'name'		=>	'ad_img_03',
					'value'		=>	$options['ad_img_03']					
				),
				'8'		=>	array(
					'type'		=>	'text',
					'title'		=>	'图③ 提示文字',
					'name'		=>	'ad_text_03',
					'value'		=>	$options['ad_text_03']					
				),
				'9'		=>	array(
					'type'		=>	'text',
					'title'		=>	'图③ 连接',
					'label'		=>	'请复制需要连接的完整网址(url)',
					'name'		=>	'ad_url_03',
					'value'		=>	$options['ad_url_03']					
				),
				'10'		=>	array(
					'type'		=>	'text',
					'title'		=>	'用户登录界面 广告图',
					'label'		=>	'<input type="button" name="upload_button" value="点击上传" class="upbottom"/>',
					'name'		=>	'profile-img',
					'value'		=>	$options['profile-img']					
				),
				'11'		=>	array(
					'type'		=>	'text',
					'title'		=>	'广告图 提示文字',
					'name'		=>	'profile-img-text',
					'value'		=>	$options['profile-img-text']					
				),
				'12'		=>	array(
					'type'		=>	'text',
					'title'		=>	'广告图连接',
					'label'		=>	'请复制需要连接的网页地址(url)',
					'name'		=>	'profile-img-url',
					'value'		=>	$options['profile-img-url']					
				)
			)		
		);
		

	$blocks[] = array(
			'block_title'	=>	'在线客服设置',
			'block_detail'	=>	array(
			   '0'		=>	array(
					'type'		=>	'checkbox',
					'title'		=>	'不显示 在线客服',
					'name'		=>	'chatonline_show',
					'value'		=>	$options['chatonline_show']					
				)
			)		
		);
	$blocks[] = array(
			'block_title'	=>	'社交网络地址',
			'block_detail'	=>	array(
				'1'		=>	array(
					'type'		=>	'text',
					'title'		=>	'Facebook',
					'title2'	=>	'',
					'label'		=>	'',
					'name'		=>	'facebook',
					'value'		=>	$options['facebook']					
				),
				'2'		=>	array(
					'type'		=>	'text',
					'title'		=>	'Twitter',
					'title2'	=>	'',
					'label'		=>	'',
					'name'		=>	'twitter',
					'value'		=>	$options['twitter']					
				),
				'3'		=>	array(
					'type'		=>	'text',
					'title'		=>	'Google',
					'title2'	=>	'',
					'label'		=>	'',
					'name'		=>	'google',
					'value'		=>	$options['google']					
				),
				'4'		=>	array(
					'type'		=>	'text',
					'title'		=>	'Tumblr',
					'title2'	=>	'',
					'label'		=>	'',
					'name'		=>	'tumblr',
					'value'		=>	$options['tumblr']					
				),
				'5'		=>	array(
					'type'		=>	'text',
					'title'		=>	'Youtube',
					'title2'	=>	'',
					'label'		=>	'',
					'name'		=>	'youtube',
					'value'		=>	$options['youtube']					
				),

				'7'		=>	array(
					'type'		=>	'text',
					'title'		=>	'Pinterest',
					'title2'	=>	'',
					'label'		=>	'',
					'name'		=>	'pinterest',
					'value'		=>	$options['pinterest']					
				)
			)		
		);

		
			$blocks[] = array(
			'block_title'	=>	'版权付款支持',
			'block_detail'	=>	array(
				'1'		=>	array(
					'type'		=>	'text',
					'title'		=>	'网站底部付款支持图',
					'label'		=>	'<input type="button" name="upload_button" value="点击上传" class="upbottom"/>',
					'name'		=>	'pay_img',
					'value'		=>	$options['pay_img']					
				),
				'2'		=>	array(
					'type'		=>	'text',
					'title'		=>	'版权内容',
					'label'		=>	'显示在底部的Copyright信息',
					'name'		=>	'footer_content',
					'value'		=>	$options['footer_content']					
				)
			)		
		);

					$blocks[] = array(
			'block_title'	=>	'第三方信息代码',
			'block_detail'	=>	array(
				'1'		=>	array(
					'type'		=>	'textarea',
					'title'		=>	'谷歌站长工具 Webmaster验证代码',
					'label'		=>	'请复制 谷歌站长工具 "HTML标记" 代码;',
					'name'		=>	'google_wm',
					'value'		=>	$options['google_wm']					
				),
				'2'		=>	array(
					'type'		=>	'textarea',
					'title'		=>	'谷歌统计代码',
					'label'		=>	'请复制 谷歌统计 Google Analysis 代码;',
					'name'		=>	'google_an',
					'value'		=>	$options['google_an']					
				),
				'3'		=>	array(
					'type'		=>	'textarea',
					'title'		=>	'其他第三方代码',
					'label'		=>	'例如: CNZZ统计，谷歌统计等代码<br />请直接复制完整的代码，多个代码请提行后接着粘贴',
					'name'		=>	'footer_code',
					'value'		=>	$options['footer_code']					
				)
			)		
		);

			$blocks[] = array(
			'block_title'	=>	'关于我们设置<br />(部分模版支持)',
			'block_detail'	=>	array(
				'6'		=>	array(
					'type'		=>	'text',
					'title'		=>	'标题',
					'label'		=>	'例如：About Yourname.com, About Us, Why Choose Us.. ',
					'name'		=>	'about_title',
					'value'		=>	$options['about_title']					
				),
				'7'		=>	array(
					'type'		=>	'textarea',
					'title'		=>	'文字信息',
					'label'		=>	'首页About Us, Why Choose Us..的详细介绍<br />例如：Thank you for visiting Yourname.com, where you will find thousands of products offered at incredible wholesale prices. A quick look around our site will reveal our massive range of first-rate goods, be they electronics, tailored clothing, or sports equipment, but who are Yourname?',
					'name'		=>	'about_text',
					'value'		=>	$options['about_text']					
				)
			)		
		);
		

					$blocks[] = array(
			'block_title'	=>	'公司联系方式<br />(部分模版支持)',
			'block_detail'	=>	array(
				'0'		=>	array(
					'type'		=>	'text',
					'title'		=>	'公司名称',
					'label'		=>	'',
					'name'		=>	'company',
					'value'		=>	$options['company']					
				),
				'1'		=>	array(
					'type'		=>	'text',
					'title'		=>	'公司地址',
					'label'		=>	'',
					'name'		=>	'address',
					'value'		=>	$options['address']					
				),
				'2'		=>	array(
					'type'		=>	'text',
					'title'		=>	'联系Phone',
					'label'		=>	'',
					'name'		=>	'phone',
					'value'		=>	$options['phone']					
				),
				'3'		=>	array(
					'type'		=>	'text',
					'title'		=>	'联系Fax',
					'label'		=>	'',
					'name'		=>	'fax',
					'value'		=>	$options['fax']					
				),
				'4'		=>	array(
					'type'		=>	'text',
					'title'		=>	'联系Email',
					'label'		=>	'',
					'name'		=>	'email',
					'value'		=>	$options['email']					
				),
				'5'		=>	array(
					'type'		=>	'text',
					'title'		=>	'联系MSN帐号',
					'label'		=>	'',
					'name'		=>	'msn',
					'value'		=>	$options['msn']					
				),
				'6'		=>	array(
					'type'		=>	'text',
					'title'		=>	'联系Skype帐号',
					'label'		=>	'',
					'name'		=>	'skype',
					'value'		=>	$options['skype']					
				)
			)		
		);		
	$blocks[] = array(
			'block_title'	=>	'限时优惠信息<br />(仅支持优惠券)',
			'block_detail'	=>	array(
				'0'		=>	array(
					'type'		=>	'checkbox',
					'title'		=>	'显示顶部 限时优惠信息',
					'name'		=>	'offcode_show',
					'value'		=>	$options['offcode_show']					
				),
				'1'		=>	array(
					'type'		=>	'text',
					'title'		=>	'优惠券使用时间：',
					'label'		=>	'如: 08.01 - 12.30，该时间请配合优惠券使用',
					'name'		=>	'off_code',
					'value'		=>	$options['off_code']					
				),
				'2'		=>	array(
					'type'		=>	'text',
					'title'		=>	'失效时间(自动倒计时)：',
					'label'		=>	'如: 2014/12/30，请配合当前使用的优惠券失效时间',
					'name'		=>	'promotion_day',
					'value'		=>	$options['promotion_day']					
				),
				'3'		=>	array(
					'type'		=>	'text',
					'title'		=>	'优惠说明：',
					'label'		=>	'如: 10% Off code: wow10off',
					'name'		=>	'off_text',
					'value'		=>	$options['off_text']					
				),
				'4'		=>	array(
					'type'		=>	'text',
					'title'		=>	'免运费说明：',
					'label'		=>	'如: Free Shipping over $199.99',
					'name'		=>	'shipping_text',
					'value'		=>	$options['shipping_text']					
				)
			)		
		);	
?>
<style type="text/css">
/* Shows the same border as on front end */
form {
	margin: 0 0 0 0;
	padding: 0 0 0 0;
}
.title {
	float:left;
	margin:20px 0 0 10px;
	padding:0 0 0 0;
	width:970px;
	height:60px;
	background:url(<?php echo get_bloginfo('template_url'); ?>/images/setup_title.png) no-repeat 0 0px;
}
.title a {
	float:left;
	margin:26px 0 0 200px;
	color:#FFF;
	font-size:12px;
	font-family: '微软雅黑';
	text-shadow: 0 1px 0 #888;
	text-decoration:none;
}
.wrap {
	float:left;
	margin: 0 0 0 10px;
	padding: 0 0 0 0;
	width:990px;
	border: 1px solid #844921;
	background:url(<?php echo get_bloginfo('template_url'); ?>/images/lmenu_bak.png) repeat-y 0 0px;
}
p.submit1 {
	width:970px;
	text-align:right;
	clear:both;
	margin: 0 0 0 0;
	padding: 10px 20px 10px 0;
	border-bottom: 1px solid #E3E3E3;
	background-color: #F5F5F5;
}
p.submit2 {
	width:970px;
	text-align:right;
	clear:both;
	margin: 0 0 0 0;
	padding: 10px 20px 10px 0;
	border-top: 1px solid #E3E3E3;
	background-color: #F5F5F5;
}
p.submit1 span {
	float:left;
	margin: 5px 0 0 20px;
	line-height:20px;
	font-size:16px;
	font-family: '微软雅黑';
	text-shadow: 0 1px 0 #eee;
	text-decoration:none;
}
p.submit1 input, p.submit2 input {
	cursor: pointer;
	font-size: 12px;
	color: #444;
	text-shadow: 0 1px 0 white;
	background: #F3F3F3 url(<?php echo get_bloginfo('template_url'); ?>/images/btn.png) repeat-x 0 0;
	border: 1px solid #BBB;
	padding: 5px 10px 3px 10px;	
}
p.submit1 input:hover, p.submit2 input:hover {
	color: black;
	border-color: #666;	
}

.f_right {
	float:right;
	margin: 8px;
}
#lmenu {
	float:left;
	margin: 0 0 0 0;
	padding: 0 0 20px 0;
	width: 150px;
}
#lmenu ul {
	margin: 0 0 0 0;
	padding: 0 0 0 0;
}
#lmenu ul li {
	margin: 0 0 0 0;
	padding: 0 0 0 0;
}
#lmenu ul li a {
	display: block;
	width: 129px;
	padding: 8px 10px;
	color: #21759B;
	text-shadow: 0 1px 0 white;
	border-top: 1px solid #fff;
	border-right: 1px solid #E3E3E3;
	border-bottom: 1px solid #E3E3E3;
	background-color: #F5F5F5;
	color: #21759B;
	text-decoration: none;
}
#lmenu ul li a:hover {
	background-color: #EAF2FA;
	color: #555;
}
#lmenu ul li a.current {
	border-right: 1px solid #FFFFFF;
	background-color: #FFFFFF;
	color: #D54E45;
}
#lmenu ul li a.out {
	background-color: #F5F5F5;
	color: #21759B;
}
#lmenu ul li a.out:hover {
	background-color: #EAF2FA;
	color: #555;
}
#main {
	float:left;
	overflow: hidden;
	margin: 0 0 0 0;
	padding: 0 20px 20px 23px;
	width: 797px;
	height:500px;
	background-color: #FFFFFF;
	overflow-y: auto;
	overflow-x: hidden;
}
label {
	padding:0px;
	margin:0px;
	color:#aaa;
	font-weight: normal;
}
ul.block {
	float:left;
	clear:both;
	min-height:400px;
	margin:0 0 0 0px;
	padding:0 0 0 0;
	width:615px;
	display:none;
}
ul.block h2 {
	margin: 0 0 10px 0;
	line-height:25px;
	font-size:14px;
	font-weight:bold;
	border-bottom:1px solid #eee;
}
ul.block li {
	float:left;
	margin: 0 0 10px 0;
	width:800px;
}
.item_left {
	float:left;
	overflow:hidden;
	width:365px;
	color: #333;
	padding: 0 0 0 0;
}
.item_right {
	float:left;
	overflow:hidden;
	width:400px;
	color: #555;
	font-size:12px;
	padding: 3px 0 0 10px;
}
input.input {
	padding: 4px;
	width: 360px;
	width: 350px\9;
	background: #fafafa;
	border-style: solid;
	border-width: 1px;
	border-color: #BBB #EEE #EEE #BBB;
	color: #666;
}
input:hover.input, input:focus.input {
	color: #333;
	background: white;
}
.textarea {
	border: 1px solid #ccc;
	height:130px;
	width: 360px;
	width: 350px\9;
	line-height:20px;
}
.option-checkbox {
	border: none;
	max-height: 140px;
	height: auto !important;
	height: expression( document.body.clientHeight > 140 ? "140px" : "auto" );
	overflow-y: scroll;
	overflow-x: hidden;
}
.option-checkbox .element {
	float:left;
	padding: 5px 0 0 0;
	width: 350px;
}
label {
	margin: 4px 0 0 0;
	padding: 4px 0 0 0;
	color: #333;
}
.select {
	width: 350px;
}

</style>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.7.2.min.js"></script>
<br />
<form action="#" method="post" enctype="multipart/form-data" name="zuluo_form" id="zuluo_form">

<div class="wrap">

	<p class="submit1"><span>网站参数设置</span><input type="submit" name="zGauge_save" value="保存设置" /></p>

	<div id="lmenu">
		<ul>
		<li><a href="#" class="current" id="menuitem99" onclick="hide(99);" title="">网站标题/时间</a></li>
		<li><a href="#" id="menuitem98" onclick="hide(98);" title="">相关显示设置</a></li>
 
<?php
	$num = 0;
	foreach($blocks as $block) {
		if($num == 999) $aclass = 'current';
		else $aclass = 'out';
?>
		<li><a href="#" class="<?php echo $aclass; ?>" id="menuitem<?php echo $num; ?>" onclick="hide(<?php echo $num; ?>);" title="<?php echo $block['block_descrip']; ?>"><?php echo $block['block_title']; ?></a></li>
<?php		
		$num = $num + 1;
	}
?>		
		</ul>
		
	</div>

	<div id="main">
<ul class="block" id="block99" style="display:block;margin:0 0 -20px -20px;">
      <iframe class="main-frame" width="100%" scrolling="auto" height="auto" frameborder="false" allowtransparency="true" frameborder="0" style="border:0; height:500px;width:900px; position:relative;overflow:hidden;overflow:auto;" src="options-general.php" name="main-frame"></iframe>	
</ul>

<ul class="block" id="block98" style="margin:0 0 -20px -20px;">
      <iframe class="main-frame" width="100%" scrolling="auto" height="auto" frameborder="false" allowtransparency="true" frameborder="0" style="border:0; height:500px;width:900px; position:relative;overflow:hidden;overflow:auto;" src="options-reading.php" name="main-frame"></iframe>	
</ul>




<?php
	$num = 0;
	foreach($blocks as $block) {
?>
		<ul class="block" id="block<?php echo $num; ?>" <?php if($num == 999) echo 'style="display:block;"'; ?>>
		<?php
			foreach($block['block_detail'] as $item) {
				
				echo '<li><h2>'.$item['title'].'</h2>';
				echo '<div class="item_left">';

				switch($item['type']):
					case 'text':
						if($item['name'] == 'ashu_logo')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';
						elseif($item['name'] == 'head_logo')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'slider_img1')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'slider_img2')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'slider_img3')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'slider_img4')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'slider_img5')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'slider_pd_img1')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'pay_img')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'slider_pd_img2')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'slider_pd_img3')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'slider_pd_img4')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'slider_pd_img5')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'about_img')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'ad_img_01')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'ad_img_02')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'ad_img_03')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'side-bn-1')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'side-bn-2')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						elseif($item['name'] == 'profile-img')
						echo '<input  class="ashu_logo input" type="text" name="'.$item['name'].'" size="70%" value="'.$item['value'].'" ><br /><img src="'.$item['value'].'" style="max-width:355px;max-height:200px;border:1px solid #ddd;box-shadow:0 0 3px rgba(0,0,0,0.2);padding:2px;margin-top:10px;" />';	
						else
						echo '<input class="input" type="text" name="'.$item['name'].'" class="code" size="70%" value="'.$item['value'].'">';
						break;
					case 'textarea':
						echo '<textarea class="textarea" name="'.$item['name'].'">'.$item['value'].'</textarea>';
						break;
					case 'checkbox':
						echo '<input type="checkbox" name="'.$item['name'];
						if($item['value']) echo '" value="checkbox" checked="checked"> '.$item['title'];
						else echo '"> '.$item['title'];
						break;
					case 'checkbox-cat':
						echo '<div class="option-checkbox">';

						global $wpdb;
						$request = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms ";
						$request .= " LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ";
						$request .= " WHERE $wpdb->term_taxonomy.taxonomy = 'category' ";
						$request .= " ORDER BY term_id asc";
						$categorys = $wpdb->get_results($request);
						$i=0;
						foreach ($categorys as $category) {
							echo '<div class="element">';
								echo '<input type="checkbox" name="'.$item['name'].'[]"';
								if(in_array($category->term_id,explode(',',$item['value'])))
									echo ' checked="checked"';
								echo '" value="'.$category->term_id.'"> ';
								echo '<label for="'.$item['name'].'_'.$i.'">'.$category->name.'</label>';							
							echo '</div>';
							$i+=1;
						}

						echo '</div>';
						break;
					case 'radio':
						foreach($item['values'] as $value => $word) {							
							echo '<input type="radio" name="'.$item['name'].'" value="'.$value.'" ';
							if($value==$item['value'])
								echo 'checked';								
							echo '>'.$word.'&nbsp;&nbsp;';		
						}
						break;	
				endswitch;

				echo '</div>';
				echo '<div class="item_right">'.$item['label'].'</li>';
			}
		?>
		</ul>
<?php		
		$num = $num + 1;
	}
?>

	</div>

	<p class="submit2"><input type="submit" name="zGauge_save" value="保存设置" /></p>

</div>

</form>

<?php
	}
}

// Register functions
add_action('admin_menu', array('EOCMSOptions', 'add'));
/** l10n */
function theme_init(){
	load_theme_textdomain('zGauge', get_template_directory() . '/languages');
}
add_action ('init', 'theme_init');

?>
