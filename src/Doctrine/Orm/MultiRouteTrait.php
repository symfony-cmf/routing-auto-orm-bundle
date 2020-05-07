<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2018 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\RoutingAutoOrmBundle\Doctrine\Orm;

/**
 * Class MultiRouteTrait.
 *
 * @author WAM Team <develop@wearemarketing.com>
 */
trait MultiRouteTrait
{
    protected $routes;

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        $this->routes = is_array($this->routes) ? $this->routes : [];

        return $this->routes;
    }

    /**
     * {@inheritdoc}
     */
    public function addRoute($route)
    {
        $this->initRoutes();

        if (!in_array($route, $this->routes)) {
            $this->routes[] = $route;
        }

        return $this;
    }

    protected function initRoutes()
    {
        if (!$this->routes) {
            $this->routes = [];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeRoute($route)
    {
        $this->initRoutes();

        $key = array_search($route, $this->routes);
        if ($key !== false) {
            unset($this->routes[$key]);
        }

        return $this;
    }
}
