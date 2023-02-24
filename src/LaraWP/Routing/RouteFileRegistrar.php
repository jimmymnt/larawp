<?php

namespace LaraWP\Routing;

class RouteFileRegistrar
{
    /**
     * The router instance.
     *
     * @var \LaraWP\Routing\Router
     */
    protected $router;

    /**
     * Create a new route file registrar instance.
     *
     * @param \LaraWP\Routing\Router $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Require the given routes file.
     *
     * @param string $routes
     * @return void
     */
    public function register($routes)
    {
        $router = $this->router;

        require $routes;
    }
}
