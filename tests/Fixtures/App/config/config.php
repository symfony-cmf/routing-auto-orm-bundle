<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2018 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$container->setParameter('cmf_testing.bundle_fqn', 'Symfony\Cmf\Bundle\RoutingAutoOrmBundle');
$loader->import(CMF_TEST_CONFIG_DIR.'/default.php');
$loader->import(__DIR__.'/parameters.yml');
$loader->import(__DIR__.'/doctrine_orm.yml');
$loader->import(__DIR__.'/extra_config.yml');
$loader->import(__DIR__.'/app_config.yml');
