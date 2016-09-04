<?php 

      if($_GET['currency']&&$_GET['eshopaction']=='') {

		 setcookie('currency', $_GET['currency'], time()+3600*24*30, COOKIEPATH, COOKIE_DOMAIN, false);

	    $url = home_url(add_query_arg(array()));

		$url = str_replace("?currency=".$_GET['currency'], "", $url);

		header('Location: '.$url);

	}	

?><!DOCTYPE html>

<html dir="ltr" lang="en">

<head>

<title><?php wp_title( ' ', true, 'right' );  ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">

<link rel="apple-touch-icon-precomposed" href="">

<meta name="format-detection" content="telephone=no">

<meta name="apple-mobile-web-app-capable" content="yes">

<meta name="apple-mobile-web-app-status-bar-style" content="black">


<link href="<?php bloginfo( 'template_url' ); ?>/style.css" rel="stylesheet" media="screen and (min-width:641px)">

<link href="<?php bloginfo( 'template_url' ); ?>/mobile.css?v=1" rel="stylesheet" media="screen and (max-width:640px)">

<script src="<?php bloginfo( 'template_url' ); ?>/js/jquery.min.js"></script>

<script src="<?php bloginfo( 'template_url' ); ?>/js/common.js"></script>

<script src="<?php bloginfo( 'template_url' ); ?>/js/owl.carousel.js"></script>

<script src="<?php bloginfo( 'template_url' ); ?>/js/lightbox.min.js"></script>

<script src="<?php bloginfo( 'template_url' ); ?>/js/view.js"></script>

<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/custom_service.js"></script>

<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery.flexslider-min.js"></script>

<!--[if lt IE 9]>

<script src="<?php bloginfo( 'template_url' ); ?>/js/html5.js"></script>

<![endif]-->

<?php query_posts(array( 'post_type' => 'ad_img','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') );  while (have_posts()) : the_post();?><?php the_field('3code_gw'); ?><?php endwhile; wp_reset_query();  ?>

<link rel="shortcut icon" href="<?php echo home_url(); ?>/favicon.ico" />

<?php wp_head();?>

</head>



<body>

<section class="photos-gallery"><b class="close-gallery"></b></section>

<div class="gallery-body-mask"></div>

<div id="loading"></div>

<section class="container">

	<!-- head-wrapper begin -->

    <header class="head-wrapper">

       <nav class="topbar">

       	<section class="layout">

            <div class="web-sup">

<?php query_posts(array( 'post_type' => 'ad_img','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>

                <span class="sup01"><?php the_field('ad_satisfation'); ?></span>

                <span class="sup02"><?php the_field('ad_ship'); ?></span>

 <?php endwhile; wp_reset_query();  ?>

            </div>

            <div class="transall"></div>

            <div id="currency" class="change-currency">

		 <div class="dropdown">

            <div class="currency-cur"><?php echo get_currency_name()?><b></b>

			<div class="currency-icon"></div></div>

			

            <div class="submenu">

				 <?php if(get_currency()!="USD"){?><a rel="nofollow" class="USD" href="?currency=USD" >USD $</a><?php }?>

				 <?php if(get_currency()!="EUR"){?><a rel="nofollow" class="EUR" href="?currency=EUR" >EUR €</a><?php }?>

				 <?php if(get_currency()!="CAD"){?><a rel="nofollow" class="CAD" href="?currency=CAD" >CAD $</a><?php }?>

				 <?php if(get_currency()!="GBP"){?><a rel="nofollow" class="GBP" href="?currency=GBP" >GBP £</a><?php }?>

				 <?php if(get_currency()!="AUD"){?><a rel="nofollow" class="AUD" href="?currency=AUD" >AUD $</a><?php }?>

				 <?php if(get_currency()!="HK"){?><a rel="nofollow" class="HK" href="?currency=HK" >HK $</a><?php }?>

				 <?php if(get_currency()!="JPY"){?><a rel="nofollow" class="JPY" href="?currency=JPY" >JPY 円</a><?php }?>

				 <?php if(get_currency()!="RUB"){?><a rel="nofollow" class="RUB" href="?currency=RUB" >RUB руб.</a><?php }?>

				 <?php if(get_currency()!="CHF"){?><a rel="nofollow" class="CHF" href="?currency=CHF" >CHF CHF</a><?php }?>

				 <?php if(get_currency()!="MXN"){?><a rel="nofollow" class="MXN" href="?currency=MXN" >MXN $</a><?php }?>

				 <?php if(get_currency()!="NOK"){?><a rel="nofollow" class="NOK" href="?currency=NOK" >NOK Kr</a><?php }?>

				 <?php if(get_currency()!="CZK"){?><a rel="nofollow" class="CZK" href="?currency=CZK" >CZK Kč</a><?php }?>

				 <?php if(get_currency()!="BRL"){?><a rel="nofollow" class="BRL" href="?currency=BRL" >BRL $</a><?php }?>

				 <?php if(get_currency()!="ARS"){?><a rel="nofollow" class="ARS" href="?currency=ARS" >ARS $</a><?php }?>

            </div>

		 </div>

              </div>  

            <ul class="top-menu">



                <li class="top-login"><a href="<?php echo home_url(); ?>/login">Log In</a> or <a href="<?php echo home_url(); ?>/register">Register</a></li>

                <li class="top-account"><a href="<?php echo home_url(); ?>/profile">Account</a></li>

                <li class="top-wishlist"><a href="<?php echo home_url(); ?>/wishlist">Wishlist</a></li>



              </ul> 

        </section>       

       </nav>

       <section class="header">  

<?php query_posts(array( 'post_type' => 'ad_img','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>

<div class="logo"><a href="<?php echo home_url(); ?>/"><img src="<?php $image = get_field('ad_logo');if( !empty($image) ): ?><?php echo $image['url']; ?><?php endif; ?>" alt="<?php wp_title( ' ', true, 'right' );  ?>"></a></div>

<?php endwhile; wp_reset_query();  ?>

        <section class="head-shopcart">

         <div class="shopcart-title">

            <span class="goods-num"><?php display_my_cart_items_no(); ?></span>

         </div>

         <!-- shopcart -->

         <div class="shopcart-cont">

               <span id="my_cart_items"></span>

               <div class="shopcart-foot">

                  <a rel="nofollow" class="btn-view-cart" href="<?php echo home_url(); ?>/shopping-cart">View Cart</a>

                  <a rel="nofollow" class="btn-check" href="<?php echo home_url(); ?>/shopping-cart/checkout">Checkout</a>

               </div>

         </div>            

      </section>

      <section class="head-search-wrap">

        <section class="head-search">

			    <form id="eshopsearchform" method="get" action="<?php bloginfo('home'); ?>/">

					<input type="text" class="search-ipt"  name="s" id="eshopws" size="20" value="Enter Keywords" />

					<input type="submit" class="search-btn" value="" />

					<input type="hidden" name="eshopsearch" value="all" />

				</form>

				</section>

        <nav class="sear-tag">

        	<ul>

<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('menu' => 570, 'echo' => false)) ));?>

            </ul>

        </nav>

      </section>

      	

       </section>

       <!-- navigation -->

       <nav class="nav-bar">

          <section class="nav-wrap">

             <ul class="nav">

<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('menu' => 31, 'echo' => false)) ));?>

             </ul>

          </section>

       </nav>
       <div class='mobile-head-wrapper'>
        <div class='mobile-serve mobile-nav-bar'>
        	<div class="title-ico"></div>
            <div class="mobile-head-hide">
            </div>
        </div>
        <div class='mobile-serve mobile-change-currency'>
        	<div class="title-ico"></div>
            <div class="mobile-head-hide">
            </div>
        </div>
        <div class='mobile-serve mobile-head-search'>
        	<div class="title-ico"></div>
            <div class="mobile-head-hide">
            </div>
        </div>
        <div class='mobile-serve mobile-head-shopcart'>
        	<div class="title-ico"></div>
            <div class="mobile-head-hide">
            </div>
        </div>
    </div>
    </header> 



<?php if(is_home()) : ?>

<!--// head-wrapper end -->

<?php else: ?>

<?php query_posts(array( 'post_type' => 'ad_img','showposts' => 1,'orderby' => 'post_date','order'=> 'DESC') ); while (have_posts()) : the_post();?>

<section class="layout">

   <section class="promote-bar">

      <ul>

         <li class="txt-1"><p><?php the_field('shipping_text'); ?></p></li>

         <li class="txt-2"><p><?php the_field('off_code'); ?></p></li>

         <li class="txt-3"><p><?php the_field('off_time'); ?></p></li>

         <li class="txt-4"><div class="time-count"><p><em class="day"></em> day <span class="hour"></span>:<span class="minute"></span>:<span class="second"></span></p></div></li>

      </ul>

   </section>

</section>

<script>

   (function($){

   $('.time-count').append("<span class='time-coming'></span>")

   $(function(){

	   //定义时间

	   countDown("<?php the_field('promotion_day'); ?> 23:59:59",".time-count .day",".time-count .hour",".time-count .minute",".time-count .second");

	   

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

			$('.time-count p').css({'display':'inline-block'})

		} else { 

			clearInterval(timer);

			$('.time-count').html('<span class="next-time">Next Time！</span>')

		}

		$('.time-coming').remove()

	}, 1000);

	}

	})(jQuery);

</script> 

<?php endwhile; wp_reset_query();  ?>

<!--// head-wrapper end -->

<?php endif; ?>