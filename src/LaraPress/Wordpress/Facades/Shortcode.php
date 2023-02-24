<?php

namespace LaraPress\Wordpress\Facades;

use LaraPress\Support\Facades\Facade;

/**
 * @method static \LaraPress\Wordpress\Shortcode\ShortcodeManager add($shortcode, $callable = null)
 * @method static \LaraPress\Wordpress\Shortcode\ShortcodeManager setBootHook($hook, $priority = 10)
 * @method static \LaraPress\Wordpress\View\Shortcode get($tag)
 * @method static boolean has($tag)
 */
class Shortcode extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'wp.shortcode';
    }
}