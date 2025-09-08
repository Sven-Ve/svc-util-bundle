<?php

/*
 * This file is part of the svc/util-bundle.
 *
 * (c) 2025 Sven Vetter <dev@sv-systems.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Svc\UtilBundle;

use Symfony\Component\AssetMapper\AssetMapperInterface;
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

            ->arrayNode('twig_components')->addDefaultsIfNotSet()
              ->children()
                ->integerNode('table_default_type')->defaultNull()->info('Default table type')->end()
              ->end()
            ->end()

          ->end();
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.php');

        $container->services()
          ->get('Svc\UtilBundle\Service\MailerHelper')
          ->arg(1, $config['mailer']['mail_address'])
          ->arg(2, $config['mailer']['mail_name'] ?? null);

        $container->services()
          ->get('Svc\UtilBundle\Twig\Components\Table')
          ->arg(1, $config['twig_components']['table_default_type'] ?? null)
        ;
    }

    public function prependExtension(ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void
    {
        if (!$this->isAssetMapperAvailable($containerBuilder)) {
            return;
        }

        $containerBuilder->prependExtensionConfig('framework', [
            'asset_mapper' => [
                'paths' => [
                    __DIR__ . '/../assets/src' => '@svc/util-bundle',
                ],
            ],
        ]);
    }

    private function isAssetMapperAvailable(ContainerBuilder $container): bool
    {
        if (!interface_exists(AssetMapperInterface::class)) {
            return false;
        }

        // check that FrameworkBundle 6.3 or higher is installed
        $bundlesMetadata = $container->getParameter('kernel.bundles_metadata');
        if (!isset($bundlesMetadata['FrameworkBundle'])) {
            return false;
        }

        return is_file($bundlesMetadata['FrameworkBundle']['path'] . '/Resources/config/asset_mapper.php');
    }
}
