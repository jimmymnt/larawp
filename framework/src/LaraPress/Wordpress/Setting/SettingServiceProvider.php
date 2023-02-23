<?php

namespace LaraPress\Wordpress\Setting;

use LaraPress\Support\ServiceProvider;

abstract class SettingServiceProvider extends ServiceProvider
{
    function register()
    {
        $this->app->singleton(Repository::class, function () {
            return new Repository($this->getOptionKey());
        });
        $this->app->alias(Repository::class, 'setting');
    }

    abstract protected function getOptionKey();
}