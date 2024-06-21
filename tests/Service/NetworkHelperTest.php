<?php

namespace Svc\UtilBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Svc\UtilBundle\Service\NetworkHelper;

/**
 * Unit tests for class NetWorkHelper.
 */
class NetworkHelperTest extends TestCase
{
  /**
   * check if location info correct for a IP in Zurich.
   *
   * @return void
   */
  public function testLocationInfo()
  {
    $helper = new NetworkHelper();
    $result = $helper->getLocationInfoByIp('178.197.235.71'); // IP is in Bern...
    $this->assertEquals('CH', $result['country']);
    $this->assertEquals('Zurich', $result['city']);
  }

  /**
   * check if ip info correct.
   *
   * @return void
   */
  public function testIPInfo()
  {
    $helper = new NetworkHelper();
    $result = $helper->getIP();
    $this->assertNull($result, 'IP should by null in test environements');
  }

  /**
   * check if referer info correct.
   *
   * @return void
   */
  public function testRefererInfo()
  {
    $helper = new NetworkHelper();
    $result = $helper->getReferer();
    $this->assertNull($result, 'Referer should by null in test environements');
  }

  /**
   * check if referer info correct.
   *
   * @return void
   */
  public function testUAInfo()
  {
    $helper = new NetworkHelper();
    $result = $helper->getUserAgent();
    $this->assertNull($result, 'UserAgent should by null in test environements');
  }
}
