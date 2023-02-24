<?php

namespace LaraWP\Wordpress\Routing;

use LaraWP\Container\Container;
use LaraWP\Contracts\Events\Dispatcher;
use LaraWP\Http\Request;
use LaraWP\Routing\Route as BaseRoute;
use LaraWP\Routing\Router as BaseRouter;

class Router extends BaseRouter
{
    /**
     * @var RouteCollection
     */
    protected $routes;

    /**
     * @param Dispatcher $events
     * @param Container|null $container
     */
    public function __construct(Dispatcher $events, Container $container = null)
    {
        parent::__construct($events, $container);
        $this->routes = new RouteCollection();
    }

    public function newRoute($methods, $uri, $action)
    {
        return (new Route($methods, $uri, $action))
            ->setRouter($this)
            ->setContainer($this->container);
    }

    protected function runRoute(Request $request, BaseRoute $route)
    {
        $response = parent::runRoute($request, $route);
        $route->setResponse($response);
        return $response;
    }

}