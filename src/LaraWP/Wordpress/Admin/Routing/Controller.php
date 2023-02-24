<?php

namespace LaraWP\Wordpress\Admin\Routing;

use LaraWP\Wordpress\Admin\View\Layout;

abstract class Controller extends \LaraWP\Routing\Controller
{
    /**
     * @var Menu
     */
    protected $menu;

    public function setMenu($menu)
    {
        $this->menu = $menu;
        return $this;
    }


}