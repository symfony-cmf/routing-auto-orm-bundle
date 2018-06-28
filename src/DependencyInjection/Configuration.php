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

use Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Doctrine\Orm\AutoRoute;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Returns the config tree builder.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        // TODO: Add adapter as extensible config param
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('cmf_routing_auto_orm')
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('route_class')->defaultValue(AutoRoute::class)
            ->end();

        return $treeBuilder;
    }
}
