<?php

declare(strict_types=1);

namespace Svc\ProfileBundle\Tests\Controller;

use Svc\UtilBundle\Tests\SvcUtilTestingKernel;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EnvInfoControllerTest extends KernelTestCase
{

  /**
   * set SERVER keys, not available in test envs
   *
   * @return void
   */
  protected function setUp(): void
  {
    $_SERVER["SERVER_SIGNATURE"] = "testing";
    $_SERVER["SERVER_SOFTWARE"] = "testing";
    $_SERVER["SERVER_ADMIN"] = "testing";
    $_SERVER["APP_ENV"] = "testing";
    $_SERVER["SYMFONY_DOTENV_VARS"] = "testing";
    $_SERVER["APP_DEBUG"] = 1;
  }

  public function testEnvInfoForm(): void
  {
    $kernel = new SvcUtilTestingKernel();
    $client = new KernelBrowser($kernel);
    $client->request('GET', '/api/en/envinfo');
    $this->assertSame(200, $client->getResponse()->getStatusCode());
  }

  public function testEnvInfoFormContent(): void
  {
    $kernel = new SvcUtilTestingKernel();
    $client = new KernelBrowser($kernel);
    $client->request('GET', '/api/en/envinfo');
    $this->assertStringContainsString("Admin Info", $client->getResponse()->getContent());
  }
}
