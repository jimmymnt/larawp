<?php

namespace LaraWP\Routing\Contracts;

use LaraWP\Routing\Route;

interface ControllerDispatcher
{
    /**
     * Dispatch a request to a given controller and method.
     *
     * @param \LaraWP\Routing\Route $route
     * @param mixed $controller
     * @param string $method
     * @return mixed
     */
    public function dispatch(Route $route, $controller, $method);

    /**
     * Get the middleware for the controller instance.
     *
     * @param \LaraWP\Routing\Controller $controller
     * @param string $method
     * @return array
     */
    public function getMiddleware($controller, $method);
}
