<?php

namespace Svc\UtilBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Svc\UtilBundle\Service\NetworkHelper;

class NetworkHelperTest extends TestCase
{
  public function testLocationInfo() {
    $helper = new NetworkHelper();
    $result = $helper->getLocationInfoByIp('178.197.235.71'); // IP is in Zürich...
    $this->assertEquals('CH', $result['country']);
    $this->assertEquals('Zurich', $result['city']);
  }
}