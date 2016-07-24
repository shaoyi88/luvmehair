<?php
/*
Template Name: login-shoppingcart
*/
?>  
<?php get_header();?>
<section class="layout">
   <nav class="path-bar">
      <ul class="path-nav">
         <li> <a itemprop="breadcrumb" href="<?php echo home_url(); ?>/">Home</a></li><li> <a href="#"><?php wp_title(); ?></a></li>
      </ul>
   </nav>
</section>
<section class="layout">
   <section class="main" style="width:100%">

      <div class="main-tit-bar">
         <h1 class="title"><?php wp_title(); ?> </h1>
         <div class="share-this"><div class="addthis_sharing_toolbox"></div><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-542380e974172b9d" async="async"></script></div>
      </div>
      <article class="entry">
<?php while ( have_posts() ) : the_post(); ?>
<?php the_content(); ?> 
<?php endwhile; ?>
<div class="clear"></div>
      </article>
</section>
</section>


<?php
if (is_page('shopping-cart')){
?>
<script>
$(document).ready(function(){
    $('.qty_add').each(function (index) {
        $(this).click(	function(){
			$("#loading").show();
		     var pid = $(this).attr('data-id');
			 var name = $("#"+pid).attr('name');
			 var qty = $("#"+pid).val();
			 $("#"+pid).val(parseInt(parseInt(qty)+1));
			 var arg = {};
			 var arg1=name;
			 var arg2="save";
			 var arg3="eshopnon";
			 var arg4="_wpnonce";
			 var arg5="update";
			 arg[arg1]=parseInt(parseInt(qty)+1);
			 arg[arg2]='true';
			 arg[arg3]='set';
			 arg[arg4]=$("#_wpnonce").val();
			 arg[arg5]='Update Cart';
			 $.post("/shopping-cart", arg,
			    function(data){
			      window.location.reload();
			  });
		})
		
    })
    $('.qty_reduce').each(function (index) {
		$(this).click(	function(){			
		     var pid = $(this).attr('data-id');
			 var name = $("#"+pid).attr('name');
			 var qty = $("#"+pid).val();
			 if(qty==1){
				 alert("Qty can not be less than 1");
				 return;
			 }
			 $("#loading").show();
			 $("#"+pid).val(parseInt(parseInt(qty)-1));
			 var arg = {};
			 var arg1=name;
			 var arg2="save";
			 var arg3="eshopnon";
			 var arg4="_wpnonce";
			 var arg5="update";
			 arg[arg1]=parseInt(parseInt(qty)-1);
			 arg[arg2]='true';
			 arg[arg3]='set';
			 arg[arg4]=$("#_wpnonce").val();
			 arg[arg5]='Update Cart';
			 $.post("/shopping-cart", arg,
			    function(data){
			      window.location.reload();
			  });
		})        
    })
});
</script>
<script>
$(document).ready(function(){

   //修改商品数量
   $('.choose-amount').each(function(){
      var aIpt=$(this).find('input')
      if(aIpt.val()==1){
         $(this).find('.ico-minus').addClass('ico-minus-disabled')
      }
	  else if(aIpt.val()==''){
         aIpt.val(1)
      }
      aIpt.blur(function(){
	     var tValue=$(this).val()
         if(tValue=='' || isNaN(tValue)){
	        $(this).val('1')
	     }
	     else if(!isNaN(tValue) && tValue<1){
		    $(this).val('1')
	     }	
	     else{
		   $(this).val(parseInt(tValue)) 
	     }
       })
	   var aIpt=$(this).find('input')
       $(this).find(".ico-plus").click(function () {
	         aIpt.val(parseInt(aIpt.val())+1)
			 if(aIpt.val()>1){
			   $(this).parents('.choose-amount').find(".ico-minus").removeClass('ico-minus-disabled')
			 }
          })
          $(this).find('.ico-minus').click(function(){			  
             if(aIpt.val()>=2){
                aIpt.val(parseInt(aIpt.val())-1)
			    if (aIpt.val()==1){
			       $(this).addClass('ico-minus-disabled')
		        }				
	         }
       })
	   aIpt.change(function(){
	      if(aIpt.val()==1){
	         $(this).parents('dl').find('.ico-minus').addClass('ico-minus-disabled')
	      }
	      else if(aIpt.val()>1){
	         $(this).parents('dl').find('.ico-minus').removeClass('ico-minus-disabled')
	      }
	   })  	
   })
})
</script>
<?php
}
?>
<!--// js for blog -->
<?php get_footer();?>