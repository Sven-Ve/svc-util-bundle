<?php

namespace Svc\UtilBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Svc\UtilBundle\Service\MailerHelper;
use Svc\UtilBundle\Tests\SvcUtilTestingKernel;
use Symfony\Component\Mime\Email;

/**
 * testing the MailHelper class
 */
class MailHelperTest extends TestCase
{

  /**
   * check if a call to send possible and all options are resolved
   * 
   * use a dry run, not sending real mail
   *
   * @return void
   */
  public function testMailOptions() {

    $kernel = new SvcUtilTestingKernel('test', true);
    $kernel->boot();
    $container = $kernel->getContainer();
    $mail = $container->get('svc_util.service.mailhelper');

    $this->assertInstanceOf(MailerHelper::class, $mail);

    $result = $mail->send('dev@sv-systems.com','Hallo','<h2>Test</h2>',null, [
      'priority' => Email::PRIORITY_LOW,
      'cc' => 'technik@sv-systems.com',
      'bcc' => 'sven@svenvetter.com',
      'replyTo' => 'sven@svenvetter.com',
      'dryRun' => true
    ]);
    $this->assertEquals(true, $result);
  }
}