<?php

namespace LaraPress\Wordpress\Admin\Facades;

use LaraPress\Support\Facades\Facade;
use LaraPress\Wordpress\Admin\Routing\Menu;
use LaraPress\Wordpress\Admin\Routing\MenuCollection;
use LaraPress\Wordpress\Admin\View\Layout;

/**
 * @method static Menu add($slug, $callback, $capability = 'read', $title = '', $page_title = '', $icon = '', $position = null)
 * @method static Menu menu($slug)
 * @method static Menu current()
 * @method static MenuCollection menus()
 * @method static \LaraPress\Wordpress\Admin\Routing\RouteRegistrar parent($parent)
 * @method static \LaraPress\Wordpress\Admin\Routing\RouteRegistrar middleware(array|string|null $middleware = null)
 * @method static \LaraPress\Wordpress\Admin\Routing\RouteRegistrar namespace(string|null $value = null)
 * @method static void group(\Closure|string|array $attributes, \Closure|string $routes)
 */
class Route extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'wp.admin.router';
    }
}