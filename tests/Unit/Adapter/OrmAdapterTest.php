<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2018 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Tests\Unit\Adapter;

use Doctrine\ORM\EntityManagerInterface;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Adapter\OrmAdapter;
use PHPUnit\Framework\TestCase;
use Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Doctrine\Orm\AutoRoute;
use Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Tests\Fixtures\App\Entity\Blog;
use Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Tests\Fixtures\App\Entity\Post;

/**
 * @author WAM Team <develop@wearemarketing.com>
 */
class OrmAdapterTest extends TestCase
{
    /** @var EntityManagerInterface|ObjectProphecy */
    private $em;

    /** @var OrmAdapter */
    private $adapter;

    protected function setUp(): void
    {
        $this->em = $this->prophesize(EntityManagerInterface::class);

        $this->adapter = new OrmAdapter($this->em->reveal(), AutoRoute::class);
    }

    public function testRemoveAutoRoute()
    {
        $content = new Blog();
        $autoRoute1 = new AutoRoute();
        $autoRoute2 = new AutoRoute();
        $content
            ->addRoute($autoRoute1)
            ->addRoute($autoRoute2);

        $this->em->remove($autoRoute1)->shouldBeCalled();
        $this->em->flush($autoRoute1)->shouldBeCalled();

        $this->adapter->removeAutoRoute($autoRoute1);

        $routes = $content->getRoutes();
        $this->assertCount(1, $routes);
        $this->assertEquals($autoRoute2, $routes[0]);
    }

    public function testTranslateObject()
    {
        $post = new Post();
        $post->setCurrentLocale('es');
        $post->setTitle('Titulo');
        $post->setCurrentLocale('en');
        $post->setTitle('Title');
        $post->mergeNewTranslations();

        $translation = $this->adapter->translateObject($post, 'es');

        $this->assertEquals('es', $translation->getLocale());
        $this->assertEquals('Titulo', $translation->getTitle());
        $this->assertEquals('en', $post->getCurrentLocale());
        $this->assertEquals('Title', $post->getTitle());
    }
}
