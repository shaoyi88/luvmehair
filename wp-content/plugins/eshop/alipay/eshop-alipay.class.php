<?php
if ('eshop-alipay.class.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');
class eshop_alipay_class {
   var $fields = array();             
   function eshop_alipay_class() {       
      $this->last_error = '';
      $this->ipn_log_file = 'ipn_log.txt';
      $this->ipn_log = false;
      $this->ipn_response = '';
   }
   
   function add_field($field, $value) {
      $this->fields["$field"] = $value;
   }

   function submit_alipay_post() {
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
      $echo .= apply_filters('eshopalipayextra','');
      $echo.='<label for="ppsubmit" class="finalize"><small>'.__('<strong>Note:</strong> Submit to finalize order at alipay.','eshop').'</small><br />
      <input class="button submit2" type="submit" id="ppsubmit" name="ppsubmit" value="'.__('Proceed to Checkout &raquo;','eshop').'" /></label>';
	  $echo.="</div></form><div style='clear:both;height:60px;'>.</div>\n";      
      return $echo;
   }
   
   function log_ipn_results($success) {       
      if (!$this->ipn_log) return;  
      $text = '['.date('m/d/Y g:i A').'] - '; 
      if ($success) $text .= "SUCCESS!\n";
      else $text .= 'FAIL: '.$this->last_error."\n";      
      $text .= "IPN POST Vars from alipay:\n";
      foreach ($this->ipn_data as $key=>$value) {
         $text .= "$key=$value, ";
      } 
      $text .= "\nIPN Response from alipay Server:\n ".$this->ipn_response;
     $fp=fopen($this->ipn_log_file,'a');
      fwrite($fp, $text . "\n\n"); 
      fclose($fp);  // close file         
   }
   function dump_fields() {
      echo "<h3>eshop_alipay_class->dump_fields() Output:</h3>";
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