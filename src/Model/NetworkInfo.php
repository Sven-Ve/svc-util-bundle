<?php

declare(strict_types=1);

/*
 * This file is part of the svc/util-bundle.
 *
 * (c) 2026 Sven Vetter <dev@sv-systems.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Svc\UtilBundle\Model;

/**
 * Value object representing network information about a client.
 *
 * This is an immutable (readonly) DTO that provides type-safe access to client network data.
 * Use this instead of the deprecated array-based NetworkHelper::getAll() method.
 *
 * @author Sven Vetter <dev@sv-systems.com>
 *
 * @since 8.4
 */
readonly class NetworkInfo implements \JsonSerializable
{
    /**
     * @param string|null $ip        Client IP address (null if not detected)
     * @param string      $country   ISO country code (e.g., "CH", "US") - empty if unknown
     * @param string      $city      City name - empty if unknown
     * @param string|null $userAgent User agent string (null if not available)
     * @param string|null $referer   HTTP referer (null if not available)
     */
    public function __construct(
        public ?string $ip,
        public string $country,
        public string $city,
        public ?string $userAgent,
        public ?string $referer,
    ) {
    }

    /**
     * Create NetworkInfo from current client request.
     *
     * This is a convenience factory method that calls NetworkHelper methods
     * to gather all information about the current HTTP request.
     *
     * @return self NetworkInfo instance with current client data
     */
    public static function fromCurrentClient(): self
    {
        $ip = \Svc\UtilBundle\Service\NetworkHelper::getIP();
        $location = \Svc\UtilBundle\Service\NetworkHelper::getLocationInfoByIp($ip);

        return new self(
            ip: $ip,
            country: $location['country'],
            city: $location['city'],
            userAgent: \Svc\UtilBundle\Service\NetworkHelper::getUserAgent(),
            referer: \Svc\UtilBundle\Service\NetworkHelper::getReferer(),
        );
    }

    /**
     * Check if location information is available.
     *
     * Returns true if either country or city information is present.
     *
     * @return bool True if country or city is not empty
     */
    public function hasLocation(): bool
    {
        return !empty($this->country) || !empty($this->city);
    }

    /**
     * Check if this is likely a localhost/private IP.
     *
     * Returns true for:
     * - Localhost IPs (127.0.0.1, ::1)
     * - Private IP ranges (192.168.x.x, 10.x.x.x, etc.)
     * - Reserved IP ranges
     *
     * @return bool True if IP is localhost or private/reserved range
     */
    public function isLocalhost(): bool
    {
        if ($this->ip === null) {
            return false;
        }

        // Check for localhost
        if ($this->ip === '127.0.0.1' || $this->ip === '::1') {
            return true;
        }

        // Check if it's a private or reserved IP
        return !filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
    }

    /**
     * Convert to array format (for backward compatibility).
     *
     * Returns the data in the legacy array format used by the deprecated
     * NetworkHelper::getAll() method. Note that this uses 'ua' instead of
     * 'userAgent' for backward compatibility.
     *
     * @return array{ip: ?string, country: string, city: string, ua: ?string, referer: ?string}
     */
    public function toArray(): array
    {
        return [
            'ip' => $this->ip,
            'country' => $this->country,
            'city' => $this->city,
            'ua' => $this->userAgent,
            'referer' => $this->referer,
        ];
    }

    /**
     * Serialize to JSON format (implements JsonSerializable).
     *
     * Returns data with 'userAgent' instead of 'ua' for better API consistency.
     * This method is automatically called when using json_encode().
     *
     * @return array{ip: ?string, country: string, city: string, userAgent: ?string, referer: ?string}
     */
    public function jsonSerialize(): array
    {
        return [
            'ip' => $this->ip,
            'country' => $this->country,
            'city' => $this->city,
            'userAgent' => $this->userAgent,
            'referer' => $this->referer,
        ];
    }
}
