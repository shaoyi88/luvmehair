<?php
if ( ! defined( 'ABSPATH' ) ) exit;

//////////////////////////////**** 添加post type ****//////////////////////////////////////////

//注册dw_license 这个post_type
function dw_license_post_type() {
  $labels = array(
    'name'               => '授权',
    'singular_name'      => 'dw_license',
    'add_new'            => '添加授权',
    'add_new_item'       => '添加新的域名授权',
    'edit_item'          => '编辑授权',
    'new_item'           => '新的域名授权',
    'all_items'          => '所有授权',
    'view_item'          => '查看',
    'search_items'       => '搜索授权',
    'not_found'          => '没有找到授权',
    'not_found_in_trash' => '没有在回收站找到授权',
    'parent_item_colon'  => '',
    'menu_name'          => 'DW域名授权'
  );

  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    //'taxonomies'          => array( 'category', 'post_tag' ),@DIY
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'dw_license' ),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => true,
    'menu_position'      => null,
    'menu_icon'          => 'dashicons-admin-network',
    'supports'           => array( 'title' )
  );

  register_post_type( 'dw_license', $args );
}
add_action( 'init', 'dw_license_post_type' );

//自动填写标题
function dw_license_set_title( $data , $postarr ) {
  if($data['post_type'] == 'dw_license') {
        $License = get_post_meta( $postarr['ID'], 'dwl_product_domain', true);
        $prouct_id = get_post_meta( $postarr['ID'], 'dwl_product_id', true);

        $event_title = $prouct_id .'-'.$License;
        $data['post_title'] = $event_title;
  }
  return $data;
}
add_filter( 'wp_insert_post_data' , 'dw_license_set_title' , '10', 2 );

// 在该post type 下隐藏 permalink 
add_action('admin_init', 'dw_license_remove_permalink');
function dw_license_remove_permalink() {
    if(isset($_GET['post'])) {
        $post_type = get_post_type($_GET['post']);
        if($post_type == 'dw_license' && $_GET['action'] == 'edit') {
            echo '<style>#edit-slug-box{display:none;}</style>';
        }
    }
}

//////////////////////////////**** 添加post meta ****//////////////////////////////////////////


function dw_license_add_meta_box() {     
    add_meta_box(     
        'custom_meta_box', // $id     
        '域名授权信息输入框', //  显示meta_box标题   
        'dw_license_show_meta_box', // 命名回调函数    
        'dw_license', //  选择发布类型   
        'normal', // $context     
        'high'); //  权限   
} 
add_action('add_meta_boxes', 'dw_license_add_meta_box');

//$prefix = '_';   
  $custom_meta_fields = array(  //初始化数组 
    array(     
          'label'=> '产品id',//标记label名
          'id'    => 'dwl_product_id',  //custom_text 为输入框标记唯一的id名  
          'desc'  => '需要与客户端代码保持一致',//输入框描述 
          'type'  => 'text' //选择输入类型   
      ),
    array(     
          'label'=> '授权域名',//标记label名
          'id'    => 'dwl_product_domain',  //custom_text 为输入框标记唯一的id名  
          'desc'  => '不需要http://，区分有无www',//输入框描述 
          'type'  => 'text' //选择输入类型   
      ),
  );     

function dw_license_show_meta_box() {     
global $custom_meta_fields, $post;     
//   添加即时验证函数   
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';     
         
    //  开始循环出metabox 输入框   
    echo '<table class="form-table">';     
    foreach ($custom_meta_fields as $field) {  //对之前存储在变量$custom_meta_fields中的数组进行遍历   
            
        $meta = get_post_meta($post->ID, $field['id'], true);  //提取出每个字段的id   
        echo '<tr>    
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>    
                <td>';     
                switch($field['type']) {  //遍历输入框类型   
                        // text    
    case 'text':     
        echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />    
            <br /><span class="description">'.$field['desc'].'</span>';     
    break;     
       
        // textarea     
    case 'textarea':     
        echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>    
            <br /><span class="description">'.$field['desc'].'</span>';     
    break;                                  
                }    
        echo '</td></tr>';     
    } // end foreach     
    echo '</table>'; // end table            
}   

function dw_license_save_meta($post_id) {     
      global $custom_meta_fields;     
           
  //验证刚才创建的即时验证函数      
      if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))   
          return $post_id;     
      //   检查自动存储   
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)     
          return $post_id;     
      // 检查发布权限是否对应发布类型   
      if ('page' == $_POST['post_type']) {     
          if (!current_user_can('edit_page', $post_id))     
              return $post_id;     
          } elseif (!current_user_can('edit_post', $post_id)) {     
              return $post_id;     
      }     
           
      // 通过字段循环存储数据   
      foreach ($custom_meta_fields as $field) {     
          $old = get_post_meta($post_id, $field['id'], true);     
          $new = $_POST[$field['id']];     
          if ($new && $new != $old) {     
              update_post_meta($post_id, $field['id'], $new);  //更新数据   
          } elseif ('' == $new && $old) {     
              delete_post_meta($post_id, $field['id'], $old);  //如果为更新，则沿用之前字段中的数据   
          }     
      } // end foreach     
  }     
  add_action('save_post', 'dw_license_save_meta');