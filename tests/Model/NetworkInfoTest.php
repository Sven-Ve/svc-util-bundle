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

namespace Svc\UtilBundle\Tests\Model;

use PHPUnit\Framework\TestCase;
use Svc\UtilBundle\Model\NetworkInfo;

/**
 * Unit tests for NetworkInfo value object.
 */
final class NetworkInfoTest extends TestCase
{
    public function testConstructor(): void
    {
        $info = new NetworkInfo(
            ip: '192.168.1.1',
            country: 'CH',
            city: 'Zurich',
            userAgent: 'Mozilla/5.0',
            referer: 'https://example.com',
        );

        $this->assertSame('192.168.1.1', $info->ip);
        $this->assertSame('CH', $info->country);
        $this->assertSame('Zurich', $info->city);
        $this->assertSame('Mozilla/5.0', $info->userAgent);
        $this->assertSame('https://example.com', $info->referer);
    }

    public function testConstructorWithNullValues(): void
    {
        $info = new NetworkInfo(
            ip: null,
            country: '',
            city: '',
            userAgent: null,
            referer: null,
        );

        $this->assertNull($info->ip);
        $this->assertSame('', $info->country);
        $this->assertSame('', $info->city);
        $this->assertNull($info->userAgent);
        $this->assertNull($info->referer);
    }

    public function testFromCurrentClient(): void
    {
        // In test environment, most values should be null/empty
        $info = NetworkInfo::fromCurrentClient();

        $this->assertInstanceOf(NetworkInfo::class, $info);
        $this->assertNull($info->ip);
        $this->assertSame('', $info->country);
        $this->assertSame('', $info->city);
        $this->assertNull($info->userAgent);
        $this->assertNull($info->referer);
    }

    public function testHasLocationWithCountry(): void
    {
        $info = new NetworkInfo(
            ip: '8.8.8.8',
            country: 'US',
            city: '',
            userAgent: null,
            referer: null,
        );

        $this->assertTrue($info->hasLocation());
    }

    public function testHasLocationWithCity(): void
    {
        $info = new NetworkInfo(
            ip: '8.8.8.8',
            country: '',
            city: 'Mountain View',
            userAgent: null,
            referer: null,
        );

        $this->assertTrue($info->hasLocation());
    }

    public function testHasLocationWithBoth(): void
    {
        $info = new NetworkInfo(
            ip: '8.8.8.8',
            country: 'US',
            city: 'Mountain View',
            userAgent: null,
            referer: null,
        );

        $this->assertTrue($info->hasLocation());
    }

    public function testHasLocationWithNeither(): void
    {
        $info = new NetworkInfo(
            ip: '8.8.8.8',
            country: '',
            city: '',
            userAgent: null,
            referer: null,
        );

        $this->assertFalse($info->hasLocation());
    }

    public function testIsLocalhostWithIPv4Localhost(): void
    {
        $info = new NetworkInfo(
            ip: '127.0.0.1',
            country: '',
            city: '',
            userAgent: null,
            referer: null,
        );

        $this->assertTrue($info->isLocalhost());
    }

    public function testIsLocalhostWithIPv6Localhost(): void
    {
        $info = new NetworkInfo(
            ip: '::1',
            country: '',
            city: '',
            userAgent: null,
            referer: null,
        );

        $this->assertTrue($info->isLocalhost());
    }

    public function testIsLocalhostWithPrivateIP(): void
    {
        $info = new NetworkInfo(
            ip: '192.168.1.1',
            country: '',
            city: '',
            userAgent: null,
            referer: null,
        );

        $this->assertTrue($info->isLocalhost());
    }

    public function testIsLocalhostWithPublicIP(): void
    {
        $info = new NetworkInfo(
            ip: '8.8.8.8',
            country: 'US',
            city: 'Mountain View',
            userAgent: null,
            referer: null,
        );

        $this->assertFalse($info->isLocalhost());
    }

    public function testIsLocalhostWithNullIP(): void
    {
        $info = new NetworkInfo(
            ip: null,
            country: '',
            city: '',
            userAgent: null,
            referer: null,
        );

        $this->assertFalse($info->isLocalhost());
    }

    public function testToArray(): void
    {
        $info = new NetworkInfo(
            ip: '8.8.8.8',
            country: 'US',
            city: 'Mountain View',
            userAgent: 'Mozilla/5.0',
            referer: 'https://example.com',
        );

        $expected = [
            'ip' => '8.8.8.8',
            'country' => 'US',
            'city' => 'Mountain View',
            'ua' => 'Mozilla/5.0',
            'referer' => 'https://example.com',
        ];

        $this->assertSame($expected, $info->toArray());
    }

    public function testToArrayWithNullValues(): void
    {
        $info = new NetworkInfo(
            ip: null,
            country: '',
            city: '',
            userAgent: null,
            referer: null,
        );

        $expected = [
            'ip' => null,
            'country' => '',
            'city' => '',
            'ua' => null,
            'referer' => null,
        ];

        $this->assertSame($expected, $info->toArray());
    }

    public function testJsonSerialize(): void
    {
        $info = new NetworkInfo(
            ip: '8.8.8.8',
            country: 'US',
            city: 'Mountain View',
            userAgent: 'Mozilla/5.0',
            referer: 'https://example.com',
        );

        $expected = [
            'ip' => '8.8.8.8',
            'country' => 'US',
            'city' => 'Mountain View',
            'userAgent' => 'Mozilla/5.0',
            'referer' => 'https://example.com',
        ];

        $this->assertSame($expected, $info->jsonSerialize());
    }

    public function testJsonEncoding(): void
    {
        $info = new NetworkInfo(
            ip: '8.8.8.8',
            country: 'US',
            city: 'Mountain View',
            userAgent: 'Mozilla/5.0',
            referer: 'https://example.com',
        );

        $json = json_encode($info);
        $decoded = json_decode($json, true);

        $expected = [
            'ip' => '8.8.8.8',
            'country' => 'US',
            'city' => 'Mountain View',
            'userAgent' => 'Mozilla/5.0',
            'referer' => 'https://example.com',
        ];

        $this->assertSame($expected, $decoded);
    }
}
