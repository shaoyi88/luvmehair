<?php
/**
 * General settings administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
require_once('./admin.php');

if ( ! current_user_can( 'manage_options' ) )
	wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );

$title = __('General Settings');
$parent_file = 'options-general.php';
/* translators: date and time format for exact current time, mainly about timezones, see http://php.net/date */
$timezone_format = _x('Y-m-d G:i:s', 'timezone date format');

/**
 * Display JavaScript on the page.
 *
 * @since 3.5.0
 */
function options_general_add_js() {
?>
<script type="text/javascript">
//<![CDATA[
	jQuery(document).ready(function($){
		$("input[name='date_format']").click(function(){
			if ( "date_format_custom_radio" != $(this).attr("id") )
				$("input[name='date_format_custom']").val( $(this).val() ).siblings('.example').text( $(this).siblings('span').text() );
		});
		$("input[name='date_format_custom']").focus(function(){
			$("#date_format_custom_radio").attr("checked", "checked");
		});

		$("input[name='time_format']").click(function(){
			if ( "time_format_custom_radio" != $(this).attr("id") )
				$("input[name='time_format_custom']").val( $(this).val() ).siblings('.example').text( $(this).siblings('span').text() );
		});
		$("input[name='time_format_custom']").focus(function(){
			$("#time_format_custom_radio").attr("checked", "checked");
		});
		$("input[name='date_format_custom'], input[name='time_format_custom']").change( function() {
			var format = $(this);
			format.siblings('.spinner').css('display', 'inline-block'); // show(); can't be used here
			$.post(ajaxurl, {
					action: 'date_format_custom' == format.attr('name') ? 'date_format' : 'time_format',
					date : format.val()
				}, function(d) { format.siblings('.spinner').hide(); format.siblings('.example').text(d); } );
		});
	});
//]]>
</script>
<?php
}
add_action('admin_head', 'options_general_add_js');
include('./admin-header.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>后台</title>
<link href="../admin/admin.css" rel="stylesheet">
<link rel='stylesheet' id='wp-slimstat-css'  href='/wp-content/plugins/wp-slimstat/admin/css/slimstat.css?ver=3.6.1' type='text/css' media='all' />
<script type='text/javascript' src='/wp-content/plugins/wp-slimstat/admin/js/jquery.flot.min.js?ver=0.7'></script>
<script type='text/javascript' src='/wp-content/plugins/wp-slimstat/admin/js/jquery.flot.navigate.min.js?ver=0.7'></script>
<script type='text/javascript' src='/wp-content/plugins/wp-slimstat/admin/js/slimstat_yestoday.admin.js?ver=1.0'></script>
<script type='text/javascript' src='/wp-content/plugins/wp-slimstat/admin/js/slimstat_morth.admin.js?ver=1.0'></script> 
<style type="text/css" title="">
#chart-placeholder_morth {
height: 175px;
margin: 10px 5px 0;
width: 98%;
}
#chart-legend_morth {
float: right;
font-size: .95em;
height: 20px;
margin-top: 5px;
overflow: hidden;
}
</style>
</head>
<body>
<?php
$post_num = count(query_posts(array( 'post_type' => 'post' )));
$article_num = count(query_posts(array( 'post_type' => 'article' )));
$blog_num = count(query_posts(array( 'post_type' => 'blog' )));
$wpcf7_contact = $wpdb->get_results("select submit_time from wp_cf7dbplugin_submits group by submit_time having count(submit_time) > 1");
$wpcf7_contact_form_num = count($wpcf7_contact);
?>
 
      <div class="admin-main">
         <div class="main-left">
            <ul class="info-items">
               <li class="info-item inquiry-info">
                  <span class="info-cont">
                     <i></i>
                     <strong class="tit">询盘合计：<?php echo $wpcf7_contact_form_num;?> 封</strong>
                     <span class="text"><a href="admin.php?page=CF7DBPluginSubmissions">点击查看详情</a></span>
                  </span>
               </li>
               <li class="info-item product-info">
                  <span class="info-cont">
                     <i></i>
                     <strong class="tit">产品数量：<?php echo $post_num;?> 个</strong>
                     <span class="text"><a href="edit.php">产品管理</a> | <a href="post-new.php">产品发布</a></span>
                  </span>
               </li>
            </ul>

<?php
//订单统计
$where_date = $a1 = $a2 = $a3 = $a4 ='';
if(isset($_GET['order_s'])){
	if($_GET['order_s']=='1'){
		//昨天
		$a1="cur";
        $where_date ='AND TO_DAYS( NOW( ) ) - TO_DAYS(`edited`) <= 1';
	}else if($_GET['order_s']=='7'){
		//近7日
		$a2="cur";
        $where_date ='AND TO_DAYS(NOW()) - TO_DAYS(`edited`) <= 7';
	}else if($_GET['order_s']=='30'){
		//近30日
		$a3="cur";
        $where_date ='AND TO_DAYS(NOW()) - TO_DAYS(`edited`) <= 30';
	}else if($_GET['order_s']=='last_month'){
		//上月
		$a4="cur";
       $where_date ='AND date(`edited`)<date(now()-86400*30)';
	}
}	

$dtable = $wpdb -> prefix . 'eshop_orders';
$itable = $wpdb -> prefix . 'eshop_order_items';
$myres = $wpdb -> get_results("SELECT COUNT( id ) as amt, status FROM $dtable WHERE id >0 $where_date GROUP BY status");

foreach ($myres as $row) {
	$status = $row -> status;
	$counted[$row -> status] = $row -> amt;
	$counted['total']+=$row -> amt;	
	$myrowres[$row -> status] = $wpdb -> get_results("Select * From $dtable where status='$status' $where_date"); 
}
 
$row = array();
foreach ($myres as $row) {
	foreach ($myrowres[$row -> status] as $myrow) {
		$checkid = $myrow -> checkid;
		$itemrowres =$itemrow = array();
		$itemrowres = $wpdb -> get_results("Select * From $itable where checkid='$checkid' AND post_id!='0'");
		$total = 0;
		$x = 0;
		foreach($itemrowres as $itemrow) {
			$value = $itemrow -> item_qty * $itemrow -> item_amt;
				if ($itemrow -> tax_amt !== '' && is_numeric($itemrow -> tax_amt))
					$value = $value + $itemrow -> tax_amt;
					$total = $total + $value;
					$x++;
			}
		$sub_total[$row -> status]=$total;
        //tax
		$itemrowres =$itemrow = array();
		$itemrowres = $wpdb -> get_results("Select * From $itable where checkid='$checkid' AND post_id='0'");
		$total = 0;
		$x = 0;
		foreach($itemrowres as $itemrow) {
			$value = $itemrow -> item_qty * $itemrow -> item_amt;
				if ($itemrow -> tax_amt !== '' && is_numeric($itemrow -> tax_amt))
					$value = $value + $itemrow -> tax_amt;
					$total = $total + $value;
					$x++;
			}
		$tax_total[$row -> status]=$total;
		//total
		$itemrowres =$itemrow = array();
		$itemrowres = $wpdb -> get_results("Select * From $itable where checkid='$checkid'");
		$total = 0;
		$x = 0;
		foreach($itemrowres as $itemrow) {
			$value = $itemrow -> item_qty * $itemrow -> item_amt;
				if ($itemrow -> tax_amt !== '' && is_numeric($itemrow -> tax_amt))
					$value = $value + $itemrow -> tax_amt;
					$total = $total + $value;
					$x++;
			}
		$all_total[$row -> status]=$total;
	}	
}
 
?>
<style type="text/css" title="">
	.tbar h2>span a{font-size:11px;font-weight: 100}
	.tbar h2>span a.cur{font-weight: 700}
</style>
			<div class="mbox mbox-mar-15 show-cont" style="height: 300px;margin-top:15px;">
               <div class="tbar">
                  <h2>订单统计<span>(<a class="<?php echo $a1;?>" href="?order_s=1">昨日</a>-<a class="<?php echo $a2;?>" href="?order_s=7">近7日</a>-<a class="<?php echo $a3;?>" href="?order_s=30">近30日</a>-<a class="<?php echo $a4;?>" href="?order_s=last_month">上月</a>)</span></h2>
               </div>
               <div class="cont" style="display:block;">
                   <table class="hidealllabels widefat">
						<thead>
							<tr>
								<th id="line" title="reference number">
									Order Type
								</th>
								<th id="date">
									#Orders
								</th>
								<th id="customer">
									Sub Total
								</th>
								<th id="items">
									Sales Tax
								</th>
								<th id="price">
									Total
								</th>								 
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>
									进程中
								</th>
								<td headers="date numb1">
									<?php echo $counted['Pending'];?>
								</td>
								<td headers="customer numb1">
									<?php echo $sub_total['Pending'];?>
								</td>
								<td headers="items numb1">
									<?php echo $tax_total['Pending'];?>
								</td>
								<td headers="price numb1" class="right">
									<?php echo $all_total['Pending'];?>
								</td>																 
							</tr>

							<tr>
								<th>
									等待付款
								</th>
								<td headers="date numb1">
									<?php echo $counted['Waiting'];?>
								</td>
								<td headers="customer numb1">
									<?php echo $sub_total['Waiting'];?>
								</td>
								<td headers="items numb1">
									<?php echo $tax_total['Waiting'];?>
								</td>
								<td headers="price numb1" class="right">
									<?php echo $all_total['Waiting'];?>
								</td>																 
							</tr>

							<tr>
								<th>
									成功订单
								</th>
								<td headers="date numb1">
									<?php echo $counted['Sent'];?>
								</td>
								<td headers="customer numb1">
									<?php echo $sub_total['Sent'];?>
								</td>
								<td headers="items numb1">
									<?php echo $tax_total['Sent'];?>
								</td>
								<td headers="price numb1" class="right">
									<?php echo $all_total['Sent'];?>
								</td>																 
							</tr>

							<tr>
								<th>
									已发货订单
								</th>
								<td headers="date numb1">
									<?php echo $counted['Completed'];?>
								</td>
								<td headers="customer numb1">
									<?php echo $sub_total['Completed'];?>
								</td>
								<td headers="items numb1">
									<?php echo $tax_total['Completed'];?>
								</td>
								<td headers="price numb1" class="right">
									<?php echo $all_total['Completed'];?>
								</td>																 
							</tr>

							<tr>
								<th>
									共计
								</th>
								<td headers="date numb1">
									<?php echo $counted['Pending']+$counted['Waiting']+$counted['Sent']+$counted['Completed'];?>
								</td>
								<td headers="customer numb1">
									<?php echo $sub_total['Pending']+$sub_total['Waiting']+$sub_total['Sent']+$sub_total['Completed'];?>
								</td>
								<td headers="items numb1">
									<?php echo $tax_total['Pending']+$tax_total['Waiting']+$tax_total['Sent']+$tax_total['Completed'];?>
								</td>
								<td headers="price numb1" class="right">
									<?php echo $all_total['Pending']+$all_total['Waiting']+$all_total['Sent']+$all_total['Completed'];?>
								</td>																 
							</tr>
							 
						</tbody>
					</table>

               </div>
            </div>

         </div>
         
         <div class="main-right">
            <ul class="info-items">
               <li class="info-item view-info">
                  <span class="info-cont">
                     <i></i>
                     <strong class="tit">博客数量：<?php echo $blog_num;?> 个</strong>
                     <span class="text"><a href="edit.php?post_type=blog">博客管理</a> | <a href="post-new.php?post_type=blog">博客发布</a></span>
                  </span>
               </li>
               <li class="info-item news-info">
                  <span class="info-cont">
                     <i></i>
                     <strong class="tit">云内容数量：<?php echo $article_num;?> 篇</strong>
                     <span class="text"><a href="edit.php?post_type=article">内容查看</a> | <a href="post-new.php?post_type=article">内容发布</a></span>
                  </span>
               </li>
            </ul>

<!--热销产品-->
<?php
$myres =array();
$offset=5;
if(isset($_GET['hot_num'])){
	if($_GET['hot_num']=='10'){
		$b1="cur";
        $offset=10;
	}else if($_GET['hot_num']=='50'){
		$b2="cur";
        $offset=50;
	}else if($_GET['hot_num']=='100'){
		$b3="cur";
		$offset=100;
	}
}
$myres = $wpdb -> get_results("SELECT *,COUNT( post_id ) as count FROM $itable WHERE post_id >0 GROUP BY post_id ORDER BY count(post_id) DESC limit 0,$offset");
?>
<div class="mbox mbox-mar-15 show-cont" style="height: auto;margin-top:15px;">
               <div class="tbar">
                  <h2>热销产品<span>显示数量(<a class="<?php echo $b1;?>" href="?hot_num=10">Top10</a>-<a class="<?php echo $b2;?>" href="?hot_num=50">Top50</a>-<a class="<?php echo $b3;?>" href="?hot_num=100">Top100</a>)</span></h2>
               </div>
               <div class="cont" style="display:block;">
                   <table class="hidealllabels widefat">
						<thead>
							<tr>
								<th id="line" title="reference number">
									Product
								</th>
								<th id="date">
									Purchases
								</th>							 							 
							</tr>
						</thead>
						<tbody>
<?php foreach($myres as $val){?>							
							<tr>
								<td>
									<?php echo $val->optname;?>
								</td>
								<td headers="date numb1">
									<?php echo $val->count;?>
								</td>								 															 
							</tr>
<?php }?>
							 
						</tbody>
					</table>

               </div>
            </div>
         </div>
		      <iframe  width="100%" scrolling="no" height="230px" frameborder="false" allowtransparency="true" frameborder="0" style="padding:20px 0 0 0 ;border:0; height:230px; position:relative;overflow:hidden;overflow:auto;" src="http://yun.goodao.cn/newsjs" ></iframe>
      </div>
 
<script>
(function($){
$(document).ready(function(){
	//打开关闭
	$('.mbox .ico-show-more,.mbox .ico-arrow').click(function(){
	   var objCont=$(this).parents('.mbox').find('.cont')
	   var objMain=$(this).parents('.mbox')
	   if($(this).parents('.mbox').hasClass('show-cont')){
		  objMain.removeClass('show-cont')
          objCont.slideUp(200)			   
	   }
	   else{
		  objMain.addClass('show-cont')
          objCont.slideDown(200)
	   }
	})
	
	//删除
	$('.mbox .ico-del').click(function(){
	  $(this).parents('.mbox').hide()
	})
})
})(jQuery);
</script>  
</body>
</html>

<div class="wrap">
<?php include('./admin-footer.php') ?>