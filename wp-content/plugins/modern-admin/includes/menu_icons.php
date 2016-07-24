<?php
global $menu;



if ( is_plugin_active('admin-menu-editor/menu-editor.php') )
{
    $getCustomMenu = get_option("ws_menu_editor");

    $rawTree = isset($getCustomMenu['custom_menu']['tree']) ? $getCustomMenu['custom_menu']['tree'] : null;

    

    $aCustomMenu = array();

    if ( !empty($rawTree) && is_array($rawTree) )
    {
        foreach ($rawTree as $k => $kArray)
        {   
            
            if ( isset($kArray['custom']) && $kArray['custom'] )
            {
                $aCustomMenu[] =  $kArray;
            }
        }

    }

   
    
}



$Options = $this->getOptions();

if (isset($_POST['save_menu_icons']))
{
    $menu_icons=array();
    if(isset($_POST['menu_icons'])){
        foreach($_POST['menu_icons'] as $key => $value)
            $menu_icons[$key]=$value;
        $Options['menu_icons'] = $menu_icons;
        update_option($this->OptionsName, $Options);
    }

    if ( isset($_POST['custom_icon']) )
    {
        $custom_icon = array();
        foreach($_POST['custom_icon'] as $key => $value)
            $custom_icon[$key]=$value;
        $Options['custom_icon'] = $custom_icon;
        update_option($this->OptionsName, $Options);
    }

    if ( isset($_POST['custom_name']) )
    {
        $custom_name = array();
        foreach($_POST['custom_name'] as $key => $value)
            $custom_name[$key]=$value;
        $Options['custom_name'] = $custom_name;
        update_option($this->OptionsName, $Options);
    }
?>
<div class="updated"><p><strong><?php _e('Settings Updated',self::LANG);?></strong></p></div>
<?php
}
if (isset($_POST['reset_menu_icons'])){

    unset($Options['menu_icons']);
    unset($Options['custom_icon']);
  
    update_option($this->OptionsName, $Options);
    unset($Options['reset_menu_icons']);
?>
    <div class="updated"><p><strong><?php _e('Reset Ok',self::LANG);?></strong></p></div>
<?php
}
?>
<div class="wrap">
    <div class="icon32" id="icon-tools"><br></div><h2><?php _e('Menu Icons',self::LANG);?></h2>
    <form action="" method="post">

		<div class="clearfix">
			<table id="mordern-admin-icons-table" class="modern-table-left form-table" >
				<tbody>
				<?php
				if(isset($menu))
						foreach($menu as $item)
								if($item[4]!='wp-menu-separator' && !preg_match("/separator/i",$item[4]))
								{
										$name=$this->get_name($item[0]);

										if(preg_match("/menu-/i",$item[5])) $id=str_replace("menu-","menu-icon-",$item[5]);
										else{
    										$id=strtolower($name);
    										$id="menu-icon-".str_replace(" ","-",$id);
										}
                ?>
                        <tr valign="top">
                            <th scope="row"><label for="<?php echo $id;?>"><?php echo $name;?></label></th>
                            <td>
                                <a href="#">
                                    <i class="md-icon modern-admin-<?php echo $id;?> icon-star"></i>
                                    <input type="hidden" class="regular-text" value="<?php $v=(isset($Options['menu_icons'][$id]))? $Options['menu_icons'][$id]:''; echo $v;?>" id="<?php echo $id;?>" name="menu_icons[<?php echo $id;?>]">

                                </a>
                            </td>
                        </tr>
			 <?php
					}
				?>

            <?php 
                // wo: fix admin edit menu plugin

                if ( isset($aCustomMenu) && !empty($aCustomMenu) )
                {
                    foreach ($aCustomMenu as $k => $menuItem)
                    {
                        $id = isset($menuItem['file']) ? $menuItem['file'] : '';
                        $menuName = isset($menuItem['menu_title']) ? $menuItem['menu_title'] : '';
                        $v=(isset($Options['custom_icon'][$id]))? $Options['custom_icon'][$id]:'';
                        ?>
                        <tr valign="top">
                            <th scope="row"><label for="<?php echo $id;?>"><?php echo $menuItem['menu_title'];?></label></th>
                            <td>
                                <a href="#">
                                    <?php if (!empty($v)) : 
                                        $iContent = "\\" . $v;
                                    ?>
                                   
                                    <style type="text/css">
                                        .md-icon.wo-<?php echo $id ?>:before{
                                            content: "<?php echo $iContent ?>";
                                        }
                                    </style>
                                    <?php 
                                     endif; ?>
                                    <i class="md-icon wo-<?php echo $id; ?>  icon-star"></i>
                                    <input type="hidden" class="customicon regular-text" value="<?php $v=(isset($Options['custom_icon'][$id]))? $Options['custom_icon'][$id]:''; echo $v;?>" id="<?php echo $id;?>" name="custom_icon[<?php echo $id;?>]">
                                   
                                </a>
                                 <input type="hidden" class="customname" name="custom_name[<?php echo $id ?>]" value="<?php  echo $menuName ?>">
                            </td>
                        </tr>
                        <?php
                    }
                }
            ?>    
		
				</tbody>
			</table>
			<?php include("icons_list.php");?>
		</div>
    <p class="submit">
        <input type="submit" value="<?php _e('Save Changes',self::LANG);?>" class="button button-primary" id="save_menu_icons" name="save_menu_icons">
        <input type="submit" value="<?php _e('Reset',self::LANG);?>" class="button button-primary" name="reset_menu_icons">
    </p>
    </form>
</div>
