<?php 
/*
* 本主题为DW License Key Manager 的示例代码，在实际项目中需要集成到您的主题中；
* 你可以原版复制相关代码集成到您的主题中，注意注释更改相关内容；
* 若有bug 或更好的想法欢迎提出！
*/

/**
 * 定义基本变量
 *
 * @version 1.0
 * @since 14.10.10
 * @internal 请参考注释自己替换相关内容
 *
 */

//当前主题名称，可以通过自定义或者通过WordPress 内置函数自动获取style.css的名称
define('PRODUCT_ID', 'mindia');
//define('PRODUCT_ID', wp_get_theme());

//远程验证授权服务器
define('LICENSE_SERVER_URL', 'http://localhost:8080/'); //Rename this constant name so it is specific to your plugin or theme.

//私钥，用于加强破解难度
$SEC_KEY ='asifhaskldfgaf';//自行自定义，每个主题都不同即可

//transient 存储的名称，默认为 网站路径，md5加密
$KEY_NAME_MD = md5($SEC_KEY.get_stylesheet_directory());

//transient 存储的值，默认为 私钥+设置的域名的名称，md5加密
$KEY_VALUE_MD = md5($SEC_KEY.$KEY_NAME_MD);


/**
 * 定义相关函数
 *
 * @version 1.0
 * @since 14.10.10
 * @internal 包括授权失败文字及判断是否为login 页面的函数
 *
 */

//授权失败提示文字，请自行修改为自己的
function admin_notice_zpXnvPSiCDpL() {
  global $current_user;
        $user_id = $current_user->ID;
  if ( ! get_user_meta($user_id, 'ignore_notice') && is_admin()) {
        echo '<div class="updated"><p>'; 
          echo'此域名没有授权，主题无法正常使用，请正版客户<a href="http://devework.com/contact" target="_blank">联系主题作者</a>进行域名授权进行授权。'; 
          echo "</p></div>";
  }
}

//自定义函数是否为login页面
function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}


/**
 * 功能：检测是否有授权缓存，如果没有，则进行远程验证
 *
 * @version 1.0
 * @since 14.10.10
 * @internal  transient 的值默认为 产品名称+license+ 自定义内容，保证了每个位置的独立性，加大破解难度；
 *
 */

//验证域名是否正确
if (false === get_transient( $PRODUCT_ID.'_license_'.$KEY_NAME_MD)){ //如果没有授权缓存信息或者过期

	//当前环境使用域名
	$DOMAIN_NAME = $_SERVER['HTTP_HOST'];
	$CLIENT_TOKEN_KEY = 'aaa'; //自定义私钥，加大破解难度，必须同服务端的相同
	$CLIENT_TOKEN = substr(md5($CLIENT_TOKEN_KEY.urlencode($DOMAIN_NAME)),9,10);
	//$CLIENT_TOKEN2 = $DOMAIN_NAME;
	//$CLIENT_TOKEN = md5(urlencode($DOMAIN_NAME));

	// API 请求信息
    $api_args = array(
            //'dw_license_key' => 'license_check',
    		'client_domain' => urlencode($DOMAIN_NAME),
            'client_product_id' => urlencode(PRODUCT_ID),
            'client_token' => $CLIENT_TOKEN,
            
        );

    // 发送信息远程验证
    $response = wp_remote_get(add_query_arg($api_args, LICENSE_SERVER_URL), array('timeout' => 20, 'sslverify' => false));

    // 请求无效等报错
   	if ( is_wp_error( $request ) ){
        echo "请求失败，请稍后再尝试！";
    }

	// 获取返回的值
    $license_data = json_decode(wp_remote_retrieve_body($response));
        
    if($license_data->result == 'success'){//验证成功的话
    		set_transient($PRODUCT_ID.'_license_'.$KEY_NAME_MD, $KEY_VALUE_MD,5);//4320000s=5day，每过5 天重复验证
        }
        else{ //验证不成功
           set_transient($PRODUCT_ID.'_license_'.$KEY_NAME_MD , 0 , 5); //验证失败则每1 分钟验证一次
        }
}


/**
 * 功能：本地验证授权信息
 *
 * @version 1.0
 * @since 14.10.10
 * @internal  验证不通过则报错提示授权，反之加载相关文件
 *
 */
if ( $KEY_VALUE_MD != get_transient( $PRODUCT_ID.'_license_'.$KEY_NAME_MD)){//非法授权，警示		
		//前台提示用语
		if(!is_admin()&& !is_login_page()){
			wp_die('<p style="text-align:center;">此域名没有被授权，主题无法正常使用，请正版用户<a href="http://devework.com/contact" target="_blank">联系主题作者</a>进行域名授权。</p>
    			<p style="text-align:center;"><a href="javascript:window.location.reload();">刷新</a>&nbsp;&nbsp;<a href="/wp-admin/index.php">进入后台</a></p>');
		}
		else {
			 //后台提示用语
          add_action('admin_notices', 'admin_notice_zpXnvPSiCDpL');
		} 		
    }
else{
//该干嘛就干嘛，如加载文件等等；
	if(!is_admin()&& !is_login_page()){echo '演示效果：域名授权成功！{Powered by DeveWork.com}';}
}

 ?>