<?php

namespace Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Tests\Unit\Doctrine\Orm;

use PHPUnit\Framework\TestCase;
use Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Doctrine\Orm\AutoRoute;
use Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Tests\Fixtures\DummyMultiRouteTraitClass;

class MultiRouteTraitTest extends TestCase
{
    public function testRemoveRouteWhenRoutesIsEmpty()
    {
        $dummy = new DummyMultiRouteTraitClass();

        $dummy->removeRoute(new AutoRoute());

        $this->assertCount(0, $dummy->getRoutes());
    }

    public function testRemoveRouteWhenRouteDoesNotInRoutes()
    {
        $dummy = new DummyMultiRouteTraitClass();
        $route = new AutoRoute();
        $route->setCanonicalName('route_1');
        $dummy->addRoute($route);

        $dummy->removeRoute(new AutoRoute());

        $this->assertCount(1, $dummy->getRoutes());
    }

    public function testRemoveRouteWhenRoutesHaveIt()
    {
        $dummy = new DummyMultiRouteTraitClass();
        $route = new AutoRoute();
        $dummy->addRoute($route);

        $dummy->removeRoute(new AutoRoute());

        $this->assertCount(0, $dummy->getRoutes());
    }
}
