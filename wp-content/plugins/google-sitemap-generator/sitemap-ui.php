<?php
/*

 $Id: sitemap-ui.php 651444 2013-01-11 19:54:39Z arnee $

*/

class GoogleSitemapGeneratorUI {

	/**
	 * The Sitemap Generator Object
	 *
	 * @var GoogleSitemapGenerator
	 */
	var $sg = null;

	var $mode = 21;

	function GoogleSitemapGeneratorUI(&$sitemapBuilder) {
		global $wp_version;
		$this->sg = &$sitemapBuilder;

		if(floatval($wp_version) >= 2.7) {
			$this->mode = 27;
		}
	}

	function HtmlPrintBoxHeader($id, $title, $right = false) {
		if($this->mode == 27) {
			?>
			<div id="<?php echo $id; ?>" class="postbox">
				<h3 class="hndle"><span><?php echo $title ?></span></h3>
				<div class="inside">
			<?php
		} else {
			?>
			<fieldset id="<?php echo $id; ?>" class="dbx-box">
				<?php if(!$right): ?><div class="dbx-h-andle-wrapper"><?php endif; ?>
				<h3 class="dbx-handle"><?php echo $title ?></h3>
				<?php if(!$right): ?></div><?php endif; ?>

				<?php if(!$right): ?><div class="dbx-c-ontent-wrapper"><?php endif; ?>
					<div class="dbx-content">
			<?php
		}
	}

	function HtmlPrintBoxFooter( $right = false) {
			if($this->mode == 27) {
			?>
				</div>
			</div>
			<?php
		} else {
			?>
					<?php if(!$right): ?></div><?php endif; ?>
				</div>
			</fieldset>
			<?php
		}
	}

	/**
	 * Displays the option page
	 *
	 * @since 3.0
	 * @access public
	 * @author Arne Brachhold
	 */
	function HtmlShowOptionsPage() {
		global $wp_version;

		$snl = false; //SNL

		$this->sg->Initate();

		$message="";

		if(!empty($_REQUEST["sm_rebuild"])) { //Pressed Button: Rebuild Sitemap
			check_admin_referer('sitemap');

			//Clear any outstanding build cron jobs
			if(function_exists('wp_clear_scheduled_hook')) wp_clear_scheduled_hook('sm_build_cron');

			if(isset($_GET["sm_do_debug"]) && $_GET["sm_do_debug"]=="true") {

				//Check again, just for the case that something went wrong before
				if(!current_user_can("administrator")) {
					echo '<p>Please log in as admin</p>';
					return;
				}

				$oldErr = error_reporting(E_ALL);
				$oldIni = ini_set("display_errors",1);

				echo '<div class="wrap">';
				echo '';
				echo '<p>This is the debug mode of the XML Sitemap Generator. It will show all PHP notices and warnings as well as the internal logs, messages and configuration.</p>';
				echo '<p style="font-weight:bold; color:red; padding:5px; border:1px red solid; text-align:center;">DO NOT POST THIS INFORMATION ON PUBLIC PAGES LIKE SUPPORT FORUMS AS IT MAY CONTAIN PASSWORDS OR SECRET SERVER INFORMATION!</p>';
				echo "<h3>WordPress and PHP Information</h3>";
				echo '<p>WordPress ' . $GLOBALS['wp_version'] . ' with ' . ' DB ' . $GLOBALS['wp_db_version'] . ' on PHP ' . phpversion() . '</p>';
				echo '<p>Plugin version: ' . $this->sg->GetVersion() . ' (' . $this->sg->_svnVersion . ')';
				echo '<h4>Environment</h4>';
				echo "<pre>";
				$sc = $_SERVER;
				unset($sc["HTTP_COOKIE"]);
				print_r($sc);
				echo "</pre>";
				echo "<h4>WordPress Config</h4>";
				echo "<pre>";
				$opts = array();
				if(function_exists('wp_load_alloptions')) {
					$opts = wp_load_alloptions();
				} else {
					global $wpdb;
					$os = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options");
					foreach ( (array) $os as $o ) $opts[$o->option_name] = $o->option_value;
				}

				$popts = array();
				foreach($opts as $k=>$v) {
					//Try to filter out passwords etc...
					if(preg_match("/pass|login|pw|secret|user|usr|key|auth|token/si",$k)) continue;
					$popts[$k] = htmlspecialchars($v);
				}
				print_r($popts);
				echo "</pre>";
				echo '<h4>Sitemap Config</h4>';
				echo "<pre>";
				print_r($this->sg->_options);
				echo "</pre>";
				echo '<h3>Errors, Warnings, Notices</h3>';
				echo '<div>';
				$status = $this->sg->BuildSitemap();
				echo '</div>';
				echo '<h3>MySQL Queries</h3>';
				if(defined('SAVEQUERIES') && SAVEQUERIES) {
					echo '<pre>';
					var_dump($GLOBALS['wpdb']->queries);
					echo '</pre>';

					$total = 0;
					foreach($GLOBALS['wpdb']->queries as $q) {
						$total+=$q[1];
					}
					echo '<h4>Total Query Time</h4>';
					echo '<pre>' . count($GLOBALS['wpdb']->queries) . ' queries in ' . round($total,2) . ' seconds.</pre>';
				} else {
					echo '<p>Please edit wp-db.inc.php in wp-includes and set SAVEQUERIES to true if you want to see the queries.</p>';
				}
				echo "<h3>Build Process Results</h3>";
				echo "<pre>";
				print_r($status);
				echo "</pre>";
				echo '<p>Done. <a href="' . wp_nonce_url($this->sg->GetBackLink() . "&sm_rebuild=true&sm_do_debug=true",'sitemap') . '">Rebuild</a> or <a href="' . $this->sg->GetBackLink() . '">Return</a></p>';
				echo '<p style="font-weight:bold; color:red; padding:5px; border:1px red solid; text-align:center;">DO NOT POST THIS INFORMATION ON PUBLIC PAGES LIKE SUPPORT FORUMS AS IT MAY CONTAIN PASSWORDS OR SECRET SERVER INFORMATION!</p>';
				echo '</div>';
				@error_reporting($oldErr);
				@ini_set("display_errors",$oldIni);
				return;
			} else {
				$this->sg->BuildSitemap();
				$redirURL = $this->sg->GetBackLink() . '&sm_fromrb=true';

				//Redirect so the sm_rebuild GET parameter no longer exists.
				@header("location: " . $redirURL);
				//If there was already any other output, the header redirect will fail
				echo '<script type="text/javascript">location.replace("' . $redirURL . '");</script>';
				echo '<noscript><a href="' . $redirURL . '">Click here to continue</a></noscript>';
				exit;
			}
		} else if (!empty($_POST['sm_update'])) { //Pressed Button: Update Config
			check_admin_referer('sitemap');

			if(isset($_POST['sm_b_style']) && $_POST['sm_b_style'] == $this->sg->getDefaultStyle()) {
				$_POST['sm_b_style_default'] = true;
				$_POST['sm_b_style'] = '';
			}

			foreach($this->sg->_options as $k=>$v) {
				//Check vor values and convert them into their types, based on the category they are in
				if(!isset($_POST[$k])) $_POST[$k]=""; // Empty string will get false on 2bool and 0 on 2float

				//Options of the category "Basic Settings" are boolean, except the filename and the autoprio provider
				if(substr($k,0,5)=="sm_b_") {
					if($k=="sm_b_filename" || $k=="sm_b_fileurl_manual" || $k=="sm_b_filename_manual" || $k=="sm_b_prio_provider" || $k=="sm_b_manual_key" || $k == "sm_b_style" || $k == "sm_b_memory") {

						if($k=="sm_b_filename" || $k=="sm_b_filename_manual") {
							if(substr($_POST[$k],-4)!=".xml") $_POST[$k].=".xml";
						}

						if($k=="sm_b_filename_manual" && strpos($_POST[$k],"\\")!==false){
							$_POST[$k]=stripslashes($_POST[$k]);
						}

						$this->sg->_options[$k]=(string) $_POST[$k];
					} else if($k=="sm_b_location_mode") {
						$tmp=(string) $_POST[$k];
						$tmp=strtolower($tmp);
						if($tmp=="auto" || $tmp="manual") $this->sg->_options[$k]=$tmp;
						else $this->sg->_options[$k]="auto";
					} else if($k == "sm_b_time" || $k=="sm_b_max_posts") {
						if($_POST[$k]=='') $_POST[$k] = -1;
						$this->sg->_options[$k] = intval($_POST[$k]);
					} else if($k== "sm_i_install_date") {
						if($this->sg->GetOption('i_install_date')<=0) $this->sg->_options[$k] = time();
					} else if($k=="sm_b_exclude") {
						$IDss = array();
						$IDs = explode(",",$_POST[$k]);
						for($x = 0; $x<count($IDs); $x++) {
							$ID = intval(trim($IDs[$x]));
							if($ID>0) $IDss[] = $ID;
						}
						$this->sg->_options[$k] = $IDss;
					} else if($k == "sm_b_exclude_cats") {
						$exCats = array();
						if(isset($_POST["post_category"])) {
							foreach((array) $_POST["post_category"] AS $vv) if(!empty($vv) && is_numeric($vv)) $exCats[] = intval($vv);
						}
						$this->sg->_options[$k] = $exCats;
					} else {
						$this->sg->_options[$k]=(bool) $_POST[$k];

					}
				//Options of the category "Includes" are boolean
				} else if(substr($k,0,6)=="sm_in_") {
					if($k=='sm_in_tax') {

						$enabledTaxonomies = array();

						foreach(array_keys((array) $_POST[$k]) AS $taxName) {
							if(empty($taxName) || !is_taxonomy($taxName)) continue;

							$enabledTaxonomies[] = $taxName;
						}

						$this->sg->_options[$k] = $enabledTaxonomies;

					} else if($k=='sm_in_customtypes') {

						$enabledPostTypes = array();

						foreach(array_keys((array) $_POST[$k]) AS $postTypeName) {
							if(empty($postTypeName) || !post_type_exists($postTypeName)) continue;

							$enabledPostTypes[] = $postTypeName;
						}

						$this->sg->_options[$k] = $enabledPostTypes;

					} else $this->sg->_options[$k]=(bool) $_POST[$k];
				//Options of the category "Change frequencies" are string
				} else if(substr($k,0,6)=="sm_cf_") {
					if(array_key_exists($_POST[$k],$this->sg->_freqNames)) {
						$this->sg->_options[$k]=(string) $_POST[$k];
					}
				//Options of the category "Priorities" are float
				} else if(substr($k,0,6)=="sm_pr_") {
					$this->sg->_options[$k]=(float) $_POST[$k];
				}
			}

			//No Mysql unbuffered query for WP < 2.2
			if(floatval($wp_version) < 2.2) {
				$this->sg->SetOption('b_safemode',true);
			}

			//No Wp-Cron for WP < 2.1
			if(floatval($wp_version) < 2.1) {
				$this->sg->SetOption('b_auto_delay',false);
			}

			//Apply page changes from POST
			$this->sg->_pages=$this->sg->HtmlApplyPages();

			if($this->sg->SaveOptions()) $message.=__('Configuration updated', 'sitemap') . "<br />";
			else $message.=__('Error while saving options', 'sitemap') . "<br />";

			if($this->sg->SavePages()) $message.=__("Pages saved",'sitemap') . "<br />";
			else $message.=__('Error while saving pages', 'sitemap'). "<br />";

		} else if(!empty($_POST["sm_reset_config"])) { //Pressed Button: Reset Config
			check_admin_referer('sitemap');
			$this->sg->InitOptions();
			$this->sg->SaveOptions();

			$message.=__('The default configuration was restored.','sitemap');
		}

		//Print out the message to the user, if any
		if($message!="") {
			?>
			<div class="updated"><strong><p><?php
			echo $message;
			?></p></strong></div><?php
		}


		if(!$snl) {

			if(isset($_GET['sm_hidedonate'])) {
				$this->sg->SetOption('i_hide_donated',true);
				$this->sg->SaveOptions();
			}
			if(isset($_GET['sm_donated'])) {
				$this->sg->SetOption('i_donated',true);
				$this->sg->SaveOptions();
			}
			if(isset($_GET['sm_hide_note'])) {
				$this->sg->SetOption('i_hide_note',true);
				$this->sg->SaveOptions();
			}
			if(isset($_GET['sm_hidedonors'])) {
				$this->sg->SetOption('i_hide_donors',true);
				$this->sg->SaveOptions();
			}
			if(isset($_GET['sm_hide_works'])) {
				$this->sg->SetOption('i_hide_works',true);
				$this->sg->SaveOptions();
			}


			if(isset($_GET['sm_donated']) || ($this->sg->GetOption('i_donated')===true && $this->sg->GetOption('i_hide_donated')!==true)) {
				?>
				<div class="updated">
					<strong><p><?php _e('Thank you very much for your donation. You help me to continue support and development of this plugin and other free software!','sitemap'); ?> <a href="<?php echo $this->sg->GetBackLink() . "&amp;sm_hidedonate=true"; ?>"><small style="font-weight:normal;"><?php _e('Hide this notice', 'sitemap'); ?></small></a></p></strong>
				</div>
				<?php
			} else if($this->sg->GetOption('i_donated') !== true && $this->sg->GetOption('i_install_date')>0 && $this->sg->GetOption('i_hide_note')!==true && time() > ($this->sg->GetOption('i_install_date') + (60*60*24*30))) {
				?>
				<div class="updated">
					<strong><p><?php echo str_replace("%s",$this->sg->GetRedirectLink("sitemap-donate-note"),__('Thanks for using this plugin! You\'ve installed this plugin over a month ago. If it works and you are satisfied with the results, isn\'t it worth at least a few dollar? <a href="%s">Donations</a> help me to continue support and development of this <i>free</i> software! <a href="%s">Sure, no problem!</a>','sitemap')); ?> <a href="<?php echo $this->sg->GetBackLink() . "&amp;sm_donated=true"; ?>" style="float:right; display:block; border:none; margin-left:10px;"><small style="font-weight:normal; "><?php _e('Sure, but I already did!', 'sitemap'); ?></small></a> <a href="<?php echo $this->sg->GetBackLink() . "&amp;sm_hide_note=true"; ?>" style="float:right; display:block; border:none;"><small style="font-weight:normal; "><?php _e('No thanks, please don\'t bug me anymore!', 'sitemap'); ?></small></a></p></strong>
					<div style="clear:right;"></div>
				</div>
				<?php
			} else if($this->sg->GetOption('i_install_date')>0 && $this->sg->GetOption('i_hide_works')!==true && time() > ($this->sg->GetOption('i_install_date') + (60*60*24*15))) {
				?>
				<div class="updated">
					<strong><p><?php echo str_replace("%s",$this->sg->GetRedirectLink("sitemap-works-note"),__('Thanks for using this plugin! You\'ve installed this plugin some time ago. If it works and your are satisfied, why not <a href="%s">rate it</a> and <a href="%s">recommend it</a> to others? :-)','sitemap')); ?> <a href="<?php echo $this->sg->GetBackLink() . "&amp;sm_hide_works=true"; ?>" style="float:right; display:block; border:none;"><small style="font-weight:normal; "><?php _e('Don\'t show this anymore', 'sitemap'); ?></small></a></p></strong>
					<div style="clear:right;"></div>
				</div>
				<?php
			}
		}

		if(function_exists("wp_next_scheduled")) {
			$next = wp_next_scheduled('sm_build_cron');
			if($next) {
				$diff = (time()-$next)*-1;
				if($diff <= 0) {
					$diffMsg = __('Your sitemap is being refreshed at the moment. Depending on your blog size this might take some time!<br /><small>Due to limitations of the WordPress scheduler, it might take another 60 seconds until the build process is actually started.</small>','sitemap');
				} else {
					$diffMsg = str_replace("%s",$diff,__('Your sitemap will be refreshed in %s seconds. Depending on your blog size this might take some time!','sitemap'));
				}
				?>
				<div class="updated">
					<strong><p><?php echo $diffMsg ?></p></strong>
					<div style="clear:right;"></div>
				</div>
				<?php
			}
		}


		?>

		<style type="text/css">

		li.sm_hint {
			color:green;
		}

		li.sm_optimize {
			color:orange;
		}

		li.sm_error {
			color:red;
		}

		input.sm_warning:hover {
			background: #ce0000;
			color: #fff;
		}

		a.sm_button {
			padding:4px;
			display:block;
			padding-left:25px;
			background-repeat:no-repeat;
			background-position:5px 50%;
			text-decoration:none;
			border:none;
		}

		a.sm_button:hover {
			border-bottom-width:1px;
		}

		a.sm_donatePayPal {
			background-image:url(<?php echo $this->sg->GetPluginUrl(); ?>img/icon-paypal.gif);
		}

		a.sm_donateAmazon {
			background-image:url(<?php echo $this->sg->GetPluginUrl(); ?>img/icon-amazon.gif);
		}

		a.sm_pluginHome {
			background-image:url(<?php echo $this->sg->GetPluginUrl(); ?>img/icon-arne.gif);
		}

		a.sm_pluginList {
			background-image:url(<?php echo $this->sg->GetPluginUrl(); ?>img/icon-email.gif);
		}

		a.sm_pluginSupport {
			background-image:url(<?php echo $this->sg->GetPluginUrl(); ?>img/icon-wordpress.gif);
		}

		a.sm_pluginBugs {
			background-image:url(<?php echo $this->sg->GetPluginUrl(); ?>img/icon-trac.gif);
		}

		a.sm_resGoogle {
			background-image:url(<?php echo $this->sg->GetPluginUrl(); ?>img/icon-google.gif);
		}

		a.sm_resBing {
			background-image:url(<?php echo $this->sg->GetPluginUrl(); ?>img/icon-bing.gif);
		}

		div.sm-update-nag p {
			margin:5px;
		}

		</style>

		<?php
			if($this->mode == 27): ?>
			<style type="text/css">

				.sm-padded .inside {
					margin:12px!important;
				}
				.sm-padded .inside ul {
					margin:6px 0 12px 0;
				}

				.sm-padded .inside input {
					padding:1px;
					margin:0;
				}

				<?php if (version_compare($wp_version, "3.4", "<")): //Fix style for WP 3.4 (dirty way for now..) ?>

				.inner-sidebar #side-sortables, .columns-2 .inner-sidebar #side-sortables {
					min-height: 300px;
					width: 280px;
					padding: 0;
				}

				.has-right-sidebar .inner-sidebar {
					display: block;
				}

				.inner-sidebar {
					float: right;
					clear: right;
					display: none;
					width: 281px;
					position: relative;
				}

				.has-right-sidebar #post-body-content {
					margin-right: 300px;
				}

				#post-body-content {
					width: auto !important;
					float: none !important;
				}

				<?php endif; ?>


			</style>

			<?php elseif(version_compare($wp_version,"2.5",">=")): ?>
				<style type="text/css">
					div#moremeta {
						float:right;
						width:200px;
						margin-left:10px;
					}
					<?php if(!$snl): ?>
					div#advancedstuff {
						width:770px;
					}
					<?php endif;?>
					div#poststuff {
						margin-top:10px;
					}
					fieldset.dbx-box {
						margin-bottom:5px;
					}

					div.sm-update-nag {
						margin-top:10px!important;
					}
				</style>
				<!--[if lt IE 7]>
					<style type="text/css">
						div#advancedstuff {
							width:735px;
						}
					</style>
				<![endif]-->

			<?php else: ?>
				<style type="text/css">
					div.updated-message {
						margin-left:0; margin-right:0;
					}
				</style>
			<?php endif;
		?>

		<div class="wrap" id="sm_div">
			<form method="post" action="<?php echo $this->sg->GetBackLink() ?>">
				
				<?php
				if(function_exists("wp_update_plugins") && (!defined('SM_NO_UPDATE') || SM_NO_UPDATE == false)) {

					wp_update_plugins();

					$file = GoogleSitemapGeneratorLoader::GetBaseName();

					$plugin_data = get_plugin_data(GoogleSitemapGeneratorLoader::GetPluginFile());

					$current = function_exists('get_transient')?get_transient('update_plugins'):get_option('update_plugins');

					if(isset($current->response[$file])) {
						$r = $current->response[$file];
						?><div id="update-nag" class="sm-update-nag"><?php
						if ( !current_user_can('edit_plugins') || version_compare($wp_version,"2.5","<") )
							printf( __('There is a new version of %1$s available. <a href="%2$s">Download version %3$s here</a>.','default'), $plugin_data['Name'], $r->url, $r->new_version);
						else if ( empty($r->package) )
							printf( __('There is a new version of %1$s available. <a href="%2$s">Download version %3$s here</a> <em>automatic upgrade unavailable for this plugin</em>.','default'), $plugin_data['Name'], $r->url, $r->new_version);
						else
							printf( __('There is a new version of %1$s available. <a href="%2$s">Download version %3$s here</a> or <a href="%4$s">upgrade automatically</a>.','default'), $plugin_data['Name'], $r->url, $r->new_version, wp_nonce_url("update.php?action=upgrade-plugin&amp;plugin=$file", 'upgrade-plugin_' . $file) );

						?></div><?php
					}
				}


				if(get_option('blog_public')!=1) {
					?><div class="error"><p><?php echo str_replace("%s","options-privacy.php",__('Your blog is currently blocking search engines! Visit the <a href="%s">privacy settings</a> to change this.','sitemap')); ?></p></div><?php
				}

				?>

				<?php if(version_compare($wp_version,"2.5","<")): ?>
				<script type="text/javascript" src="../wp-includes/js/dbx.js"></script>
				<script type="text/javascript">
				//<![CDATA[
				addLoadEvent( function() {
					var manager = new dbxManager('sm_sitemap_meta_33');

					//create new docking boxes group
					var meta = new dbxGroup(
						'grabit', 		// container ID [/-_a-zA-Z0-9/]
						'vertical', 	// orientation ['vertical'|'horizontal']
						'10', 			// drag threshold ['n' pixels]
						'no',			// restrict drag movement to container axis ['yes'|'no']
						'10', 			// animate re-ordering [frames per transition, or '0' for no effect]
						'yes', 			// include open/close toggle buttons ['yes'|'no']
						'open', 		// default state ['open'|'closed']
						<?php echo "'" . js_escape(__('open')); ?>', 		// word for "open", as in "open this box"
						<?php echo "'" . js_escape(__('close')); ?>', 		// word for "close", as in "close this box"
						<?php echo "'" . js_escape(__('click-down and drag to move this box')); ?>', // sentence for "move this box" by mouse
						<?php echo "'" . js_escape(__('click to %toggle% this box')); ?>', // pattern-match sentence for "(open|close) this box" by mouse
						<?php echo "'" . js_escape(__('use the arrow keys to move this box')); ?>', // sentence for "move this box" by keyboard
						<?php echo "'" . js_escape(__(', or press the enter key to %toggle% it')); ?>',  // pattern-match sentence-fragment for "(open|close) this box" by keyboard
						'%mytitle%  [%dbxtitle%]' // pattern-match syntax for title-attribute conflicts
						);

					var advanced = new dbxGroup(
						'advancedstuff', 		// container ID [/-_a-zA-Z0-9/]
						'vertical', 		// orientation ['vertical'|'horizontal']
						'10', 			// drag threshold ['n' pixels]
						'yes',			// restrict drag movement to container axis ['yes'|'no']
						'10', 			// animate re-ordering [frames per transition, or '0' for no effect]
						'yes', 			// include open/close toggle buttons ['yes'|'no']
						'open', 		// default state ['open'|'closed']
						<?php echo "'" . js_escape(__('open')); ?>', 		// word for "open", as in "open this box"
						<?php echo "'" . js_escape(__('close')); ?>', 		// word for "close", as in "close this box"
						<?php echo "'" . js_escape(__('click-down and drag to move this box')); ?>', // sentence for "move this box" by mouse
						<?php echo "'" . js_escape(__('click to %toggle% this box')); ?>', // pattern-match sentence for "(open|close) this box" by mouse
						<?php echo "'" . js_escape(__('use the arrow keys to move this box')); ?>', // sentence for "move this box" by keyboard
						<?php echo "'" . js_escape(__(', or press the enter key to %toggle% it')); ?>',  // pattern-match sentence-fragment for "(open|close) this box" by keyboard
						'%mytitle%  [%dbxtitle%]' // pattern-match syntax for title-attribute conflicts
						);
				});
				//]]>
				</script>
				<?php endif; ?>

				<?php if($this->mode == 27): ?>

					<?php if(!$snl): ?>
						<div id="poststuff" class="metabox-holder has-right-sidebar">
							<div class="inner-sidebar">
								<div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position:relative;">
					<?php else: ?>
						<div id="poststuff" class="metabox-holder">
					<?php endif; ?>
				<?php else: ?>
					<?php if(!$snl): ?>
						<div id="poststuff">
							<div id="moremeta">
								<div id="grabit" class="dbx-group">
					<?php else: ?>
						<div>
					<?php endif; ?>
				<?php endif; ?>

					<?php if(!$snl): ?>

							

						</div>
					</div>
					<?php endif; ?>

					<?php if($this->mode == 27): ?>
						<div class="has-sidebar sm-padded" >

							<div id="post-body-content" class="<?php if(!$snl): ?>has-sidebar-content<?php endif; ?>">

								<div class="meta-box-sortabless">
					<?php else: ?>
						<div id="advancedstuff" class="dbx-group" >
					<?php endif; ?>

					<!-- Rebuild Area -->
					<?php
						$status = &GoogleSitemapGeneratorStatus::Load();
						$head = __('The sitemap wasn\'t generated yet.','sitemap');
						if($status != null) {
							$st=$status->GetStartTime();
							$head=str_replace("%date%",date(get_option('date_format'),$st) . " " . date(get_option('time_format'),$st),__("Result of the last build process, started on %date%.",'sitemap'));
						}

						$this->HtmlPrintBoxHeader('sm_rebuild',$head); ?>
						<ul>
							<?php


							if($status == null) {
								echo "<li>" . str_replace("%s",wp_nonce_url($this->sg->GetBackLink() . "&sm_rebuild=true&noheader=true",'sitemap'),__('The sitemap wasn\'t built yet. <a href="%s">Click here</a> to build it the first time.','sitemap')) . "</li>";
							}  else {
								if($status->_endTime !== 0) {
									if($status->_usedXml) {
										if($status->_xmlSuccess) {
											$ft = is_readable($status->_xmlPath)?filemtime($status->_xmlPath):false;
											if($ft!==false) echo "<li>" . str_replace("%url%",$status->_xmlUrl,str_replace("%date%",date(get_option('date_format'),$ft) . " " . date(get_option('time_format'),$ft),__("Your <a href=\"%url%\">sitemap</a> was last built on <b>%date%</b>.",'sitemap'))) . "</li>";
											else echo "<li class=\"sm_error\">" . __("The last build succeeded, but the file was deleted later or can't be accessed anymore. Did you move your blog to another server or domain?",'sitemap') . "</li>";
										} else {
											echo "<li class=\"sm_error\">" . str_replace("%url%",$this->sg->GetRedirectLink('sitemap-help-files'),__("There was a problem writing your sitemap file. Make sure the file exists and is writable. <a href=\"%url%\">Learn more</a>",'sitemap')) . "</li>";
										}
									}

									if($status->_usedZip) {
										if($status->_zipSuccess) {
											$ft = is_readable($status->_zipPath)?filemtime($status->_zipPath):false;
											if($ft !== false) echo "<li>" . str_replace("%url%",$status->_zipUrl,str_replace("%date%",date(get_option('date_format'),$ft) . " " . date(get_option('time_format'),$ft),__("Your sitemap (<a href=\"%url%\">zipped</a>) was last built on <b>%date%</b>.",'sitemap'))) . "</li>";
											else echo "<li class=\"sm_error\">" . __("The last zipped build succeeded, but the file was deleted later or can't be accessed anymore. Did you move your blog to another server or domain?",'sitemap') . "</li>";
										} else {
											echo "<li class=\"sm_error\">" . str_replace("%url%",$this->sg->GetRedirectLink('sitemap-help-files'),__("There was a problem writing your zipped sitemap file. Make sure the file exists and is writable. <a href=\"%url%\">Learn more</a>",'sitemap')) . "</li>";
										}
									}

									if($status->_usedGoogle) {
										if($status->_gooogleSuccess) {
											echo "<li>" .__("Google was <b>successfully notified</b> about changes.",'sitemap'). "</li>";
											$gt = $status->GetGoogleTime();
											if($gt>4) {
												echo "<li class=\sm_optimize\">" . str_replace("%time%",$gt,__("It took %time% seconds to notify Google, maybe you want to disable this feature to reduce the building time.",'sitemap')) . "</li>";
											}
										} else {
											echo "<li class=\"sm_error\">" . str_replace("%s",wp_nonce_url($this->sg->GetBackLink() . "&sm_ping_service=google&noheader=true",'sitemap'),__('','sitemap')) . "</li>";
										}
									}

									if($status->_usedMsn) {
										if($status->_msnSuccess) {
											echo "<li>" .__("Bing was <b>successfully notified</b> about changes.",'sitemap'). "</li>";
											$at = $status->GetMsnTime();
											if($at>4) {
												echo "<li class=\sm_optimize\">" . str_replace("%time%",$at,__("It took %time% seconds to notify Bing, maybe you want to disable this feature to reduce the building time.",'sitemap')) . "</li>";
											}
										} else {
											echo "<li class=\"sm_error\">" . str_replace("%s",wp_nonce_url($this->sg->GetBackLink() . "&sm_ping_service=msn&noheader=true",'sitemap'),__('There was a problem while notifying Bing. <a href="%s">View result</a>','sitemap')) . "</li>";
										}
									}

									$et = $status->GetTime();
									$mem = $status->GetMemoryUsage();

									if($mem > 0) {
										echo "<li>" .str_replace(array("%time%","%memory%"),array($et,$mem),__("The building process took about <b>%time% seconds</b> to complete and used %memory% MB of memory.",'sitemap')). "</li>";
									} else {
										echo "<li>" .str_replace("%time%",$et,__("The building process took about <b>%time% seconds</b> to complete.",'sitemap')). "</li>";
									}

									if(!$status->_hasChanged) {
										echo "<li>" . __("The content of your sitemap <strong>didn't change</strong> since the last time so the files were not written and no search engine was pinged.",'sitemap'). "</li>";
									}

								} else {
									if($this->sg->GetOption("b_auto_delay")) {
										$st = ($status->GetStartTime() - time()) * -1;
										//If the building process runs in background and was started within the last 45 seconds, the sitemap might not be completed yet...
										if($st < 45) {
											echo '<li class="">'. __("The building process might still be active! Reload the page in a few seconds and check if something has changed.",'sitemap') . '</li>';
										}
									}
									echo '<li class="sm_error">'. str_replace("%url%",$this->sg->GetRedirectLink('sitemap-help-memtime'),__("The last run didn't finish! Maybe you can raise the memory or time limit for PHP scripts. <a href=\"%url%\">Learn more</a>",'sitemap')) . '</li>';
									if($status->_memoryUsage > 0) {
										echo '<li class="sm_error">'. str_replace(array("%memused%","%memlimit%"),array($status->GetMemoryUsage(),ini_get('memory_limit')),__("The last known memory usage of the script was %memused%MB, the limit of your server is %memlimit%.",'sitemap')) . '</li>';
									}

									if($status->_lastTime > 0) {
										echo '<li class="sm_error">'. str_replace(array("%timeused%","%timelimit%"),array($status->GetLastTime(),ini_get('max_execution_time')),__("The last known execution time of the script was %timeused% seconds, the limit of your server is %timelimit% seconds.",'sitemap')) . '</li>';
									}

									if($status->GetLastPost() > 0) {
										echo '<li class="sm_optimize">'. str_replace("%lastpost%",$status->GetLastPost(),__("The script stopped around post number %lastpost% (+/- 100)",'sitemap')) . '</li>';
									}
								}
								echo "<li>" . str_replace("%s",wp_nonce_url($this->sg->GetBackLink() . "&sm_rebuild=true&noheader=true",'sitemap'),__('<a href="%s">重置Sitemap</a>','sitemap')) . "</li>";
							}
							echo "<li>" . str_replace("%d",wp_nonce_url($this->sg->GetBackLink() . "&sm_rebuild=true&sm_do_debug=true",'sitemap'),__('','sitemap')) . "</li>";

							if(version_compare($wp_version,"2.9",">=") && version_compare(PHP_VERSION,"5.1",">=")) {
								echo "<li class='sm_hint'>" . str_replace("%s",$this->sg->GetRedirectLink('sitemap-info-beta'), __('','sitemap')) . "</li>";
							}
							?>

						</ul>
					<?php $this->HtmlPrintBoxFooter(); ?>

					
					<?php $this->HtmlPrintBoxFooter(); ?>

					</div>
					<div>
					</div>

				<?php if($this->mode == 27): ?>
				</div>
				</div>
				<?php endif; ?>
				</div>
				<script type="text/javascript">if(typeof(sm_loadPages)=='function') addLoadEvent(sm_loadPages); </script>
			</form>

		</div>
		<?php
	}
}

