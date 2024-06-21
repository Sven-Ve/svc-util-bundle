<?php

namespace Svc\UtilBundle\Tests;

use Svc\UtilBundle\SvcUtilBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

/**
 * Test kernel.
 */
final class SvcUtilTestingKernel extends Kernel
{
  use MicroKernelTrait;

  public function registerBundles(): iterable
  {
    yield new FrameworkBundle();
    yield new TwigBundle();
    yield new SvcUtilBundle();
  }

  protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
  {
    $config = [
      'http_method_override' => false,
      'secret' => 'foo-secret',
    ];

    $container->loadFromExtension('framework', $config);
  }

  /**
   * load bundle routes.
   *
   * @return void
   */
  private function configureRoutes(RoutingConfigurator $routes)
  {
    $routes->import(__DIR__ . '/../config/routes.yaml')->prefix('/api/{_locale}');
    // $routes->import(__DIR__ . '/../config/routes.yaml')->prefix('/api/en');
  }
}
