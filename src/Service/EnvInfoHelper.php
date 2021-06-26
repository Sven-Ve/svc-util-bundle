<?php

namespace Svc\UtilBundle\Service;

/**
 * Helper class to give environment information
 * 
 * @author Sven Vetter <dev@sv-systems.com>
 */
class EnvInfoHelper
{

  /**
   * give protocoll and servername
   *
   * @return string
   */
  public static function getRootURL(): string
  {
    $prot = $_SERVER["REQUEST_SCHEME"] ?? null;
    if ($prot === null) {
      if (array_key_exists("HTTPS", $_SERVER) and $_SERVER['HTTPS'] == "On") {
        $prot = "https";
      } else {
        $prot = "http";
      }
    }
    $host = $_SERVER["HTTP_HOST"] ?? null;
    return $prot . "://" . $host;
  }

  /**
   * give protokoll, servername and prefix (if server not installed in "/" )
   *
   * @return string
   */
  public static function getRootURLandPrefix(): string
  {
    if (array_key_exists("CONTEXT_PREFIX", $_SERVER)) {
      return self::getRootURL()  . $_SERVER["CONTEXT_PREFIX"];
    }
    return self::getRootURL();
  }

  /**
   * URL to index.php
   *
   * @return string
   */
  public static function getURLtoIndexPhp(): string
  {
    if (array_key_exists("SCRIPT_NAME", $_SERVER)) {
      return self::getRootURL()  . $_SERVER["SCRIPT_NAME"];
    }
    return self::getRootURL();
  }
}
