<?php

get_header();

$product = get_post_meta($post->ID, '_eshop_product');

$pid = $post->ID;

$post->saleprice = get_currency_price($product[0][products][1][saleprice]);

$post->price = get_currency_price($product[0][products][1][price]);

$eshop_combination_sale_ids = get_post_meta($post->ID, '_eshop_combination_sale_ids', true);

$eshop_whs_data = maybe_unserialize(get_post_meta($post->ID, '_eshop_whs', true));

$eshop_rolesprice_data = maybe_unserialize(get_post_meta($post->ID, '_eshop_rolesprice', true));

$stkav = get_post_meta($post->ID, '_eshop_stock', true);

$post->option = $product[0][products][1][option];

?>

<script type="text/javascript">

var relate_json = new Array();

</script>	<section class="layout">

 <nav class="path-bar">

          <ul class="path-nav">

             <h2>You are here: </h2>

         <li><?php 

if (function_exists('cmp_breadcrumbs')) {

    cmp_breadcrumbs();

}

?>

</li>            

          </ul>

       </nav>

       <section class="detail-wrap">

          <!-- product info -->

          <section class="product-intro">

             <div class="product-view">

            <div class="product-img jqzoom">

<?php 

$images = get_field('product_gallery');

if ($images) {

    for ($x = 0; $x < 1; $x++) {

        ?>

<img id="bigImg" style="cursor:pointer" src="<?php 

        echo $images[0]['url'];

        ?>

" jqimg="<?php 

        echo $images[0]['url'];

        ?>

" alt="<?php 

        wp_title();

        ?>

" />

<?php 

    }

}

?>

            </div>

                    <!-- small img -->

                    <div class="small-img-wrap">

                        <a href="javascript:" class="small-btn-prev"><b></b></a>

                        <div class="small-img-scroll">

                                        <ul>

<?php 

$images = get_field('product_gallery');

if ($images) {

    foreach ($images as $image) {

        ?>

                <li>

                <a class="small-img-item" href="javascript:" target="_self">

                   <img src="<?php 

        echo $image['sizes']['thumbnail'];

        ?>

" src_big="<?php 

        echo $image['url'];

        ?>

" src_mid="<?php 

        echo $image['url'];

        ?>

">

                </a>

                </li>

<?php 

    }

}

?>

                </ul>

                        </div>

                        <a href="javascript:" class="small-btn-next"><b></b></a>

                     </div>

                    <!--// small img end -->   

<?php 

if (get_field('youtube_title')) {

    ?>

                <div class="pick-method">

                    	<h2 class="title"><?php 

    the_field('youtube_title');

    ?>

</h2>

                        <div class="pick-method-detail">

                        	<p>

                            	<?php 

    the_field('youtube_code');

    ?>

                            </p>

                        </div>

                    </div> 

<?php 

}

?>

					

              </div>

             <section class="product-summary">

            <h1 class="product-title"><?php 

wp_title();

?>

</h1>

            <div class="product-meta">

               <span class="product-id">SKU: <?php 

echo $post->option;

?>

 - <?php 

if ($stkav < '1') {

    ?>

<span>Out of Stock</span><?php 

} else {

    ?>

<span>In Stock</span><?php 

}

?>

</span> - <?php 

if (get_field('yes_reviews')) {

    ?>

<div class="review-wrap" ><?php 

    if (function_exists('the_ratings')) {

        echo expand_ratings_template('<span>%RATINGS_IMAGES%</span>', get_the_ID());

    }

    ?>

 <span> Reviews(<?php 

    echo Reviews_num();

    ?>

)</span></div><?php 

}

?>

 - <?php 

if (is_user_logged_in()) {

    wpfp_link();

} else {

    ?>

<a class="add-to-wishlist" href="<?php 

    echo home_url();

    ?>

/register" title="Please Register" rel="nofollow">Login to Add Wishlist</a></li>

<?php 

}

?>

            </div>

            <div class="price-bar">

               <div class="price-info">

                  <?php 

if (get_field('yes_price')) {

    ?>

<span class="old-price"><?php 

    echo get_currency_symbol();

    ?>

<i class="sys_item_mktprice"><?php 

    echo number_format($post->price, 2);

    ?>

</i></span><?php 

}

?>

                  <span class="special-price"><?php 

echo get_currency_symbol();

?>

<i class="sys_item_price"><?php 

echo number_format($post->saleprice, 2);

?>

</i></span>

                 <?php 

if (get_field('yes_price')) {

    ?>

<span class="discount">(<b></b><i>%</i> <em>off</em>)</span><?php 

}

?>

				 

				 <?php 

if (is_user_logged_in()) {

    foreach ($eshop_rolesprice_data as $rolesprice) {

        if ($rolesprice['user_roles'] == $current_user->roles[0]) {

            ?>

				 <p style="color:red"><?php 

            echo $rolesprice['user_roles'];

            ?>

 Customer,Will Get <b style="color:blue"><?php 

            echo get_currency_symbol();

            ?>

 <?php 

            echo number_format(get_currency_price($rolesprice['price']), 2);

            ?>

</b> again when you add to your cart</p>

				 <?php 

        }

    }

}

?>

               </div>

			  <?php 

if (is_array($eshop_whs_data)) {

    ?>

			   <div class="wholesale-info">			   

			   <div id="" class="wholesale-title">

				Wholesale Price:

			   </div>

			   <div id="" class="wholesale-price-info">

				    <table border="1" bordercolor="#ccc" style="border-collapse:collapse;">

						<tr>

							<th width="60">Qty</th>	<th width="60">Price</th>

						</tr>

						<?php 

    foreach ($eshop_whs_data as $v) {

        ?>

						<tr>

							<td align="center"><?php 

        echo $v['qty_start'];

        ?>

-<?php 

        echo $v['qty_end'];

        ?>

</td>	<td><?php 

        echo get_currency_symbol();

        echo number_format($post->saleprice + $v['price'], 2);

        ?>

</td>

						</tr>

						<?php 

    }

    ?>

				    </table>

			   </div>

			   </div>

			   <?php 

}

?>

               <?php 

if (get_field('yes_djs')) {

    ?>

<div class="goods-time-count">

               <p><em class="day"></em> day <span class="hour"></span>:<span class="minute"></span>:<span class="second"></span></p>

               </div><?php 

}

?>

            </div>

               <?php 

if ($stkav < '1') {

    ?>

<div class="clear"></div><br /><span style="font-weight:bold;color:red;font-size:16px;">Out of Stock</span>

<?php 

} else {

    ?>

	<section class="product-shop">

<script>

$(document).ready(function(){

$('form.addtocart').appendTo('.product-shop')

})

</script>

            </section><?php 

}

?>

			<hr>

<?php 

query_posts(array('post_type' => 'productitems', 'showposts' => 1, 'orderby' => 'post_date', 'order' => 'DESC'));

while (have_posts()) {

    the_post();

    the_field('add_cart_info');

    ?>

			<hr>

<?php 

}

wp_reset_query();

?>

                <section class="product-detail">

                 <div class="detail-tabs">

                    <h2 class="current">Product Detail</h2>

                    <h2>Products Tags</h2>

                 </div>

                 <section class="entry detail-panel">

<?php 

while (have_posts()) {

    the_post();

    the_content();

    ?>

 

<?php 

}

?>

<div class="clear"></div>

                 </section>

                 <section class="entry detail-panel disabled"><?php 

the_tags();

?>

</section>

              </section>

             </section>

             <div class="clear"></div>

                <section class="product-desc">

                 <div class="product-desc-tabs">

                    <h2 class="current">Product Details</h2>

                    <h2>Feedback(<?php echo Reviews_num();?>)</h2>

                    <h2>Shipment & Payment</h2>

                    <h2>Seller Guarantees</h2>

                    <h2>About Luvme Hair</h2>
                 </div>

                 <section class="product-desc-panel">
                  <section class="product-detail-pic">

                              	<section class="layout">

                 				<?php

                 the_field('products_detail_text');

                 ?>





                 <?php

                 if (get_field('yes_products_img')) {

                     ?>

                 <hr>

                 <div class="products-img entry">

                 <?php

                     $images = get_field('product_gallery');

                     if ($images) {

                         ?>

                         <?php

                         foreach ($images as $image) {

                             ?>

                 		<img src="<?php

                             echo $image['url'];

                             ?>

                 " alt="<?php

                             echo $image['alt'];

                             ?>

                 "><br />

                         <?php

                         }

                     }

                     ?>

                 </div>

                 <?php

                 }

                 ?>

                              	</section>



                              </section>
                 </section>

                 <section class="product-desc-panel disabled">
                  <section class="product-slides-wrap">

                         <section class="layout">


                 		  	  <section class="product-detail">

                 	           <div class="detail-tbar">

                             <h2 class="current">Reviews<?php

                 if (get_field('yes_reviews')) {

                     ?>

                 (<?php

                     echo Reviews_num();

                     ?>

                 )<?php

                 }

                 ?>

                 </h2>

                          </div>

                 	   <!-- comment -->

                       <section class="comment-form">

                         <?php

                 comments_template();

                 ?>

                       </section>

                 <!--// comment -->
                 <div class="mobile-pd-pic">
                              	<ul>
                                 	<li><img src="template/img/demo/vedio01.jpg" alt=""></li>
                                     <li><img src="template/img/demo/vedio01.jpg" alt=""></li>
                                     <li><img src="template/img/demo/vedio01.jpg" alt=""></li>
                                     <li><img src="template/img/demo/vedio01.jpg" alt=""></li>
                                 </ul>
                              </div>

                 	  </section>



                         </section>

                     </section>
                 </section>

                  <section class="product-desc-panel disabled">
<div style="margin: 20px 0;">
<h2>Shipment Options:</h2>
<p>1. FedEx / DHL / Nigeria Lagos Express</p>
<p>2. We will choose the Fastest & Best shipment worldwide for you!</p>
<div style="margin-top:20px"></div>
<h2>Delivery Time:</h2>
<p>2-3days to USA/CAN/AU via FedEx/DHL</p>
<p>3-5days to EUR via FedEx/DHL</p>
<p>4-6days to Africa via FedEx/DHL</p>
<p>2-4days to Nigeria via Nigeria Lagos Express</p>
<div style="margin-top:20px"></div>
<h2>Shipping Fee:</h2>
<p>1. All order is free shipping</p>
<p>2. Remote area/country will have $20 fee</p>
<div style="margin-top:20px"></div>
<h2>Shipment Notice:</h2>
<p>1. Your delivery address needs to keep consistent with Paypal address.If not ,we will ship out goods according to PayPal address. Or we will contact you to get your definite address.</p>
<p>2. If you have any other special requirements, please contact us so we can send out your goods as soon as possible.</p>
<div style="margin-top:20px"></div>
<h2>Payment Methods:</h2>
<p>1.PayPal ( our PayPal account: hellena780@live.cn )</p>
<p>2.Credit Card through PayPal</p>
<div style="margin-top:20px"></div>
<h2>Payment Notice:</h2>
<p>1. With PayPal, you can send payment quickly and securely online.</p>
<p>2. Through PayPal, you can pay with credit card, debit card, or bank account balance.</p>
<p>3. Once your order is submitted, you will be redirected to PayPal’s site where you could make the payment.</p>
<p>4. You needn’t pay any PayPal fee, and we will bear these costs.</p>
</div>
                   </section>

                   <section class="product-desc-panel disabled">
<div style="margin: 20px 0;">
<h2>Return Policy：</h2>
<p>1. 7 Days Full Refund: after receive the hair, within 7 days, full refund for no reason.</p>
<p>2. 6 Months Quality Guarantee: if any quality problems within 6 months, we can solve it for you.</p>
<div style="margin-top:20px"></div>
<h2>Seller Service:</h2>
<p>On-time Delivery: we promise to ship out the goods within 3 days. No matter which country you are, you will be able to get the hair within 7 days after place order.</p>
</div>
                   </section>
<section class="product-desc-panel disabled">
<div style="margin: 20px 0;">
<p style="text-align: left;"><em><span style="color: #ffffff; font-family: arial, helvetica, sans-serif; font-size: 24px; display: block; width: 100%; background: #333; padding-left: 20px; line-height: 40px;"> 100% Virgin Hair Certification </span></em></p><p> </p><p style="text-align: left;"><img style="width:100%" class="aligncenter size-full wp-image-1811" alt="5-Certification" src="http://www.luvmehair.com/uploads/5-Certification5.jpg" /></p><p> </p><p style="text-align: left;"><span style="font-size: 24px; font-family: arial, helvetica, sans-serif; color: #ffffff; display: block; width: 1000px; background: #333; padding-left: 20px; line-height: 40px;"> <em>Refund &amp; Return Policy</em> </span></p><p> </p><p style="text-align: left;"><img style="width:100%" class="aligncenter size-full wp-image-1786" alt="6-Return" src="http://www.luvmehair.com/uploads/return1.jpg" /></p><p> </p><p style="text-align: left;"><em><span style="color: #ffffff; font-size: 24px; font-family: arial, helvetica, sans-serif; display: block; width: 1000px; background: #333; padding-left: 20px; line-height: 40px;"> Customers' Voice </span></em></p><p> </p><p style="text-align: left;"><img style="width:100%" class="aligncenter size-full wp-image-1787" alt="7-Customers'-voice" src="http://www.luvmehair.com/uploads/7-Customers-voice3.jpg" /></p><p style="text-align: left;"><strong><em></em></strong><em><span style="color: #ffffff; font-size: 24px; font-family: arial, helvetica, sans-serif; display: block; width: 1000px; background: #333; padding-left: 20px; line-height: 40px;">Our Voice</span><br /> </em><em></em><strong><em></em></strong></p><p style="text-align: center;"><span style="font-family: 'comic sans ms', sans-serif;"><strong><em><span style="font-size: 20px;">the Letter to Buyer</span></em></strong></span></p><p style="text-align: left;"><span style="font-size: 18px; font-family: 'comic sans ms', sans-serif;"><em>Dear,</em></span></p><p style="text-align: left;"><span style="font-size: 18px; font-family: 'comic sans ms', sans-serif;"><em>Since many buyers in market complain the hair they bought can't last and they always have some very bad experiences </em></span><span style="font-size: 18px; font-family: 'comic sans ms', sans-serif;"><em>shopping </em></span><span style="font-size: 18px; font-family: 'comic sans ms', sans-serif;"><em>online,</em></span><span style="font-size: 18px; font-family: 'comic sans ms', sans-serif;"><em>They don't know how to buy good hair from so many chaotic hair sellers online.</em></span></p><p> </p><p style="text-align: left;"><span style="font-size: 18px; font-family: 'comic sans ms', sans-serif;"><em>Are you also been plagued by this trouble?</em></span></p><p> </p><p style="text-align: left;"><span style="font-size: 18px; font-family: 'comic sans ms', sans-serif;"><em>When the beauty of black women around world were so desire to be able to use the best hair longer time without worry, as the top hair brand has a mission that brings beauty and valuable service to customers around world, Luvme Hair was determined to research and develop a unique top quality virgin hair, and ensure that the top quality virgin hair can last many years.In the development process,the Co-founder Hellena and Beryl tried hundreds of ways to solve this problem. Finally,heaven pays off,they found the best material in the world and the most advanced technology to keep hair curl. Now we put our fingerprint here to help you recognize the original hair.</em></span></p><p> </p><p style="text-align: left;"><span style="font-size: 18px; font-family: 'comic sans ms', sans-serif;"><em>Most importantly, We are your consultant in terms of hair using&amp;caring more than a hair supplier! We promise the virgin hair can last one year at least.In addition,We will try our best to help you solve hair problems or return/refund. It's our responsibility to bring you a pleasant shopping experience!</em></span></p><p> </p><p style="text-align: left;"><span style="font-size: 18px; font-family: 'comic sans ms', sans-serif;"><em>Best Regards,</em></span></p><p style="text-align: left;"><span style="font-size: 18px; font-family: 'comic sans ms', sans-serif;"><em>Hellena</em></span></p><p> </p><p style="text-align: left;"><em><span style="color: #ffffff; font-size: 24px; font-family: arial, helvetica, sans-serif; display: block; width: 1000px; background: #333; padding-left: 20px; line-height: 40px;"> About Luvme Hair </span></em></p><p> </p><table style="width: 100%" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td style="padding: 20px;" width="50%"><p style="text-align: left; font-size: 18px;">Luvme Hair Products Co.,Ltd is located in Guangzhou China. As the top virgin hair supplier, Luvme Hair has its own hair factory in Xuchang city which is the biggest human hair production base. In the factory, the most experienced technical staffs are employed to operate the most advanced production technology of hair production. The hair quality problem was eliminated at the source.</p><p> </p><p style="text-align: left; font-size: 18px;">Luvme Hair has an excellent sales and after-sales team. The members do their best to provide customers with the best solution of purchasing &amp; using hair. Efficient and patience are their features.</p><p> </p><p style="text-align: left; font-size: 18px;">Luvme Hair supplies top virgin hair to customers around the world and has won the trust of customers and recognition. Honesty is the greatest tag of Luvme.</p></td><td width="40%"><img style="width:100%" class="alignleft size-full wp-image-2286" alt="choose best virgin hair (6)" src="http://www.luvmehair.com/uploads/9-About-Luvme-3.jpg" /></td></tr></tbody></table><p style="text-align: left;"><img style="width:100%" class="aligncenter size-full wp-image-1788" alt="9-About-Luvme" src="http://www.luvmehair.com/uploads/9-About-Luvme-2.jpg" /></p><p> </p>
<p style="text-align: left;"><span style="font-size: 24px; background-color: #333333;"><strong></strong><span style="color: #ffffff;"><em><span style="font-family: arial, helvetica, sans-serif; display: block; width: 1000px; background: #333; padding-left: 20px; line-height: 40px;">Kindly Reminder</span></em></span></span></p>
<h2><span style="color: #c0c; font-size: 36px;">99%</span> <span style="font-size: 24px;">of People Regret Not Seeing These Facts Before They Bought Hair!</span></h2>
<p style="font-size: 20px; font-weight: bold; text-align: left;">Compared with other Chinese sellers:</p>
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0" align="left">
  <tbody>
    <tr>
      <td width="50%"><img style="width:100%" class="alignleft size-full wp-image-2281" alt="choose best virgin hair (1)" src="http://www.luvmehair.com/uploads/choose-luvme-virgin-hair-11.jpg" /></td>
      <td style="padding: 20px; background: #f1f1f1;" width="40%"><p style="text-align: left; font-size: 40px; margin: 0px;">Fact 1: <span style="color: #c0c; font-size: 40px;">Clean?</span></p>
        <p style="text-align: left; font-size: 14px;">In order to seize the market at lower price, most of cheap hair sellers sell more and more bad hair. In Fact., you will find the "cheap hair" has a worse quality beyond your imagination after used. Not only that,terrible collection of raw materials and producing process will make you unexpected! Luvme Hair refuses to the price war,and just use a reasonable price to ensure hair high quality.</p></td>
    </tr>
  </tbody>
</table>
<p> </p>
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
    <tr>
      <td width="50%"><img style="width:100%" class="alignleft size-full wp-image-2282" alt="choose best virgin hair (2)" src="http://www.luvmehair.com/uploads/choose-luvme-virgin-hair-21.jpg" /></td>
      <td style="padding: 20px; background: #f1f1f1;" width="40%"><p style="text-align: left; font-size: 40px; margin: 0px;">Fact 2: <span style="color: #c0c; font-size: 40px;">Healthy?</span></p>
        <p style="text-align: left; font-size: 14px;">It's not only dirty in a worse process of "cheap hair", more importantly,but it is also a huge threat to users' health! In order to reduce processing cost, they ignore residual chemicals of processing. However, as a customer-centric brand,we never make a evil profit at the cost of users' health.</p></td>
    </tr>
  </tbody>
</table>
<p> </p>
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
    <tr>
      <td width="50%"><img style="width:100%" class="alignleft size-full wp-image-2283" alt="choose best virgin hair (3)" src="http://www.luvmehair.com/uploads/choose-luvme-virgin-hair-31.jpg" /></td>
      <td style="padding: 20px; background: #f1f1f1;" width="40%"><p style="text-align: left; font-size: 40px; margin: 0px;">Fact 3: <span style="color: #c0c; font-size: 40px;">Risk?</span></p>
        <p style="text-align: left; font-size: 14px;">we are confident of all aspects of our products,so we can provide a full guarantees service.The service makes sure you can have a risk-free shopping and use hair without worry.</p></td>
    </tr>
  </tbody>
</table>
<p> </p>
<p style="font-size: 20px; font-weight: bold; text-align: left;">Compared with the so-called "Big Brand":</p>
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
    <tr>
      <td style="padding: 20px; background: #f1f1f1;" width="40%"><p style="text-align: left; font-size: 40px; margin: 0px;">Fact 4: <span style="color: #c0c; font-size: 40px;">Cost-Effective?</span></p>
        <p style="text-align: left; font-size: 14px;">After careful and extensive research,we can find that almost all suppliers of so-called "global brand" are from China, and these hair material isn't actually the best quality. However, their prices are far too high, these hair doesn't have a good cost performance at all. Luvme Hair has the best quality and the reasonable price, so you can always get high cost-effective hair.</p></td>
      <td width="50%"><img style="width:100%" class="alignleft size-full wp-image-2285" alt="choose best virgin hair (5)" src="http://www.luvmehair.com/uploads/choose-luvme-virgin-hair-51.jpg" /></td>
    </tr>
  </tbody>
</table>
<p> </p>
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
    <tr>
      <td style="padding: 20px; background: #f1f1f1;" width="40%"><p style="text-align: left; font-size: 40px; margin: 0px;">Fact 5: <span style="color: #c0c; font-size: 40px;">Buy What?</span></p>
        <p style="text-align: left; font-size: 14px;">Different from these brands' strategy that they spend the major money on advertising and promotion, our major money is spent on three aspects(Screening of raw material, Quality Control and After-sales service). Just a advice: Don't spend your hard-earned money on a so-called "Brand" !</p></td>
      <td width="50%"><img style="width:100%" class="alignleft size-full wp-image-2284" alt="choose best virgin hair (4)" src="http://www.luvmehair.com/uploads/choose-luvme-virgin-hair-41.jpg" /></td>
    </tr>
  </tbody>
</table>
<p> </p>
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0" align="center">
  <tbody>
    <tr>
      <td style="padding: 20px; background: #f1f1f1;" width="40%"><p style="text-align: left; font-size: 40px; margin: 0px;">Fact 6: <span style="color: #c0c; font-size: 40px;">Service?</span></p>
        <p style="text-align: left; font-size: 14px;">Increasing labor costs makes these companys localed in USA/Europe seems inadequate in terms of staffing. Luvme Hair has a more abundant human resources, so there is always a well-staffed and experienced team for you. Please think about that, when you need a faster shipping or some detailed service, it may be the time when these "Brands" ignore you.</p></td>
      <td width="50%"><img style="width:100%" class="alignleft size-full wp-image-2286" alt="choose best virgin hair (6)" src="http://www.luvmehair.com/uploads/choose-luvme-virgin-hair-61.jpg" /></td>
    </tr>
  </tbody>
</table>
<p style="font-size: 20px; font-weight: bold; text-align: left;">So, Which is your <span style="color: #c0c; font-size: 28px;"><i>best choice?</i></span></p>
<p></p>
<p style="text-align: left;"><em><span style="color: #ffffff; font-size: 24px; font-family: arial, helvetica, sans-serif; display: block; width: 1000px; background: #333; padding-left: 20px; line-height: 40px;"> Direct Contact </span></em></p><p> </p><p style="text-align: left;"><span style="font-family: arial, helvetica, sans-serif; font-size: 18px;"><strong><em>Phone/Whatsapp</em><em>:</em> </strong>0086-18613122553 </span></p><p style="text-align: left;"><span style="font-family: arial, helvetica, sans-serif; font-size: 18px;"><strong><em> Email</em><em>:</em> </strong>stella@luvmehair.com</span></p>
</section>
                 </section>
<div class="clear"></div>


          </section>

      </section>

       

       

    </section>
<style>
.product-desc-tabs{
    border-bottom: 2px solid #000;
}
.product-desc-tabs h2 {
    display: inline-block;
    vertical-align: top;
    height: 30px;
    line-height: 30px;
    padding: 0 15px;
    background: #fab23a;
    font-size: 14px;
    color: #000;
    cursor: pointer;
    border-radius: 3px 3px 0 0;
    font-weight: bold;
}
.product-desc-tabs h2.current {
    background: #000;
    color: #fff;
}
@media screen and (max-width: 641px){
    .product-desc-tabs h2 {
        width: 100%;
        margin-bottom: 10px;
        border-radius: 0;
    }
}
</style>
<script>
$(function(){
    $('.product-desc .product-desc-tabs h2').click(function(){
        i=$(this).index();
        $(this).addClass('current').siblings().removeClass('current');
        $('.product-desc .product-desc-panel').eq(i).show();
        $('.product-desc .product-desc-panel').not($('.product-desc .product-desc-panel').eq(i)).hide();
    })

});
</script>


<script src="<?php 

bloginfo('template_url');

?>

/js/select-drop.js"></script>

<!-- js for product -->

<script>

(function($){

	   

   $(function(){

	   //定义商品时间

	   countDown("<?php 

the_field('djs_time');

?>23:59:59",".goods-time-count .day",".goods-time-count .hour",".goods-time-count .minute",".goods-time-count .second");

   });

   function countDown(time,day_elem,hour_elem,minute_elem,second_elem){

	var end_time = new Date(time).getTime(),

	sys_second = (end_time-new Date().getTime())/1000;

	var timer = setInterval(function(){

		if (sys_second > 0) {

			sys_second -= 1;

			var day = Math.floor((sys_second / 3600) / 24);

			var hour = Math.floor((sys_second / 3600) % 24);

			var minute = Math.floor((sys_second / 60) % 60);

			var second = Math.floor(sys_second % 60);

			day_elem && $(day_elem).html(day);

			$(hour_elem).text(hour<10?"0"+hour+'':hour+'');

			$(minute_elem).text(minute<10?"0"+minute+'':minute+'');

			$(second_elem).text(second<10?"0"+second:second);

			$('.goods-time-count p').css({'display':'inline-block'})

		} else { 

			clearInterval(timer);

			$('.goods-time-count').html('')

		}

		$('.goods-time-count .time-coming').remove()

	}, 1000);

	}

	

   $('.goods-time-count').append("<span class='time-coming'></span>")

   $(document).ready(function(){

	//下拉框--选择第二项,展示自定义

	$('.select-with-custom').change(function(){

	   if(this.selectedIndex==1){   

		  $(this).parents('.form-item').find('.custom-form').show() 

	   }

	   else{

		  $(this).parents('.form-item').find('.custom-form').hide()		   

	   }

	})

   })

   //下拉框美化

   $.fn.clicktoggle = function(a, b) {

	return this.each(function() {

		var clicked = false;

		$(this).click(function() {

			if (clicked) {

				clicked = false;

				return b.apply(this, arguments);

			}

			clicked = true;

			return a.apply(this, arguments);

		});

	});

   };

   $.fn.ready(function() {

    $('.select-box select').dropkick();

   });

	

$(document).ready(function(){

//价格变动

$(function(){

var triggerBind = $(function(){

	$('body').append('<div style="display:none" class="price-add-list"></div><div style="display:none" class="mkt-price-add-list"></div>')		

	$(".product-shop .form-item").each(function(){

		var i=$(this);

		var p=$(this).find('.price-change');

		function getobjVal(){}

		p.change(function(){

			i.attr("data-attrval",$(this).attr("value"))

			if($(this).parents('dl').hasClass('check-item')){

			   if(!$(this).parents('.check-item').find('input[type="checkbox"]').is(':checked')){

			      $(this).parents('.form-item').attr("data-attrval",0)

		  	   }

			}

			getattrprice()

		})

		p.click(function(){

			p.attr("data-attrval",$(this).attr("value"));

			$("#bigImg").attr({ src: $(this).attr("data-img") });

			$("#bigImg").attr({ jqimg: $(this).attr("data-img") });

			if($(this).parents('dl').hasClass('check-item')){

			   if(!$(this).parents('.check-item').find('input[type="checkbox"]').is(':checked')){

			      $(this).parents('.form-item').attr("data-attrval",0)

		  	   }

			}		

			getattrprice()

		})

	})

	var oldPrice=$('.old-price i').html()

	var curPrice=$('.special-price i').html()

	function getattrprice(){

		var defaultstats=true;

		var _val='';

		var _resp={

			mktprice:".old-price i",

			price:".special-price i"

		}

		$('.price-add-list li,.mkt-price-add-list li').remove()

	   $(".product-shop .form-item").each(function(){

			var i=$(this);

			var v=i.attr("data-attrval");

			if(!v){

				defaultstats=false;				

			}else{

				_val=v;

				$('.price-add-list').append('<li>'+(parseFloat(sys_item['sys_attrprice'][_val]['price'])).toFixed(2)+' '+'</li>')			

				$('.mkt-price-add-list').append('<li>'+(parseFloat(sys_item['sys_attrprice'][_val]['mktprice'])).toFixed(2)+' '+'</li>')			

			}

		})

		

		var addPrice=0

		$('.price-add-list li').each(function(){

		   addPrice = addPrice + parseFloat($(this).text());

		})

		var addMktPrice=0

		$('.mkt-price-add-list li').each(function(){

		   addMktPrice = addMktPrice + parseFloat($(this).text());  

		})

		

	  var gNums =$('.ipt-qty').val()

	   _mktprice=(parseFloat(addMktPrice)+parseFloat(oldPrice)).toFixed(2);

	   _price=((parseFloat(addPrice)+parseFloat(curPrice))*gNums).toFixed(2);

		$(_resp.mktprice).text(_mktprice);

		$(_resp.price).text(_price);

				

		$('.product-summary').each(function(){ 

	   var curPrice=parseFloat($('.product-summary').find('.special-price i').text())

	   var oPrice=parseFloat($('.product-summary').find('.old-price i').text())  

	   if(curPrice<oPrice)

	   {

		  var discount=Math.round((1-curPrice/oPrice)*100)

		  $('.product-summary').find('.discount b').html(discount)

	   }

	   else{

		  $('.product-summary').find('.discount').hide()

	   } 

	})

	}

	

	//单选框美化

	$('.color-list li,.size-list li,.keyss-list li').each(function(){

	   var input = $(this).find('input');

	   var option = $(this).find('option');

	   if($(this).find('input:checked').length>0){

	      $(this).addClass('checked');

	   }

	   $(this).click(function(){

	      if($(this).find('input').is(':checked')){

	         $(this).addClass('checked').siblings().removeClass('checked');

			 var cat = $(this).attr('data-cat');

			 var relate = $(this).attr('data-relate');

			 var val = $(this).attr('data-val');

			 var in_html='';

			 if(relate!=''){				 

				 $("#form_item_"+relate+"_all").html('');				 

				 var show_style=$("#form_item_"+relate+"_all").attr('data-style');

				 if(show_style=='select'){

					 in_html += '<dl> <dt>'+relate+': </dt> <dd><div class="select-box change-item"><select id="a'+name_str+'" name="diy_option['+relate+']" class="select-size select-with-custom price-change select-require"><option value="0">--- Please Select ---</option>';

					for(var k in relate_json[cat][val][relate]){

						var name_str = relate_json[cat][val][relate][k];

						var name_arr = name_str.split("@"); 

						in_html += '<option value="'+name_str+'">'+name_arr[0]+'</option>';

					}					

					 in_html += '</select></div><div class="form-error-msg"> --- Please Select ---</div> </dd></dl>';

					 $("#form_item_"+relate+"_all").append(in_html);

				     $('.select-box select').dropkick();

				 }else if(show_style=='checkbox'){

					in_html += '<dl> <dt>'+relate+': </dt> <dd><ul class="check-require tags-for-color">';

					for(var k in relate_json[cat][val][relate]){

						var name_str = relate_json[cat][val][relate][k];

						var name_arr = name_str.split("@"); 

						in_html += '<li><input class="price-change" type="radio" value="'+name_str+'" id="a'+name_str+'" name="diy_option['+relate+']" data-attrval="'+name_str+'"><label for="a'+name_str+'"> <span class="size-value">'+name_arr[0]+'</span> <b class="ico-tick"> </b></label> </li>';

					}					

					 in_html += '</ul><div class="form-error-msg"> --- Please Select ---</div> </dd></dl>';

					 $("#form_item_"+relate+"_all").append(in_html);

				 }else{

					 in_html += '<dl> <dt>'+relate+': </dt> <dd><ul class="size-list check-require tags-for-color">';

					for(var k in relate_json[cat][val][relate]){

						var name_str = relate_json[cat][val][relate][k];

						var name_arr = name_str.split("@"); 

						in_html += '<li><input class="price-change" type="radio" value="'+name_str+'" id="a'+name_str+'" name="diy_option['+relate+']" data-attrval="'+name_str+'"><label for="a'+name_str+'"> <span class="size-value">'+name_arr[0]+'</span> <b class="ico-tick"> </b></label> </li>';

					}					

					 in_html += '</ul><div class="form-error-msg"> --- Please Select ---</div> </dd></dl>';

					 $("#form_item_"+relate+"_all").append(in_html);

				 }				 

					var i=$("#form_item_"+relate+"_all");

					var p=$("#form_item_"+relate+"_all").find('.price-change');

					function getobjVal(){}

					p.change(function(){

						i.attr("data-attrval",$(this).attr("value"))

						if($(this).parents('dl').hasClass('check-item')){

						   if(!$(this).parents('.check-item').find('input[type="checkbox"]').is(':checked')){

							  $(this).parents('.form-item').attr("data-attrval",0)

						   }

						}

						getattrprice()

					})

					p.click(function(){

						$(this).parents('li').addClass('checked');

						$(this).parents('li').addClass('checked').siblings().removeClass('checked');

						p.attr("data-attrval",$(this).attr("value"));

						$("#bigImg").attr({ src: $(this).attr("data-img") });

						$("#bigImg").attr({ jqimg: $(this).attr("data-img") });

						if($(this).parents('dl').hasClass('check-item')){

						   if(!$(this).parents('.check-item').find('input[type="checkbox"]').is(':checked')){

							  $(this).parents('.form-item').attr("data-attrval",0)

						   }

						}		

						getattrprice()

					})

			 }

	      }

		  else{

	         $(this).removeClass('checked')

		  }		

	   })

	})

	

	//客户自定义商品参数-单选框

	$('.radio-custom-set').click(function(){

	   if($(this).find('input:checked').length>0){

	      $(this).prevAll().find('input[type="radio"]').attr({

			  'checked':false,

			  'disabled':'disabled'

		  })

		  $(this).prevAll().removeClass('checked')

		  $(this).prevAll().addClass('radio-disabled')

		  $(this).addClass('checked')

		  $(this).parents('.form-item').find('.custom-form').show()

	   }

	   else {

		  $(this).prevAll().removeClass('radio-disabled')

		  $(this).prevAll().find('input[type="radio"]').removeAttr("disabled")

		  $(this).removeClass('checked')

		  $(this).parents('.form-item').find('.custom-form').hide()

	   }

	})

	

  //弹出颜色图片

   $('.color-list li').each(function(){

	   if(!$(this).hasClass('radio-custom-set')){

	     var colorImg=$(this).find('.color-small-img img').data('big')

	     var colorName=$(this).find('.color-small-img img').data('name')

	     $(this).append('<div class="color-img-pop"><img src='+colorImg+'><span class="color-name">'+colorName+'</span></div>')

	     $(this).hover(function(){

	        $(this).toggleClass('z9999')

	     })

	   }

   })	

   

   

 //浮动小图 

	$('.tags-for-color li').each(function(){

	   if(typeof($(this).find('.size-value').attr("data-big"))!="undefined" && typeof($(this).find('.size-value').attr("data-name"))!="undefined" && !$(this).hasClass('radio-custom-set')){

	     var colorImg=$(this).find('.size-value').data('big')

	     var colorName=$(this).find('.size-value').data('name')

	     $(this).append('<div class="color-img-pop"><img src='+colorImg+'><span class="color-name">'+colorName+'</span></div>')

	     $(this).hover(function(){

	        $(this).toggleClass('z9999')

	     })

	   }		

	})	

	

		

})

})

})//ready	

   //必填(商品参数)

   $('.add-to-cart').click(function(){

	var requireNum=0;

	$(this).parents('form').find("input.ipt-require").each(function(n){

		if($(this).val()=="")

		{

			requireNum++;

			$(this).parents('dl').find('.form-error-msg').show()

		}

		else{

			$(this).parents('dl').find('.form-error-msg').hide()		

		}

	});

	$(this).parents('form').find("input.ipt-require").blur(function(){

		if($(this).val()=="")

		{

			requireNum++;

			$(this).parents('dl').find('.form-error-msg').show()

		}

		else{

			$(this).parents('dl').find('.form-error-msg').hide()		

		}

	});

	

	$(this).parents('form').find(".check-require").each(function(n){

		if($(this).find('input:checked').length<1)

		{

			requireNum++;

			$(this).parents('dl').find('.form-error-msg').show()

		}

		else{

			$(this).parents('dl').find('.form-error-msg').hide()		

		}

	});

	$(this).parents('form').find(".check-require").click(function(){

		if($(this).find('input:checked').length<1)

		{

			requireNum++;

			$(this).parents('dl').find('.form-error-msg').show()

		}

		else{

			$(this).parents('dl').find('.form-error-msg').hide()		

		}

	});	

	

	

	$(this).parents('form').find('.select-require').each(function(){

	  if($(this).val()==$(this).find("option:first").val()){

		  requireNum++

		  $(this).parents('.form-item').find('.form-error-msg').show()

	   }

	   else {

		  $(this).parents('.form-item').find('.form-error-msg').hide()

	   }

	 })

	 $(this).parents('form').find('.select-require').change(function(){

	  if($(this).val()==$(this).find("option:first").val()){

		  $(this).parents('.form-item').find('.form-error-msg').show()

	   }

	   else {

		  $(this).parents('.form-item').find('.form-error-msg').hide()

	   }		 

	 })

	 	 

	if(requireNum>0 )

	{

		return false;

	}

	else{

		return true;

	}	 

	})

})(jQuery);

//reset form

$(window).load(function() {

   $('.product-shop form')[0].reset()

});

</script>

    <section class="product-slides-wrap">

        <section class="layout">

            <div class="index-tit-bar">

              <h2 class="title">Best Sellers</h2>

           </div>

            <section class="product-slides">

<?php 

$post_num = 8;

$exclude_id = $post->ID;

$posttags = get_the_tags();

$i = 0;

if ($posttags) {

    $tags = '';

    foreach ($posttags as $tag) {

        $tags .= $tag->term_id . ',';

    }

    $args = array('post_status' => 'publish', 'tag__in' => explode(',', $tags), 'post__not_in' => explode(',', $exclude_id), 'caller_get_posts' => 1, 'orderby' => 'comment_date', 'posts_per_page' => $post_num);

    query_posts($args);

    while (have_posts()) {

        the_post();

        $product = get_post_meta($post->ID, '_eshop_product');

        $post->saleprice = get_currency_price($product[0][products][1][saleprice]);

        $post->price = get_currency_price($product[0][products][1][price]);

        ?>

	<div class="product-item">

              <div class="item-wrap">

            <div class="pd-img">

               <a href="<?php 

        the_permalink();

        ?>

">

                 <img src="<?php 

        $images = get_field('product_gallery');

        if ($images) {

            for ($x = 0; $x < 1; $x++) {

                echo $images[0]['sizes']['thumbnail'];

            }

        }

        ?>

" alt="<?php 

        echo mb_strimwidth(strip_tags(apply_filters('the_title', $post->post_title)), 0, 300, '...');

        ?>

">

               </a>

             <!--  <?php 

        if (get_field('yes_price')) {

            ?>

<span class="discount"><b></b><i>%</i><em>OFF</em></span><?php 

        }

        ?>

 -->

            </div>

            <div class="pd-info">

               <h3 class="pd-name"><a href="<?php 

        the_permalink();

        ?>

"><?php 

        echo mb_strimwidth(strip_tags(apply_filters('the_title', $post->post_title)), 0, 50, '...');

        ?>

</a></h3>

               <div class="pd-price">

                  <?php 

        if (get_field('yes_price')) {

            ?>

<del><?php 

            echo get_currency_symbol();

            ?>

<i><?php 

            echo number_format($post->price, 2);

            ?>

</i></del><?php 

        }

        ?>

                  <b><?php 

        echo get_currency_symbol();

        ?>

<i><?php 

        echo number_format($post->saleprice, 2);

        ?>

</i></b>

               </div>

            </div>

         </div>

              </div>

	<?php 

        $exclude_id .= ',' . $post->ID;

        $i++;

    }

    wp_reset_query();

}

if ($i < $post_num) {

    $cats = '';

    foreach (get_the_category() as $cat) {

        $cats .= $cat->cat_ID . ',';

    }

    $args = array('category__in' => explode(',', $cats), 'post__not_in' => explode(',', $exclude_id), 'caller_get_posts' => 1, 'orderby' => 'comment_date', 'posts_per_page' => $post_num - $i);

    query_posts($args);

    while (have_posts()) {

        the_post();

        $product = get_post_meta($post->ID, '_eshop_product');

        $post->saleprice = get_currency_price($product[0][products][1][saleprice]);

        $post->price = get_currency_price($product[0][products][1][price]);

        ?>

			

	<div class="product-item">

              <div class="item-wrap">

            <div class="pd-img">

               <a href="<?php 

        the_permalink();

        ?>

">

                 <img src="<?php 

        $images = get_field('product_gallery');

        if ($images) {

            for ($x = 0; $x < 1; $x++) {

                echo $images[0]['sizes']['thumbnail'];

            }

        }

        ?>

" alt="<?php 

        echo mb_strimwidth(strip_tags(apply_filters('the_title', $post->post_title)), 0, 300, '...');

        ?>

">

               </a>

             <!--  <?php 

        if (get_field('yes_price')) {

            ?>

<span class="discount"><b></b><i>%</i><em>OFF</em></span><?php 

        }

        ?>

 -->

            </div>

            <div class="pd-info">

               <h3 class="pd-name"><a href="<?php 

        the_permalink();

        ?>

"><?php 

        echo mb_strimwidth(strip_tags(apply_filters('the_title', $post->post_title)), 0, 50, '...');

        ?>

</a></h3>

               <div class="pd-price">

                  <?php 

        if (get_field('yes_price')) {

            ?>

<del><?php 

            echo get_currency_symbol();

            ?>

<i><?php 

            echo number_format($post->price, 2);

            ?>

</i></del><?php 

        }

        ?>

                  <b><?php 

        echo get_currency_symbol();

        ?>

<i><?php 

        echo number_format($post->saleprice, 2);

        ?>

</i></b>

               </div>

            </div>

         </div>

              </div>		

			

			<?php 

        $i++;

    }

    wp_reset_query();

}

if ($i == 0) {

    echo '<li>No Related Products!</li>';

}

?>

	

                 

            </section>  

        </section>

    </section>

    

    <section class="share-slide-wrap">

        <section class="layout">

        	<div class="share-title-bar">

            	<h2 class="share-title">Share Your New Looking With Us</h2>

                <!-- <a href="" class="shopping">SHOPPING NOW</a> -->

                <a href="<?php 

echo home_url('/');

?>

gallery" class="view-gallery">VIEW GALLERY</a>

            </div>

            <section class="share-slide">

			

<?php 

query_posts(array('post_type' => 'gallery', 'showposts' => 12, 'orderby' => 'post_date', 'order' => 'DESC'));

while (have_posts()) {

    the_post();

    ?>

            	<div class="share-item">

                	<div class="share-item-wrap">

                    	<div class="share-img"><a href="<?php 

    the_permalink();

    ?>

"><img src="<?php 

    $images = get_field('gallery_img');

    if ($images) {

        for ($x = 0; $x < 1; $x++) {

            echo $images[0]['sizes']['thumbnail'];

        }

    }

    ?>

" alt="<?php 

    echo mb_strimwidth(strip_tags(apply_filters('the_title', $post->post_title)), 0, 200, '...');

    ?>

"></a></div>

                	</div>

                </div>

<?php 

}

wp_reset_query();

?>

				</section>

        </section>

    </section>

<?php 

get_footer();