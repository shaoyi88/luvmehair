<?php
if ('eshop-amazon.class.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');
class eshop_amazon_class {
    
   var $last_error;                 // holds the last error encountered
   
   var $ipn_log;                    // bool: log IPN results to text file?
   var $ipn_log_file;               // filename of the IPN log
   var $ipn_response;               // holds the IPN response from paypal   
   var $ipn_data = array();         // array contains the POST values for IPN
   
   var $fields = array();           // array holds the fields to submit to paypal

   
   function eshop_amazon_class() {
      $this->last_error = '';
      $this->ipn_log_file = 'ipn_log.txt';
      $this->ipn_log = false;
      $this->ipn_response = '';
   }
   
   function add_field($field, $value) {
      $this->fields["$field"] = $value;
   }

   function submit_amazon_post() {
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
      $echo.='<label for="ppsubmit" class="finalize"><small>'.__('<strong>Note:</strong> Submit to finalize order at Amazon.','eshop').'</small><br />
      <input class="button submit2" type="submit" id="ppsubmit" name="ppsubmit" value="'.__('Proceed to Checkout &raquo;','eshop').'" /></label>';
	  $echo.="</div></form><div style='clear:both;height:60px;'>.</div>\n";
      
      return $echo;
   }   	function signBackParameters(array $parameters, $key)	{		$stringToSign = null;		$algorithm    = "HmacSHA256";		$stringToSign = $this->calculateStringToSignV2Back($parameters);		return $this->sign($stringToSign, $key, $algorithm);	}		function calculateStringToSignV2Back(array $parameters)	{		$data = 'GET';		$data .= "\n";		$data .= "www.luvmehair.com";		$data .= "\n";		$data .= "/shopping-cart/thank-you";		$data .= "\n";		$data .= $this->getParametersAsString($parameters);		return $data;	}   	function signParameters(array $parameters, $key)	{		$stringToSign = null;		$algorithm    = "HmacSHA256";		$stringToSign = $this->calculateStringToSignV2($parameters);		return $this->sign($stringToSign, $key, $algorithm);	}	function calculateStringToSignV2(array $parameters)	{		$data = 'POST';		$data .= "\n";		$data .= "payments.amazon.com";		$data .= "\n";		$data .= "/";		$data .= "\n";		$data .= $this->getParametersAsString($parameters);		return $data;	}	function getParametersAsString(array $parameters)	{		$queryParameters = array();		foreach ($parameters as $key => $value) {				$queryParameters[] = $key . '=' . $this->urlencode($value);		}		return implode('&', $queryParameters);	}	function urlencode($value)	{		return str_replace('%7E', '~', rawurlencode($value));	}	function sign($data, $key, $algorithm)	{		if ($algorithm === 'HmacSHA1') {				$hash = 'sha1';		} else if ($algorithm === 'HmacSHA256') {				$hash = 'sha256';		} else {				throw new Exception("Non-supported signing method specified");		}		return base64_encode(hash_hmac($hash, $data, $key, true));	}		function validateSignature($secretKey){		$parameters = $_GET;		unset($parameters['eshopaction']);		unset($parameters['signature']);		uksort($parameters, 'strcmp');		$signature = $this->urlencode($this->signBackParameters($parameters, $secretKey));		if($_GET['signature'] == $signature){			return true;		}else{			return false;		}	}      function eshop_submit_amazon_post($espost){   		$sellerId =  $espost['seller_id'];		$lwaClientId =  $espost['client_id'];		$accessKey =  $espost['access_key'];		$secretKey =  $espost['secret_key'];		$note = $espost['comments']; 		$amount = $espost['amount']; 		if($espost['debug']){			$payUrl = "<script type='text/javascript' src='https://static-na.payments-amazon.com/OffAmazonPayments/us/sandbox/js/Widgets.js'></script>";		}else{			$payUrl = "<script type='text/javascript' src='https://static-na.payments-amazon.com/OffAmazonPayments/us/js/Widgets.js'></script>";		}				$parameters = array('returnURL'=> $espost['return'],			'cancelReturnURL' => $espost['cancel_return'],			'accessKey'=>  $accessKey,			'lwaClientId'=> $lwaClientId,			'currencyCode' => $espost['currency_code'],			'sellerOrderId' => $espost['checkid'],			'shippingAddressRequired' => 'false',			'sellerId'=> $sellerId,			'paymentAction'=> 'AuthorizeAndCapture',			'sellerNote'=> $note,			'amount'=> $amount); 			uksort($parameters, 'strcmp');						$signature = $this->urlencode($this->signParameters($parameters, $secretKey));			$parameters['signature'] = $signature;  			$buttonId = uniqid();  	  		$button = $payUrl."<div id='process'><div id='AmazonPayButton" . $buttonId . "'></div>		<script type='text/javascript'>			OffAmazonPayments.Button('AmazonPayButton" . $buttonId . "', '$sellerId', {				type: 'hostedPayment',				hostedParametersProvider: function(done) {					data =" . json_encode($parameters) . "; 					done(data); 				},				onError: function(errorCode) {					console.log(errorCode.getErrorCode() + ' ' + errorCode.getErrorMessage());				}			});		</script><div style='clear:both;height:60px;'>.</div></div>";   		return $button;   }
}   