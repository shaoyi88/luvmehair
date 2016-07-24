 <!-- aside begin -->

   <aside class="aside">

      <section class="side-widget">

         <div class="side-tit-bar">

            <h4 class="side-tit">My Account</h4>

         </div>

         <div class="side-cate side-hide">

            <ul>

<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('menu' => 187, 'echo' => false)) ));?>

            </ul>

         </div>

      </section>



   </aside>

   <!--// aisde end -->