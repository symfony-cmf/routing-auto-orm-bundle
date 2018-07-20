<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2018 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\RoutingAutoOrmBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CompilerPass
 *
 * @author WAM Team <develop@wearemarketing.com>
 */
class AdaptRefreshCommandPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $commandService = $container->getDefinition('cmf_routing_auto.auto_route_refresh_command');
        $commandService->replaceArgument(2, new Reference('doctrine.orm.entity_manager'));
        $commandService->replaceArgument(3, new Reference('cmf_routing_auto.adapter.orm'));
    }
}
