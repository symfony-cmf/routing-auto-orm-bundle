<?php


namespace Symfony\Cmf\Bundle\RoutingAutoOrmBundle\DependencyInjection;


use Symfony\Cmf\Bundle\RoutingAutoOrmBundle\TokenProvider\ContentMethodProvider;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SwitchContentMethodTokenProviderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container->getDefinition('cmf_routing_auto.token_provider.content_method')
            ->setClass(ContentMethodProvider::class);
    }
}
