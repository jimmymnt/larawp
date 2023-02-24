<?php

namespace LaraWP\Wordpress\Routing;

use LaraWP\Support\ServiceProvider;

class RoutingServiceProvider extends ServiceProvider
{
    function register()
    {
        $this->app->singleton('wp.router', function ($app) {
            return new Router($app['events'], $app);
        });
        $this->app->alias('wp.router', Router::class);
    }

    function boot()
    {

    }
}