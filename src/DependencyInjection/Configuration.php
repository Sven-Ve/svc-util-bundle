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
        ->booleanNode('run_git')->defaultTrue()->info('Should git runs after version increase?')->end()
        ->booleanNode('run_deploy')->defaultTrue()->info('Should deploy runs after git?')->end()
        ->scalarNode('mail_address')->cannotBeEmpty()->defaultValue('dev@sv-systems.com')->info('Default sender mail address')->end()
      ->end();
    return $treeBuilder;

    }

}