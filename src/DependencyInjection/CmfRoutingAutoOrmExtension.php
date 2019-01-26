<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\RoutingAutoOrmBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class CmfRoutingAutoOrmExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $config = $processor->processConfiguration($configuration, $configs);

        $loader->load('orm.xml');

        $container->setParameter('cmf_routing_auto.auto_route_entity.class', $config['route_class']);
    }

    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        $bundles = $container->getParameter('kernel.bundles');

        if (isset($bundles['CmfRoutingBundle'])) {
            $cmfRoutingBundle = [
                'dynamic' => [
                    'persistence' => [
                        'orm' => [
                            'enabled' => true,
                            'route_class' => $config['route_class'],
                        ],
                        'phpcr' => [
                            'enabled' => false,
                        ],
                    ],
                ],
            ];

            $container->prependExtensionConfig('cmf_routing', $cmfRoutingBundle);
        }

        if (isset($bundles['CmfRoutingAutoBundle'])) {
            $cmfRoutingAutoBundle = [
                'adapter' => 'doctrine_orm',
                'persistence' => [
                    'phpcr' => [
                        'enabled' => false,
                    ],
                ],
            ];

            $container->prependExtensionConfig('cmf_routing_auto', $cmfRoutingAutoBundle);
        }
    }
}
