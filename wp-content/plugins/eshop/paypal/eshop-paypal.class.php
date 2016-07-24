<?php
if ('eshop-paypal.class.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');
     
/*******************************************************************************
 *                      PHP Paypal IPN Integration Class
 *******************************************************************************
 *      Author:     Micah Carrick
 *      Email:      email@micahcarrick.com
 *      Website:    http://www.micahcarrick.com
 *
 *      File:       eshop-paypal.class.php
 *      Version:    1.00
 *      Copyright:  (c) 2005 - Micah Carrick 
 *                  You are free to use, distribute, and modify this software 
 *                  under the terms of the GNU General Public License.  See the
 *                  included license.txt file.
 *      
 *******************************************************************************
 *  VERION HISTORY:
 *  
 *      v1.0.0 [04.16.2005] - Initial Version
 *
 *******************************************************************************
 *  DESCRIPTION:
 *
 *      This file provides a neat and simple method to interface with paypal and
 *      The paypal Instant Payment Notification (IPN) interface.  This file is
 *      NOT intended to make the paypal integration "plug 'n' play". It still
 *      requires the developer (that should be you) to understand the paypal
 *      process and know the variables you want/need to pass to paypal to
 *      achieve what you want.  
 *
 *      This class handles the submission of an order to paypal aswell as the
 *      processing an Instant Payment Notification.
 *  
 *      This code is based on that of the php-toolkit from paypal.  I've taken
 *      the basic principals and put it in to a class so that it is a little
 *      easier--at least for me--to use.  The php-toolkit can be downloaded from
 *      http://sourceforge.net/projects/paypal.
 *      
 *      To submit an order to paypal, have your order form POST to a file with:
 *
 *          $p = new eshop_paypal_class;
 *          $p->add_field('business', 'somebody@domain.com');
 *          $p->add_field('first_name', $_POST['first_name']);
 *          ... (add all your fields in the same manor)
 *          $p->submit_paypal_post();
 *
 *      To process an IPN, have your IPN processing file contain:
 *
 *          $p = new eshop_paypal_class;
 *          if ($p->validate_ipn()) {
 *          ... (IPN is verified.  Details are in the ipn_data() array)
 *          }
 *
 *
 *      In case you are new to paypal, here is some information to help you:
 *
 *      1. Download and read the Merchant User Manual and Integration Guide from
 *         http://www.paypal.com/en_US/pdf/integration_guide.pdf.  This gives 
 *         you all the information you need including the fields you can pass to
 *         paypal (using add_field() with this class) aswell as all the fields
 *         that are returned in an IPN post (stored in the ipn_data() array in
 *         this class).  It also diagrams the entire transaction process.
 *
 *      2. Create a "sandbox" account for a buyer and a seller.  This is just
 *         a test account(s) that allow you to test your site from both the 
 *         seller and buyer perspective.  The instructions for this is available
 *         at https://developer.paypal.com/ as well as a great forum where you
 *         can ask all your paypal integration questions.  Make sure you follow
 *         all the directions in setting up a sandbox test environment, including
 *         the addition of fake bank accounts and credit cards.
 * 
 *******************************************************************************
*/

class eshop_paypal_class {
    
   var $last_error;                 // holds the last error encountered
   
   var $ipn_log;                    // bool: log IPN results to text file?
   var $ipn_log_file;               // filename of the IPN log
   var $ipn_response;               // holds the IPN response from paypal   
   var $ipn_data = array();         // array contains the POST values for IPN
   
   var $fields = array();           // array holds the fields to submit to paypal

   
   function eshop_paypal_class() {
       
      // initialization constructor.  Called when class is created.
      
      //$this->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
      //$this->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
      $this->last_error = '';
      $this->ipn_log_file = 'ipn_log.txt';
      $this->ipn_log = false;
      $this->ipn_response = '';
      
      // populate $fields array with a few default values.  See the paypal
      // documentation for a list of fields and their data types. These defaul
      // values can be overwritten by the calling script.

    //  $this->add_field('rm','2');           // Return method = POST
     // $this->add_field('cmd','_xclick'); 
      
   }
   
   function add_field($field, $value) {
      
      // adds a key=>value pair to the fields array, which is what will be 
      // sent to paypal as POST variables.  If the value is already in the 
      // array, it will be overwritten.
      
      $this->fields["$field"] = $value;
   }

   function submit_paypal_post() {
      // this function actually generates an entire HTML page consisting of
      // a form with hidden elements which is submitted to paypal via the 
      // BODY element's onLoad attribute.  We do this so that you can validate
      // any POST vars from you custom form before submitting to paypal.  So 
      // basically, you'll have your own form which is submitted to your script
      // to validate the data, which in turn calls this function to create
      // another hidden form and submit to paypal.
 
      // The user will briefly see a message on the screen that reads:
      // "Please wait, your order is being processed..." and then immediately
      // is redirected to paypal.

      $echo= "<form method=\"post\" class=\"eshop eshop-confirm\" action=\"".$this->autoredirect."\"><div>\n";

      foreach ($this->fields as $name => $value) {
        $pos = strpos($name, 'amount');
		if ($pos === false) {
			$value=stripslashes($value);
		   $echo.= "<input type=\"hidden\" name=\"$name\" value=\"$value\" />\n";
		}else{
			$echo .= eshopTaxCartFields($name,$value);
		}
      }
      $echo .= apply_filters('eshoppaypalextra','');
      $echo.='<label for="ppsubmit" class="finalize"><small>'.__('<strong>Note:</strong> Submit to finalize order at PayPal.','eshop').'</small><br />
      <input class="button submit2" type="submit" id="ppsubmit" name="ppsubmit" value="'.__('Proceed to Checkout &raquo;','eshop').'" /></label>';
	  $echo.="</div></form><div style='clear:both;height:60px;'>.</div>\n";
      
      return $echo;
   }
	function eshop_submit_paypal_post($espost) {
 
      // this function actually generates an entire HTML page consisting of
      // a form with hidden elements which is submitted to paypal via the 
      // BODY element's onLoad attribute.  We do this so that you can validate
      // any POST vars from you custom form before submitting to paypal.  So 
      // basically, you'll have your own form which is submitted to your script
      // to validate the data, which in turn calls this function to create
      // another hidden form and submit to paypal.
 
      // The user will briefly see a message on the screen that reads:
      // "Please wait, your order is being processed..." and then immediately
      // is redirected to paypal.

		$rtnecho ='

       <div id="process">
	     <p><strong>'. __('Will automatically redirected to Paypal, Please wait or use the <em>Proceed to Paypal</em> button.','eshop').'</strong></p>
         <form name="paypalform" method="post" class="eshop" id="eshopgateway" action="'.$this->paypal_url.'">
          <p>';
		  foreach ($espost as $name => $value) {
			if($name!='submit' && $name!='ppsubmit'){			
				if($name!='return' && $name!='cancel_return' && $name!='notify_url'){
					$value=stripslashes($value);
					$replace = array("&#039;","'", "\"","&quot;","&amp;","&");
					$value = str_replace($replace, " ", $value);
				}
				if($name=='phone')
					$name='contact_phone';
				$rtnecho .= "<input type=\"hidden\" name=\"$name\" value=\"$value\" />\n";
			 }

		  }
      	$rtnecho .= '<input class="button" type="submit" id="ppsubmit" name="ppsubmit" value="'. __('Proceed to Paypal &raquo;','eshop').'" /></p>
	     </form><div style="clear:both;height:60px;">.</div>
	  </div>';
      	global $eshopoptions;
      	if($eshopoptions['status']!='live'){
	  		$rtnecho .= "<p class=\"testing\"><strong>".__('Test Mode &#8212; No money will be collected. This page will not auto redirect in test mode.','eshop')."</strong></p>\n";
	  	}
		return $rtnecho;
   }   
   function validate_ipn() {

      // parse the paypal URL
      $url_parsed=parse_url($this->paypal_url);        

      // generate the post string from the _POST vars aswell as load the
      // _POST vars into an arry so we can play with them from the calling
      // script.
      $post_string = '';    
      foreach ($_POST as $field=>$value) { 
         $this->ipn_data["$field"] = $value;//str_replace('%40','@', $value);
         $post_string .= $field.'='.urlencode($value).'&'; 
      }
      $post_string.="cmd=_notify-validate"; // append ipn command
/*
      	// open the connection to paypal was:
    	//$fp = fsockopen($url_parsed[host],"80",$err_num,$err_str,30);
    	//try uncommenting that line if the following doesn't work.
	   	$fp = fsockopen ('ssl://'.$url_parsed[host], "443", $err_no, $err_str, 30);
      if(!$fp) {
         // could not open the connection.  If loggin is on, the error message
         // will be in the log.
         $this->last_error = "fsockopen error no. $errnum: $errstr";
         $this->log_ipn_results(false);       
         return false;
*/
		$ipnhost= $url_parsed['host'];
		$ipnport= 80;

		if (function_exists('stream_get_transports')) {
			$transports= stream_get_transports();
			if (in_array('ssl', $transports)) {
				$ipnport= 443;
			}
		}

		if ($ipnport == 443) {
			$ipnhost= "ssl://$ipnhost";
		}

		$fp = fsockopen($ipnhost, $ipnport, $err_no, $err_str, 30);

		if(!$fp) {
			// could not open the connection.  If loggin is on, the error message
			// will be in the log. // TYPO FIXES:
			$this->last_error = "fsockopen error no. $err_no: $err_str";
			$this->last_error .= "\n host= $ipnhost, port= $ipnport";
			$this->log_ipn_results(false);       
			return false;

	  	} else { 
 
			 // Post the data back to paypal
			 fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n"); 
			 fputs($fp, "Host: $url_parsed[host]\r\n"); 
			 fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n"); 
			 fputs($fp, "Content-length: ".strlen($post_string)."\r\n"); 
			 fputs($fp, "Connection: close\r\n\r\n"); 
			 fputs($fp, $post_string . "\r\n\r\n"); 

			 // loop through the response from the server and append to variable
			 while(!feof($fp)) { 
				$this->ipn_response .= fgets($fp, 1024); 
			 } 

			 fclose($fp); // close connection

      }
      
     // if (eregi("verified",$this->ipn_response)) {
  	if(stristr($this->ipn_response, 'VERIFIED')) {
         // Valid IPN transaction.
         $this->log_ipn_results(true);
         return true;       
         
      } else {
  
         // Invalid IPN transaction.  Check the log for details.
         $this->last_error = 'IPN Validation Failed.';
         $this->log_ipn_results(false);   
         return false;
         
      }
      
   }
   
   function log_ipn_results($success) {
       
      if (!$this->ipn_log) return;  // is logging turned off?
      
      // Timestamp
      $text = '['.date('m/d/Y g:i A').'] - '; 
      
      // Success or failure being logged?
      if ($success) $text .= "SUCCESS!\n";
      else $text .= 'FAIL: '.$this->last_error."\n";
      
      // Log the POST variables
      $text .= "IPN POST Vars from Paypal:\n";
      foreach ($this->ipn_data as $key=>$value) {
         $text .= "$key=$value, ";
      }
 
      // Log the response from the paypal server
      $text .= "\nIPN Response from Paypal Server:\n ".$this->ipn_response;
      // Write to log
      
      $fp=fopen($this->ipn_log_file,'a');
      fwrite($fp, $text . "\n\n"); 

      fclose($fp);  // close file
      
      /* or use this 
      mail('YOUR ADDRESS','paypal',$text);
      */
                
   }

   function dump_fields() {
 
      // Used for debugging, this function will output all the field/value pairs
      // that are currently defined in the instance of the class using the
      // add_field() function.
      
      echo "<h3>eshop_paypal_class->dump_fields() Output:</h3>";
      echo "<table width=\"95%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\">
            <tr>
               <td bgcolor=\"black\"><b><font color=\"white\">Field Name</font></b></td>
               <td bgcolor=\"black\"><b><font color=\"white\">Value</font></b></td>
            </tr>"; 
      
      ksort($this->fields);
      foreach ($this->fields as $key => $value) {
         echo "<tr><td>$key</td><td>".urldecode($value)."&nbsp;</td></tr>";
      }
 
      echo "</table><br>"; 
   }
}   