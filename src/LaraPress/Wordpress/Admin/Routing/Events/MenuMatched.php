<?php

namespace LaraPress\Wordpress\Admin\Routing\Events;

use LaraPress\Wordpress\Admin\Routing\Menu;

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
     * @var \LaraPress\Http\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param \LaraPress\Wordpress\Admin\Routing\Menu $route
     * @param \LaraPress\Http\Request $request
     * @return void
     */
    public function __construct($menu, $request)
    {
        $this->menu = $menu;
        $this->request = $request;
    }
}