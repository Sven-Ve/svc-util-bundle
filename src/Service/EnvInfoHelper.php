<?php

declare(strict_types=1);

/*
 * This file is part of the svc/util-bundle.
 *
 * (c) 2025 Sven Vetter <dev@sv-systems.com>.
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

        // Validate protocol to prevent header injection
        if (!in_array($prot, ['http', 'https'], true)) {
            $prot = 'http';
        }

        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

        // Validate and sanitize host to prevent header injection
        if (!preg_match('/^[a-zA-Z0-9.-]+(?::[0-9]+)?$/', $host)) {
            $host = 'localhost';
        }

        return $prot . '://' . $host;
    }

    /**
     * give protokoll, servername and prefix (if server not installed in "/" ).
     */
    public static function getRootURLandPrefix(): string
    {
        if (array_key_exists('CONTEXT_PREFIX', $_SERVER)) {
            $prefix = $_SERVER['CONTEXT_PREFIX'];
            // Validate prefix to prevent path injection
            if (preg_match('/^\/[a-zA-Z0-9\/_-]*$/', $prefix)) {
                return self::getRootURL() . $prefix;
            }
        }

        return self::getRootURL();
    }

    /**
     * URL to index.php.
     */
    public static function getURLtoIndexPhp(): string
    {
        if (array_key_exists('SCRIPT_NAME', $_SERVER)) {
            $scriptName = $_SERVER['SCRIPT_NAME'];
            // Validate script name to prevent path injection
            if (preg_match('/^\/[a-zA-Z0-9\/_.-]*\.php$/', $scriptName)) {
                return self::getRootURL() . $scriptName;
            }
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
            $url = $_SERVER['HTTP_HOST'] ?? '';
        }

        // Validate URL format to prevent injection
        if (!preg_match('/^[a-zA-Z0-9.-]+(?::[0-9]+)?$/', $url)) {
            return '';
        }

        if (str_starts_with($url, '127.0.0.1')) {
            return '';
        }

        return substr_count($url, '.') > 1 ? substr($url, 0, strpos($url, '.')) : '';
    }
}
