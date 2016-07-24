<?php

if ( ! defined( 'ABSPATH' ) ) exit;

//获取请求
add_filter( 'query_vars','dw_license_query_vars' );
function dw_license_query_vars( $vars ){
    array_push($vars, 'client_domain');
    return $vars;
}

//检测验证请求是否为真
function dw_license_check_api() {
    global $wp_query;
    if(isset($wp_query->query_vars['client_domain'])) {

        //读取来自请求的值
        $client_domain = strip_tags($_REQUEST['client_domain']);
        $client_product_id = strip_tags($_REQUEST['client_product_id']);
        $client_token = strip_tags($_REQUEST['client_token']);

        //遍历查询是否有符合的domain
        global $wpdb;
        $sqlprepare = $wpdb->prepare("SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = 'dwl_product_domain' AND meta_value = '%s'", $client_domain);
        $sqlvalidate = $wpdb->get_row( $sqlprepare );
        $date_domain = get_post_meta( $sqlvalidate->post_id, 'dwl_product_domain', true);//数据库中获取域名

        
        if( $sqlvalidate){//如果有符合的domain
        $sqlprepare2 = $wpdb->prepare("SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = 'dwl_product_id' AND meta_value = '%s'", $client_product_id);
        $sqlvalidate2 = $wpdb->get_row( $sqlprepare2 );
        $date_product_id = get_post_meta( $sqlvalidate2->post_id, 'dwl_product_id', true);//数据库中获取产品id
        }

        //token的值设置为域名的md5加密取部分值
        $date_token_key = 'aaa'; //@DIY 自定义私钥，加大破解难度，必须同客户端的相同
        $date_token = substr(md5($date_token_key.urlencode($date_domain)),9,10);


        if( $sqlvalidate){//如果域名有效
            if($sqlvalidate2 && ($sqlvalidate->post_id == $sqlvalidate2->post_id)){//如果对应域名下产品有效且域名跟产品是在同一post id下
                if($date_token == $client_token){//如果对应域名下产品id有效,Token的值有效
                    $json_list = array(
                        'result' => 'success',
                        // 'date_domain' => $date_domain,
                        // 'date_product_id' => $date_product_id,
                        // 'date_token' => $date_token,
                        // 'client_domain' => $client_domain,
                        // 'client_product_id' => $client_product_id,
                        // 'client_token' => $client_token,
                        'mess' => '域名成功授权！'
                        );
                }
                else{
                     $json_list = array(
                        'result' => 'error',
                        // 'date_domain' => $date_domain,
                        // 'date_product_id' => $date_product_id,
                        // 'date_token' => $date_token,
                        // 'client_domain' => $client_domain,
                        // 'client_product_id' => $client_product_id,
                        // 'client_token' => $client_token,                        
                        'mess' => 'Token的值无效！'
                         );
                }

            }
            else{
                 $json_list = array(
                    'result' => 'error',
                    // 'date_domain' => $date_domain,
                    // 'date_product_id' => $date_product_id,
                    // 'date_token' => $date_token,
                    // 'client_domain' => $client_domain,
                    // 'client_product_id' => $client_product_id,
                    // 'client_token' => $client_token,                    
                    'mess' => '当前域名下没有有效的产品id！'

                    );   
                }	
        }
        else{
        	$json_list = array(
                'result' => 'error',
                // 'date_domain' => $date_domain,
                // 'date_product_id' => $date_product_id,
                // 'date_token' => $date_token,
                // 'client_domain' => $client_domain,
                // 'client_product_id' => $client_product_id,
                // 'client_token' => $client_token,               
                'mess' => '数据库没有该域名记录！'

                );	
        }

        //访问历史记录 @DIY
       // dw_license_log_file();

        header('Content-type: application/json');
        print json_encode( $json_list );
        exit;
    }
}
add_action( 'template_redirect', 'dw_license_check_api');