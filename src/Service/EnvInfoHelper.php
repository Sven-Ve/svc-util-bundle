<?php

namespace Svc\UtilBundle\Service;

class EnvInfoHelper
{
  
  public static function dumpServerInfo() {
    dump($_SERVER);
  }

  // only Protokoll and Servername
  public static function getRootURL() {
    $prot = $_SERVER["REQUEST_SCHEME"] ?? null;
    $host = $_SERVER["HTTP_HOST"] ?? null;
    return $prot . "://" . $host;
  }

  // only Protokoll and Servername and prefix (if server not installed in "/" )
  public static function getRootURLandPrefix() {
    if ($_SERVER["CONTEXT_PREFIX"]) {
      return self::getRootURL()  . $_SERVER["CONTEXT_PREFIX"];
    }
    return self::getRootURL();
  }

  // URL to index.php
  public static function getURLtoIndexPhp() {
    if ($_SERVER["SCRIPT_NAME"]) {
      return self::getRootURL()  . $_SERVER["SCRIPT_NAME"];
    }
    return self::getRootURL();
  }
}