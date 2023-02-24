<?php

namespace LaraWP\Wordpress\Translation;

use LaraWP\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    function register()
    {
        $this->app->singleton('l10n', function ($app) {
            return new L10n($app['config']);
        });
        $this->app->alias('l10n', L10n::class);
    }
}