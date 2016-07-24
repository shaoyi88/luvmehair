#DW License Manager

## 插件简介

基于WordPress 的一个用于商业WordPress 收费主题或插件的在线域名授权管理插件，可用于实际项目中。

本插件为收费插件，请购买用户尊重劳动成果，勿泄露。

## 使用方法

插件目录下的 Example-theme 为例子主题，里面的代码可参考集成到您的主题或插件中。

安装插件后激活，通过自定义的license 文章类型输入产品id、域名，保存两次即可。

实际项目中，主题安装后通过发送类似下面的链接访问授权服务器：

http://domain.com/?client_domain=xxxxxxx&client_product_id=xxxxx&client_token=xxxxxx

服务器根据请求的数据返回json 格式的数据，主题端即可根据结果保留授权信息到数据库中，并定时重新验证授权。


##更新历史

### 14-10-29 初步改版成功

### 14-10-28 初步改版成功

### 14-10-10 改版的初版，问题多多