<?php

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
 * Helper class to give network information.
 *
 * @author Sven Vetter <dev@sv-systems.com>
 */
class NetworkHelper
{
    /**
     * give client IP adress.
     */
    public static function getIP(): ?string
    {
        // Priority order: client IP, forwarded IP, remote address
        $headers = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'REMOTE_ADDR',
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ip = $_SERVER[$header];

                // Handle comma-separated IPs from X-Forwarded-For
                if ($header === 'HTTP_X_FORWARDED_FOR' && str_contains($ip, ',')) {
                    $ip = trim(explode(',', $ip)[0]);
                }

                // Validate IP and exclude private/reserved ranges for security
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }

                // If it's a valid IP but private/reserved, still return it for local development
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }

        return null;
    }

    /**
     * give client user agent.
     */
    public static function getUserAgent(): ?string
    {
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            return $_SERVER['HTTP_USER_AGENT'];
        }

        return null;
    }

    /**
     * give client referer.
     */
    public static function getReferer(): ?string
    {
        return $_SERVER['HTTP_REFERER'] ?? null;
    }

    /**
     * give location info (country and city) based on IP.
     *
     * @param string $ip if null, use current IP
     *
     * @return array ['country', 'city']
     */
    public static function getLocationInfoByIp($ip = null): array
    {
        if (!$ip) {
            $ip = static::getIP();
        }
        $result = ['country' => '', 'city' => ''];

        // Validate IP address to prevent SSRF attacks
        if (!$ip || !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return $result;
        }

        try {
            // Use HTTP and add timeout for security and performance
            // TODO: use ssl, but needs and account and an api key
            $context = stream_context_create([
                'http' => [
                    'timeout' => 5,
                    'method' => 'GET',
                    'header' => 'User-Agent: SvcUtilBundle/1.0',
                ],
                // 'ssl' => [
                //     'verify_peer' => true,
                //     'verify_peer_name' => true,
                // ],
            ]);

            $response = @file_get_contents('http://www.geoplugin.net/json.gp?ip=' . urlencode($ip), false, $context);
            if ($response === false) {
                return $result;
            }

            $ip_data = json_decode($response, null, 512, JSON_THROW_ON_ERROR);

            if ($ip_data && isset($ip_data->geoplugin_countryCode)) {
                $result['country'] = $ip_data->geoplugin_countryCode;
                $result['city'] = $ip_data->geoplugin_city ?? '';
            }
        } catch (\Exception) {
            // Silently fail and return empty result
        }

        return $result;
    }

    /**
     * give info about current client.
     *
     * @return array ['ip', 'country', 'city', 'ua', 'referer']
     */
    public static function getAll(): array
    {
        $ip = static::getIP();
        $loc = static::getLocationInfoByIp($ip);
        $ret = [];
        $ret['ip'] = $ip;
        $ret['country'] = $loc['country'];
        $ret['city'] = $loc['city'];
        $ret['ua'] = static::getUserAgent();
        $ret['referer'] = static::getReferer();

        return $ret;
    }
}
