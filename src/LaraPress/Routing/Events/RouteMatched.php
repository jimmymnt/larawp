<?php

namespace LaraPress\Routing\Events;

class RouteMatched
{
    /**
     * The route instance.
     *
     * @var \LaraPress\Routing\Route
     */
    public $route;

    /**
     * The request instance.
     *
     * @var \LaraPress\Http\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param \LaraPress\Routing\Route $route
     * @param \LaraPress\Http\Request $request
     * @return void
     */
    public function __construct($route, $request)
    {
        $this->route = $route;
        $this->request = $request;
    }
}
