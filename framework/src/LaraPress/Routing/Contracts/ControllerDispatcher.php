<?php

namespace LaraPress\Routing\Contracts;

use LaraPress\Routing\Route;

interface ControllerDispatcher
{
    /**
     * Dispatch a request to a given controller and method.
     *
     * @param \LaraPress\Routing\Route $route
     * @param mixed $controller
     * @param string $method
     * @return mixed
     */
    public function dispatch(Route $route, $controller, $method);

    /**
     * Get the middleware for the controller instance.
     *
     * @param \LaraPress\Routing\Controller $controller
     * @param string $method
     * @return array
     */
    public function getMiddleware($controller, $method);
}
