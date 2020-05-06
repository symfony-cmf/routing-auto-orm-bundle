<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2018 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Tests\WebTest\Orm;

use Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Tests\Fixtures\App\Entity\SeoArticle;
use Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Tests\Functional\OrmBaseTestCase;
use Symfony\Cmf\Component\Testing\Functional\DbManager\ORM;

/**
 * Class RedirectTest.
 *
 * @group orm
 * @group dev
 *
 * @author WAM Team <develop@wearemarketing.com>
 */
class RedirectTest extends OrmBaseTestCase
{
    public function getKernelConfiguration(): array
    {
        return [
            'environment' => 'orm',
        ];
    }

    protected function setUp()
    {
        parent::setUp();

        /** @var ORM $dbManager */
        $dbManager = $this->getDbManager('ORM');
        $dbManager->purgeDatabase();

        $article = new SeoArticle();
        $article->setTitle('SEO Article');
        $this->getObjectManager()->persist($article);
        $this->getObjectManager()->flush();
    }

    public function testRedirect()
    {
        $repository = $this->getObjectManager()->getRepository(SeoArticle::class);
        $article = $repository->findOneByTitle('SEO Article');
        $this->assertNotNull($article);
        $article->setTitle('Renamed Article');
        $this->getObjectManager()->persist($article);
        $this->getObjectManager()->flush();

        $client = $this->createClient(['environment' => 'orm']);
        $client->request('GET', '/seo-articles/seo-article');
        $resp = $client->getResponse();
        $this->assertEquals(301, $resp->getStatusCode());
        $this->assertContains('Redirecting to <a href="http://localhost/seo-articles/renamed-article">http://localhost/seo-articles/renamed-article</a>', $resp->getContent());
    }
}
