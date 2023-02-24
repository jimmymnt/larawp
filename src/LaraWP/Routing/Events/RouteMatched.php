<?php

namespace LaraWP\Routing\Events;

class RouteMatched
{
    /**
     * The route instance.
     *
     * @var \LaraWP\Routing\Route
     */
    public $route;

    /**
     * The request instance.
     *
     * @var \LaraWP\Http\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param \LaraWP\Routing\Route $route
     * @param \LaraWP\Http\Request $request
     * @return void
     */
    public function __construct($route, $request)
    {
        $this->route = $route;
        $this->request = $request;
    }
}
