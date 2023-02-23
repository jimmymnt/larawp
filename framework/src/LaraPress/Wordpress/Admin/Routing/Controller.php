<?php

namespace LaraPress\Wordpress\Admin\Routing;

use LaraPress\Wordpress\Admin\View\Layout;

abstract class Controller extends \LaraPress\Routing\Controller
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