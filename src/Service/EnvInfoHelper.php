<?php

/*
 * This file is part of the svc/util-bundle.
 *
 * (c) Sven Vetter <dev@sv-systems.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Svc\UtilBundle\Service;

/**
 * Helper class to give environment information.
 *
 * @author Sven Vetter <dev@sv-systems.com>
 */
class EnvInfoHelper
{
    /**
     * give protocoll and servername.
     */
    public static function getRootURL(): string
    {
        $prot = $_SERVER['REQUEST_SCHEME'] ?? null;
        if ($prot === null) {
            if (array_key_exists('HTTPS', $_SERVER) and $_SERVER['HTTPS'] == 'On') {
                $prot = 'https';
            } else {
                $prot = 'http';
            }
        }
        $host = $_SERVER['HTTP_HOST'] ?? null;

        return $prot . '://' . $host;
    }

    /**
     * give protokoll, servername and prefix (if server not installed in "/" ).
     */
    public static function getRootURLandPrefix(): string
    {
        if (array_key_exists('CONTEXT_PREFIX', $_SERVER)) {
            return self::getRootURL() . $_SERVER['CONTEXT_PREFIX'];
        }

        return self::getRootURL();
    }

    /**
     * URL to index.php.
     */
    public static function getURLtoIndexPhp(): string
    {
        if (array_key_exists('SCRIPT_NAME', $_SERVER)) {
            return self::getRootURL() . $_SERVER['SCRIPT_NAME'];
        }

        return self::getRootURL();
    }

    /**
     * get the subdomain for a url or '' if no subdomain exists.
     *
     * @param string|null $url if null the current host is used
     */
    public static function getSubDomain(?string $url = null): string
    {
        if (!$url) {
            $url = $_SERVER['HTTP_HOST'];
        }
        if (str_starts_with($url, '127.0.0.1')) {
            return '';
        }

        return substr_count($url, '.') > 1 ? substr($url, 0, strpos($url, '.')) : '';
    }
}
