<?php

/**
 * This file is part of Spiral package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Bootloader;

use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Router\Route;
use Spiral\Router\RouteInterface;
use Spiral\Router\RouterInterface;
use Spiral\Router\Target\Namespaced;

class RoutesBootloader extends Bootloader
{
    /**
     * Bootloader execute method.
     *
     * @param RouterInterface $router
     */
    public function boot(RouterInterface $router): void
    {
        $router->setDefault($this->defaultRoute());
    }

    /**
     * Default route points to namespace of controllers.
     *
     * @return RouteInterface
     */
    protected function defaultRoute(): RouteInterface
    {
        $defaults = ['controller' => 'home', 'action' => 'index'];
//        $middleware = new ExceptionFirewall(new UnauthorizedException('Invalid token'));
        $route = new Route(
            '/[<controller>[/<action>[/<id>]]]',
            new Namespaced('App\\Controller')
        );

        return $route
            ->withDefaults($defaults)
//            ->withMiddleware($middleware)
            ;
    }
}
