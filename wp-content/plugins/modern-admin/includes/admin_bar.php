<?php
$AllDefaultNodes=$this->admin_bar_filter_load();
$Options = $this->getOptions();
if(isset($_POST['save_admin_bar'])){
    $admin_bar=array();
    if(isset($_POST['admin_bar'])){

        foreach($_POST['admin_bar'] as $key => $value){
            $href=(isset($value["href"]))?$value["href"]:'';
            $show=(isset($value["show"]))?$value["show"]:0;
            $title = (isset($value["title"]))?$value["title"]:'';
            $admin_bar[$key]['href']=$href;
            $admin_bar[$key]['show']=$show;
            $admin_bar[$key]['title']=$title;

        }
        $Options['admin_bar'] = $admin_bar;
        if(isset($_POST['admin_bar_font']))
            $Options['admin_bar_font'] = (isset($_POST['admin_bar_font']))? $_POST['admin_bar_font']: 'awesome';
        update_option($this->OptionsName, $Options);
    }

    ?>
    <div class="updated"><p><strong><?php _e('Settings Updated',self::LANG);?>.</strong></p></div>
<?php
}
if(isset($_POST['reset_admin_bar'])){
    unset($Options['admin_bar']);
    update_option($this->OptionsName, $Options);
    ?>
    <div class="updated"><p><strong><?php _e('Reset Ok',self::LANG);?>.</strong></p></div>
<?php
}

$font = (isset($Options['admin_bar_font']))?$Options['admin_bar_font']:'awesome';
?>



<div class="wrap">
    <div id="icon-tools" class="icon32"></div>
    <h2>Admin Bar Menu</h2>

    <form action="" method="post" class="waum_form" id="waum_setting_admin_bar_menu">
       <!-- left items -->
       <div class="metabox-holder columns-1">
            <div class="postbox">
                <h3 class="hndle"><span>Admin Bar Outsdie</span></h3>
                <div class="inside">
                    <p> <?php _e('Please switch font to avoid confict font with some themes and plugins in frontpage outside when logged in.',self::LANG);?></p>
                    <p>
                        <input type="radio" id="admin_font1" value="awesome" <?php checked($font,'awesome');?> name="admin_bar_font">

                        <label for="admin_font1"><?php _e('Awesome',self::LANG);?></label>

                    </p>
                    <p>
                        <input type="radio" id="admin_font2" value="tello" <?php checked($font,'tello');?> name="admin_bar_font">

                        <label for="admin_font2"><?php _e('Tello',self::LANG);?></label>

                    </p>
                </div>
            </div>
        </div>

        <div class="metabox-holder columns-1">
            <div class="postbox">
                <h3 class="hndle"><span>Left Items</span></h3>
                <div class="inside">
                    <!-- main item -->
                    <?php
                    foreach($AllDefaultNodes["left"]["main"] as $main_node){
                        $show=(isset($Options['admin_bar'][$main_node->id]['show']))?$Options['admin_bar'][$main_node->id]['show']:1;
                        $href=(isset($Options['admin_bar'][$main_node->id]['href']))?$Options['admin_bar'][$main_node->id]['href']:$main_node->href;
                        $title=(isset($Options['admin_bar'][$main_node->id]['title']))?$Options['admin_bar'][$main_node->id]['title']:$main_node->title;
						if(preg_match("/<form/i",$title)) $title = $main_node->id;
                    ?>
                    <div class="widget  wp-logo">
                        <div class="widget-top">

                            <div class="widget-title-action">
                                <a href="#available" class="widget-action"></a>
                            </div>
                            <div class="widget-title">
                                <h4>
                                    <input type="checkbox" name="admin_bar[<?php echo $main_node->id;?>][show]" value="1" <?php checked($show,1);?>> <?php echo $title;?>:<span class="in-widget-title"><?php echo $main_node->id;?></span>
                                </h4>
                            </div>
                        </div>

                        <div class="widget-inside">
                            <div class="settings">
                                <p class="description">
                                    ID: <?php echo $main_node->id;?><br>
                                    link: <input type="text" name="admin_bar[<?php echo $main_node->id;?>][href]" value="<?php echo $href?>" class="linktext">

                                </p>
                                <label>
                                    Title :
                                </label>
                                <input type="text" name="admin_bar[<?php echo $main_node->id;?>][title]" value="<?php echo esc_html(stripslashes($title));?>" class="regular-text titletext">
                                <?php if($main_node->id=='wp-logo'):?>
                                <input type="button" class="button button-secondary" value="Upload" name="logo_upload">
                                <?php endif?>
                            </div>

                            <div class="submenu ui-sortable">
                                <p class="description">Sub Menus</p>

                                <!-- sub items -->
                                <?php
                                if( !empty( $AllDefaultNodes["left"]["sub"] ) )
                                    foreach( $AllDefaultNodes["left"]["sub"] as $sub_node)
                                        if( $main_node->id == $sub_node->parent ){
                                            $show=(isset($Options['admin_bar'][$sub_node->id]['show']))?$Options['admin_bar'][$sub_node->id]['show']:1;
                                            $href=(isset($Options['admin_bar'][$sub_node->id]['href']))?$Options['admin_bar'][$sub_node->id]['href']:$sub_node->href;
                                            $title=(isset($Options['admin_bar'][$sub_node->id]['title']))?$Options['admin_bar'][$sub_node->id]['title']:$sub_node->title;
	                                        if(preg_match("/<form/i",$title)) $title = $main_node->id;
                                            ?>

                                  <div class="widget">

                                      <div class="widget-top">
                                          <div class="widget-title-action">
                                              <a href="#available" class="widget-action"></a>
                                          </div>
                                          <div class="widget-title">
                                              <h4>
                                                  <input type="checkbox" name="admin_bar[<?php echo $sub_node->id;?>][show]" value="1" <?php checked($show,1);?>> <?php echo $title;?>: <span class="in-widget-title"><?php echo $sub_node->id;?></span>
                                              </h4>
                                          </div>
                                      </div>

                                      <div class="widget-inside">
                                          <div class="settings">
                                              <p class="description">
                                                  ID: <?php echo $sub_node->id;?><br>
                                                  link: <input type="text" name="admin_bar[<?php echo $sub_node->id;?>][href]" value="<?php echo esc_html($href);?>" class="linktext">
                                              </p>
                                              <label>
                                                  Title :
                                              </label>
                                              <input type="text" name="admin_bar[<?php echo $sub_node->id;?>][title]" value="<?php echo esc_html(stripslashes($title));?>" class="regular-text titletext">
                                          </div>

                                      </div>
                                  </div>
                                  <!-- end sub item -->
                                <?php }?>

                              </div>

                          </div>

                      </div>
                    <?php } ?>
                  <!-- end main items -->


                <div class="clear"></div>

                </div>
            </div>

        </div>
        <!-- end left-->
       <!-- right items -->
        <div class="metabox-holder columns-1">
           <div class="postbox">
               <h3 class="hndle"><span>Right Items</span></h3>
               <div class="inside">
                   <!-- main item -->
                   <?php
                   foreach($AllDefaultNodes["right"]["main"] as $main_node){
                       $show=(isset($Options['admin_bar'][$main_node->id]['show']))?$Options['admin_bar'][$main_node->id]['show']:1;
                       $href=(isset($Options['admin_bar'][$main_node->id]['href']))?$Options['admin_bar'][$main_node->id]['href']:$main_node->href;
                       $title=(isset($Options['admin_bar'][$main_node->id]['title']))?$Options['admin_bar'][$main_node->id]['title']:$main_node->title;
	                   if(preg_match("/<form/i",$title)) $title = $main_node->id;
                       ?>
                       <div class="widget  wp-logo">
                           <div class="widget-top">
                               <div class="widget-title-action">
                                   <a href="#available" class="widget-action"></a>
                               </div>
                               <div class="widget-title">
                                   <h4>
                                       <input type="checkbox" name="admin_bar[<?php echo $main_node->id;?>][show]" value="1" <?php checked($show,1);?>>  <?php if($main_node->id=='my-account') echo "My Account"; else echo $title;?>:<span class="in-widget-title"><?php echo $main_node->id;?></span>
                                   </h4>
                               </div>
                           </div>

                           <div class="widget-inside">
                               <div class="settings">
                                   <p class="description">
                                       ID: <?php echo $main_node->id;?><br>
                                       link: <input type="text" name="admin_bar[<?php echo $main_node->id;?>][href]" value="<?php echo $href;?>" class="linktext">

                                   </p>
                                   <label>
                                       Title :
                                   </label>
                                   <input type="text" name="admin_bar[<?php echo $main_node->id;?>][title]" value="<?php echo esc_html(stripslashes($title));?>" class="regular-text titletext">
                               </div>

                               <div class="submenu ui-sortable">
                                   <p class="description">Sub Menus</p>

                                   <!-- sub items -->
                                   <?php
                                   if( !empty( $AllDefaultNodes["right"]["sub"] ) )
                                       foreach( $AllDefaultNodes["right"]["sub"] as $sub_node)
                                           if( $main_node->id == $sub_node->parent ){
                                               $show=(isset($Options['admin_bar'][$sub_node->id]['show']))?$Options['admin_bar'][$sub_node->id]['show']:1;
                                               $href=(isset($Options['admin_bar'][$sub_node->id]['href']))?$Options['admin_bar'][$sub_node->id]['href']:$sub_node->href;
                                               $title=(isset($Options['admin_bar'][$sub_node->id]['title']))?$Options['admin_bar'][$sub_node->id]['title']:$sub_node->title;
	                                           if(preg_match("/<form/i",$title)) $title = $main_node->id;
	                                           ?>

                                               <div class="widget">

                                                   <div class="widget-top">
	                                                <?php if($sub_node->id!='logout'):?>
                                                       <div class="widget-title-action">
                                                           <a href="#available" class="widget-action"></a>
                                                       </div>
		                                           <?php endif;?>
                                                       <div class="widget-title">
                                                           <h4>
                                                               <input type="checkbox" name="admin_bar[<?php echo $sub_node->id;?>][show]" value="1" <?php checked($show,1);?>>     <?php if($sub_node->id=='user-info') echo "User Info"; else echo $title;?>: <span class="in-widget-title"><?php echo $sub_node->id;?></span>
                                                           </h4>
                                                       </div>
                                                   </div>
													<?php if($sub_node->id!='logout'):?>
                                                   <div class="widget-inside">
                                                       <div class="settings">
                                                           <p class="description">
                                                               ID: <?php echo $sub_node->id;?><br>
                                                               link: <input type="text" name="admin_bar[<?php echo $sub_node->id;?>][href]" value="<?php echo esc_html($href);?>" class="linktext">
                                                           </p>
                                                           <label>
                                                               Title :
                                                           </label>
                                                           <input type="text" name="admin_bar[<?php echo $sub_node->id;?>][title]" value="<?php echo esc_html(stripslashes($title));?>" class="regular-text titletext">
                                                       </div>

                                                   </div>
		                                           <?php endif;?>
                                               </div>
                                               <!-- end sub item -->
                                           <?php }?>

                               </div>

                           </div>

                       </div>
                   <?php } ?>
                   <!-- end main items -->


                   <div class="clear"></div>

               </div>
           </div>

        </div>
       <!-- end right-->
    <p class="submit">
        <input type="submit" name="save_admin_bar" class="button button-primary" value="<?php _e('Save Changes',self::LANG);?>"/>
        <input type="submit" name="reset_admin_bar" class="button button-secondary" value="<?php _e('Reset',self::LANG);?>"/>
    </p>

    </form>

</div>
<script>
    jQuery(document).ready(function($){
        $(".widget-top a.widget-action ").live('click', function() {
            $(this).parents(".widget-top").siblings(".widget-inside").toggle('swing');

        })
        $("input[name=logo_upload]").live('click', function(event) {
            $(this).siblings()
            var send_attachment_bkp = wp.media.editor.send.attachment;
            wp.media.editor.send.attachment = function(props, attachment) {
	            var image_size =  props.size;
	            var image_url = attachment.sizes[image_size].url;
                $("input[name='admin_bar[wp-logo][title]']").val('<img src="'+image_url+'">');
                wp.media.editor.send.attachment = send_attachment_bkp;

            }
            wp.media.editor.open();
            event.preventDefault();
            return false;
        });
    });

</script>