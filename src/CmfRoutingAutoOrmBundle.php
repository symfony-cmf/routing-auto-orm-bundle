<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2018 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\RoutingAutoOrmBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Cmf\Bundle\RoutingAutoOrmBundle\DependencyInjection\Compiler\AdaptRefreshCommandPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CmfRoutingAutoOrmBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        // Disabled phpcr mappings
        $container->getParameterBag()->remove('cmf_routing.backend_type_phpcr');

        $this->buildOrmCompilerPass($container);
    }

    /**
     * Creates and registers compiler passes for ORM mappings if both doctrine
     * ORM and a suitable compiler pass implementation are available.
     *
     * @param ContainerBuilder $container
     */
    private function buildOrmCompilerPass(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        if (!isset($bundles['CmfRoutingBundle']) || !isset($bundles['DoctrineBundle']) || isset($bundles['DoctrinePHPCRBundle'])) {
            return;
        }

        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createXmlMappingDriver(
                [
                    realpath(__DIR__.'/Resources/config/doctrine-model') => 'Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Doctrine\Orm',
                ],
                ['cmf_routing.dynamic.persistence.orm.manager_name'],
                false,
                ['CmfRoutingAutoOrmBundle' => 'Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Doctrine\Orm']
            )
        );
    }
}
