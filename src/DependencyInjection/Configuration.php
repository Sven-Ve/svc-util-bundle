<?php

namespace Svc\UtilBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
  public function getConfigTreeBuilder()
  {
    $treeBuilder = new TreeBuilder('svc_util'); # ohne Bundle, so muss es dann im yaml-file heissen
    $rootNode = $treeBuilder->getRootNode();

    $rootNode
    ->children()
      ->arrayNode('general')
        ->children()
          ->booleanNode('debug')->defaultFalse()->info('Should we debug a little bit?')->end()
        ->end()
      ->end()
      ->arrayNode('mailer')
        ->children()
          ->scalarNode('mail_address')->cannotBeEmpty()->defaultValue('dev@sv-systems.com')->info('Default sender mail address')->end()
          ->scalarNode('mail_name')->info('Default sender name')->end()
        ->end()
      ->end()
    ->end();

    return $treeBuilder;
    }

}