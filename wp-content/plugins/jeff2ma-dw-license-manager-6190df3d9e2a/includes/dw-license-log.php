<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
function dw_license_log_file(){
        //log文件名
  $filename = 'log.txt'; 
        //去除rc-ajax评论以及cron机制访问记录
  if(strstr($_SERVER["REQUEST_URI"],"rc-ajax")== false 
    && strstr($_SERVER["REQUEST_URI"],"wp-cron.php")== false ) {
    $word .= date('mdHis',$_SERVER['REQUEST_TIME'] + 3600*8) . " ";
                //访问页面
    $word .= $_SERVER["REQUEST_URI"] ." ";
                //协议
    $word .= $_SERVER['SERVER_PROTOCOL'] ." ";
                //方法,POST OR GET
    $word .= $_SERVER['REQUEST_METHOD'] . " ";
    //$word .= $_SERVER['HTTP_ACCEPT'] . " ";
                //获得浏览器信息
    $word .= dw_license_getbrowser(). " ";
                //传递参数
    $word .= "[". $_SERVER['QUERY_STRING'] . "] ";
                //跳转地址
    $word .= $_SERVER['HTTP_REFERER'] . " ";
                //获取IP
    $word .= dw_license_getIP() . " ";
    $word .= "\n";
    $fh = fopen($filename, "a");
    fwrite($fh, $word);    
    fclose($fh);
  }
}
//获取IP地址，网上现成代码
function dw_license_getIP() //get ip address
    {
        if (getenv('HTTP_CLIENT_IP')) 
        {
            $ip = getenv('HTTP_CLIENT_IP');
        } 
        else if (getenv('HTTP_X_FORWARDED_FOR')) 
        {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } 
        else if (getenv('REMOTE_ADDR')) 
        {
            $ip = getenv('REMOTE_ADDR');
        } 
        else 
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
//获取浏览器信息，移动端，平板电脑数据还未加上。
 function dw_license_getbrowser()
    {
        $Agent = $_SERVER['HTTP_USER_AGENT'];
        $browser = '';
        $browserver = '';

        if(ereg('Mozilla', $Agent) && ereg('Chrome', $Agent))
        {
            $temp = explode('(', $Agent);
            $Part = $temp[2];
            $temp = explode('/', $Part);
            $browserver = $temp[1];
            $temp = explode(' ', $browserver);
            $browserver = $temp[0];
            $browserver = $browserver;
            $browser = 'Chrome';
        }
    if(ereg('Mozilla', $Agent) && ereg('Firefox', $Agent))
        {
            $temp = explode('(', $Agent);
            $Part = $temp[1];
            $temp = explode('/', $Part);
            $browserver = $temp[2];
            $temp = explode(' ', $browserver);
            $browserver = $temp[0];
            $browserver = $browserver;
            $browser = 'Firefox';
        }
        if(ereg('Mozilla', $Agent) && ereg('Opera', $Agent)) 
        {
            $temp = explode('(', $Agent);
            $Part = $temp[1];
            $temp = explode(')', $Part);
            $browserver = $temp[1];
            $temp = explode(' ', $browserver);
            $browserver = $temp[2];
            $browserver = $browserver;
            $browser = 'Opera';
        }
        if(ereg('Mozilla', $Agent) && ereg('MSIE', $Agent))
        {
            $temp = explode('(', $Agent);
            $Part = $temp[1];
            $temp = explode(';', $Part);
            $Part = $temp[1];
            $temp = explode(' ', $Part);
            $browserver = $temp[2];
            $browserver = $browserver;
            $browser = 'Internet Explorer';
        }
        if($browser != '')
        {
            $browseinfo = $browser.' '.$browserver;
        } 
        else
        {
            $browseinfo = $_SERVER['HTTP_USER_AGENT'];
        }
        return $browseinfo;
    }
 ?>