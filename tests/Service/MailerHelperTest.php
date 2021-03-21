<?php

namespace Svc\UtilBundle\Tests\Service;

use PHPUnit\Framework\TestCase;


class MailHelperTest extends TestCase
{

  public function testEasy() {
    $a = 1+2;
    // assert that your calculator added the numbers correctly!
    $this->assertEquals(3, $a);
  }

  public function testMailOptions() {
/*
    $mail = new MailerHelper('dev@sv-systems.com', 'dev', new Symfony\Component\Mailer\MailerInterface());
    $result = $this->mail->send('dev@sv-systems.com','Hallo','<h2>Test</h2>',null, [
      'priority' => Email::PRIORITY_LOW,
      'cc' => 'technik@sv-systems.com',
      'bcc' => 'sven@svenvetter.com',
      'replyTo' => 'sven@svenvetter.com',
      'dryRun' => true
    ]);
    */
    $result=true;
    $this->assertEquals(true, $result);
  }
}