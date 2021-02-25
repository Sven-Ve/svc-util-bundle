<?php

namespace Svc\UtilBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SvcUtilExtension extends Extension
{
  public function load(array $configs, ContainerBuilder $container)
  {
    // $rootPath = $container->getParameter("kernel.project_dir");
    // $this->createConfigIfNotExists($rootPath);

    $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    $loader->load('services.xml');

    $configuration = $this->getConfiguration($configs, $container);
    $config = $this->processConfiguration($configuration, $configs);

    // set arguments for __construct in services
    // $definition = $container->getDefinition('svc_versioning.release_prod_command');
    // $definition->setArgument(0, $config['run_git']);
    // $definition->setArgument(1, $config['run_deploy']);
  }

  private function createConfigIfNotExists($rootPath) {
    $fileName= $rootPath . "/config/packages/svc_xx.yaml";
    if (file_exists($fileName)) {
      return false;
    }
    
    $text="svc_xx:\n";
    $text.="    # Default sender mail address\n";
    $text.="    mail_address:         dev@sv-systems.com\n";
    $text.="    # Default sender name\n";
    $text.="    mail_name:           ~\n";

    file_put_contents($fileName, $text);
  }
}