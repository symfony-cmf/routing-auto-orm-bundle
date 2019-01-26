<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2018 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Tests\Fixtures\App;

use Symfony\Cmf\Bundle\RoutingAutoBundle\CmfRoutingAutoBundle;
use Symfony\Cmf\Bundle\RoutingAutoOrmBundle\CmfRoutingAutoOrmBundle;
use Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle;
use Symfony\Cmf\Component\Testing\HttpKernel\TestKernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class Kernel extends TestKernel
{
    public function configure()
    {
        $this->requireBundleSets(['default', 'doctrine_orm']);

        $this->addBundles([
            new CmfRoutingBundle(),
            new CmfRoutingAutoBundle(),
            new CmfRoutingAutoOrmBundle(),

            new TestBundle(),
        ]);
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->import(__DIR__.'/config/config.php');
    }
}
