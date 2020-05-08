<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2018 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Tests\Functional\Command;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Command\RefreshCommand;
use Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Doctrine\Orm\AutoRoute;
use Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Tests\Fixtures\App\Entity\Blog;
use Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Tests\Functional\OrmBaseTestCase;
use Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Tests\Fixtures\Repository\DoctrineOrm;
use Symfony\Cmf\Component\Testing\Functional\DbManager\ORM;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @group orm
 *
 * @author WAM Team <develop@wearemarketing.com>
 */
class RefreshCommandTest extends OrmBaseTestCase
{
    public function getKernelConfiguration(): array
    {
        return [
            'environment' => 'orm',
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        /** @var ORM $dbManager */
        $dbManager = $this->getDbManager('ORM');
        $dbManager->purgeDatabase();
    }

    public function testCommand()
    {
        /** @var DoctrineOrm $repository */
        $repository = $this->getRepository();
        $repository->createBlog(true);

        $this->updateBlogTitle($repository);

        $application = $this->getApplication();

        $command = $application->find('cmf:routing:orm:auto:refresh');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['--verbose' => true]);

        $post = $this->getRepository()->findPost('This is a post title');
        $this->getObjectManager()->refresh($post);

        $routes = $post->getRoutes();
        $this->assertCount(2, $routes);
        /** @var AutoRoute $route */
        $route = $routes[1];
        $this->assertEquals('/blog/foobar/2013/03/21/this-is-a-post-title', $route->getStaticPrefix());
    }

    /**
     * @param $repository
     */
    private function updateBlogTitle($repository)
    {
        /** @var Blog $blog */
        $blog = $repository->findBlog('Unit testing blog');
        // test update
        $blog->setTitle('Foobar');
        $blog->mergeNewTranslations();

        /** @var ObjectManager $objectManager */
        $objectManager = $this->getObjectManager();
        $objectManager->persist($blog);
        $objectManager->flush();
        $objectManager->clear();
    }
}
