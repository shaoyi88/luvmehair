<?php 


 
//creating cookie file
$cookie_file = str_replace('test.php', 'newfile.txt', __FILE__);

echo 'Cookie file:'.$cookie_file;

if (! file_exists($cookie_file) || ! is_writable($cookie_file)){
    echo 'Cookie file missing or not writable.';
    exit;
}


//curl ini
$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER,0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_TIMEOUT,20);
curl_setopt($ch, CURLOPT_REFERER, 'http://www.bing.com/');
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8');
curl_setopt($ch, CURLOPT_MAXREDIRS, 5); // Good leeway for redirections.

//curl_setopt($ch, CURLOPT_COOKIEJAR , "cookie.txt");
curl_setopt ( $ch, CURLOPT_COOKIEJAR, $cookie_file );

$verbose=fopen( str_replace('test.php', 'verbose.txt', __FILE__)  , 'w');
curl_setopt($ch, CURLOPT_VERBOSE , 1);
curl_setopt($ch, CURLOPT_STDERR,$verbose);

//curl get
$x='error';
$url='http://deandev.com/php/test2.php';
curl_setopt($ch, CURLOPT_HTTPGET, 1);
curl_setopt($ch, CURLOPT_URL, trim($url));
 
	$exec=curl_exec($ch);
	 $x=curl_error($ch);
 
	 echo $exec;




?>