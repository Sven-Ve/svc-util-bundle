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
      ->arrayNode('contact_form')->addDefaultsIfNotSet()
        ->children()
          ->scalarNode('contact_mail')->cannotBeEmpty()->defaultValue('dev@sv-systems.com')->info('Email adress for contact mails')->end()
          ->scalarNode('route_after_send')->cannotBeEmpty()->defaultValue('index')->info('Which route should by called after amil sent')->end()
          ->booleanNode('enable_captcha')->defaultFalse()->info('Enable captcha for contact form?')->end()
          ->booleanNode('enable_copy_to_me')->defaultTrue()->info('Enable sending a copy of the contact request to me too?')->end()
        ->end()
      ->end()
      ->arrayNode('mailer')->addDefaultsIfNotSet()
        ->children()
          ->scalarNode('mail_address')->cannotBeEmpty()->defaultValue('dev@sv-systems.com')->info('Default sender mail address')->end()
          ->scalarNode('mail_name')->cannotBeEmpty()->defaultValue('Test User')->info('Default sender name')->end()
        ->end()
      ->end()
    ->end();
    return $treeBuilder;
    }

}