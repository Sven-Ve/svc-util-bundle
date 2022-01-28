<?php

namespace Svc\UtilBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
  public function getConfigTreeBuilder(): TreeBuilder
  {
    $treeBuilder = new TreeBuilder('svc_util');
    $rootNode = $treeBuilder->getRootNode();

    $rootNode
    ->children()
      ->arrayNode('mailer')->addDefaultsIfNotSet()
        ->children()
          ->scalarNode('mail_address')->cannotBeEmpty()->defaultValue('test@test.com')->info('Default sender mail address')->end()
          ->scalarNode('mail_name')->cannotBeEmpty()->defaultValue('Test User')->info('Default sender name')->end()
        ->end()
      ->end()
    ->end();
    return $treeBuilder;
    }
}
