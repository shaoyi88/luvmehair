<?php

/*
Plugin Name: Modern Admin
Plugin URI: http://wpprime.com
Description: Modern Admin Theme
Author: WPPrime
Version: 1.16.5
Author URI: http://wpprime.com
*/





if(!function_exists('wp_get_current_user')) {
	include("includes/pluggable.min.php");
}
add_action('init','obtain_user',1,1);
function obtain_user(){
	global $current_user;
	$user_role = $current_user;
	if(class_exists("modern_admin_ui")){
		$modern_admin_ui= new modern_admin_ui($user_role);
	}
}


class modern_admin_ui{
	const LANG = 'modern-admin';
	public $suffix;
	public $pluginURL;
	public $OptionsName = "modern-admin-option";
	public $LicenseName = "modern_admin_license";
	public $color;
	public $admin_bar;
    public $admin_bar2;
	public $string_notice;
	public $slug;
	public $turnon;
	public $remote_path = "http://update.wpprime.com/index.php";
	public $user_current_role;
	public function __construct($user_role){

		// fix admin-edit-menu

		if ( !function_exists('is_plugin_active') )
		{
			 include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		if ( is_plugin_active('admin-menu-editor/menu-editor.php') )
		{
			add_action('admin_enqueue_scripts', array($this, 'wo_load_font_awesome'));

		}

		$this->user_current_role = $user_role;

		list ($t1, $t2) = explode('/', plugin_basename(__FILE__));
		$this->slug = str_replace('.php', '', $t2);
		//add_action('init',array($this,'get_data_user_role'),1);
		$option=$this->getOptions();
		if(isset($_POST['settings']['color'])) $this->color=$_POST['settings']['color'];
		else {
			$this->color=(isset($option['settings']['color']))?$option['settings']['color']:0;
		}
		if(isset($_POST['reset_modern_settings']) || isset($_POST['reset_settings'])) $this->color='0';
		if (isset($_POST['save_modern_settings']) && !isset($_POST['settings']['turnon'])) $this->turnon=0;
		elseif(isset($_POST['reset_settings'])) $this->turnon=1;
		elseif(isset($_POST['settings']['turnon'])) $this->turnon=$_POST['settings']['turnon'];
		else {
			$this->turnon=(isset($option['settings']['turnon']))?$option['settings']['turnon']:1;
		}

		$this->pluginURL = plugins_url().'/'.str_replace(basename( __FILE__ ),"",plugin_basename( __FILE__ ) );
		$this->suffix=defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		add_action('init', array($this,'load_language'));
		add_action('admin_menu', array($this,'register_modern_admin_menu' ));
		//

		if($this->turnon){

			//if($this->check_license()){
			add_action('init', array($this,'auto_check_update'));
            if($this->check_role()){
                add_action('wp_before_admin_bar_render' , array( $this , 'admin_bar_default_load' ) , 1 );
                add_action('wp_before_admin_bar_render' , array( $this , 'update_admin_bar' ) , 100 );
                if(is_admin()){
                    if ($GLOBALS['pagenow'] != 'customize.php'){
                        add_action('init',array($this,'update_default_url'),100);
                        add_action('init',array($this,'remove_default_stylesheets'));
                        add_action('admin_print_styles', array($this,'loading_css'),19);
                        add_action('admin_enqueue_scripts', array($this,'loading_js'),18);
                        remove_action('wp_default_styles', 'wp_default_styles' );              // removes the default wp_default_styles function
                        add_action('wp_default_styles', array($this,'modern_admin_wp_default_styles') ); // adds our customized modern_admin_wp_default_styles function
                        add_action('admin_menu', array($this,'new_menus'),9999);
                        add_action('admin_head',array($this,'generate_dashboard_icons'),1000);
                        add_action('admin_head',array($this,'generate_menu_icons'),100);
                        add_action('admin_head',array($this,'generate_custom_color'),101);
                        add_action('admin_footer',array($this,'generate_admin_logo'));
                        add_action('admin_footer',array($this,'generate_custom_css'),100);
                        add_filter('update_footer', array($this,'update_version_footer'), 100);
                        add_filter('admin_footer_text', array($this,'update_admin_footer'));
                        add_action('wp_dashboard_setup', array($this,'add_dashboard_widgets'),10);
                        add_action('wp_dashboard_setup', array($this,'get_dashboard_widgets') ,100);
                        add_action('wp_dashboard_setup', array($this,'hide_dashboard_widgets'),101);
                        if(isset($option['dashboard_welcome_widget']['show']) && $option['dashboard_welcome_widget']['show']==0)
                            remove_action('welcome_panel', 'wp_welcome_panel');
                        add_filter('admin_body_class', array($this,'add_admin_body_class'),50);
                        add_action('wp_ajax_export_modern_admin', array( $this , 'export_modern_admin_callback' ) );
                    }
                }
                add_action('wp_print_styles', array($this,'wp_admin_bar_style'),99999);
                if($this->color=='custom'&& is_user_logged_in())
                    add_action('wp_head',array($this,'generate_wp_admin_bar_custom_color'));
			}
			if($this->is_login()){
				if(!isset($option['login_screen']['active'])||(isset($option['login_screen']['active']) && $option['login_screen']['active']=='1')){
                    add_action( 'style_loader_tag', create_function( '$a', "return null;" ) );
                    add_action('init',array($this,'remove_default_stylesheets'));
					add_action('login_head', array($this,'generate_login_bg'),10);
					add_filter('login_headertitle' , array( $this , 'login_logo_title' ) );
					add_action('login_head' , array( $this , 'login_logo_image' ) );
					add_filter('login_headerurl', array( $this , 'login_logo_url' ) );
					add_filter('bloginfo',array($this,'login_logo_text'),10,2);
					add_action('login_footer',array($this,'login_footer_text'));
					// add script + css
					add_action('login_enqueue_scripts', array($this,'modern_admin_login_css'));
					add_action('login_footer', array($this,'modern_admin_login_js'));
					if(isset($option['login_screen']['lost_password']) && $option['login_screen']['lost_password']=='1')
						add_filter( 'gettext', array($this,'remove_lostpassword_text' ));
					if(isset($option['login_screen']['back_to']) && $option['login_screen']['back_to']=='1')
						add_filter( 'gettext', array($this,'remove_backto_text' ));
                    add_action('login_head' , array( $this , 'remove_login_text'),100);
				}

			}

		}

		

	}

	public function wo_load_font_awesome()
	{	
		
		wp_enqueue_style( 'wo-load-fa', plugin_dir_url(__FILE__) . 'assets/fonts/css/font-awesome.min.css' );
	}

    /*
         * Get User Roles
         */
    public function get_current_user_roles(){

        global $current_user;
        require_once(ABSPATH . 'wp-includes/pluggable.php');
        if(is_multisite()){
            $this->user_current_role = $current_user->roles;
        }else{
            $user_roles = $current_user->roles;
            $this->user_current_role = array_shift($user_roles);

        }

    }
    public function get_user_role() {
        $editable_roles = get_editable_roles();
        foreach ( $editable_roles as $role => $details ) {
            $editable_roles[$role]["label"] = translate_user_role( $details['name'] );
        }

        return $editable_roles;
    }
	/**
	 * Check User
	 **/

	public function check_role()
	{
        $Options = $this->getOptions();
        if(isset($_POST['user_roles'])){
            $userroles= array();
            foreach($_POST['user_roles'] as $key => $value){
                $userroles[$key]=stripslashes($value);
            }
            $Options['user_roles'] = $userroles;
            update_option($this->OptionsName, $Options);
        }
        if(!isset($Options['user_roles']) || empty($Options['user_roles']) || isset($_POST['reset_settings']) || isset($_POST['reset_modern_settings']))
            return true;
        else{

            $user_roles = $this->user_current_role->roles;
            $current_role = array_shift($user_roles);
            if (isset($Options['user_roles'][$current_role])&&($Options['user_roles'][$current_role]==1) )
                return true;
            else return false;

        }

	}

	/*
	 * License
	 */
	public function get_license(){

		$default_modern_admin_license = array('license' => '',
			'status' => false,
			'date' => time(),
		);
		$modern_admin_license = get_option($this->LicenseName);
		if (!empty($modern_admin_license)) {
			foreach ($modern_admin_license as $key => $option)
				$default_modern_admin_license[$key] = $option;
		}
		update_option($this->LicenseName, $default_modern_admin_license);
		return $default_modern_admin_license;
	}

	public function check_license(){
		$now=time();
		$license=$this->get_license();
		$start_time = $license['date'];
		$days = round(($now - $start_time)/(60*60*24));
		$until = 15 - $days;
		if($license['status']==false && $days>=15){
			$this->string_notice="Please enter your license key <a href=\"admin.php?page=modern-admin-license\">here</a> to continue using Modern Admin plugin.";
			add_action( 'admin_notices', array($this,'admin_notice') );
			return false;
		}

		if($license['status']==false && $days<15)
		{
			$this->string_notice="You have ".$until." days for trial. Please enter your license key at <a href=\"admin.php?page=modern-admin-license\">here</a>.";
			add_action( 'admin_notices', array($this,'admin_notice') );
			return true;
		}

		if($license['status']==true) return true;
	}

	public function admin_notice(){
		?>
		<div class="updated">
			<p><?php _e( $this->string_notice, self::LANG ); ?></p>
		</div>
	<?php
	}

	public function modern_admin_license_page(){
		include_once('includes/license.php');
	}

	public function auto_check_update(){
		if ( is_admin() ) {
			require_once ('wp_autoupdate.php');
			$license=$this->get_license();
			if(!empty($license['license'])){
				if ( ! function_exists( 'get_plugin_data' ) )
					require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				$current_plugin = get_plugin_data( __FILE__, $markup = true, $translate = true );
				$current_version = $current_plugin['Version'];
				$plugin_slug = plugin_basename(__FILE__);
				new modern_admin_auto_update ($license['license'],$current_version, $this->remote_path, $plugin_slug);
			}
		}
	}
	/*
	 * Generate custom color
	 */
	public function generate_custom_color(){
		$Options = $this->getOptions();
		if(isset($_POST['settings'])){
			foreach($_POST['settings'] as $key => $value){
				$settings[$key]=stripslashes($value);
			}
			$Options['settings'] = $settings;
		}
		if(isset($Options['settings']['color']) && $Options['settings']['color']=='custom'){
			include("includes/custom_color.php");
		}
	}
    public function generate_wp_admin_bar_custom_color(){
        $Options = $this->getOptions();
        $field = "main_color";
        $main_color = (isset($Options['settings']['custom_color_'.$field]))?$Options['settings']['custom_color_'.$field]:'';

        $css="<style>\n";
        $css.="#wpadminbar,
#wpadminbar .ab-top-menu > li:hover > .ab-item,
#wpadminbar .ab-top-menu > li.hover > .ab-item,
#wpadminbar .ab-top-menu > li > .ab-item:focus,
#wpadminbar.nojq .quicklinks .ab-top-menu > li > .ab-item:focus,
#wpadminbar.nojs .ab-top-menu > li.menupop:hover > .ab-item,
#wpadminbar .ab-top-menu > li.menupop.hover > .ab-item,
#wpadminbar .quicklinks .menupop .ab-item:focus,
#wpadminbar .quicklinks .ab-top-menu .menupop .ab-item:focus {
    background: {$main_color};
}
/* Auto-folding of the admin menu */
@media only screen and (max-width: 900px) {
    #adminmenu .wp-submenu .wp-submenu-head,
    #adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head { background: $main_color}
}";
        $css.="</style>";
        echo $css;
    }
	/*
	 * admin bar
	 */
	public function wp_admin_bar_style(){
		if ( is_user_logged_in() ){
			global $wp_version;
	        if(preg_match('/-/i',$wp_version)) {
	            $version = explode('-',$wp_version);
	            $version = $version[0];
	        }else $version = $wp_version;

            $Options = $this->getOptions();
            $font = (isset($Options['admin_bar_font']))?$Options['admin_bar_font']:'awesome';
            if($font == 'awesome')
                wp_enqueue_style('modern-admin-font', $this->pluginURL."assets/fonts/css/font-awesome$this->suffix.css", false, '1.0');
            else wp_enqueue_style('modern-admin-fontello', $this->pluginURL."assets/fonts/css/fontello.css", false, '1.0');
            if (version_compare($version, '3.8', '>='))
            	wp_enqueue_style('modern-wpadminbar3', $this->pluginURL."assets/css/colors/adminbar-38.css", false, '1.0');
            else
            	wp_enqueue_style('modern-wpadminbar3', $this->pluginURL."assets/css/colors/adminbar.css", false, '1.0');
            wp_enqueue_style('modern-wpadminbar', $this->pluginURL."assets/css/colors/adminbar-front.css", false, '1.0');

            if($this->color!='custom' && $this->color!='0')
                wp_enqueue_style('modern-wpadminbar2', $this->pluginURL."assets/css/colors/adminbar-".$this->color.".css", false, '1.0');
            elseif($this->color=='0')
                wp_enqueue_style('modern-wpadminbar2', $this->pluginURL."assets/css/colors/adminbar-blue.css", false, '1.0');
        }


    }

	public function remove_default_stylesheets() {
		global $pagenow;
		// if('customize.php' != $pagenow)
		// 	wp_deregister_style('wp-admin');
	}

	public function load_language() {
		$path = dirname(plugin_basename( __FILE__ )) . '/languages/';
		$loaded = load_plugin_textdomain( 'modern-admin', false, $path);

	}

	public function is_login() {
		$login_page = array( 'wp-login.php', 'wp-register.php' );
		if ( is_multisite() ) {
			foreach($login_page as $page)
				if(preg_match("/{$page}/i",$_SERVER['PHP_SELF'])) return true;
			return false;
		}
		return in_array( $GLOBALS['pagenow'], $login_page );
	}

	public function loading_js(){
		wp_enqueue_script('jquery');
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_media();
		wp_enqueue_script('media-upload');

		wp_deregister_script('admin-bar');

		wp_enqueue_script('admin-bar', $this->pluginURL.'assets/js/script.js', array("jquery"), null, false);
		wp_enqueue_script('modern-setting-script', $this->pluginURL.'assets/js/settings.js', array("jquery"), null, false);
	}

	public function loading_css(){
		global $wp_version;
        if(preg_match('/-/i',$wp_version)) {
            $version = explode('-',$wp_version);
            $version = $version[0];
        }else $version = $wp_version;
         wp_register_style('modern-admin-buttonrtl', plugin_dir_url(__FILE__)  . 'assets/css/buttons-rtl.css');
		wp_enqueue_style('modern-admin-buttonrtl');
        wp_register_style('modern-admin-button', plugin_dir_url(__FILE__)  . 'assets/css/buttons.css');
		wp_enqueue_style('modern-admin-button');
		// Moderm admin Style
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_style('modern-admin-font', $this->pluginURL."assets/fonts/css/font-awesome$this->suffix.css", false, '1.0');
		//wp_enqueue_style('modern-admin-fontello', $this->pluginURL."assets/fonts/css/fontello.css", false, '1.0');
		wp_enqueue_style('customized-modern', $this->pluginURL."assets/css/modern-style.css", false, '1.0');
		
		wp_enqueue_style('modern-admin-custom', $this->pluginURL."assets/css/modern-admin.css", false, '1.0');

		if (version_compare($version, '3.8', '>=')) {
			//fix css wp 3.8
	        wp_deregister_style('admin-bar');
	        wp_deregister_style('wp-admin');
	        wp_deregister_style('dashicons');
	        wp_deregister_style('buttons');
			wp_enqueue_style('dashicons-38', site_url()."/wp-includes/css/dashicons.css", false, '1.0');
			wp_enqueue_style('mediaview-38', site_url()."/wp-includes/css/media-views.min.css", false, '1.0');
			wp_enqueue_style('adminbar-38', $this->pluginURL."/assets/css/adminbar-38.css", false, '1.0');
		} else {
			wp_enqueue_style('modern-admin-admin-bar', $this->pluginURL."assets/css/adminbar.css", false, '1.0');
		}

		if (version_compare($version, '3.9', '>=')) {
			wp_enqueue_style('modern-admin-39', $this->pluginURL."/assets/css/modern-admin-39.css", false, '1.0');
		}

		if($this->color!='0' && $this->color!='custom')
			wp_enqueue_style('modern-admin-color', $this->pluginURL."assets/css/colors/".$this->color.".css", false, '1.0');

		if ( is_rtl() )
			wp_enqueue_style('modern-admin-rtl', $this->pluginURL."assets/css/rtl.css", false, '1.0');
		if (version_compare($wp_version, '3.6', '>=') && version_compare($wp_version, '3.8', '<='))
			wp_enqueue_style('modern-admin-36', $this->pluginURL."assets/css/modern-admin-36.css", false, '1.0');
		if (version_compare($version, '3.8', '>=')&&version_compare($version, '3.9', '<'))
			wp_enqueue_style('modern-admin-38', $this->pluginURL."assets/css/modern-admin-38.css", false, '1.0');
	}
	public function modern_admin_login_css(){
        global $wp_version;
		if (version_compare($wp_version, '3.9', '>='))
			echo '<link rel="stylesheet" id="modern-admin-login-3.9"  href="'.$this->pluginURL."assets/css/login-styles-3.9.css".'" type="text/css" media="all" />'."\n";
			echo '<link rel="stylesheet" id="modern-admin-login"  href="'.$this->pluginURL."assets/css/login-styles.css".'" type="text/css" media="all" />';
		if($this->color!='0')
		echo '<link rel="stylesheet" id="modern-admin-color"  href="'.$this->pluginURL."assets/css/colors/".$this->color.'.css" type="text/css" media="all" />';
	}
	

	public function modern_admin_login_js(){
		// admin login
        echo "<script type='text/javascript' src='".$this->pluginURL."assets/js/login.js'></script>";
//		wp_enqueue_script('modern-admin-login', $this->pluginURL."assets/js/login.js", false, '1.0');
	}

	/** get list dash widget */
	public function get_dashboard_widgets() {
		global $wp_meta_boxes, $wpdb;

		if (current_user_can('administrator') && is_array($wp_meta_boxes['dashboard'])) {
			$id_registered_dash_widget=array();

			foreach(array('normal','side','column3','column4') as $context){
				if(isset($wp_meta_boxes['dashboard'][$context]))
					foreach ( array('high', 'sorted', 'core', 'default', 'low') as $priority ) {
						if(isset($wp_meta_boxes['dashboard'][$context][$priority]))
							foreach ( (array) $wp_meta_boxes['dashboard'][$context][$priority] as $box ) {
								if(!in_array($box['id'],$id_registered_dash_widget))
									array_push($id_registered_dash_widget,$box['id']);
							}
					}
			}
			update_option($wpdb->prefix.'modern_admin_dashboard_widget_registered', $id_registered_dash_widget);
		}
	}

	public function hide_dashboard_widgets(){
		$Options = $this->getOptions();

		global $wp_meta_boxes;

		if (is_admin() && is_array($wp_meta_boxes['dashboard'])) {

			foreach(array('normal','side','column3','column4') as $context){
				if(isset($wp_meta_boxes['dashboard'][$context]))
					foreach ( array('high', 'sorted', 'core', 'default', 'low') as $priority ) {
						if(isset($wp_meta_boxes['dashboard'][$context][$priority]))
							foreach ( (array) $wp_meta_boxes['dashboard'][$context][$priority] as $box ) {

								if(isset($Options['dashboard_icons'][$box['id']]['show']) && $Options['dashboard_icons'][$box['id']]['show']==0)
									remove_meta_box( $box['id'], 'dashboard', $context );
								if($box['id']=='custom_db_widget' && !isset($Options['dashboard_icons'][$box['id']]['show']))
									remove_meta_box( $box['id'], 'dashboard', $context );
                                if($box['id']=='custom_rss_db_widget' && !isset($Options['dashboard_icons'][$box['id']]['show']))
                                    remove_meta_box( $box['id'], 'dashboard', $context );
							}
					}
			}

		}
	}

	/** option */
	public function update_default_url(){
		global $wpdb;
		$default_url = get_option($wpdb->prefix.'modern_admin_default_url');
		//var_dump(get_site_url());

		if($default_url==false)
			update_option($wpdb->prefix.'modern_admin_default_url', get_site_url());
		else{
			$current_url = get_site_url();
			if($default_url!=$current_url){
				$this->new_replace($default_url,$current_url);

			}
		}
	}
	public function new_replace($default_url,$current_url){
		global $wpdb;
		$option = $this->getOptions();
		$replaces = array("settings"=>"admin_logo_image"
		,"login_screen"=>"image","login_screen"=>"background");
		foreach($replaces as $k=>$v){
			if(isset($option[$k][$v]) && $option[$k][$v]!='')
			{
				$option[$k][$v] = str_replace($default_url,$current_url,$option[$k][$v]);
			}
			if(isset($option['admin_bar']) && is_array($option['admin_bar']))
				foreach($option['admin_bar'] as $node_id=>$node){
					if(isset($option['admin_bar'][$node_id]['href']))
						$option['admin_bar'][$node_id]['href'] = str_replace($default_url,$current_url,$option['admin_bar'][$node_id]['href']);
				}

		}
		update_option($this->OptionsName,$option);
		update_option($wpdb->prefix.'modern_admin_default_url', $current_url);


	}
	public function getOptions() {
		$ModernOptions=array();
		$Options = get_option($this->OptionsName);

		if (!empty($Options)) {
			foreach ($Options as $key => $option)
				$ModernOptions[$key] = $option;
		}
		else update_option($this->OptionsName, $ModernOptions);

		return $ModernOptions;
	}

	/** admin menu */
	public function register_modern_admin_menu(){
		add_menu_page( 'Modern Admin', 'Modern Admin', 'manage_options', 'modern-admin-ui-settings', array($this,'modern_admin_ui_setting_page'), '' );
		add_submenu_page( 'modern-admin-ui-settings', 'Settings', 'Settings', 'manage_options', 'modern-admin-ui-settings', array($this,'modern_admin_ui_setting_page') );
		if($this->turnon){
			add_submenu_page( 'modern-admin-ui-settings', 'Admin Bar', 'Admin Bar', 'manage_options', 'modern-admin-bar', array($this,'modern_admin_bar') );
			$menuIcon = add_submenu_page( 'modern-admin-ui-settings', 'Menu Icons', 'Menu Icons', 'manage_options', 'modern-admin-menu-icons', array($this,'modern_admin_menu_icons') );

			

			add_submenu_page( 'modern-admin-ui-settings', 'Dashboard Settings', 'Dashboard Settings', 'manage_options', 'modern-admin-dashboard-icons', array($this,'modern_admin_dashboard_icons') );
			add_submenu_page( 'modern-admin-ui-settings', 'Login Screen', 'Login Screen', 'manage_options', 'modern-admin-login-screen', array($this,'modern_admin_login_screen') );
			add_submenu_page( 'modern-admin-ui-settings', 'Import/Export', 'Import/Export Settings', 'manage_options', 'modern-admin-import-export', array($this,'modern_admin_import_export') );
			add_submenu_page( 'modern-admin-ui-settings', 'License', 'License Settings', 'manage_options', 'modern-admin-license', array($this,'modern_admin_license_page') );

		}
	}


	public function modern_admin_ui_setting_page(){
		include("includes/settings.php");
	}

	/** menu icons */
	public function new_menus(){
		global $menu;
		//var_dump($menu);
		$new_menu=array();
		foreach($menu as $item){
			if($item[4]!='wp-menu-separator' && !preg_match("/separator/i",$item[4])){

				$name=$this->get_name($item[0]);
				//var_dump($item);
				if(preg_match("/menu-/i",$item[5])) $id=str_replace("menu-","menu-icon-",$item[5]);
				else{
					$id=strtolower($name);
					$id="menu-icon-".str_replace(" ","-",$id);
				}
				if(isset($item[4]) && $item[4]!=''){
					if(!preg_match("/".$id."/i",$item[4])){
						$item[4].=" ".$id;
					}
				}else $item[4]=$id;

			}
			array_push($new_menu,$item);
		}
		$menu=$new_menu;
	}

	public function generate_menu_icons(){
		if(!isset($_POST['reset_menu_icons'])){
			global $menu;
			$ids=array();
			if(is_array($menu))
				foreach($menu as $item)
					if($item[4]!='wp-menu-separator' && !preg_match("/separator/i",$item[4]) )
					{
						$name=$this->get_name($item[0]);
						if(preg_match("/menu-/i",$item[5])) $id=str_replace("menu-","menu-icon-",$item[5]);
						else{
							$id=strtolower($name);
							$id="menu-icon-".str_replace(" ","-",$id);
						}
						array_push($ids,$id);
					}
			$Options = $this->getOptions();

			if(isset($_POST['menu_icons'])){
				$menu_icons=array();
				foreach($_POST['menu_icons'] as $key => $value)
					$menu_icons[$key]=$value;
				$Options['menu_icons'] = $menu_icons;
			}

			$style="<style type=\"text/css\">\n";
			if(is_array($ids) && count($ids)>0)
				foreach($ids as $i){
					if(isset($Options['menu_icons'][$i]) && $Options['menu_icons'][$i]!='')
					{
						$style.=".".$i. " .wp-menu-image:before, .modern-admin-" .$i. ":before{content: \"\\".$Options['menu_icons'][$i]."\" !important;}\n";
					}
						
				}
			$style.="</style>\n";
			echo $style;
		}

	}
	private function get_name($key){
		if(preg_match("/<span/",$key)){
			$key=explode("<",$key);
			return $key[0];
		}
		return strip_tags($key);

	}
	public function modern_admin_menu_icons() {
		include("includes/menu_icons.php");
	}
	/** dashboard icons */
	public function modern_admin_dashboard_icons() {
		include('includes/dashboard_icons.php');
	}

	public function generate_dashboard_icons(){
		$Options = $this->getOptions();

		if(isset($_POST['dashboard_icons'])){
			$dashboard_icons=array();
			foreach($_POST['dashboard_icons'] as $key => $value)
				$dashboard_icons[$key]=$value;
			$Options['dashboard_icons'] = $dashboard_icons;
		}
		$style="";
		if(isset($Options['dashboard_icons']) && is_array($Options['dashboard_icons'])){
			$style="<style type=\"text/css\">\n";
			foreach(array_keys($Options['dashboard_icons']) as $i){
				if(isset($Options['dashboard_icons'][$i]['icon']) && $Options['dashboard_icons'][$i]['icon']!='')
					$style.="#".$i. " .hndle > span:before, .modern-admin-".$i. ":before {content: \"\\".$Options['dashboard_icons'][$i]['icon']."\" !important;}\n";
			}
			$style.="</style>\n";
		}
		




		if ( isset($Options['custom_name']) && is_array($Options['custom_name'] )   )
		{
			$getAllKey = ($Options['custom_name']);
	
			$aCustomMenu = array();
			$aCustomIcon = array();

			$style .="<script type=\"text/javascript\">\n";
			$style .= 'jQuery(document).ready(function(){';	
			foreach ($getAllKey as $k =>$kName)
			{
				
				// if (!empty($Options['menu_icons'][$kName]))
				// {
					
					// $style.=".".$i. " .wp-menu-image:before, .modern-admin-" .$i. ":before{content: \"\\".$Options['menu_icons'][$i]."\" !important;}\n";

				// 	$iconCode = isset($_POST['menu_icons'][$kName])  ? $_POST['menu_icons'][$kName] : $Options['menu_icons'][$kName];

				// 	$style .= ".menu-top a.menu-top[href^='".$kName."']" . " .wp-menu-image.dashicons-before:before{content: \"\\".$iconCode."\" !important;}\n";
				
				// }

				if ( !isset($_POST['custom_icon']) || ( isset($Options['custom_icon'][$k]) && !empty($Options['custom_icon'][$k]) ) )
				{
					$kName = stripslashes(ltrim($kName));
					$addClass = 'wo_fix_' . $k;
					$aCustomMenu[] = $addClass;
					$aCustomIcon[] =  !isset($_POST['custom_icon'][$k]) ? $Options['custom_icon'][$k] : $_POST['custom_icon'][$k];
					$icon = $Options['custom_icon'][$k];
					$style .= "(jQuery(\".wp-not-current-submenu div.wp-menu-name:contains('".$kName."')\").siblings('.wp-menu-image.dashicons-before')).addClass('".$addClass."');" . "\n";
				}

				
			}
			$style .= '})';
			$style.="</script>\n";


			if ( !empty($aCustomMenu) )
			{
				$style .= "<style type=\"text/css\">\n";
				foreach ($aCustomMenu as $ka => $className)
				{
					$style .= ".menu-top .wp-menu-image.dashicons-before.".$className.":before{content: \"\\".$aCustomIcon[$ka]."\" !important;}\n";
				}
				$style .= "</style>\n";
			}

		}

		// if (isset($_POST['reset_menu_icons'])) unset($_POST['reset_menu_icons']);

		echo $style;

	}

	/** end admin menu */
	/** admin style */
	public function modern_admin_wp_default_styles( &$styles ) {
		if ( ! $guessurl = site_url() )
			$guessurl = wp_guess_url();
		$styles->base_url = $guessurl;
		$styles->content_url = defined('WP_CONTENT_URL')? WP_CONTENT_URL : '';
		$styles->default_version = get_bloginfo( 'version' );
		$styles->text_direction = function_exists( 'is_rtl' ) && is_rtl() ? 'rtl' : 'ltr';
		$styles->default_dirs = array('/wp-admin/', '/wp-includes/css/');
		$rtl_styles = array( 'wp-admin', 'ie', 'media', 'admin-bar', 'customize-controls', 'media-views', 'wp-color-picker' );
		$no_suffix = array( 'farbtastic' );
		$styles->add( 'wp-admin', "/wp-admin/css/wp-admin$this->suffix.css" );
		$styles->add( 'ie', "/wp-admin/css/ie$this->suffix.css" );
		$styles->add_data( 'ie', 'conditional', 'lte IE 7' );
		$styles->add( 'colors', true, array('wp-admin', 'buttons') );
		$styles->add( 'media', "/wp-admin/css/media$this->suffix.css" );
		$styles->add( 'install', "/wp-admin/css/install$this->suffix.css", array('buttons') );
		$styles->add( 'thickbox', '/wp-includes/js/thickbox/thickbox.css', array(), '20121105' );
		$styles->add( 'farbtastic', '/wp-admin/css/farbtastic.css', array(), '1.3u1' );
		$styles->add( 'wp-color-picker', "/wp-admin/css/color-picker$this->suffix.css" );
		$styles->add( 'jcrop', "/wp-includes/js/jcrop/jquery.Jcrop.min.css", array(), '0.9.10' );
		$styles->add( 'imgareaselect', '/wp-includes/js/imgareaselect/imgareaselect.css', array(), '0.9.8' );
		$styles->add( 'admin-bar', "/wp-includes/css/admin-bar$this->suffix.css" );
		$styles->add( 'wp-jquery-ui-dialog', "/wp-includes/css/jquery-ui-dialog$this->suffix.css" );
		$styles->add( 'editor-buttons', "/wp-includes/css/editor$this->suffix.css" );
		$styles->add( 'wp-pointer', "/wp-includes/css/wp-pointer$this->suffix.css" );
		$styles->add( 'customize-controls', "/wp-admin/css/customize-controls$this->suffix.css", array( 'wp-admin', 'colors', 'ie' ) );
		$styles->add( 'media-views', "/wp-includes/css/media-views$this->suffix.css", array( 'buttons' ) );
		$styles->add( 'buttons', $this->pluginURL.'assets/css/buttons.css' );
		foreach ( $rtl_styles as $rtl_style ) {
			$styles->add_data( $rtl_style, 'rtl', true );
			if ( $this->suffix && ! in_array( $rtl_style, $no_suffix ) )
				$styles->add_data( $rtl_style, 'suffix', $this->suffix );
		}
	}

	/** Login Screen */
	public function generate_login_bg(){
		$Options=$this->getOptions();
		$img=(isset($Options['login_screen']['background']))?$Options['login_screen']['background']:'';
        $fullpage = (isset($Options['login_screen']['fullpage']))?$Options['login_screen']['fullpage']:false;
		$color=(isset($Options['login_screen']['bg-color']))?$Options['login_screen']['bg-color']:'';
        $button_bgcolor = (isset($Options['login_screen']['button_bgcolor']))?$Options['login_screen']['button_bgcolor']:'';
        $button_textcolor = (isset($Options['login_screen']['button_textcolor']))?$Options['login_screen']['button_textcolor']:'';
        $button_bordercolor = (isset($Options['login_screen']['button_bordercolor']))?$Options['login_screen']['button_bordercolor']:'';
		if($img!='' || $color!='' || $button_bgcolor!='' || $button_textcolor!='' || $button_bordercolor!=''){
			$style="<style>\n";
			if($color!='') $style.="html {background-color:".$color.";}";
			$style.="body.login {\n";

			if($color!='') $style.="background-color:".$color.";\n";
			if($img!='') {
                $style.="background-image:url('".$img."');\n";
                $style.="position:fixed !important;";
                $style.="position:absolute;";
                $style.="top:0;";
                $style.="right:0;";
                $style.="bottom:0;";
                $style.="left:0;";
            };
            if($fullpage) $style.="background-size:cover;\n";
			if(!empty($Options['login_screen']['bg-repeat'])) $style.="background-repeat:".$Options['login_screen']['bg-repeat'].";\n";
			if(!empty($Options['login_screen']['bg-position'])) $style.="background-position:".$Options['login_screen']['bg-position'].";\n";
			$style.="}\n";
            if($button_bgcolor!='' || $button_textcolor!='' || $button_bordercolor!=''){
                $style .= "#wp-submit{\n";
                if($button_bordercolor!='')
                    $style .="border-color: ".$button_bordercolor. "!important;\n";
                if($button_bgcolor!='')
                    $style .="background-color: ".$button_bgcolor." !important;\n";
                if($button_textcolor!='')
                    $style .="color: ".$button_textcolor. "!important;\n";

                $style .= "}\n";
            }


			$style.="</style>";
			echo $style;
		}else echo '';

	}
	public function modern_admin_login_screen(){
		include('includes/login_screen.php');
	}
	public function login_logo_image() {
		$Options=$this->getOptions();
		if(isset($Options['login_screen']))

			if(!empty( $Options['login_screen']['image'] ) && $Options['login_screen']['image']!='' ) {
                $size = isset($Options['login_screen']['height']) ? $Options['login_screen']['height'] : 1024;
                
               
                if ( function_exists('getimagesize') && function_exists('curl_version')  )
                {
                	$size = getimagesize($Options['login_screen']['image']);
                	$size = $size[1];
                }

                $script = "<style>#login h1{background-image: url(\"".$Options['login_screen']['image']."\");
                    background-position: center center;
                    background-repeat: no-repeat;
                    height:{$size}px;
                    margin-bottom: 20px;
                }
                .login h1 a{
                   display: block;
                    height: 100%;
                    margin: 0;
                    padding: 0;
                    text-indent: -9999px;
                    width: 100%;
                }
                </style>";
//				$script="<script>\n";
//				$script.="var link=\"".$Options['login_screen']['image']."\";\n";
//				$script.="</script>";
				echo $script;
			}
	}

	public function login_logo_title(){
		$Options=$this->getOptions();
		$title = __( 'Powered by WordPress', self::LANG );
		if(isset($Options['login_screen']))
			if(!empty( $Options['login_screen']['title'] ) && $Options['login_screen']['title'] !='') {
				$title = strip_tags( $Options['login_screen']['title']  );

			}
		return $title;
	}

	public function login_logo_url(){
		$Options=$this->getOptions();
		$url = __( 'http://wordpress.org', self::LANG);
		if(isset($Options['login_screen']))
			if(!empty( $Options['login_screen']['url']  ) && $Options['login_screen']['url']!='') {
				$url = strip_tags( $Options['login_screen']['url']  );
			}
		return $url;
	}

	public function login_logo_text($content,$show){
		$Options=$this->getOptions();
		if(isset($Options['login_screen']['text']))
			if($Options['login_screen']['text']!='' && ($Options['login_screen']['image']=='' || empty( $Options['login_screen']['image'] )) ) {
				if ($show == 'name'){
					$content = $Options['login_screen']['text'];
				}
			}
		return $content;
	}

	public function login_footer_text(){
		$Options=$this->getOptions();
		$text='';
		if(isset($Options['login_screen']))
			if(!empty( $Options['login_screen']['footer_text'] )) {

				$text = "<div id=\"footer_text\">".$Options['login_screen']['footer_text']."</div>";

			}
		echo $text;
	}
	public function remove_lostpassword_text ( $text ) {
		if ($text == 'Lost your password?'){$text = '';}
		return $text;
	}
	public function remove_backto_text ( $text ) {
		if (preg_match("/Back to/i",$text)){$text = '';}
		return $text;
	}
    public function remove_login_text(){
        $option=$this->getOptions();
        if(isset($option['login_screen']['lost_password']) || isset($option['login_screen']['back_to']) || isset($option['login_screen']['remember_me'])){
            $css="<style>\n";
            if(isset($option['login_screen']['lost_password']) && $option['login_screen']['lost_password']=='1')
                $css.=".login #nav { display:none; }\n";
            if(isset($option['login_screen']['back_to']) && $option['login_screen']['back_to']=='1')
                $css.=".login #backtoblog { display:none; }\n";
            if(isset($option['login_screen']['remember_me']) && $option['login_screen']['remember_me']=='1')
                $css.=".forgetmenot { display:none; }\n";
            $css.="</style>";
            echo $css;
        }

    }

	/*** admin logo **/
	public function generate_admin_logo(){
		$Options=$this->getOptions();
		$html='';
		if(!empty($Options['settings']['admin_logo_image']) || !empty($Options['settings']['admin_logo_text'])){
			$html="<div id=\"modern-admin-logo\">";
			$html.="<a href=\"".$Options['settings']['admin_logo_url']."\">";
			if($Options['settings']['admin_logo_image']!='')
				$html.="<img src=\"".$Options['settings']['admin_logo_image']."\">";
			$html.=$Options['settings']['admin_logo_text'];
			$html.="</a>";
			$html.="</div>\n";
		}
		echo $html;
	}
	/**Admin bar **/
	public function modern_admin_bar(){
		include("includes/admin_bar.php");
	}
	public function admin_bar_default_load( $wp_admin_bar ) {
		global $wp_admin_bar;
		$admin_bar = $wp_admin_bar->get_nodes();
        if(is_array($admin_bar) && count($admin_bar)>0) $this->admin_bar = $admin_bar;

	}
	public function admin_bar_filter_load() {
		$Default_bar = $this->admin_bar;
		$current_user = wp_get_current_user();

		$Delete_bar = array( "user-actions" , "wp-logo-external" , "top-secondary" , "my-sites-super-admin" , "my-sites-list" );
		foreach( $Delete_bar as $del_name ) {
			if( !empty( $Default_bar[$del_name] ) ) {
				unset( $Default_bar[$del_name] );
			}
		}
		foreach( $Default_bar as $node_id => $node ) {
			if( preg_match( "/blog-[0-9]/" , $node->parent ) ) {
				unset( $Default_bar[$node_id] );
			}
		}
		//var_dump(get_avatar( get_the_author_meta( $current_user->user_login ), 16 ));
		if(is_array($Default_bar))foreach( $Default_bar as $node_id => $node ) {
			if( $node->id == 'my-account' ) {
				//var_dump( $Default_bar[$node_id]->title);
				if(explode(',', $Default_bar[$node_id]->title)) {
					$hello = explode(',', $Default_bar[$node_id]->title);
					$hello = $hello[0];
				}
				else $hello = "Howdy";
				$str = sprintf( __( $hello.', %1$s', self::LANG ) ,'[user_name]' );
				$Default_bar[$node_id]->title = $str."[avatar16]";

				//$Default_bar[$node_id]->title = str_replace('Howdy, '.$current_user->display_name,$str,$Default_bar[$node_id]->title);
			} elseif( $node->id == 'user-info' ) {
				$str ="<span class='display-name'>[user_name]</span>";
				$str2 ="<span class='username'>[user_login]</span>";
				$Default_bar[$node_id]->title= "[avatar64]".$str.$str2;
				//$Default_bar[$node_id]->title = str_replace('<span class=\'display-name\'>'.$current_user->display_name.'</span>',$str,$Default_bar[$node_id]->title);
				//$Default_bar[$node_id]->title = str_replace('<span class=\'username\'>'.$current_user->user_login.'</span>',$str2,$Default_bar[$node_id]->title);
			} elseif( $node->id == 'logout' ) {
				$Default_bar[$node_id]->href =preg_replace( '/&amp(.*)/' , '' , $node->href );
			} elseif( $node->id == 'site-name' ) {
				$Default_bar[$node_id]->title = '[blog_name]';
			} elseif( $node->id == 'updates' ) {
				$Default_bar[$node_id]->title = '[update_total]';
			} elseif( $node->id == 'comments' ) {
				$Default_bar[$node_id]->title = '[comment_count]';
			}
		}

		$Filter_bar = array();
		$MainMenuIDs = array();
        $Default_bar = array_filter($Default_bar);
        if(is_array($Default_bar)) foreach( $Default_bar as $node_id => $node ) {
			if( empty( $node->parent ) ) {
				$Filter_bar["left"]["main"][$node_id] = $node;
				$MainMenuIDs[$node_id] = "left";
				unset( $Default_bar[$node_id] );
			} elseif( $node->parent == 'top-secondary' ) {
				$Filter_bar["right"]["main"][$node_id] = $node;
				$MainMenuIDs[$node_id] = "right";
				unset( $Default_bar[$node_id] );
			}
		}

        if(is_array($Default_bar)) foreach( $Default_bar as $node_id => $node ) {
			if( $node->parent == 'wp-logo-external' ) {
				$Default_bar[$node_id]->parent = 'wp-logo';
			} elseif( $node->parent == 'user-actions' ) {
				$Default_bar[$node_id]->parent = 'my-account';
			} elseif( $node->parent == 'my-sites-list' ) {
				$Default_bar[$node_id]->parent = 'my-sites';
			} else{
				if( !array_keys( $MainMenuIDs , $node->parent ) ) {
					if( !empty( $Default_bar[$node->parent] ) ) {
						$Default_bar[$node_id]->parent = $Default_bar[$node->parent]->parent;
					}
				}
			}
		}

        if(is_array($Default_bar)) foreach( $MainMenuIDs as $parent_id => $menu_type ) {

			foreach( $Default_bar as $node_id => $node ) {
				if( $node->parent == $parent_id ) {
					$Filter_bar[$menu_type]["sub"][$node_id] = $node;
					unset( $Default_bar[$node_id] );
				}


			}
		}

		return $Filter_bar;
	}

	public function update_admin_bar(){
		if(!isset($_POST['reset_admin_bar'])){
			$Options = $this->getOptions();
			if(isset($_POST['admin_bar'])){
				$admin_bar=array();
				foreach($_POST['admin_bar'] as $key => $value){
					$href=(isset($value["href"]))?$value["href"]:'';
					$show=(isset($value["show"]))?$value["show"]:0;
					$title = (isset($value["title"]))?$value["title"]:'';
					$admin_bar[$key]['href']=$href;
					$admin_bar[$key]['show']=$show;
					$admin_bar[$key]['title']=$title;
				}

				$Options['admin_bar'] = $admin_bar;
			}
			global $wp_admin_bar;
			$admin_bar = $wp_admin_bar->get_nodes();
            if(is_array($admin_bar) && count($admin_bar)>0) $this->admin_bar2 = $admin_bar;
			if(is_array($this->admin_bar2)) foreach($this->admin_bar2 as $node_id => $node){
				if(isset($Options['admin_bar'][$node_id]['show']) && $Options['admin_bar'][$node_id]['show']==0)
					$wp_admin_bar->remove_menu($node_id);
				else{
					$new_node=$wp_admin_bar->get_node($node_id);

					if(!empty($Options['admin_bar'][$node_id]['title']) && $Options['admin_bar'][$node_id]['show']!=$node->title){
						$title=$this->val_replace($Options['admin_bar'][$node_id]['title']);
						$new_node->title=stripslashes($title);
					}

					if(isset($Options['admin_bar'][$node_id]['href']) && $Options['admin_bar'][$node_id]['href']!=$node->href)
						$new_node->href=$Options['admin_bar'][$node_id]['href'];
					if($new_node->id=='logout')
						$new_node->href=wp_logout_url();
					$wp_admin_bar->remove_menu($node_id);
					$wp_admin_bar->add_node($new_node);
				}

			}
		}
       // exit;

	}
	private function val_replace( $str ) {

		if( !empty( $str ) ) {

			$update_data = wp_get_update_data();
			$awaiting_mod = wp_count_comments();
			$awaiting_mod = $awaiting_mod->moderated;
			$current_user = wp_get_current_user();

			if( is_multisite() ) {
				$current_site = get_current_site();
			}
			if( strstr( $str , '[comment_count]') ) {
				if ( current_user_can('edit_posts') ) {
					$str  = str_replace( '[comment_count]' , '<span class="ab-icon"></span><span id="ab-awaiting-mod" class="ab-label awaiting-mod pending-count count-[comment_count]">[comment_count_format]</span>' ,  $str );
				}
			}
			if( strstr( $str , '[update_total]') ) {
				if ( $update_data['counts']['total'] ) {
					$str = str_replace( '[update_total]' , '<span class="ab-icon"></span><span class="ab-label">[update_total_format]</span>' ,  $str );
				}
			}
			if( strstr( $str , '[update_plugins]') ) {
				if ( $update_data['counts']['plugins'] ) {
					$str  = str_replace( '[update_plugins]' , '[update_plugins_format]' , $str  );
				}
			}
			if( strstr( $str  , '[update_themes]') ) {
				if ( $update_data['counts']['themes'] ) {
					$str  = str_replace( '[update_themes]' , '[update_themes_format]' ,  $str );
				}
			}

			if( strstr( $str , '[blog_url]') ) {
				$str = str_replace( '[blog_url]' , home_url() , $str );
			}
			if( strstr( $str , '[template_directory_uri]') ) {
				$str = str_replace( '[template_directory_uri]' ,get_template_directory_uri() , $str );
			}
			if( strstr( $str , '[stylesheet_directory_uri]') ) {
				$str = str_replace( '[stylesheet_directory_uri]' , get_stylesheet_directory_uri() , $str );
			}
			if( strstr( $str , '[blog_name]') ) {
				$str = str_replace( '[blog_name]' , get_bloginfo( 'name' ) , $str );
			}
			if( strstr( $str , '[update_total]') ) {
				$str = str_replace( '[update_total]' , $update_data["counts"]["total"] , $str );
			}
			if( strstr( $str , '[update_total_format]') ) {
				$str = str_replace( '[update_total_format]' , number_format_i18n( $update_data["counts"]["total"] ) , $str );
			}
			if( strstr( $str , '[update_plugins]') ) {
				$str = str_replace( '[update_plugins]' , $update_data["counts"]["plugins"] , $str );
			}
			if( strstr( $str , '[update_plugins_format]') ) {
				$str = str_replace( '[update_plugins_format]' , number_format_i18n( $update_data["counts"]["plugins"] ) , $str );
			}
			if( strstr( $str , '[update_themes]') ) {
				$str = str_replace( '[update_themes]' , $update_data["counts"]["themes"] , $str );
			}
			if( strstr( $str , '[update_themes_format]') ) {
				$str = str_replace( '[update_themes_format]' , number_format_i18n( $update_data["counts"]["themes"] ) , $str );
			}
			if( strstr( $str , '[comment_count]') ) {
				$str = str_replace( '[comment_count]' , $awaiting_mod , $str );
			}
			if( strstr( $str , '[comment_count_format]') ) {
				$str = str_replace( '[comment_count_format]' , number_format_i18n( $awaiting_mod ) , $str );
			}
			if( strstr( $str , '[user_name]') ) {
				$str = str_replace( '[user_name]' , '<span class="display-name">' . $current_user->display_name . '</span>' , $str );
			}
			if( strstr( $str , '[user_login]') ) {
				$str = str_replace( '[user_login]' , '<span class=\'username\'>' . $current_user->user_login . '</span>' , $str );
			}
			if( strstr( $str , '[avatar16]') ) {
                if(function_exists('bp_core_fetch_avatar'))
                    $avatar16 = bp_core_fetch_avatar(array('item_id' => get_current_user_id()
                    , 'type' => 'thumb', 'width' => 16, 'height' => 16
                    , 'class' => 'friend-avatar', 'html'=>true));
                else $avatar16 = get_avatar( get_the_author_meta( $current_user->user_login ), 16 );
				$str = str_replace( '[avatar16]' , $avatar16, $str );
			}
			if( strstr( $str , '[avatar64]') ) {
                if(function_exists('bp_core_fetch_avatar'))
                    $avatar64 = bp_core_fetch_avatar(array('item_id' => get_current_user_id()
                    , 'type' => 'full', 'width' => 64, 'height' => 64
                    , 'class' => 'friend-avatar', 'html'=>true));
                else $avatar64 = get_avatar( get_the_author_meta( $current_user->user_login ), 64 );
				$str = str_replace( '[avatar64]' , $avatar64, $str );
			}
			if( is_multisite() ) {
				if( strstr( $str , '[site_name]') ) {
					$str = str_replace( '[site_name]' , esc_attr( $current_site->site_name ) , $str );
				}
				if( strstr( $str , '[site_url]') ) {
					$protocol = is_ssl() ? 'https://' : 'http://';
					$str = str_replace( '[site_url]' , $protocol . esc_attr( $current_site->domain ) , $str );
				}
			}

		}

		return $str;
	}

	/** Admin footer text */
	public function update_admin_footer ()
	{
		$text =__('Thank you for creating with <a href="http://wordpress.org/">WordPress</a>.',self::LANG);
		if(!isset($_POST['reset_settings'])){
			$Options = $this->getOptions();
			if(!empty($Options['settings']['admin_footer_text']))
				$text = $Options['settings']['admin_footer_text'];
		}

		echo $text;


	}

	public function update_version_footer($upgrade){
		$Options=$this->getOptions();
		if(isset($_POST['reset_settings'])) return $upgrade;
		if(!isset($Options['settings']['admin_footer_version'])) echo '';
		elseif($Options['settings']['admin_footer_version']==1)
			return $upgrade;


	}
	/**Custom CSS**/
	public function generate_custom_css(){
		$text ='';
		if(!isset($_POST['reset_settings'])){
			$Options = $this->getOptions();
			if(isset($_POST['settings']['custom_css'])) $Options['settings']['custom_css']=$_POST['settings']['custom_css'];
			if(!empty($Options['settings']['custom_css'])){
				$text="<style>\n";
				$text.= $Options['settings']['custom_css']."\n";
				$text.="</style>\n";
			}
		}
		echo $text;
	}
	/** custom dashboard widget */
	public function add_dashboard_widgets() {
		$Option=$this->getOptions();
		$title=(!empty($Option['custom_db_widget']['title']))?$Option['custom_db_widget']['title']:"Your Custom Widget Title";
		wp_add_dashboard_widget('custom_db_widget', $title, array($this,'db_wiget_content'));
        $title=(!empty($Option['custom_rss_db_widget']['title']))?$Option['custom_rss_db_widget']['title']:"Your RSS Widget Title";
        wp_add_dashboard_widget('custom_rss_db_widget', $title, array($this,'rss_db_wiget_content'));


	}
    public function rss_db_wiget_content($content){
        $Option=$this->getOptions();
        $url =(!empty($Option['custom_rss_db_widget']['url']))?$Option['custom_rss_db_widget']['url']:false;
        $max = (!empty($Option['custom_rss_db_widget']['max']))?$Option['custom_rss_db_widget']['max']:5;
        if(!is_integer($max)) $max=5;
        $result = false;
        if($url){
            // Get RSS Feed(s)
            include_once(ABSPATH . WPINC . '/feed.php');
            $urls = explode("\r\n",$url);
            foreach ( $urls as $feed) :

                if(filter_var($feed, FILTER_VALIDATE_URL) != FALSE){

                    // Get a SimplePie feed object from the specified feed source.
                    $rss = fetch_feed( $feed );

                    if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly
                        // Figure out how many total items there are, and choose a limit
                        $maxitems = $rss->get_item_quantity( $max );

                        // Build an array of all the items, starting with element 0 (first element).
                        $rss_items = $rss->get_items( 0, $maxitems );

                        // Get RSS title
                        $rss_title = '<a href="'.$rss->get_permalink().'" target="_blank">'.strtoupper( $rss->get_title() ).'</a>';
                    endif;

                    // Display the container
                    $result .= '<div class="rss-widget">';
                    $result .= '<strong>'.$rss_title.'</strong>';
                    $result .= '<hr style="border: 0; background-color: #DFDFDF; height: 1px;">';

                    // Starts items listing within <ul> tag
                    $result .= '<ul>';

                    // Check items
                    if ( $maxitems == 0 ) {
                        $result .= '<li>'.__( 'No item', 'rc_mdm').'.</li>';
                    } else {
                        // Loop through each feed item and display each item as a hyperlink.
                        foreach ( $rss_items as $item ) :
                            // Uncomment line below to display non human date
                            //$item_date = $item->get_date( get_option('date_format').' @ '.get_option('time_format') );

                            // Get human date (comment if you want to use non human date)
                            $item_date = human_time_diff( $item->get_date('U'), current_time('timestamp')).' '.__( 'ago', 'rc_mdm' );

                            // Start displaying item content within a <li> tag
                            $result .= '<li>';
                            // create item link
                            $result .= '<a href="'.esc_url( $item->get_permalink() ).'" title="'.$item_date.'">';
                            // Get item title
                            $result .= esc_html( $item->get_title() );
                            $result .= '</a>';
                            // Display date
                            $result .= ' <span class="rss-date">'.$item_date.'</span><br />';
                            // Get item content
                            $content = $item->get_content();
                            // Shorten content
                            $content = wp_html_excerpt($content, 120) . ' [...]';
                            // Display content
                            $result .= $content;
                            // End <li> tag
                            $result .= '</li>';
                        endforeach;
                    }
                    // End <ul> tag
                    $result .= '</ul></div>';
                }


            endforeach; // End foreach feed
            $content = $result;

        }else $content="URL feed is empty";
        if(!$result) $content="URL invalid";
        echo $content;
    }

	public function db_wiget_content($content){
		$Option=$this->getOptions();
		$content=(!empty($Option['custom_db_widget']['content']))?$Option['custom_db_widget']['content']:"Your Custom Widget Content";
		echo $content;
	}
	/** hover */

	public function add_admin_body_class( $classes )
	{
		if(!isset($_POST['reset_settings'])){
			$Options=$this->getOptions();
			if(isset($_POST['settings'])) $Options['settings']['hover']=(isset($_POST['settings']['hover']))?$_POST['settings']['hover']:NULL;
			if(isset($Options['settings']['hover']))
				$classes .=" modern-admin-hover";
		}

		return $classes;
	}

	public function export_modern_admin_callback(){
		$Option = $this->getOptions();
		$content = serialize($Option);
		header("HTTP/1.1 200 OK");
		$file_name = "modern_admin_export.txt";
		header('Content-Type: text/csv');
		$fsize = strlen($content);
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header('Content-Description: File Transfer');
		header("Content-Disposition: attachment; filename=" . $file_name);
		header("Content-Length: ".$fsize);
		header("Expires: 0");
		header("Pragma: public");
		echo $content;

	}

	public function modern_admin_import_export(){
		include("includes/import-export.php");
	}
	public function hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);

		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		//return implode(",", $rgb); // returns the rgb values separated by commas
		return $rgb; // returns an array with the rgb values
	}

}


?>
