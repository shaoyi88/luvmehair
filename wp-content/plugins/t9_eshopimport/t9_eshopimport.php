<?php
/**
 * Plugin Name: eshop input
 * Plugin URI: http://www.eoseo.cn/
 * Description: eshop input
 * Version: 1.0.00
 * Author: eshop input
 * Author URI: http://www.eoseo.cn/
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE);
@set_time_limit(1000);
@set_magic_quotes_runtime(0);

if (!defined('IMPORT_PATH'))
	define('IMPORT_PATH', plugin_dir_path(__FILE__));
add_action('admin_menu', 't9_init');
function t9_init() {
	add_menu_page('Eshop数据导入', 'Eshop数据导入', 7, 't9_eshopimport');
	add_submenu_page('t9_eshopimport', '数据导入', '数据导入', 7, 't9_eshopimport', 'data_import');
} 

function data_import() {
	global $wpdb;
	$dir = IMPORT_PATH . "/upload/";
	$displaymain = true;
	if ($_REQUEST['action'] == 'import') {
		$file_name = $_REQUEST['file_name'];
		$file_path = $dir . $file_name;
		$csv_file = fopen($file_path, 'r');
		$result_arr = input_csv($csv_file);
		fclose($csv_file);
 
		echo '<div class="update-nag">导入开始！<br /></div>';
		$unique = false;

		foreach($result_arr as $key => $val) {
			$category = explode('|', $val[B]);
			$catids = array();
			foreach($category as $catname){
				$catid = get_catid($catname);
				$catids[] = $catid;
			}
			$my_post = array('post_title' => $val[A],
				'post_content' => $val[C],
				'post_status' => 'publish',
				'post_author' => $user_ID,
				'post_category' => $catids
				);
			$post_id = wp_insert_post($my_post);

			add_post_meta($post_id, '_eshop_sale', 'yes', $unique);
			$eshop_product = array();
			$eshop_product[sku] = '#';
			$eshop_product[products][1][option] = $val[D];
			$eshop_product[products][1][price] = $val[E];
			$eshop_product[products][1][saleprice] = $val[F];
			$eshop_product[products][1][tax] = $val[G];
			$eshop_product[products][1][weight] = $val[H];
			
			
			$eshop_product[description] = $val[A];
			$eshop_product[shiprate] = $val[J];
			$eshop_product[featured] = 'no';
			$eshop_product[sale] = 'yes';
			$eshop_product[cart_radio] = '';
			$eshop_product[optset] = explode(',', $val[I]);
			add_post_meta($post_id, '_eshop_product', $eshop_product, $unique);
			add_post_meta($post_id, '_eshop_stock', '1', $unique);
			if ($val[K] != '') {
				$filename = $val[K];
				$parent_post_id = $post_id;
				$filetype = wp_check_filetype(basename($filename), null);
				$wp_upload_dir = wp_upload_dir();
				$attachment = array('guid' => $wp_upload_dir['url'] . '/' . basename($filename),
					'post_mime_type' => $filetype['type'],
					'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
					'post_content' => '',
					'post_status' => 'inherit'
					);
				$attach_id = wp_insert_attachment($attachment, $filename, 0);
				add_post_meta($post_id, '_thumbnail_id', $attach_id, $unique);
			} 
			$pics = explode("@", $val[L]);
			if (is_array($pics)) {
				foreach($pics as $pic) {
					$filename = $pic;
					$parent_post_id = $post_id;
					$filetype = wp_check_filetype(basename($filename), null);
					$wp_upload_dir = wp_upload_dir();
					$attachment = array('guid' => $wp_upload_dir['url'] . '/' . basename($filename),
						'post_mime_type' => $filetype['type'],
						'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
						'post_content' => '',
						'post_status' => 'inherit'
						);
					$attach_id = wp_insert_attachment($attachment, $filename, $parent_post_id);
					$product_gallery[]=$attach_id;
				}
				add_post_meta($post_id, 'product_gallery',$product_gallery);
			} 
			if ($val[S] != '') {
				$filename = $val[S];
				$parent_post_id = $post_id;
				$filetype = wp_check_filetype(basename($filename), null);
				$wp_upload_dir = wp_upload_dir();
				$attachment = array('guid' => $wp_upload_dir['url'] . '/' . basename($filename),
					'post_mime_type' => $filetype['type'],
					'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
					'post_content' => '',
					'post_status' => 'inherit'
					);
				$attach_id = wp_insert_attachment($attachment, $filename, 0);
				add_post_meta($post_id, 'pro-img-bg', $attach_id, $unique);
				add_post_meta($post_id, '_pro-img-bg', 'field_541e43b5175d0', $unique);
			} 




			add_post_meta($post_id, 'zdy-01', $val[R], $unique);
			add_post_meta($post_id, '_zdy-01', 'field_541e4926f0077', $unique);

			echo '<p>第' . $key . '条导入成功！</p>';
		} 
		echo'<div class="update-nag">导入完毕！</div>';
	} else {
		if ($_REQUEST['dosubmit']) {
			if (is_dir($dir) == false) {
				mkdir($dir, 0777);
			} 
			$csv_filename = "csv_" . date("Ymdhis", time()) . ".csv";
			move_uploaded_file($_FILES["csv_file"]["tmp_name"], IMPORT_PATH . "/upload/" . $csv_filename);
			echo '<div class="update-nag">上传成功！<br /><a class="" href="admin.php?page=t9_eshopimport&action=import&file_name=' . $csv_filename . '">点击导入</a></div>';
		} else {
			echo '<div class="wrap d_wrap entry">
			<table style="padding:20px 0 0 0;">
	<tr>
        <td style="color:red;">
			CSV文件导入 (文件格式请联系谷道科技客服获取, 请勿乱提交CSV文件导入, 数据出错后果自负！)
        </td>
    </tr>
	
		<tr>
        <td style="height:50px;">
			<form action="" method="post" enctype="multipart/form-data">
				<input type="file" name="csv_file" size="50" maxlength="100000" />
				<input type="submit" name="dosubmit" value="点击上传" class="button button-primary"/>
			</form>        </td>
    </tr>
	</table>	
</div>';
		} 
	} 
} 

function input_csv($csv_file) {
	$result_arr = array ();
	$i = 0;
	while ($data_line = fgetcsv($csv_file, 10000)) {
		if ($i == 0) {
			$GLOBALS['csv_key_name_arr'] = $data_line;
			$i++;
			continue;
		} 
		$k = A;
		foreach($GLOBALS['csv_key_name_arr'] as $csv_key_num => $csv_key_name) {
			$csv_key_name = iconv("GBK", "UTF-8", $csv_key_name);
			$result_arr[$i][$k] = iconv("GBK", "UTF-8", $data_line[$csv_key_num]);
			$k++;
		} 
		$i++;
	} 
	return $result_arr;
}
function get_catid($cat_name){
  $rid = get_cat_ID($cat_name);
  if($rid!=0){
	  $catid = $rid;
  }else{
	  $catid = wp_create_category($cat_name);
  }
  return $catid;
}
 
?>