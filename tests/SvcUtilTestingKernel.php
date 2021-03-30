<?php

namespace Svc\UtilBundle\Tests;

require_once(__dir__ . "/Dummy/AppKernelDummy.php");

use App\Kernel as AppKernel;
use Symfony\Component\HttpKernel\Kernel;
use Svc\UtilBundle\SvcUtilBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Bundle\TwigBundle\TwigBundle;

/**
 * Test kernel
 */
class SvcUtilTestingKernel extends Kernel
{
  use MicroKernelTrait;

  private $builder;
  private $routes;
  private $extraBundles;

  /**
   * @param array             $routes  Routes to be added to the container e.g. ['name' => 'path']
   * @param BundleInterface[] $bundles Additional bundles to be registered e.g. [new Bundle()]
   */
  public function __construct(ContainerBuilder $builder = null, array $routes = [], array $bundles = [])
  {
    $this->builder = $builder;
    $this->routes = $routes;
    $this->extraBundles = $bundles;

    parent::__construct('test', true);
  }

  public function registerBundles(): array
  {
    return [
      new SvcUtilBundle(),
      new FrameworkBundle(),
      new TwigBundle(),
    ];
  }

  public function registerContainerConfiguration(LoaderInterface $loader): void
  {
    if (null === $this->builder) {
      $this->builder = new ContainerBuilder();
    }

    $builder = $this->builder;

    $loader->load(function (ContainerBuilder $container) use ($builder) {
      $container->merge($builder);

      $container->loadFromExtension(
        'framework',
        [
          'secret' => 'foo',
          'router' => [
            'resource' => 'kernel::loadRoutes',
            'type' => 'service',
            'utf8' => true,
          ],
        ]
      );
      
      $container->register(AppKernel::class)
      ->setAutoconfigured(true)
      ->setAutowired(true);

      $container->register('kernel', static::class)->setPublic(true);

      $kernelDefinition = $container->getDefinition('kernel');
      $kernelDefinition->addTag('routing.route_loader');
    });
  }

  /**
   * load bundle routes
   *
   * @param RoutingConfigurator $routes
   * @return void
   */
  protected function configureRoutes(RoutingConfigurator $routes)
  {
    $routes->import(__DIR__ . '/../src/Resources/config/routes.xml')->prefix('/api/{_locale}');
  }

  protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
  {
  }
}
