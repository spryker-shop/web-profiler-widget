<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\WebProfilerWidget\Router;

use Symfony\Component\Routing\Loader\ClosureLoader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

class WebProfilerRouterBuilder
{
    /**
     * @param callable $routeDefinitionsProvider Returns a list of `[$pathinfo, $controller, $routeName]` definitions.
     *
     * @return \Symfony\Component\Routing\RouterInterface
     */
    public function buildRouter(callable $routeDefinitionsProvider): RouterInterface
    {
        $loader = new ClosureLoader();

        $resource = function () use ($routeDefinitionsProvider) {
            $routeCollection = new RouteCollection();
            foreach ($routeDefinitionsProvider() as $routeDefinition) {
                [$pathinfo, $controller, $routeName] = $routeDefinition;

                $route = new Route($pathinfo);
                $route->setMethods('GET');
                $route->setDefault('_controller', $controller);

                $routeCollection->add($routeName, $route, 0);
            }

            return $routeCollection;
        };

        return new Router($loader, $resource, []);
    }
}
