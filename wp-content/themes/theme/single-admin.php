<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>GD-Shop 外贸商城运营系统</title>
<link href="<?php echo home_url(); ?>/admin/admin.css" rel="stylesheet">
<script src="<?php echo home_url(); ?>/admin/js/jquery.min.js"></script>
<script src="<?php echo home_url(); ?>/admin/js/common.js"></script>
<script src="<?php echo home_url(); ?>/admin/js/jquery.nicescroll.js"></script>
<!--[if IE 6]>
<script src="<?php echo home_url(); ?>/admin/js/iepng.js"></script>
<![endif]-->
</head>
<?php if( current_user_can('administrator') ) : ?>
<body>
<!-- header -->
<div class="admin-head">
   <div class="admin-logo"><a href="http://www.GD-Shop.cn/"></a></div>
   <div class="nav-bar">

      <ul class="left-nav">
         <li><i></i><b>显示所有语言版本内容</b></li>
      </ul>
      <ul class="left-nav">
         <li><i></i><b>仅显示: English</b></li>
      </ul>
      <ul class="admin-nav">
         <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=sc_opt_pg_a" target="main-frame">您好! <?php global $current_user; get_currentuserinfo(); echo $current_user->user_login;?> (<?php if( current_user_can('administrator') ) : ?>超级管理员<?php elseif( current_user_can('editor') ) : ?>网站编辑<?php elseif( current_user_can('yewu') ) : ?>网站业务员<?php elseif( current_user_can('kefu') ) : ?>网站客服<?php endif; ?>)</a></li>
         <li class="menu-guide"><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=sc_opt_pg_a" target="main-frame">在线客服</a></li>
         <li class="menu-guide"><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=sc_chat_m_chat_logs" target="main-frame">聊天记录</a></li>
         <li class="menu-guide"><a style="color:#FFD200;" href="http://www.goodao.cn/guide" target="_blank">操作教程</a></li>
         <li class="menu-browse"><a target="_blank" href="<?php echo home_url(); ?>/">访问网站</a></li>
         <li class="menu-promote"><a href="<?php echo home_url(); ?>/logout?_wpnonce=a3f9f14d95"  target="main-frame">安全退出</a></li>
      </ul>
   </div>
</div>

<!-- aside -->
<div class="admin-side">
   <ul class="side-nav">
   <li class="current">
         <a href="javascript:"><span class="ico-box"><i class="ico-pc"></i><b class="ico-bg-red"></b></span>仪 表 盘</a>
	      <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Completed&by=dd" target="main-frame">最新订单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/users.php?orderby=registered&order=desc" target="main-frame">最新注册</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit.php" target="main-frame">最新产品</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=CF7DBPluginSubmissions" target="main-frame">客户询盘</a></li>
         </ul>         
      </li>
   
	 <li>
         <a href="#"><span class="ico-box"><i class="ico-pc"></i><b class="ico-bg-blue"></b></span>网站管理</a>
	      <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/options-general-email.php" target="main-frame">系统设置</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/post.php?post=1251&action=edit" target="main-frame">网站形象</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=all-in-one-seo-pack/aioseop_class.php" target="main-frame">网站标题</a></li>
<!--
            <li><a href="<?php echo home_url(); ?>/wp-admin/post.php?post=1228&action=edit" target="main-frame">联系方式</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/post.php?post=1241&action=edit" target="main-frame">关于我们</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=ico" target="main-frame">首页图标</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=ad01" target="main-frame">系列广告01</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=ad02" target="main-frame">系列广告02</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=ad03" target="main-frame">系列广告03</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=download" target="main-frame">Download</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=pdf" target="main-frame">PDF</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=certificate" target="main-frame">Certificate</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=video" target="main-frame">Video</a></li>
-->

			</ul>         
      </li>

      <li>
         <a href="#"><span class="ico-box"><i class="ico-site-map"></i><b class="ico-bg-cyan"></b></span>商城管理</a>
         <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=eshop-settings.php" target="main-frame">基础设置</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=eshop-settings.php&mstatus=Merchant" target="main-frame">支付通道</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-shipping.php" target="main-frame">运费设置</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=eshop-settings.php&mstatus=Tax" target="main-frame">税率设置</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=t9_eshop_currency" target="main-frame">汇率设置</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=eshop-settings.php&mstatus=Discounts" target="main-frame">折扣设置</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-discount-codes.php" target="main-frame">优惠券</a></li>
        </ul>         
      </li>
	  
	        <li><a href="#"><span class="ico-box"><i class="ico-product"></i><b class="ico-bg-yellow"></b></span>产品管理</a>
         <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/post-new.php" target="main-frame">产品发布</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit.php" target="main-frame">产品列表</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit-tags.php?taxonomy=category" target="main-frame">产品分类</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-options.php" target="main-frame">产品通用参数</a></li>
			<li><a href="<?php echo home_url(); ?>/wp-admin/themes.php?page=functions.php" target="main-frame">产品过滤筛选</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-products.php&eshopall=yes" target="main-frame">产品批量管理</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/post.php?post=1301&action=edit" target="main-frame">产品统一说明</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=t9_eshopimport" target="main-frame">产品批量导入</a></li>
            <!--<li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-base.php" target="main-frame">Google Shopping</a></li>-->
         </ul>         
      </li>

	  
	  
	  <li>	  <a href="#"><span class="ico-box"><i class="ico-user"></i><b class="ico-bg-red"></b></span>用户管理</a>

	     <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/users.php?orderby=registered&order=desc" target="main-frame">用户管理</a></li>                        <li><a href="<?php echo home_url(); ?>/wp-admin/supplier.php?orderby=registered&order=desc&role=supplier" target="main-frame">供应商管理</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/post.php?post=1146&action=edit" target="main-frame">用户权限</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=mailusers-user-settings" target="main-frame">邮件用户</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=mailusers-send-to-group-page" target="main-frame">邮件群发</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=mailusers-send-to-user-page " target="main-frame">邮件单发</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-templates.php&eshoptemplate=2" target="main-frame">自动邮件模版</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=wp-mail-smtp/wp_mail_smtp.php " target="main-frame">邮箱SMTP设置</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=wordpress-social-login" target="main-frame">第三方登录设置</a></li>
        </ul>         
      </li>
      <li>
	  <a href="#"><span class="ico-box"><i class="ico-google-tool"></i><b class="ico-bg-orange"></b></span>订单管理</a>
	     <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Pending&by=dd" target="main-frame">未付款</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Waiting&by=dd" target="main-frame">等待付款</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Failed&by=dd" target="main-frame">付款失败</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Completed&by=dd" target="main-frame">成功订单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Sent&by=dd" target="main-frame">已发货</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Deleted&by=dd" target="main-frame">回收站</a></li>
         </ul>         
      </li>
	  
      <li><a href="#"><span class="ico-box"><i class="ico-site-map"></i><b class="ico-bg-green-2"></b></span>页面管理</a>
	     <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/post-new.php?post_type=help" target="main-frame">新建页面</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=help" target="main-frame">页面管理</a></li>
         </ul>         
      </li>
      <li><a href="#"><span class="ico-box"><i class="ico-site-map"></i><b class="ico-bg-green-2"></b></span>视频模块</a>
	     <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/post-new.php?post_type=video" target="main-frame">新建视频</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=video" target="main-frame">视频管理</a></li>
         </ul>         
      </li>
      <li><a href="#"><span class="ico-box"><i class="ico-site-map"></i><b class="ico-bg-green-2"></b></span>相册模块</a>
	     <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/post-new.php?post_type=gallery" target="main-frame">新建相册</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=gallery" target="main-frame">相册管理</a></li>
         </ul>         
      </li>
	  
	  
      <li><a href="#"><span class="ico-box"><i class="ico-news"></i><b class="ico-bg-red"></b></span>博客管理</a>
	     <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/post-new.php?post_type=blog" target="main-frame">博客发布</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=blog" target="main-frame">博客列表</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit-tags.php?taxonomy=blog_catalog&post_type=blog" target="main-frame">博客分类</a></li>
         </ul>         
      </li>
<!--
 <li><a href="#"><span class="ico-box"><i class="ico-news"></i><b class="ico-bg-red"></b></span>新闻管理</a>
	     <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/post-new.php?post_type=news" target="main-frame">新闻发布</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=news" target="main-frame">新闻列表</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit-tags.php?taxonomy=news_catalog&post_type=news" target="main-frame">新闻分类</a></li>
         </ul>         
      </li>
-->
      <li><a href="#"><span class="ico-box"><i class="ico-site-map"></i><b class="ico-bg-blue"></b></span>网站导航</a>
	     <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=31" target="main-frame">网站主导航</a></li>		
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=219" target="main-frame">顶部 - 注册菜单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=570" target="main-frame">顶部 - 热门搜索</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=70" target="main-frame">侧栏 - 帮助菜单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=187" target="main-frame">侧栏 - 用户菜单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=68" target="main-frame">侧栏 - 博客菜单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=61" target="main-frame">底部 - Company Info</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=60" target="main-frame">底部 - Customer Service</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=305" target="main-frame">底部 - Payment & Shipping</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=306" target="main-frame">底部 - Company Policies</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=442" target="main-frame">底部 - 功能菜单</a></li>
         </ul>         
      </li>

	  
      <li><a href="#"><span class="ico-box"><i class="ico-product"></i><b class="ico-bg-yellow"></b></span>媒体管理</a>
         <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/upload.php" target="main-frame">媒体库</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="main-frame">上传媒体</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=DX-Watermark" target="main-frame">水印设置</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/options-media.php" target="main-frame">图片尺寸设置</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/tools.php?page=regenerate-thumbnails" target="main-frame">重新生成缩略图</a></li>


			</ul>         
      </li>

      <li><a href="#"><span class="ico-box"><i class="ico-file"></i><b class="ico-bg-cyan"></b></span>附件管理</a>
	     <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit-tags.php?taxonomy=post_tag" target="main-frame">标签管理</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit-comments.php" target="main-frame">评价管理</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=skype" target="main-frame">Skype客服</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=wpcf7&post=1045&action=edit" target="main-frame">联系表单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=wpcf7&post=1046&action=edit" target="main-frame">订阅表单</a></li>
            <li><a href="#" >缓存更新(自动)</a></li>
            <li><a href="#" >数据优化(自动)</a></li>
            <li><a href="#" >数据备份(自动)</a></li>
         </ul>         
      </li>
	  
      <li><a href="#"><span class="ico-box"><i class="ico-seo"></i><b class="ico-bg-orange"></b></span>SEO功能</a>
	     <ul class="sub-menu">
            <li><a href="http://webmaster.eoseo.cn/" target="main-frame">SEO站长工具 New!</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=iq-block-country/iq-block-country.php" target="main-frame">任意国家IP屏蔽</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/options-reading-google.php" target="main-frame">谷歌屏蔽设置</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=google-sitemap-generator/sitemap.php" target="main-frame">谷歌Sitemap地图</a></li>
            <li><a href="http://www.google.com/intl/zh-CN/webmasters/" target="main-frame">谷歌管理员工具</a></li>
            <li><a href="https://adwords.google.com/" target="main-frame">谷歌竞价广告</a></li>
            <li><a href="http://www.google.cn/intl/zh-CN_ALL/analytics/" target="main-frame">谷歌网站统计</a></li>
            <li><a href="http://translate.google.cn/" target="main-frame">谷歌翻译</a></li>
            <li><a href="http://www.google.com/trends/" target="main-frame">谷歌趋势</a></li>
            <li><a href="https://support.google.com/webmasters/answer/35843?hl=zh-Hans" target="main-frame">网站重审</a></li>
            <li><a href="https://www.google.com/webmasters/tools/disavow-links-main?pli=1" target="main-frame">外链屏蔽</a></li>
         </ul>         
      </li>

   </ul>
  
<?php elseif( current_user_can('editor') ) : ?>

<body>
<!-- header -->
<div class="admin-head">
   <div class="admin-logo"><a href="http://www.GD-Shop.cn/"></a></div>
   <div class="nav-bar">

      <ul class="left-nav">
         <li><i></i><b>显示所有语言版本内容</b></li>
      </ul>
      <ul class="left-nav">
         <li><i></i><b>仅显示: English</b></li>
      </ul>
      <ul class="admin-nav">
         <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=sc_opt_pg_a" target="main-frame">您好! <?php global $current_user; get_currentuserinfo(); echo $current_user->user_login;?> (<?php if( current_user_can('administrator') ) : ?>超级管理员<?php elseif( current_user_can('editor') ) : ?>网站编辑<?php elseif( current_user_can('yewu') ) : ?>网站业务员<?php elseif( current_user_can('kefu') ) : ?>网站客服<?php endif; ?>)</a></li>
         <?php if( in_array( '在线客服', get_field('qita') ) ){ ?><li class="menu-guide"><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=sc_opt_pg_a" target="main-frame">在线客服</a></li><?php } ?>
         <?php if( in_array( '聊天记录', get_field('qita') ) ){ ?><li class="menu-guide"><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=sc_chat_m_chat_logs" target="main-frame">聊天记录</a></li><?php } ?>
         <?php if( in_array( '操作教程', get_field('qita') ) ){ ?><li class="menu-guide"><a style="color:#FFD200;" href="http://www.gd-shop.cn/jc" target="_blank">操作教程</a></li><?php } ?>
         <li class="menu-browse"><a target="_blank" href="<?php echo home_url(); ?>/">访问网站</a></li>
         <li class="menu-promote"><a href="<?php echo home_url(); ?>/logout?_wpnonce=a3f9f14d95"  target="main-frame">安全退出</a></li>
      </ul>
   </div>
</div>

<!-- aside -->
<div class="admin-side">
   <ul class="side-nav">
   <li class="current">
         <a href="javascript:"><span class="ico-box"><i class="ico-pc"></i><b class="ico-bg-red"></b></span>仪 表 盘</a>
	      <ul class="sub-menu">
            <?php if( in_array( '最新订单', get_field('ybp') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Completed&by=dd" target="main-frame">最新订单</a></li><?php } ?>
            <?php if( in_array( '最新注册', get_field('ybp') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/users.php?orderby=registered&order=desc" target="main-frame">最新注册</a></li><?php } ?>
            <?php if( in_array( '最新产品', get_field('ybp') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit.php" target="main-frame">最新产品</a></li><?php } ?>
            <?php if( in_array( '客户询盘', get_field('ybp') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=CF7DBPluginSubmissions" target="main-frame">客户询盘</a></li><?php } ?>
         </ul>         
      </li>
   
	 <li>
         <a href="#"><span class="ico-box"><i class="ico-pc"></i><b class="ico-bg-blue"></b></span>网站管理</a>
	      <ul class="sub-menu">
		  
		    <?php if( in_array( '系统设置', get_field('wzgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general-email.php" target="main-frame">系统设置</a></li><?php } ?>
            <?php if( in_array( '网站形象', get_field('wzgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post.php?post=1251&action=edit" target="main-frame">网站形象</a></li><?php } ?>
            <?php if( in_array( '网站标题', get_field('wzgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=all-in-one-seo-pack/aioseop_class.php" target="main-frame">网站标题</a></li><?php } ?>

		  
			</ul>         
      </li>

      <li>
         <a href="#"><span class="ico-box"><i class="ico-site-map"></i><b class="ico-bg-cyan"></b></span>商城管理</a>
         <ul class="sub-menu">
            <?php if( in_array( '基础设置', get_field('scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=eshop-settings.php" target="main-frame">基础设置</a></li><?php } ?>
            <?php if( in_array( '支付通道', get_field('scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=eshop-settings.php&mstatus=Merchant" target="main-frame">支付通道</a></li><?php } ?>
            <?php if( in_array( '运费设置', get_field('scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-shipping.php" target="main-frame">运费设置</a></li><?php } ?>
            <?php if( in_array( '税率设置', get_field('scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=eshop-settings.php&mstatus=Tax" target="main-frame">税率设置</a></li><?php } ?>
            <?php if( in_array( '汇率设置', get_field('scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=t9_eshop_currency" target="main-frame">汇率设置</a></li><?php } ?>
            <?php if( in_array( '折扣设置', get_field('scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=eshop-settings.php&mstatus=Discounts" target="main-frame">折扣设置</a></li><?php } ?>
            <?php if( in_array( '优惠券', get_field('scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-discount-codes.php" target="main-frame">优惠券</a></li><?php } ?>
         </ul>         
      </li>
      <li><a href="#"><span class="ico-box"><i class="ico-product"></i><b class="ico-bg-yellow"></b></span>产品管理</a>
         <ul class="sub-menu">
            <?php if( in_array( '产品发布', get_field('cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post-new.php" target="main-frame">产品发布</a></li><?php } ?>
            <?php if( in_array( '产品列表', get_field('cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit.php" target="main-frame">产品列表</a></li><?php } ?>
            <?php if( in_array( '产品分类', get_field('cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit-tags.php?taxonomy=category" target="main-frame">产品分类</a></li><?php } ?>
            <?php if( in_array( '产品通用参数', get_field('cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-options.php" target="main-frame">产品通用参数</a></li><?php } ?>
			<?php if( in_array( '产品过滤筛选', get_field('cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/themes.php?page=functions.php" target="main-frame">产品过滤筛选</a></li><?php } ?>
            <?php if( in_array( '产品批量管理', get_field('cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-products.php&eshopall=yes" target="main-frame">产品批量管理</a></li><?php } ?>
            <?php if( in_array( '产品统一说明', get_field('cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post.php?post=1301&action=edit" target="main-frame">产品统一说明</a></li><?php } ?>
            <?php if( in_array( '产品批量导入', get_field('cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=t9_eshopimport" target="main-frame">产品批量导入</a></li><?php } ?>
            <!--<li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-base.php" target="main-frame">Google Shopping</a></li>-->
         </ul>         
      </li>


	  <li>	  <a href="#"><span class="ico-box"><i class="ico-user"></i><b class="ico-bg-red"></b></span>用户管理</a>

	     <ul class="sub-menu">
            <?php if( in_array( '用户管理', get_field('yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/users.php?orderby=registered&order=desc" target="main-frame">用户管理</a></li><?php } ?>
            <?php if( in_array( '用户权限', get_field('yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post.php?post=46560&action=edit" target="main-frame">用户权限</a></li><?php } ?>
            <?php if( in_array( '邮件用户', get_field('yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=mailusers-user-settings" target="main-frame">邮件用户</a></li><?php } ?>
            <?php if( in_array( '邮件群发', get_field('yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=mailusers-send-to-group-page" target="main-frame">邮件群发</a></li><?php } ?>
            <?php if( in_array( '邮件单发', get_field('yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=mailusers-send-to-user-page " target="main-frame">邮件单发</a></li><?php } ?>
            <?php if( in_array( '邮件模版', get_field('yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-templates.php&eshoptemplate=2" target="main-frame">自动邮件模版</a></li><?php } ?>
            <?php if( in_array( '邮箱SMTP设置', get_field('yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=wp-mail-smtp/wp_mail_smtp.php " target="main-frame">邮箱SMTP设置</a></li><?php } ?>
            <?php if( in_array( '第三方登录设置', get_field('yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=wordpress-social-login" target="main-frame">第三方登录设置</a></li><?php } ?>
        </ul>         
      </li>
      <?php if( in_array( '订单管理', get_field('ddgl') ) ){ ?><li>
	  <a href="#"><span class="ico-box"><i class="ico-google-tool"></i><b class="ico-bg-orange"></b></span>订单管理</a>
	     <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Pending&by=dd" target="main-frame">未付款</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Waiting&by=dd" target="main-frame">等待付款</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Failed&by=dd" target="main-frame">付款失败</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Completed&by=dd" target="main-frame">成功订单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Sent&by=dd" target="main-frame">已发货</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Deleted&by=dd" target="main-frame">回收站</a></li>
         </ul>         
      </li><?php } ?>
	  
      <li><a href="#"><span class="ico-box"><i class="ico-site-map"></i><b class="ico-bg-green-2"></b></span>页面管理</a>
	     <ul class="sub-menu">
            <?php if( in_array( '新建页面', get_field('ymgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post-new.php?post_type=help" target="main-frame">新建页面</a></li><?php } ?>
            <?php if( in_array( '页面管理', get_field('ymgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=help" target="main-frame">页面管理</a></li><?php } ?>
         </ul>         
      </li>
	  
	  
      <li><a href="#"><span class="ico-box"><i class="ico-news"></i><b class="ico-bg-red"></b></span>博客管理</a>
	     <ul class="sub-menu">
            <?php if( in_array( '博客发布', get_field('bkgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post-new.php?post_type=blog" target="main-frame">博客发布</a></li><?php } ?>
            <?php if( in_array( '博客列表', get_field('bkgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=blog" target="main-frame">博客列表</a></li><?php } ?>
            <?php if( in_array( '博客分类', get_field('bkgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit-tags.php?taxonomy=blog_catalog&post_type=blog" target="main-frame">博客分类</a></li><?php } ?>
         </ul>         
      </li>
	  <?php if( in_array( '网站导航', get_field('wzdh') ) ){ ?>
      <li><a href="#"><span class="ico-box"><i class="ico-site-map"></i><b class="ico-bg-blue"></b></span>网站导航</a>
	     <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=31" target="main-frame">网站主导航</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=4" target="main-frame">导航 - 产品分类</a></li>			
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=219" target="main-frame">顶部 - 注册菜单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=70" target="main-frame">侧栏 - 帮助菜单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=187" target="main-frame">侧栏 - 用户菜单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=68" target="main-frame">侧栏 - 博客菜单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=61" target="main-frame">底部 - Company Info</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=60" target="main-frame">底部 - Customer Service</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=305" target="main-frame">底部 - Payment & Shipping</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=306" target="main-frame">底部 - Company Policies</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=442" target="main-frame">底部 - 功能菜单</a></li>
         </ul>         
      </li><?php } ?>

	  
      <li><a href="#"><span class="ico-box"><i class="ico-product"></i><b class="ico-bg-yellow"></b></span>媒体管理</a>
         <ul class="sub-menu">
            <?php if( in_array( '媒体库', get_field('mtgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/upload.php" target="main-frame">媒体库</a></li><?php } ?>
            <?php if( in_array( '上传媒体', get_field('mtgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="main-frame">上传媒体</a></li><?php } ?>
            <?php if( in_array( '水印设置', get_field('mtgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=DX-Watermark" target="main-frame">水印设置</a></li><?php } ?>
            <?php if( in_array( '图片尺寸设置', get_field('mtgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-media.php" target="main-frame">图片尺寸设置</a></li><?php } ?>
            <?php if( in_array( '重新生成缩略图', get_field('mtgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/tools.php?page=regenerate-thumbnails" target="main-frame">重新生成缩略图</a></li><?php } ?>
			</ul>         
      </li>

      <li><a href="#"><span class="ico-box"><i class="ico-file"></i><b class="ico-bg-cyan"></b></span>附件管理</a>
	     <ul class="sub-menu">
            <?php if( in_array( '标签管理', get_field('qita') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit-tags.php?taxonomy=post_tag" target="main-frame">标签管理</a></li><?php } ?>
            <?php if( in_array( '评价管理', get_field('qita') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit-comments.php" target="main-frame">评价管理</a></li><?php } ?>
            <?php if( in_array( 'Skype客服', get_field('qita') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=skype" target="main-frame">Skype客服</a></li><?php } ?>
            <?php if( in_array( '联系表单', get_field('qita') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=wpcf7&post=1045&action=edit" target="main-frame">联系表单</a></li><?php } ?>
            <?php if( in_array( '订阅表单', get_field('qita') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=wpcf7&post=1046&action=edit" target="main-frame">订阅表单</a></li><?php } ?>
         </ul>         
      </li>
	  <?php if( in_array( 'SEO功能', get_field('qita') ) ){ ?>
      <li><a href="#"><span class="ico-box"><i class="ico-seo"></i><b class="ico-bg-orange"></b></span>SEO功能</a>
	     <ul class="sub-menu">
            <li><a href="http://webmaster.eoseo.cn/" target="main-frame">SEO站长工具 New!</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=iq-block-country/iq-block-country.php" target="main-frame">任意国家IP屏蔽</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=google-sitemap-generator/sitemap.php" target="main-frame">谷歌Sitemap地图</a></li>
            <li><a href="http://www.google.com/intl/zh-CN/webmasters/" target="main-frame">谷歌管理员工具</a></li>
            <li><a href="https://adwords.google.com/" target="main-frame">谷歌竞价广告</a></li>
            <li><a href="http://www.google.cn/intl/zh-CN_ALL/analytics/" target="main-frame">谷歌网站统计</a></li>
            <li><a href="http://translate.google.cn/" target="main-frame">谷歌翻译</a></li>
            <li><a href="http://www.google.com/trends/" target="main-frame">谷歌趋势</a></li>
            <li><a href="https://support.google.com/webmasters/answer/35843?hl=zh-Hans" target="main-frame">网站重审</a></li>
            <li><a href="https://www.google.com/webmasters/tools/disavow-links-main?pli=1" target="main-frame">外链屏蔽</a></li>
         </ul>         
      </li><?php } ?>

   </ul>
<?php elseif( current_user_can('yewu') ) : ?>

<body>
<!-- header -->
<div class="admin-head">
   <div class="admin-logo"><a href="http://www.GD-Shop.cn/"></a></div>
   <div class="nav-bar">

      <ul class="left-nav">
         <li><i></i><b>显示所有语言版本内容</b></li>
      </ul>
      <ul class="left-nav">
         <li><i></i><b>仅显示: English</b></li>
      </ul>
      <ul class="admin-nav">
         <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=sc_opt_pg_a" target="main-frame">您好! <?php global $current_user; get_currentuserinfo(); echo $current_user->user_login;?> (<?php if( current_user_can('administrator') ) : ?>超级管理员<?php elseif( current_user_can('editor') ) : ?>网站编辑<?php elseif( current_user_can('yewu') ) : ?>网站业务员<?php elseif( current_user_can('kefu') ) : ?>网站客服<?php endif; ?>)</a></li>
         <?php if( in_array( '在线客服', get_field('yewu_qita') ) ){ ?><li class="menu-guide"><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=sc_opt_pg_a" target="main-frame">在线客服</a></li><?php } ?>
         <?php if( in_array( '聊天记录', get_field('yewu_qita') ) ){ ?><li class="menu-guide"><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=sc_chat_m_chat_logs" target="main-frame">聊天记录</a></li><?php } ?>
         <?php if( in_array( '操作教程', get_field('yewu_qita') ) ){ ?><li class="menu-guide"><a style="color:#FFD200;" href="http://www.gd-shop.cn/jc" target="_blank">操作教程</a></li><?php } ?>
         <li class="menu-browse"><a target="_blank" href="<?php echo home_url(); ?>/">访问网站</a></li>
         <li class="menu-promote"><a href="<?php echo home_url(); ?>/logout?_wpnonce=a3f9f14d95"  target="main-frame">安全退出</a></li>
      </ul>
   </div>
</div>

<!-- aside -->
<div class="admin-side">
   <ul class="side-nav">
   <li class="current">
         <a href="javascript:"><span class="ico-box"><i class="ico-pc"></i><b class="ico-bg-red"></b></span>仪 表 盘</a>
	      <ul class="sub-menu">
            <?php if( in_array( '最新订单', get_field('yewu_ybp') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Completed&by=dd" target="main-frame">最新订单</a></li><?php } ?>
            <?php if( in_array( '最新注册', get_field('yewu_ybp') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/users.php?orderby=registered&order=desc" target="main-frame">最新注册</a></li><?php } ?>
            <?php if( in_array( '最新产品', get_field('yewu_ybp') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit.php" target="main-frame">最新产品</a></li><?php } ?>
            <?php if( in_array( '客户询盘', get_field('yewu_ybp') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=CF7DBPluginSubmissions" target="main-frame">客户询盘</a></li><?php } ?>
         </ul>         
      </li>
   
	 <li>
         <a href="#"><span class="ico-box"><i class="ico-pc"></i><b class="ico-bg-blue"></b></span>网站管理</a>
	      <ul class="sub-menu">
		    <?php if( in_array( '系统设置', get_field('yewu_wzgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general-email.php" target="main-frame">系统设置</a></li><?php } ?>
            <?php if( in_array( '网站形象', get_field('yewu_wzgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post.php?post=1251&action=edit" target="main-frame">网站形象</a></li><?php } ?>
            <?php if( in_array( '网站标题', get_field('yewu_wzgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=all-in-one-seo-pack/aioseop_class.php" target="main-frame">网站标题</a></li><?php } ?>
  		  </ul>         
      </li>

      <li>
         <a href="#"><span class="ico-box"><i class="ico-site-map"></i><b class="ico-bg-cyan"></b></span>商城管理</a>
         <ul class="sub-menu">
            <?php if( in_array( '基础设置', get_field('yewu_scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=eshop-settings.php" target="main-frame">基础设置</a></li><?php } ?>
            <?php if( in_array( '支付通道', get_field('yewu_scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=eshop-settings.php&mstatus=Merchant" target="main-frame">支付通道</a></li><?php } ?>
            <?php if( in_array( '运费设置', get_field('yewu_scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-shipping.php" target="main-frame">运费设置</a></li><?php } ?>
            <?php if( in_array( '税率设置', get_field('yewu_scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=eshop-settings.php&mstatus=Tax" target="main-frame">税率设置</a></li><?php } ?>
            <?php if( in_array( '汇率设置', get_field('yewu_scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=t9_eshop_currency" target="main-frame">汇率设置</a></li><?php } ?>
            <?php if( in_array( '折扣设置', get_field('yewu_scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=eshop-settings.php&mstatus=Discounts" target="main-frame">折扣设置</a></li><?php } ?>
            <?php if( in_array( '优惠券', get_field('yewu_scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-discount-codes.php" target="main-frame">优惠券</a></li><?php } ?>
         </ul>         
      </li>

	        <li><a href="#"><span class="ico-box"><i class="ico-product"></i><b class="ico-bg-yellow"></b></span>产品管理</a>
         <ul class="sub-menu">
            <?php if( in_array( '产品发布', get_field('yewu_cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post-new.php" target="main-frame">产品发布</a></li><?php } ?>
            <?php if( in_array( '产品列表', get_field('yewu_cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit.php" target="main-frame">产品列表</a></li><?php } ?>
            <?php if( in_array( '产品分类', get_field('yewu_cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit-tags.php?taxonomy=category" target="main-frame">产品分类</a></li><?php } ?>
            <?php if( in_array( '产品通用参数', get_field('yewu_cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-options.php" target="main-frame">产品通用参数</a></li><?php } ?>
			<?php if( in_array( '产品过滤筛选', get_field('yewu_cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/themes.php?page=functions.php" target="main-frame">产品过滤筛选</a></li><?php } ?>
            <?php if( in_array( '产品批量管理', get_field('yewu_cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-products.php&eshopall=yes" target="main-frame">产品批量管理</a></li><?php } ?>
            <?php if( in_array( '产品统一说明', get_field('yewu_cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post.php?post=1301&action=edit" target="main-frame">产品统一说明</a></li><?php } ?>
            <?php if( in_array( '产品批量导入', get_field('yewu_cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=t9_eshopimport" target="main-frame">产品批量导入</a></li><?php } ?>
            <!--<li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-base.php" target="main-frame">Google Shopping</a></li>-->
         </ul>         
      </li>


	  <li>	  <a href="#"><span class="ico-box"><i class="ico-user"></i><b class="ico-bg-red"></b></span>用户管理</a>

	     <ul class="sub-menu">
            <?php if( in_array( '用户管理', get_field('yewu_yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/users.php?orderby=registered&order=desc" target="main-frame">用户管理</a></li><?php } ?>
            <?php if( in_array( '用户权限', get_field('yewu_yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post.php?post=46560&action=edit" target="main-frame">用户权限</a></li><?php } ?>
            <?php if( in_array( '邮件用户', get_field('yewu_yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=mailusers-user-settings" target="main-frame">邮件用户</a></li><?php } ?>
            <?php if( in_array( '邮件群发', get_field('yewu_yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=mailusers-send-to-group-page" target="main-frame">邮件群发</a></li><?php } ?>
            <?php if( in_array( '邮件单发', get_field('yewu_yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=mailusers-send-to-user-page " target="main-frame">邮件单发</a></li><?php } ?>
            <?php if( in_array( '邮件模版', get_field('yewu_yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-templates.php&eshoptemplate=2" target="main-frame">自动邮件模版</a></li><?php } ?>
            <?php if( in_array( '邮箱SMTP设置', get_field('yewu_yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=wp-mail-smtp/wp_mail_smtp.php " target="main-frame">邮箱SMTP设置</a></li><?php } ?>
            <?php if( in_array( '第三方登录设置', get_field('yewu_yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=wordpress-social-login" target="main-frame">第三方登录设置</a></li><?php } ?>
        </ul>         
      </li>
      <?php if( in_array( '订单管理', get_field('yewu_ddgl') ) ){ ?><li>
	  <a href="#"><span class="ico-box"><i class="ico-google-tool"></i><b class="ico-bg-orange"></b></span>订单管理</a>
	     <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Pending&by=dd" target="main-frame">未付款</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Waiting&by=dd" target="main-frame">等待付款</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Failed&by=dd" target="main-frame">付款失败</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Completed&by=dd" target="main-frame">成功订单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Sent&by=dd" target="main-frame">已发货</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Deleted&by=dd" target="main-frame">回收站</a></li>
         </ul>         
      </li><?php } ?>
	  
      <li><a href="#"><span class="ico-box"><i class="ico-site-map"></i><b class="ico-bg-green-2"></b></span>页面管理</a>
	     <ul class="sub-menu">
            <?php if( in_array( '新建页面', get_field('yewu_ymgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post-new.php?post_type=help" target="main-frame">新建页面</a></li><?php } ?>
            <?php if( in_array( '页面管理', get_field('yewu_ymgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=help" target="main-frame">页面管理</a></li><?php } ?>
         </ul>         
      </li>
	  
	  
      <li><a href="#"><span class="ico-box"><i class="ico-news"></i><b class="ico-bg-red"></b></span>博客管理</a>
	     <ul class="sub-menu">
            <?php if( in_array( '博客发布', get_field('yewu_bkgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post-new.php?post_type=blog" target="main-frame">博客发布</a></li><?php } ?>
            <?php if( in_array( '博客列表', get_field('yewu_bkgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=blog" target="main-frame">博客列表</a></li><?php } ?>
            <?php if( in_array( '博客分类', get_field('yewu_bkgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit-tags.php?taxonomy=blog_catalog&post_type=blog" target="main-frame">博客分类</a></li><?php } ?>
         </ul>         
      </li>
	  <?php if( in_array( '网站导航', get_field('yewu_wzdh') ) ){ ?>
      <li><a href="#"><span class="ico-box"><i class="ico-site-map"></i><b class="ico-bg-blue"></b></span>网站导航</a>
	     <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=31" target="main-frame">网站主导航</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=4" target="main-frame">导航 - 产品分类</a></li>			
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=219" target="main-frame">顶部 - 注册菜单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=70" target="main-frame">侧栏 - 帮助菜单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=187" target="main-frame">侧栏 - 用户菜单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=68" target="main-frame">侧栏 - 博客菜单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=61" target="main-frame">底部 - Company Info</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=60" target="main-frame">底部 - Customer Service</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=305" target="main-frame">底部 - Payment & Shipping</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=306" target="main-frame">底部 - Company Policies</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=442" target="main-frame">底部 - 功能菜单</a></li>
         </ul>         
      </li><?php } ?>

	  
      <li><a href="#"><span class="ico-box"><i class="ico-product"></i><b class="ico-bg-yellow"></b></span>媒体管理</a>
         <ul class="sub-menu">
            <?php if( in_array( '媒体库', get_field('yewu_mtgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/upload.php" target="main-frame">媒体库</a></li><?php } ?>
            <?php if( in_array( '上传媒体', get_field('yewu_mtgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="main-frame">上传媒体</a></li><?php } ?>
            <?php if( in_array( '水印设置', get_field('yewu_mtgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=DX-Watermark" target="main-frame">水印设置</a></li><?php } ?>
            <?php if( in_array( '图片尺寸设置', get_field('yewu_mtgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-media.php" target="main-frame">图片尺寸设置</a></li><?php } ?>
            <?php if( in_array( '重新生成缩略图', get_field('yewu_mtgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/tools.php?page=regenerate-thumbnails" target="main-frame">重新生成缩略图</a></li><?php } ?>
			</ul>         
      </li>

      <li><a href="#"><span class="ico-box"><i class="ico-file"></i><b class="ico-bg-cyan"></b></span>附件管理</a>
	     <ul class="sub-menu">
            <?php if( in_array( '标签管理', get_field('yewu_qita') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit-tags.php?taxonomy=post_tag" target="main-frame">标签管理</a></li><?php } ?>
            <?php if( in_array( '评价管理', get_field('yewu_qita') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit-comments.php" target="main-frame">评价管理</a></li><?php } ?>
            <?php if( in_array( 'Skype客服', get_field('yewu_qita') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=skype" target="main-frame">Skype客服</a></li><?php } ?>
            <?php if( in_array( '联系表单', get_field('yewu_qita') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=wpcf7&post=1045&action=edit" target="main-frame">联系表单</a></li><?php } ?>
            <?php if( in_array( '订阅表单', get_field('yewu_qita') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=wpcf7&post=1046&action=edit" target="main-frame">订阅表单</a></li><?php } ?>
         </ul>         
      </li>
	  <?php if( in_array( 'SEO功能', get_field('yewu_qita') ) ){ ?>
      <li><a href="#"><span class="ico-box"><i class="ico-seo"></i><b class="ico-bg-orange"></b></span>SEO功能</a>
	     <ul class="sub-menu">
            <li><a href="http://webmaster.eoseo.cn/" target="main-frame">SEO站长工具 New!</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=iq-block-country/iq-block-country.php" target="main-frame">任意国家IP屏蔽</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=google-sitemap-generator/sitemap.php" target="main-frame">谷歌Sitemap地图</a></li>
            <li><a href="http://www.google.com/intl/zh-CN/webmasters/" target="main-frame">谷歌管理员工具</a></li>
            <li><a href="https://adwords.google.com/" target="main-frame">谷歌竞价广告</a></li>
            <li><a href="http://www.google.cn/intl/zh-CN_ALL/analytics/" target="main-frame">谷歌网站统计</a></li>
            <li><a href="http://translate.google.cn/" target="main-frame">谷歌翻译</a></li>
            <li><a href="http://www.google.com/trends/" target="main-frame">谷歌趋势</a></li>
            <li><a href="https://support.google.com/webmasters/answer/35843?hl=zh-Hans" target="main-frame">网站重审</a></li>
            <li><a href="https://www.google.com/webmasters/tools/disavow-links-main?pli=1" target="main-frame">外链屏蔽</a></li>
         </ul>         
      </li><?php } ?>

   </ul>
   
   
   
   <?php elseif( current_user_can('kefu') ) : ?>

<body>
<!-- header -->
<div class="admin-head">
   <div class="admin-logo"><a href="http://www.GD-Shop.cn/"></a></div>
   <div class="nav-bar">

      <ul class="left-nav">
         <li><i></i><b>显示所有语言版本内容</b></li>
      </ul>
      <ul class="left-nav">
         <li><i></i><b>仅显示: English</b></li>
      </ul>
      <ul class="admin-nav">
         <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=sc_opt_pg_a" target="main-frame">您好! <?php global $current_user; get_currentuserinfo(); echo $current_user->user_login;?> (<?php if( current_user_can('administrator') ) : ?>超级管理员<?php elseif( current_user_can('editor') ) : ?>网站编辑<?php elseif( current_user_can('yewu') ) : ?>网站业务员<?php elseif( current_user_can('kefu') ) : ?>网站客服<?php endif; ?>)</a></li>
         <?php if( in_array( '在线客服', get_field('kefu_qita') ) ){ ?><li class="menu-guide"><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=sc_opt_pg_a" target="main-frame">在线客服</a></li><?php } ?>
         <?php if( in_array( '聊天记录', get_field('kefu_qita') ) ){ ?><li class="menu-guide"><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=sc_chat_m_chat_logs" target="main-frame">聊天记录</a></li><?php } ?>
         <?php if( in_array( '操作教程', get_field('kefu_qita') ) ){ ?><li class="menu-guide"><a style="color:#FFD200;" href="http://www.gd-shop.cn/jc" target="_blank">操作教程</a></li><?php } ?>
         <li class="menu-browse"><a target="_blank" href="<?php echo home_url(); ?>/">访问网站</a></li>
         <li class="menu-promote"><a href="<?php echo home_url(); ?>/logout?_wpnonce=a3f9f14d95"  target="main-frame">安全退出</a></li>
      </ul>
   </div>
</div>

<!-- aside -->
<div class="admin-side">
   <ul class="side-nav">
   <li class="current">
         <a href="javascript:"><span class="ico-box"><i class="ico-pc"></i><b class="ico-bg-red"></b></span>仪 表 盘</a>
	      <ul class="sub-menu">
            <?php if( in_array( '最新订单', get_field('kefu_ybp') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Completed&by=dd" target="main-frame">最新订单</a></li><?php } ?>
            <?php if( in_array( '最新注册', get_field('kefu_ybp') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/users.php?orderby=registered&order=desc" target="main-frame">最新注册</a></li><?php } ?>
            <?php if( in_array( '最新产品', get_field('kefu_ybp') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit.php" target="main-frame">最新产品</a></li><?php } ?>
            <?php if( in_array( '客户询盘', get_field('kefu_ybp') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=CF7DBPluginSubmissions" target="main-frame">客户询盘</a></li><?php } ?>
         </ul>         
      </li>
   
	 <li>
         <a href="#"><span class="ico-box"><i class="ico-pc"></i><b class="ico-bg-blue"></b></span>网站管理</a>
	      <ul class="sub-menu">
		    <?php if( in_array( '系统设置', get_field('kefu_wzgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general-email.php" target="main-frame">系统设置</a></li><?php } ?>
            <?php if( in_array( '网站形象', get_field('kefu_wzgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post.php?post=1251&action=edit" target="main-frame">网站形象</a></li><?php } ?>
            <?php if( in_array( '网站标题', get_field('kefu_wzgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=all-in-one-seo-pack/aioseop_class.php" target="main-frame">网站标题</a></li><?php } ?>
  		  </ul>         
      </li>

      <li>
         <a href="#"><span class="ico-box"><i class="ico-site-map"></i><b class="ico-bg-cyan"></b></span>商城管理</a>
         <ul class="sub-menu">
            <?php if( in_array( '基础设置', get_field('kefu_scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=eshop-settings.php" target="main-frame">基础设置</a></li><?php } ?>
            <?php if( in_array( '支付通道', get_field('kefu_scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=eshop-settings.php&mstatus=Merchant" target="main-frame">支付通道</a></li><?php } ?>
            <?php if( in_array( '运费设置', get_field('kefu_scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-shipping.php" target="main-frame">运费设置</a></li><?php } ?>
            <?php if( in_array( '税率设置', get_field('kefu_scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=eshop-settings.php&mstatus=Tax" target="main-frame">税率设置</a></li><?php } ?>
            <?php if( in_array( '汇率设置', get_field('kefu_scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=t9_eshop_currency" target="main-frame">汇率设置</a></li><?php } ?>
            <?php if( in_array( '折扣设置', get_field('kefu_scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=eshop-settings.php&mstatus=Discounts" target="main-frame">折扣设置</a></li><?php } ?>
            <?php if( in_array( '优惠券', get_field('kefu_scgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-discount-codes.php" target="main-frame">优惠券</a></li><?php } ?>
         </ul>         
      </li>
	  
	        <li><a href="#"><span class="ico-box"><i class="ico-product"></i><b class="ico-bg-yellow"></b></span>产品管理</a>
         <ul class="sub-menu">
            <?php if( in_array( '产品发布', get_field('kefu_cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post-new.php" target="main-frame">产品发布</a></li><?php } ?>
            <?php if( in_array( '产品列表', get_field('kefu_cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit.php" target="main-frame">产品列表</a></li><?php } ?>
            <?php if( in_array( '产品分类', get_field('kefu_cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit-tags.php?taxonomy=category" target="main-frame">产品分类</a></li><?php } ?>
            <?php if( in_array( '产品通用参数', get_field('kefu_cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-options.php" target="main-frame">产品通用参数</a></li><?php } ?>
			<?php if( in_array( '产品过滤筛选', get_field('kefu_cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/themes.php?page=functions.php" target="main-frame">产品过滤筛选</a></li><?php } ?>
            <?php if( in_array( '产品批量管理', get_field('kefu_cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-products.php&eshopall=yes" target="main-frame">产品批量管理</a></li><?php } ?>
            <?php if( in_array( '产品统一说明', get_field('kefu_cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post.php?post=1301&action=edit" target="main-frame">产品统一说明</a></li><?php } ?>
            <?php if( in_array( '产品批量导入', get_field('kefu_cpgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=t9_eshopimport" target="main-frame">产品批量导入</a></li><?php } ?>
            <!--<li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-base.php" target="main-frame">Google Shopping</a></li>-->
         </ul>         
      </li>

	  
	  
	  <li>	  <a href="#"><span class="ico-box"><i class="ico-user"></i><b class="ico-bg-red"></b></span>用户管理</a>

	     <ul class="sub-menu">
            <?php if( in_array( '用户管理', get_field('kefu_yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/users.php?orderby=registered&order=desc" target="main-frame">用户管理</a></li><?php } ?>
            <?php if( in_array( '用户权限', get_field('kefu_yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post.php?post=46560&action=edit" target="main-frame">用户权限</a></li><?php } ?>
            <?php if( in_array( '邮件用户', get_field('kefu_yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=mailusers-user-settings" target="main-frame">邮件用户</a></li><?php } ?>
            <?php if( in_array( '邮件群发', get_field('kefu_yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=mailusers-send-to-group-page" target="main-frame">邮件群发</a></li><?php } ?>
            <?php if( in_array( '邮件单发', get_field('kefu_yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=mailusers-send-to-user-page " target="main-frame">邮件单发</a></li><?php } ?>
            <?php if( in_array( '邮件模版', get_field('kefu_yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-templates.php&eshoptemplate=2" target="main-frame">自动邮件模版</a></li><?php } ?>
            <?php if( in_array( '邮箱SMTP设置', get_field('kefu_yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=wp-mail-smtp/wp_mail_smtp.php " target="main-frame">邮箱SMTP设置</a></li><?php } ?>
            <?php if( in_array( '第三方登录设置', get_field('kefu_yhgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=wordpress-social-login" target="main-frame">第三方登录设置</a></li><?php } ?>
        </ul>         
      </li>
      <?php if( in_array( '订单管理', get_field('kefu_ddgl') ) ){ ?><li>
	  <a href="#"><span class="ico-box"><i class="ico-google-tool"></i><b class="ico-bg-orange"></b></span>订单管理</a>
	     <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Pending&by=dd" target="main-frame">未付款</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Waiting&by=dd" target="main-frame">等待付款</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Failed&by=dd" target="main-frame">付款失败</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Completed&by=dd" target="main-frame">成功订单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Sent&by=dd" target="main-frame">已发货</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Deleted&by=dd" target="main-frame">回收站</a></li>
         </ul>         
      </li><?php } ?>
	  
      <li><a href="#"><span class="ico-box"><i class="ico-site-map"></i><b class="ico-bg-green-2"></b></span>页面管理</a>
	     <ul class="sub-menu">
            <?php if( in_array( '新建页面', get_field('kefu_ymgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post-new.php?post_type=help" target="main-frame">新建页面</a></li><?php } ?>
            <?php if( in_array( '页面管理', get_field('kefu_ymgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=help" target="main-frame">页面管理</a></li><?php } ?>
         </ul>         
      </li>
	  
	  
      <li><a href="#"><span class="ico-box"><i class="ico-news"></i><b class="ico-bg-red"></b></span>博客管理</a>
	     <ul class="sub-menu">
            <?php if( in_array( '博客发布', get_field('kefu_bkgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/post-new.php?post_type=blog" target="main-frame">博客发布</a></li><?php } ?>
            <?php if( in_array( '博客列表', get_field('kefu_bkgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=blog" target="main-frame">博客列表</a></li><?php } ?>
            <?php if( in_array( '博客分类', get_field('kefu_bkgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit-tags.php?taxonomy=blog_catalog&post_type=blog" target="main-frame">博客分类</a></li><?php } ?>
         </ul>         
      </li>
	  <?php if( in_array( '网站导航', get_field('kefu_wzdh') ) ){ ?>
      <li><a href="#"><span class="ico-box"><i class="ico-site-map"></i><b class="ico-bg-blue"></b></span>网站导航</a>
	     <ul class="sub-menu">
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=31" target="main-frame">网站主导航</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=4" target="main-frame">导航 - 产品分类</a></li>			
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=219" target="main-frame">顶部 - 注册菜单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=70" target="main-frame">侧栏 - 帮助菜单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=187" target="main-frame">侧栏 - 用户菜单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=68" target="main-frame">侧栏 - 博客菜单</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=61" target="main-frame">底部 - Company Info</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=60" target="main-frame">底部 - Customer Service</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=305" target="main-frame">底部 - Payment & Shipping</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=306" target="main-frame">底部 - Company Policies</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php?menu=442" target="main-frame">底部 - 功能菜单</a></li>
         </ul>         
      </li><?php } ?>

	  
      <li><a href="#"><span class="ico-box"><i class="ico-product"></i><b class="ico-bg-yellow"></b></span>媒体管理</a>
         <ul class="sub-menu">
            <?php if( in_array( '媒体库', get_field('kefu_mtgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/upload.php" target="main-frame">媒体库</a></li><?php } ?>
            <?php if( in_array( '上传媒体', get_field('kefu_mtgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="main-frame">上传媒体</a></li><?php } ?>
            <?php if( in_array( '水印设置', get_field('kefu_mtgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=DX-Watermark" target="main-frame">水印设置</a></li><?php } ?>
            <?php if( in_array( '图片尺寸设置', get_field('kefu_mtgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/options-media.php" target="main-frame">图片尺寸设置</a></li><?php } ?>
            <?php if( in_array( '重新生成缩略图', get_field('kefu_mtgl') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/tools.php?page=regenerate-thumbnails" target="main-frame">重新生成缩略图</a></li><?php } ?>
			</ul>         
      </li>

      <li><a href="#"><span class="ico-box"><i class="ico-file"></i><b class="ico-bg-cyan"></b></span>附件管理</a>
	     <ul class="sub-menu">
            <?php if( in_array( '标签管理', get_field('kefu_qita') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit-tags.php?taxonomy=post_tag" target="main-frame">标签管理</a></li><?php } ?>
            <?php if( in_array( '评价管理', get_field('kefu_qita') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit-comments.php" target="main-frame">评价管理</a></li><?php } ?>
            <?php if( in_array( 'Skype客服', get_field('kefu_qita') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/edit.php?post_type=skype" target="main-frame">Skype客服</a></li><?php } ?>
            <?php if( in_array( '联系表单', get_field('kefu_qita') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=wpcf7&post=1045&action=edit" target="main-frame">联系表单</a></li><?php } ?>
            <?php if( in_array( '订阅表单', get_field('kefu_qita') ) ){ ?><li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=wpcf7&post=1046&action=edit" target="main-frame">订阅表单</a></li><?php } ?>
         </ul>         
      </li>
	  <?php if( in_array( 'SEO功能', get_field('kefu_qita') ) ){ ?>
      <li><a href="#"><span class="ico-box"><i class="ico-seo"></i><b class="ico-bg-orange"></b></span>SEO功能</a>
	     <ul class="sub-menu">
            <li><a href="http://webmaster.eoseo.cn/" target="main-frame">SEO站长工具 New!</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=iq-block-country/iq-block-country.php" target="main-frame">任意国家IP屏蔽</a></li>
            <li><a href="<?php echo home_url(); ?>/wp-admin/options-general.php?page=google-sitemap-generator/sitemap.php" target="main-frame">谷歌Sitemap地图</a></li>
            <li><a href="http://www.google.com/intl/zh-CN/webmasters/" target="main-frame">谷歌管理员工具</a></li>
            <li><a href="https://adwords.google.com/" target="main-frame">谷歌竞价广告</a></li>
            <li><a href="http://www.google.cn/intl/zh-CN_ALL/analytics/" target="main-frame">谷歌网站统计</a></li>
            <li><a href="http://translate.google.cn/" target="main-frame">谷歌翻译</a></li>
            <li><a href="http://www.google.com/trends/" target="main-frame">谷歌趋势</a></li>
            <li><a href="https://support.google.com/webmasters/answer/35843?hl=zh-Hans" target="main-frame">网站重审</a></li>
            <li><a href="https://www.google.com/webmasters/tools/disavow-links-main?pli=1" target="main-frame">外链屏蔽</a></li>
         </ul>         
      </li><?php } ?>

   </ul>
 <?php elseif( current_user_can('supplier') ) : ?>  <body><!-- header --><div class="admin-head">   <div class="admin-logo"><a href="http://www.GD-Shop.cn/"></a></div>   <div class="nav-bar">      <ul class="left-nav">         <li><i></i><b>显示所有语言版本内容</b></li>      </ul>      <ul class="left-nav">         <li><i></i><b>仅显示: English</b></li>      </ul>      <ul class="admin-nav">         <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=sc_opt_pg_a" target="main-frame">您好! <?php global $current_user; get_currentuserinfo(); echo $current_user->user_login;?> (<?php echo $current_user->user_nicename;?>)</a></li>         <?php if( in_array( '在线客服', get_field('kefu_qita') ) ){ ?><li class="menu-guide"><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=sc_opt_pg_a" target="main-frame">在线客服</a></li><?php } ?>         <?php if( in_array( '聊天记录', get_field('kefu_qita') ) ){ ?><li class="menu-guide"><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=sc_chat_m_chat_logs" target="main-frame">聊天记录</a></li><?php } ?>         <?php if( in_array( '操作教程', get_field('kefu_qita') ) ){ ?><li class="menu-guide"><a style="color:#FFD200;" href="http://www.gd-shop.cn/jc" target="_blank">操作教程</a></li><?php } ?>         <li class="menu-browse"><a target="_blank" href="<?php echo home_url(); ?>/">访问网站</a></li>         <li class="menu-promote"><a href="<?php echo home_url(); ?>/logout?_wpnonce=a3f9f14d95"  target="main-frame">安全退出</a></li>      </ul>   </div></div><!-- aside --><div class="admin-side">   <ul class="side-nav">	<li>	  <a href="#"><span class="ico-box"><i class="ico-google-tool"></i><b class="ico-bg-orange"></b></span>订单管理</a>	     <ul class="sub-menu">            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Pending&by=dd" target="main-frame">未付款</a></li>            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Waiting&by=dd" target="main-frame">等待付款</a></li>            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Failed&by=dd" target="main-frame">付款失败</a></li>            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Completed&by=dd" target="main-frame">成功订单</a></li>            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Sent&by=dd" target="main-frame">已发货</a></li>            <li><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Deleted&by=dd" target="main-frame">回收站</a></li>         </ul>               </li>     </ul>
<?php endif; ?>

 <div class="copyright">
      <p><em>GD-Shop</em> 外贸商城运营系统</p>
      <p><a target="_blank" href="http://www.GD-Shop.cn/">谷道科技 © 深度开发</a></p>
   </div>
</div>
<div class="path-bar">
   <ul> <?php if( current_user_can('supplier') ) : ?>   <li class="home">订单管理</li><li><i>/</i><span class="cur">成功订单</span></li> <?php else: ?>
      <li class="home"><a target="main-frame" href="<?php echo home_url(); ?>/wp-admin/index-ybp.php">仪 表 盘</a></li>
      <li><i>/</i><span class="cur"></span></li><?php endif; ?>
   </ul>
</div>

<div class="admin-wrap">
   <div class="frame-wrap">

      <?php if( current_user_can('supplier') ) : ?> <iframe class="main-frame" width="100%" scrolling="auto" height="auto" frameborder="false" allowtransparency="true" frameborder="0" style="border:0; height:100%; position:relative;overflow:hidden;overflow:auto;" src="<?php echo home_url(); ?>/wp-admin/admin.php?page=eshop-orders.php&action=Completed" name="main-frame"></iframe><?php else: ?>
      <iframe class="main-frame" width="100%" scrolling="auto" height="auto" frameborder="false" allowtransparency="true" frameborder="0" style="border:0; height:100%; position:relative;overflow:hidden;overflow:auto;" src="<?php echo home_url(); ?>/wp-admin/index-ybp.php" name="main-frame"></iframe><?php endif; ?>
   </div>
</div>


<script>
//左侧栏滚动条美化
$(".side-nav").niceScroll({  
	cursorcolor:"#3b4956",  
	cursoropacitymax:1,  
	touchbehavior:false,  
	cursorwidth:"4px",  
	cursorborder:"0",  
	cursorborderradius:"0"  
}); 
</script>
<script>
// ie6宽高自适应
(function($){
var winWidth = 0;
var winHeight = 0;
function findDimensions()
{
	if (window.innerWidth)
		winWidth = window.innerWidth;
	else if ((document.body) && (document.body.clientWidth))
		winWidth = document.body.clientWidth;
	if (window.innerHeight)
		winHeight = window.innerHeight;
	else if ((document.body) && (document.body.clientHeight))
		winHeight = document.body.clientHeight;
	if (document.documentElement  && document.documentElement.clientHeight && document.documentElement.clientWidth)
	{
        winHeight = document.documentElement.clientHeight;
        winWidth = document.documentElement.clientWidth;
	}
	$('.frame-wrap,.main-frame').height(winHeight-86)
	$('.admin-side').height(winHeight-50)
	$('.side-nav').height(winHeight-100)
}
findDimensions();
window.onresize=findDimensions;
$(window).resize(function(){
})
})(jQuery);
</script>


</body>
</html>