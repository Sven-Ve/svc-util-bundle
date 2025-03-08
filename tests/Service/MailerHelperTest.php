<?php

/*
 * This file is part of the svc/util-bundle.
 *
 * (c) Sven Vetter <dev@sv-systems.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Svc\UtilBundle\Tests\Service;

use Svc\UtilBundle\Service\MailerHelper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Mime\Email;

/**
 * testing the MailHelper class.
 */
class MailerHelperTest extends KernelTestCase
{
  /**
   * check if a call to send possible and all options are resolved.
   *
   * use a dry run, not sending real mail
   *
   * @return void
   */
  public function testMailOptions()
  {
    $kernel = self::bootKernel();
    $container = $kernel->getContainer();
    $mail = $container->get('Svc\UtilBundle\Service\MailerHelper');

    $this->assertInstanceOf(MailerHelper::class, $mail);

    $result = $mail->send('dev@sv-systems.com', 'Hallo', '<h2>Test</h2>', null, [
      'priority' => Email::PRIORITY_LOW,
      'cc' => 'technik@sv-systems.com',
      'bcc' => 'sven@svenvetter.com',
      'replyTo' => 'sven@svenvetter.com',
      'dryRun' => true,
    ]);
    $this->assertEquals(true, $result);
  }

  /**
   * check call with wrong option (should raise an exception).
   *
   * @return void
   */
  public function testMailWrongOptions()
  {
    $kernel = self::bootKernel();
    $container = $kernel->getContainer();
    $mail = $container->get('Svc\UtilBundle\Service\MailerHelper');

    $this->expectException("Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException");
    $mail->send('dev@sv-systems.com', 'Hallo', '<h2>Test</h2>', null, [
      'WRONGpriority' => Email::PRIORITY_LOW,
      'dryRun' => true,
    ]);
  }
}
