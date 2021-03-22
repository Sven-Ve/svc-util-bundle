<?php

namespace Svc\UtilBundle\Service;

/**
 * Helper class to give network information
 * 
 * @author Sven Vetter <dev@sv-systems.com>
 */
class NetworkHelper
{

  /**
   * give client IP adress
   */
  public static function getIP(): ?string {
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

  /**
   * give client user agent
   */
  public static function getUserAgent(): ?string {
    if (!empty($_SERVER['HTTP_USER_AGENT'])) {
      return $_SERVER['HTTP_USER_AGENT'];
    } 
    return null;
  }
  
  /**
   * give client referer
   */
  public static function getReferer(): ?string {
    return $_SERVER["HTTP_REFERER"] ?? null;
  }
  
  /**
   * give location info (country and city) based on IP
   * 
   * @param string $ip if null, use current IP
   * 
   * @return array ['country', 'city']
   */
  public static function getLocationInfoByIp($ip = null): array{
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

  /**
   * give info about current client
   * 
   * @return array ['ip', 'country', 'city', 'ua', 'referer']
   */
  public static function getAll(): array {
    $ip=static::getIP();
    $loc=static::getLocationInfoByIp($ip);
    $ret = [];
    $ret['ip'] = $ip;
    $ret['country'] = $loc['country'];
    $ret['city'] = $loc['city'];
    $ret['ua'] = static::getUserAgent();
    $ret['referer'] = static::getReferer();
    return $ret;
  }
}