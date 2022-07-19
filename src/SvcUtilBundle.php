<?php

namespace Svc\UtilBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class SvcUtilBundle extends AbstractBundle
{
  public function getPath(): string
  {
    return \dirname(__DIR__);
  }

  public function configure(DefinitionConfigurator $definition): void
  {
    $definition->rootNode()
      ->children()
        ->arrayNode('mailer')->addDefaultsIfNotSet()
          ->children()
            ->scalarNode('mail_address')->cannotBeEmpty()->defaultValue('test@test.com')->info('Default sender mail address')->end()
            ->scalarNode('mail_name')->cannotBeEmpty()->defaultValue('Test User')->info('Default sender name')->end()
          ->end()
        ->end()
      ->end();
  }

  public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
  {
    $container->import('../config/services.yaml');

    $container->services()
      ->get('Svc\UtilBundle\Service\MailerHelper')
      ->arg(1, $config['mailer']['mail_address'])
      ->arg(2, $config['mailer']['mail_name'] ?? null);
  }
}
