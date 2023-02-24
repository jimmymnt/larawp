<?php

namespace LaraWP\Wordpress\Admin\Routing\Events;

use LaraWP\Wordpress\Admin\Routing\Menu;

class MenuMatched
{
    /**
     * The menu instance.
     *
     * @var Menu
     */
    public $menu;

    /**
     * The request instance.
     *
     * @var \LaraWP\Http\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param \LaraWP\Wordpress\Admin\Routing\Menu $route
     * @param \LaraWP\Http\Request $request
     * @return void
     */
    public function __construct($menu, $request)
    {
        $this->menu = $menu;
        $this->request = $request;
    }
}