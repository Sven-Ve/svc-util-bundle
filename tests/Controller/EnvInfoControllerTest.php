<?php

declare(strict_types=1);

namespace Svc\ProfileBundle\Tests\Controller;

use Svc\UtilBundle\Tests\SvcUtilTestingKernel;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EnvInfoControllerTest extends KernelTestCase
{

  public function DISABLEDtestEnvInfoForm()
  {
    $kernel = new SvcUtilTestingKernel();
    $client = new KernelBrowser($kernel);
    $client->request('GET', '/api/en/envinfo');
    $this->assertSame(200, $client->getResponse()->getStatusCode());
  }

  /*
  public function testContactContactForm()
  {
    $kernel = new SvcUtilTestingKernel();
    $client = new KernelBrowser($kernel);
    $client->request('GET', '/api/en/contact');
    $this->assertStringContainsString("Contact", $client->getResponse()->getContent());
  }
*/
}
