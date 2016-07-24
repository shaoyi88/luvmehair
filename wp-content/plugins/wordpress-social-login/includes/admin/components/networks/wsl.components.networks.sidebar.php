<?php
/*!
* WordPress Social Login
*
* http://miled.github.io/wordpress-social-login/ | https://github.com/miled/wordpress-social-login
*  (c) 2011-2014 Mohamed Mrassi and contributors | http://wordpress.org/plugins/wordpress-social-login/
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; 

// --------------------------------------------------------------------

function wsl_component_networks_sidebar()
{
	// HOOKABLE: 
	do_action( "wsl_component_networks_sidebar_start" );

	$sections = array(
		'what_is_this'   => 'wsl_component_networks_sidebar_what_is_this',
		'add_more_idps'  => 'wsl_component_networks_sidebar_add_more_idps',
		'basic_insights' => 'wsl_component_networks_sidebar_basic_insights',
	);

	$sections = apply_filters( 'wsl_component_networks_sidebar_alter_sections', $sections );

	foreach( $sections as $section => $action )
	{
		add_action( 'wsl_component_networks_sidebar_sections', $action );
	}

	// HOOKABLE: 
	do_action( 'wsl_component_networks_sidebar_sections' );
} 

// --------------------------------------------------------------------	

function wsl_component_networks_sidebar_what_is_this()
{
?>

<?php
}

add_action( 'wsl_component_networks_sidebar_what_is_this', 'wsl_component_networks_sidebar_what_is_this' );

// --------------------------------------------------------------------	

function wsl_component_networks_sidebar_add_more_idps()
{
	GLOBAL $WORDPRESS_SOCIAL_LOGIN_PROVIDERS_CONFIG;

	$assets_base_url = WORDPRESS_SOCIAL_LOGIN_PLUGIN_URL . '/assets/img/32x32/icondock/';
?>
<div class="postbox">
	<div class="inside">
		<h3>添加更多第三方登录接口</h3>

		<div style="padding:0 20px;">

			<div style="width: 320px; padding: 10px; border: 1px solid #ddd; background-color: #fff;">
				<?php 
					$nb_used = count( $WORDPRESS_SOCIAL_LOGIN_PROVIDERS_CONFIG );

					foreach( $WORDPRESS_SOCIAL_LOGIN_PROVIDERS_CONFIG AS $item )
					{
						$provider_id   = isset( $item["provider_id"]   ) ? $item["provider_id"]   : '';
						$provider_name = isset( $item["provider_name"] ) ? $item["provider_name"] : '';

						if( isset( $item["default_network"] ) && $item["default_network"] )
						{
							continue;
						}

						if( ! get_option( 'wsl_settings_' . $provider_id . '_enabled' ) )
						{
							?>
								<a href="options-general.php?page=wordpress-social-login&wslp=networks&enable=<?php echo $provider_id ?>#setup<?php echo strtolower( $provider_id ) ?>"><img src="<?php echo $assets_base_url . strtolower( $provider_id ) . '.png' ?>" alt="<?php echo $provider_name ?>" title="<?php echo $provider_name ?>" /></a>
							<?php

							$nb_used--;
						}
					}

					if( $nb_used == count( $WORDPRESS_SOCIAL_LOGIN_PROVIDERS_CONFIG ) )
					{
						_wsl_e("Well! none left.", 'wordpress-social-login');
					}
				?> 
			</div> 
		</div> 	
	</div> 
</div> 
<?php
}

add_action( 'wsl_component_networks_sidebar_add_more_idps', 'wsl_component_networks_sidebar_add_more_idps' );

// --------------------------------------------------------------------	

function wsl_component_networks_sidebar_basic_insights()
{
	GLOBAL $WORDPRESS_SOCIAL_LOGIN_PROVIDERS_CONFIG;

	$assets_base_url = WORDPRESS_SOCIAL_LOGIN_PLUGIN_URL . '/assets/img/32x32/icondock/';
?>

<?php
}

add_action( 'wsl_component_networks_sidebar_basic_insights', 'wsl_component_networks_sidebar_basic_insights' );

// --------------------------------------------------------------------	
