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
    $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    $loader->load('services.xml');

    $configuration = $this->getConfiguration($configs, $container);
    $config = $this->processConfiguration($configuration, $configs);

    // set arguments for __construct in services (mailhelper)
    $definition = $container->getDefinition('svc_util.service.mailhelper');
    $definition->setArgument(1, $config["mailer"]['mail_address']);
    $definition->setArgument(2, $config["mailer"]['mail_name'] ?? null);
  }
}
