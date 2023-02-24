<?php

namespace LaraWP\Wordpress\Facades;

use LaraWP\Support\Facades\Facade;

/**
 * @method static \LaraWP\Wordpress\Shortcode\ShortcodeManager add($shortcode, $callable = null)
 * @method static \LaraWP\Wordpress\Shortcode\ShortcodeManager setBootHook($hook, $priority = 10)
 * @method static \LaraWP\Wordpress\View\Shortcode get($tag)
 * @method static boolean has($tag)
 */
class Shortcode extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'wp.shortcode';
    }
}