<?php

namespace Svc\UtilBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Svc\UtilBundle\Service\UIHelper;

/**
 * Unit tests for class UIHelper.
 */
class UIHelperTest extends TestCase
{
  /**
   * check function getRandomColor.
   *
   * @return void
   */
  public function testGetRandomColor()
  {
    $helper = new UIHelper();
    $result = $helper->getRandomColor();
    $this->assertNotEmpty($result);
    $this->assertStringStartsWith('rgb', $result);
  }
}
