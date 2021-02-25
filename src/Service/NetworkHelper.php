<?php

namespace Svc\UtilBundle\Service;

class NetworkHelper
{

  public static function getIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']) and filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    //whether ip is from proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) and filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
      return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    //whether ip is from remote address
    elseif (!empty($_SERVER['REMOTE_ADDR'])) {
      return $_SERVER['REMOTE_ADDR'];
    } else {
      return null;
    }
  }

  public static function getUserAgent() {
    if (!empty($_SERVER['HTTP_USER_AGENT'])) {
      return $_SERVER['HTTP_USER_AGENT'];
    } 
    return null;
  }
  
  public static function getLocationInfoByIp($ip = null){
    if (!$ip) {
      $ip = static::getIP();
    }
    $result  = array('country'=>'', 'city'=>'');

    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));    

    if($ip_data && $ip_data->geoplugin_countryName != null){
        $result['country'] = $ip_data->geoplugin_countryCode;
        $result['city'] = $ip_data->geoplugin_city;
    }
    return $result;
  }
}