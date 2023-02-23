<?php

namespace LaraPress\Wordpress\Routing;

use LaraPress\Container\Container;
use LaraPress\Contracts\Events\Dispatcher;
use LaraPress\Http\Request;
use LaraPress\Routing\Route as BaseRoute;
use LaraPress\Routing\Router as BaseRouter;

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