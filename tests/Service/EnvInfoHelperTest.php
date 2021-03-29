<?php

namespace Svc\UtilBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Svc\UtilBundle\Service\EnvInfoHelper;

/**
 * Unit tests for class EnvInfo
 * Helper
 */
class EnvInfoHelperTest extends TestCase
{
  /**
   * check root url, should by empty in tests
   *
   * @return void
   */
  public function getURLtoIndexPhp()
  {
    $helper = new EnvInfoHelper();
    $result = $helper->getRootURL();
    $this->assertEquals("://", $result); // should be only "://"
  }

  /**
   * check root url and prefix, should by empty in tests
   *
   * @return void
   */
  public function testRootUrlAndPrefix()
  {
    $helper = new EnvInfoHelper();
    $result = $helper->getRootURLandPrefix();
    $this->assertEquals("://", $result); // should be only "://" because returns getURLtoIndexPhp
  }

  /**
   * check URL to index.php, should by empty in tests
   *
   * @return void
   */
  public function testURLtoIndexPhp()
  {
    $helper = new EnvInfoHelper();
    $result = $helper->getURLtoIndexPhp();
    $this->assertEquals("://vendor/bin/simple-phpunit", $result); // should be path to simple-phpunit
  }
}
