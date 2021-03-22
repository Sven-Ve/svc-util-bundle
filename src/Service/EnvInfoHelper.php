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
  public static function getRootURL(): string {
    $prot = $_SERVER["REQUEST_SCHEME"] ?? null;
    $host = $_SERVER["HTTP_HOST"] ?? null;
    return $prot . "://" . $host;
  }

  /**
   * give protokoll, servername and prefix (if server not installed in "/" )
   *
   * @return string
   */
  public static function getRootURLandPrefix(): string {
    if ($_SERVER["CONTEXT_PREFIX"]) {
      return self::getRootURL()  . $_SERVER["CONTEXT_PREFIX"];
    }
    return self::getRootURL();
  }

  /**
   * URL to index.php
   *
   * @return string
   */
  public static function getURLtoIndexPhp():string {
    if ($_SERVER["SCRIPT_NAME"]) {
      return self::getRootURL()  . $_SERVER["SCRIPT_NAME"];
    }
    return self::getRootURL();
  }
}