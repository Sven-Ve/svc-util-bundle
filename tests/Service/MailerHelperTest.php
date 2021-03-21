<?php

namespace Svc\UtilBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Svc\UtilBundle\SvcUtilBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class MailHelperTest extends TestCase
{

  public function testMailOptions() {

    $kernel = new SvcUtilTestingKernel('test', true);
    $kernel->boot();
    $container = $kernel->getContainer();
//    $mail = $container->get('mailer.mailer');
    $mail = $container->get('svc_util.service.mailhelper');

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

class SvcUtilTestingKernel extends Kernel
{
    public function registerBundles()
    {
      return [
        new SvcUtilBundle(),
        new FrameworkBundle()
    ];
    }
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }
}