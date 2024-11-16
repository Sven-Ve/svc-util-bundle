<?php

namespace Svc\UtilBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Svc\UtilBundle\Service\BotChecker;

/**
 * Unit tests for class BotChecker
 * Helper.
 */
class BotCheckerTest extends TestCase
{


  /**
   * check if UserAgent a google bot
   *
   * @return void
   */
  public function testGoogleBot()
  {
    $helper = new BotChecker();
    $result = $helper->getBot('Google');
    $this->assertNotNull($result);
    $this->assertEquals('Googlebot', $result['name']);
  }

  public function testAmazonBot()
  {
    $helper = new BotChecker();
    $result = $helper->getBot('Amazonbot/1');
    $this->assertNotNull($result);
    $this->assertEquals('Amazon Bot', $result['name']);
  }

  public function testNoBot()
  {
    $helper = new BotChecker();
    $result = $helper->getBot();
    $this->assertNull($result);
  }

  public function testRealUseragent()
  {
    $helper = new BotChecker();
    $result = $helper->getBot("Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:132.0) Gecko/20100101 Firefox/132.");
    $this->assertNull($result);
  }

}
