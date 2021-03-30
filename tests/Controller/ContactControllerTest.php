<?php

declare(strict_types=1);

namespace Svc\ProfileBundle\Tests\Controller;

use Svc\UtilBundle\Tests\SvcUtilTestingKernel;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ChangeMailControllerTest extends KernelTestCase
{

  public function testOpenContactForm()
  {
    $kernel = new SvcUtilTestingKernel();
    $client = new KernelBrowser($kernel);
    $client->request('GET', '/api/en/contact');
    $this->assertSame(200, $client->getResponse()->getStatusCode());
  }

  public function testContactFormContent()
  {
    $kernel = new SvcUtilTestingKernel();
    $client = new KernelBrowser($kernel);
    $client->request('GET', '/api/en/contact');
    $this->assertStringContainsString("Contact", $client->getResponse()->getContent());
  }

  public function testContactFormContentDE()
  {
    $kernel = new SvcUtilTestingKernel();
    $client = new KernelBrowser($kernel);
    $client->request('GET', '/api/de/contact');
    $this->assertStringContainsString("Kontakt", $client->getResponse()->getContent());
  }
}
