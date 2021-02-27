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
    $rootPath = $container->getParameter("kernel.project_dir");
    $this->createConfigIfNotExists($rootPath);

    $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    $loader->load('services.xml');

    $configuration = $this->getConfiguration($configs, $container);
    $config = $this->processConfiguration($configuration, $configs);

    // set arguments for __construct in services
    $definition = $container->getDefinition('svc_util.service.mailhelper');
    $definition->setArgument(0, $config["mailer"]['mail_address']);
    $definition->setArgument(1, $config["mailer"]['mail_name'] ?? null);
  }

  private function createConfigIfNotExists($rootPath) {
    $fileName= $rootPath . "/config/packages/svc_util.yaml";
    if (!file_exists($fileName)) {
      $text="svc_util:\n";
      $text.="    general:\n";
      $text.="        # Should we debug a little bit?\n";
      $text.="        debug:                false\n";
      $text.="    mailer:\n";
      $text.="        # Default sender mail address\n";
      $text.="        mail_address:         dev@sv-systems.com\n";
      $text.="        # Default sender name\n";
      $text.="        mail_name:\n";
      file_put_contents($fileName, $text);
      dump ("Please adapt config file $fileName");
    }

    $fileName= $rootPath . "/config/routes/svc_util.yaml";
    if (!file_exists($fileName)) {
      $text="_svc_util:\n";
      $text.="    resource: '@SvcUtilBundle/src/Resources/config/routes.xml'\n";
      $text.="    prefix: /envinfo\n";
      file_put_contents($fileName, $text);
    }
  }
}