<?php

use LaraPress\Wordpress\Http\Response\Content;
use LaraPress\Wordpress\Http\Response\Shortcode;
use LaraPress\Wordpress\Http\Response\Page;

if (!function_exists('is_wp')) {
    /**
     * Check if we are running in wp
     * @return bool
     */
    function is_wp()
    {
        return function_exists('add_filter');
    }
}
if (!function_exists('lp_view')) {
    /**
     * Get the full page view
     *
     * @param  $view
     * @param \LaraPress\Contracts\Support\Arrayable|array $data
     * @param array $mergeData
     * @return \LaraPress\Wordpress\Http\Response\Page
     */
    function lp_view($view, $data = [], $mergeData = [])
    {
        return Page::make($view, $data, $mergeData);
    }
}
if (!function_exists('content_view')) {
    /**
     * Get the post content view
     *
     * @param  $view
     * @param \LaraPress\Contracts\Support\Arrayable|array $data
     * @param array $mergeData
     * @return \LaraPress\Wordpress\Http\Response\Content
     */
    function content_view($view, $data = [], $mergeData = [])
    {
        return Content::make($view, $data, $mergeData);
    }
}
if (!function_exists('shortcode_view')) {
    /**
     * Get the shortcode view
     *
     * @param  $view
     * @param \LaraPress\Contracts\Support\Arrayable|array $data
     * @param array $mergeData
     * @param string $tag
     * @return \LaraPress\Wordpress\Http\Response\Shortcode
     */
    function shortcode_view($view, $data = [], $mergeData = [], $tag = null)
    {
        return Shortcode::make($view, $data, $mergeData, $tag);
    }
}

if (!function_exists('lp_plugin_url')) {
    /**
     * Get url to ws plugin
     * @param string $path Optional. Path relative to the site URL. Default empty.
     * @param string|null $scheme Optional. Scheme to give the site URL context. See set_url_scheme().
     * @return string
     */
    function lp_plugin_url($path = '', $scheme = null)
    {
        if (defined('ABSPATH') && defined('__WS_FILE__')) {
            $basePath = str_replace(ABSPATH, '', __WS_FILE__);
            $basePath = trim(dirname($basePath), '\/');
            return site_url($basePath . '/' . ltrim($path, '/'), $scheme);
        }
    }
}
if (!function_exists('lp_admin_menu')) {
    /**
     * Get current admin menu
     * @return null|\LaraPress\Wordpress\Admin\Routing\Menu
     */
    function lp_admin_menu()
    {
        return lp_app('wp.admin.router')->current();
    }
}

if (!function_exists('lp_admin_url')) {
    /**
     * Get url to admin page
     * @param string $slug The slug name to refer to this menu by (should be unique for this menu).
     * @param array $params Query to add to url
     */
    function lp_admin_url($slug = null, $params = [])
    {
        return lp_app('url')->admin($slug, $params);
    }
}
if (!function_exists('lp_pass')) {
    /**
     * Bypass response
     * @return \LaraPress\Wordpress\Http\Response\PassThrough
     */
    function lp_pass()
    {
        return lp_redirect()->pass();
    }
}


if (!function_exists('lp_setting')) {
    /**
     * Get or set the setting
     * @param $key
     * @param $default
     * @return mixed|\LaraPress\Wordpress\Setting\Repository|null
     */
    function lp_setting($key = null, $default = null)
    {
        if (is_null($key)) {
            return lp_app('setting');
        }
        if (is_array($key)) {
            return lp_app('setting')->set($key);
        }

        return lp_app('setting')->get($key, $default);
    }
}

if (!function_exists('lp_admin_notice')) {
    /**
     * @param $message
     * @param $type
     * @return \LaraPress\Wordpress\Admin\Notice\NoticeManager|\LaraPress\Wordpress\Admin\Notice\Message
     */
    function lp_admin_notice($message = null, $type = 'success')
    {
        if (is_null($message)) {
            return lp_app('wp.admin.notice');
        }
        return lp_app('wp.admin.notice')->notify($message, $type);
    }
}
