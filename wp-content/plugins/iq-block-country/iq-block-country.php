<?php
/*
Plugin Name: iQ Block Country
Plugin URI: http://www.redeo.nl/2010/03/iq-block-country-a-wordpress-plugin/
Version: 1.0.10
Author: Pascal
Author URI: http://www.redeo.nl/
Description: Block visitors from visiting your website and backend website based on which country their IP address is from. The Maxmind GeoIP lite database is used for looking up from which country an ip address is from.
Author URI: http://www.redeo.nl/
License: GPL2
*/

/* This script uses GeoLite Country from MaxMind (http://www.maxmind.com) which is available under terms of GPL/LGPL */

/*  Copyright 2010-2013  Pascal  (email : pascal@redeo.nl)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
 * 
 * This software is dedicated to my one true love.
 * Luvya :)
 * 
 */

/*
 * Check of an IP address is a valid IPv4 address
 */
function iq_is_valid_ipv4($ipv4) 
{
    if(filter_var($ipv4, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === FALSE) {
        return false;
    }

    return true;
}

/*
 * Check of an IP address is a valid IPv6 address
 */
function iq_is_valid_ipv6($ipv6) 
{
    if(filter_var($ipv6, FILTER_VALIDATE_IP,FILTER_FLAG_IPV6) === FALSE) {
	return false;
    }

    return true;
}

/*
 * Try to make this plugin the first plugin that is loaded.
 * Because we output header info we don't want other plugins to send output first.
 */
function iq_this_plugin_first() 
{
	$wp_path_to_this_file = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR."/$2", __FILE__);
	$this_plugin = plugin_basename(trim($wp_path_to_this_file));
	$active_plugins = get_option('active_plugins');
	$this_plugin_key = array_search($this_plugin, $active_plugins);
	if ($this_plugin_key) { // if it's 0 it's the first plugin already, no need to continue
		array_splice($active_plugins, $this_plugin_key, 1);
		array_unshift($active_plugins, $this_plugin);
		update_option('active_plugins', $active_plugins);
	}     
}

	
/*
 * Create the wp-admin menu for iQ Block Country
 */
function iqblockcountry_create_menu() 
{
	//create new menu option in the settings department
	add_submenu_page ( 'options-general.php', 'iQ Block Country', 'iQ Block Country', 'administrator', __FILE__, 'iqblockcountry_settings_page' );
	//call register settings function
	add_action ( 'admin_init', 'iqblockcountry_register_mysettings' );
}

/*
 * Register all settings.
 */
function iqblockcountry_register_mysettings() 
{
	//register our settings
	register_setting ( 'iqblockcountry-settings-group', 'blockcountry_banlist' );
	register_setting ( 'iqblockcountry-settings-group', 'blockcountry_backendbanlist' );
	register_setting ( 'iqblockcountry-settings-group', 'blockcountry_backendblacklist' );
	register_setting ( 'iqblockcountry-settings-group', 'blockcountry_backendwhitelist' );
	register_setting ( 'iqblockcountry-settings-group', 'blockcountry_frontendblacklist' );
	register_setting ( 'iqblockcountry-settings-group', 'blockcountry_frontendwhitelist' );
	register_setting ( 'iqblockcountry-settings-group', 'blockcountry_blockmessage' );
	register_setting ( 'iqblockcountry-settings-group', 'blockcountry_blocklogin' );
	register_setting ( 'iqblockcountry-settings-group', 'blockcountry_blockfrontend' );
	register_setting ( 'iqblockcountry-settings-group', 'blockcountry_blockbackend' );
        register_setting ( 'iqblockcountry-settings-group', 'blockcountry_lastupdate');
        register_setting ( 'iqblockcountry-settings-group', 'blockcountry_version');
        
}

/*
 * Set default values when activating this plugin.
 */
function iq_set_defaults() 
{
        update_option('blockcountry_version',$version);
        update_option('blockcountry_lastupdate' , 0);
        update_option('blockcountry_blockfrontend' , 'on');
}

/*
 * Download the GeoIP database from MaxMind
 */
function iqblockcountry_downloadgeodatabase($version, $displayerror) 
                {
	
 if( !class_exists( 'WP_Http' ) )
        include_once( ABSPATH . WPINC. '/class-http.php' );

 global $geodbfile,$geodb6file;
 if ($version == 6)
 {
 	$url = 'http://geolite.maxmind.com/download/geoip/database/GeoIPv6.dat.gz';
 	$geofile = $geodb6file;
 }
 else 
 {
 	$url = 'http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz';
 	$geofile = $geodbfile;
 }       
 
 $request = new WP_Http ();
 $result = $request->request ( $url );
 $content = array ();

 if ((in_array ( '403', $result ['response'] )) && (preg_match('/Rate limited exceeded, please try again in 24 hours./', $result['body'] )) )  {
    if($displayerror){
 ?>
 	<p>Error occured: Could not download the GeoIP database from <?php echo $url;?><br />
	MaxMind has blocked requests from your IP address for 24 hours. Please check again in 24 hours or download this file from your own PC<br />
    unzip this file and upload it (via FTP for instance) to:<br /> <strong><?php echo $geofile;?></strong></p>
 <?php
    }
 }
 elseif ((isset ( $result->errors )) || (! (in_array ( '200', $result ['response'] )))) {
    if($displayerror){
 ?>
 	<p>Error occured: Could not download the GeoIP database from <?php echo $url;?><br />
	Please download this file from your own PC unzip this file and upload it (via FTP for instance) to:<br /> 
	<strong><?php echo $geofile;?></strong></p>
 <?php
    }
 } else {

	/* Download file */
	if (file_exists ( $geofile . ".gz" )) { unlink ( $geofile . ".gz" ); }
	$content = $result ['body'];
	$fp = fopen ( $geofile . ".gz", "w" );
	fwrite ( $fp, "$content" );
	fclose ( $fp );
		
	/* Unzip this file and throw it away afterwards*/
	$zd = gzopen ( $geofile . ".gz", "r" );
	$buffer = gzread ( $zd, 2000000 );
	gzclose ( $zd );
	if (file_exists ( $geofile . ".gz" )) { unlink ( $geofile . ".gz" ); }
			
	/* Write this file to the GeoIP database file */
	if (file_exists ( $geofile )) { unlink ( $geofile ); } 
	$fp = fopen ( $geofile, "w" );
	fwrite ( $fp, "$buffer" );
	fclose ( $fp );
        update_option('blockcountry_lastupdate' , time());
        if($displayerror){
	   print "<p>Finished downloading</p>";
        }
 }
 if (! (file_exists ( $geodbfile ))) {
    if($displayerror){
	?> 
	<p>Fatal error: GeoIP <?php echo $geodbfile ?> database does not exists. This plugin will not work until the database file is present.</p>
	<?php
    }
 }
 print "<hr />";
}

/*
 * Get list of countries from Geo Database
 */
function iq_get_countries()
{
    global $countrylist;
    
    $countrylist = array();
    if (!class_exists('GeoIP'))
    {
	include_once("geoip.inc");
    }
    if (class_exists('GeoIP'))
    {
	/* Create an array with all countries that the database knows */
	$geo = new GeoIP ();
	$countrycodes = $geo->GEOIP_COUNTRY_CODE_TO_NUMBER;
	$countries = $geo->GEOIP_COUNTRY_NAMES;
	$countrylist = array ();
	foreach ( $countrycodes as $key => $value ) {
            if (!empty($value))
            {
		$countrylist [$key] = $countries [$value];
            }
	}
	array_multisort($countrylist);

        return $countrylist;
    }

    return $countylist;
 }    


/*
 * Create the settings page.
 */
function iqblockcountry_settings_page() {
	?>
<div class="wrap">
        <?php
        $dateformat = get_option('date_format');
        $time = get_option('blockcountry_lastupdate');
        
        $lastupdated = date($dateformat,$time);
        
	echo "<strong>&#x5168;&#x7403;IP&#x6570;&#x636E;&#x66F4;&#x65B0;&#x65F6;&#x95F4;: " . $lastupdated . ".</strong>.";
        ?>
        
	<form name="download_geoip" action="#download" method="post">
        <input type="hidden" name="action" value="download" />
<?php 
        echo '<div class="submit"><input type="submit" name="test" value="' . __( '&#x4E0B;&#x8F7D;&#x6700;&#x65B0;&#x6570;&#x636E;', 'iq-block-country' ) . '" /></div>';
        wp_nonce_field('iq-block-country');
        echo '</form>';
?>		
		<form name="download_geoip6" action="#download6" method="post">
        <input type="hidden" name="action" value="download6" />
<?php 
        echo '<div class="submit"><input type="submit" name="test" value="' . __( '&#x4E0B;&#x8F7D;IPv6&#x6700;&#x65B0;&#x6570;&#x636E; ', 'iq-block-country' ) . '" /></div>';
        wp_nonce_field('iq-block-country');
        echo '</form>';
        
        if ( isset($_POST['action']) && $_POST[ 'action' ] == 'download') {
			echo "Downloading....";	
			iqblockcountry_downloadgeodatabase('4', true);	
		}
        if ( isset($_POST['action']) && $_POST[ 'action' ] == 'download6') {
			echo "Downloading....";	
			iqblockcountry_downloadgeodatabase('6', true);	
		}
		
        
        ?>

        
<hr />
<h3>&#x57FA;&#x672C;&#x8BBE;&#x7F6E;</h3>
        
<form method="post" action="options.php">
    <?php
	settings_fields ( 'iqblockcountry-settings-group' );
    if (!class_exists('GeoIP'))
	{
		include_once("geoip.inc");
	}
	if (class_exists('GeoIP'))
	{
		
            $countrylist = iq_get_countries();

            $ip_address = iq_get_ipaddress();
            $country = iq_check_ipaddress($ip_address);
            $displaycountry = $countrylist[$country];
            
           
	?>
    
            <input type="hidden" name="blockcountry_lastupdate" value="
            <?php
                echo get_option('blockcountry_lastupdate');
            ?>" />
            <input type="hidden" name="blockcountry_version" value="
            <?php
                global $version;
                echo $version;
            ?>" />

            <table class="form-table" cellspacing="2" cellpadding="5" width="100%">    	    
            <tr valign="top">
    	    <th width="30%">&#x88AB;&#x5C01;IP&#x6D4F;&#x89C8;&#x63D0;&#x793A;:</th>
    	    <td width="70%">
    	    	<input type="text" size=75 name="blockcountry_blockmessage"
    	    <?php
				$blockmessage = get_option ( 'blockcountry_blockmessage' );
				if (empty($blockmessage)) { $blockmessage = "Forbidden - Users from your country are not permitted to browse this site."; }
				echo "value=\"" . $blockmessage . "\" />";
    	    ?>
    	    </td></tr>

    	    <tr valign="top">
    	    <th width="30%">&#x4E0D;&#x8981;&#x963B;&#x6B62;&#x767B;&#x5F55;&#x7528;&#x6237;&#x8BBF;&#x95EE;&#x7F51;&#x7AD9;&#xFF1A;: </th>
    	    <td width="70%">
    	    	<input type="checkbox" name="blockcountry_blocklogin"
    	    <?php
				$blocklogin = get_option ( 'blockcountry_blocklogin' );
				if ($blocklogin == "on") { print "checked"; }
				echo " />";
    	    ?>
    	    </td></tr>

    	    <tr valign="top">
    	    <th width="30%">&#x963B;&#x6B62;&#x4EE5;&#x4E0B;&#x56FD;&#x5BB6;&#x533A;&#x57DF;&#x7528;&#x6237;IP&#x8BBF;&#x95EE;&#x4F60;&#x7684;&#x7F51;&#x7AD9;:</th>
    	    <td width="70%">
    	    	<input type="checkbox" name="blockcountry_blockfrontend"
    	    <?php
				$blockfrontend = get_option ( 'blockcountry_blockfrontend' );
				if ($blockfrontend == "on") { print "checked"; }
				echo " />";
    	    ?>
    	    </td></tr>
            
    	    
            <tr valign="top">
		<th scope="row" width="30%">&#x9009;&#x62E9;&#x88AB;&#x7981;&#x6B62;&#x6D4F;&#x89C8;&#x7684;&#x56FD;&#x5BB6;&#x533A;&#x57DF;:</th>
		<td width="70%"><select name="blockcountry_banlist[]" multiple="multiple" style="height: 300px;">
    	        <?php
			$haystack = get_option ( 'blockcountry_banlist' );
			foreach ( $countrylist as $key => $value ) {
			print "<option value=\"$key\"";
			if (is_array($haystack) && in_array ( $key, $haystack )) {
				print " selected=\"selected\" ";
			}
			print ">$value</option>\n";
			
		}
		
		?>
    	        </select></td>
			</tr>
    	    <tr valign="top">
    	    <th width="30%">&#x963B;&#x6B62;&#x7528;&#x6237;&#x8BBF;&#x95EE;&#x60A8;&#x7684;&#x7F51;&#x7AD9;&#x540E;&#x53F0;&#xFF1A;:</th>
    	    <td width="70%">
    	    	<input type="checkbox" name="blockcountry_blockbackend"
    	    <?php
				$blockbackend = get_option ( 'blockcountry_blockbackend' );
				if ($blockbackend == "on") { print "checked"; }
				echo " />";
                                
            ?>                    
            <tr>
                <th width="30%"></th>
                <th width="70%">
                   Your IP address is <i><?php echo $ip_address ?></i>. The country that is listed for this IP address is <em><?php echo $displaycountry ?></em>.<br />  
                     
                </th>
            </tr>
    	    </td></tr>
            <tr valign="top">
		<th scope="row" width="30%">&#x963B;&#x6B62;&#x4EE5;&#x4E0B;&#x56FD;&#x5BB6;&#x533A;&#x57DF;&#x7528;&#x6237;IP&#x8BBF;&#x95EE;&#x4F60;&#x7684;&#x7F51;&#x7AD9;&#x540E;&#x53F0;:</th>
		<td width="70%"><select name="blockcountry_backendbanlist[]" multiple="multiple" style="height: 300px;">
    	        <?php
			$haystack = get_option ( 'blockcountry_backendbanlist' );
			foreach ( $countrylist as $key => $value ) {
			print "<option value=\"$key\"";
			if (is_array($haystack) && in_array ( $key, $haystack )) {
				print " selected=\"selected\" ";
			}
			print ">$value</option>\n";
			
		}
		
		?>
    	        </select></td>
			</tr>
                        
		<tr><td></td><td>
						<p class="submit"><input type="submit" class="button-primary"
				value="<?php _e ( 'Save Changes' )?>" /></p>
		</td></tr>	
		</table>	
	
	
	<?php 
	} 
	else
	{
		print "<p>You are missing the GeoIP class. Perhaps geoip.inc is missing?</p>";	
	
	}
	?>	

	
    <?php
	global $geodbfile;
	
	/* Check if the Geo Database exists otherwise try to download it */
	if (! (file_exists ( $geodbfile ))) {
		?> 
		<hr>
		<p>GeoIP database does not exists. Trying to download it...</p>
		<?php
		
			iqblockcountry_downloadgeodatabase('4', true);	
			iqblockcountry_downloadgeodatabase('6', true);	
		}
	
	?>



</form>
</div>
<?php
}

function iq_check_ipaddress($ip_address)
{
    global $country,$geodbfile,$geodb6file;
    if (!class_exists('GeoIP'))
    {
	include_once("geoip.inc");
    }
    
    if ((file_exists ( $geodbfile )) && function_exists('geoip_open')) {

	$ipv4 = FALSE;
	$ipv6 = FALSE;
	if (iq_is_valid_ipv4($ip_address)) { $ipv4 = TRUE; }
	if (iq_is_valid_ipv6($ip_address)) { $ipv6 = TRUE; }
	
	if ($ipv4) 
	{ 	
		$gi = geoip_open ( $geodbfile, GEOIP_STANDARD );
		$country = geoip_country_code_by_addr ( $gi, $ip_address );
		geoip_close ( $gi );
	}
	elseif ($ipv6)
	{
		if (file_exists ( $geodb6file )) {				
			$gi = geoip_open($geodb6file,GEOIP_STANDARD);
			$country = geoip_country_code_by_addr_v6 ( $gi, $ip_address );
 			geoip_close($gi);
		}
		else {
			$country = 'ipv6';				
		}
	}
        else { $country = "Unknown"; }
        }
        else { $country = "Unknown"; }
        
    return $country;
}

/*
  * Retrieves the IP address from the HTTP Headers
 */

function iq_get_ipaddress() {
    global $ip_address;
    
    $ip_address = "";
    if (empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $ip_address = $_SERVER["REMOTE_ADDR"];
    } else {
        $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    return $ip_address;
}


/*
  * Does the real check of visitor IP against MaxMind database.
 * Looks up country in the Maxmind database and if needed blocks IP.
 */
function iqblockcountry_CheckCountry() {

    $ip_address = "";
    if (empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $ip_address = $_SERVER["REMOTE_ADDR"];
    } else {
        $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    
    $ip_address = iq_get_ipaddress();
    $country = iq_check_ipaddress($ip_address);
    
    if ((iq_is_login_page() || is_admin()) && get_option('blockcountry_blockbackend'))
    { 
        $badcountries = get_option( 'blockcountry_backendbanlist' );
    }
    else
    {    
        $badcountries = get_option( 'blockcountry_banlist' );
    }
    $blocklogin = get_option ( 'blockcountry_blocklogin' );
    if ( ((is_user_logged_in()) && ($blocklogin != "on")) || (!(is_user_logged_in())) )  {			
	/* Check if we have one of those bad guys */
	if (is_array ( $badcountries ) && in_array ( $country, $badcountries )) {
        	$blockmessage = get_option ( 'blockcountry_blockmessage' );
                                
                // Prevent as much as possible that this error message is cached:
                header("Cache-Control: no-store, no-cache, must-revalidate");
                header("Cache-Control: post-check=0, pre-check=0", false);
                header("Pragma: no-cache");
                header("Expires: Sat, 26 Jul 2012 05:00:00 GMT"); 
                                
                // Display block message
		header ( 'HTTP/1.1 403 Forbidden' );
		print "<p><strong>$blockmessage</strong></p>";
		exit ();
	}
		
    }
	
}

/*
 * Check if Geo databases needs to be updated.
 */
function iqblockcountry_checkupdatedb()
{
    $lastupdate = get_option('blockcountry_lastupdate');
    if (empty($lastupdate)) { $lastupdate = 0; }
    $time = $lastupdate + 86400 * 31;
  
    if(time() > $time)
    {
        iqblockcountry_downloadgeodatabase("4", false);
        iqblockcountry_downloadgeodatabase("6", false);
        update_option('blockcountry_lastupdate' , time());

    }
}

/*
 * Check if page is the login page
 */
function iq_is_login_page() {
    return !strncmp($_SERVER['REQUEST_URI'], '/wp-login.php', strlen('/wp-login.php'));
}


/*
 * Main plugin works.
 */

$geodbfile = WP_PLUGIN_DIR . "/" . dirname ( plugin_basename ( __FILE__ ) ) . "/GeoIP.dat";
$geodb6file = WP_PLUGIN_DIR . "/" . dirname ( plugin_basename ( __FILE__ ) ) . "/GeoIPv6.dat";
$version = "1.0.10";

add_action ( "activated_plugin", "iq_this_plugin_first");
add_action ( "activated_plugin", "iq_set_defaults");

/* Check if update is necessary */
$dbversion = get_option( 'blockcountry_version' );

if ($dbversion != "" && version_compare($dbversion, "1.0.9", '<=') )
{
            // Get banlist option and convert to backend banlist
            update_option('blockcountry_version',$version);
            $frontendbanlist = get_option('blockcountry_banlist');
            update_option('blockcountry_backendbanlist',$frontendbanlist);
}
elseif ($dbversion != $version)
{
            update_option('blockcountry_lastupdate' , 0); 
            update_option('blockcountry_blockfrontend' , 'on');
            update_option('blockcountry_version',$version);
}    


/*
 * Check first if users want to block the backend.
 */
if ((iq_is_login_page() || is_admin()) && get_option('blockcountry_blockbackend'))
{
    add_action ( 'login_head', 'iqblockcountry_checkCountry', 1 );
}
/*
 * Check first if users want to block the frontend.
 */
if (get_option('blockcountry_blockfrontend'))
{
    add_action ( 'wp_head', 'iqblockcountry_checkCountry', 1 );
}

add_action ( 'admin_menu', 'iqblockcountry_create_menu' );
add_action ( 'admin_init', 'iqblockcountry_checkupdatedb' );

?>