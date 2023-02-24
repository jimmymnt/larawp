<?php

namespace LaraWP\Wordpress\Console;

use LaraWP\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $earlyBootstrapers = [
        \LaraWP\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \LaraWP\Foundation\Bootstrap\LoadConfiguration::class,
        \LaraWP\Wordpress\Bootstrap\HandleExceptions::class,
        \LaraWP\Foundation\Bootstrap\RegisterFacades::class,
    ];
    /**
     * The bootstrap classes for the application.
     *
     * @var string[]
     */
    protected $bootstrappers = [
        \LaraWP\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \LaraWP\Foundation\Bootstrap\LoadConfiguration::class,
        \LaraWP\Wordpress\Bootstrap\HandleExceptions::class,
        \LaraWP\Foundation\Bootstrap\RegisterFacades::class,
        \LaraWP\Foundation\Bootstrap\SetRequestForConsole::class,
        \LaraWP\Foundation\Bootstrap\RegisterProviders::class,
        \LaraWP\Foundation\Bootstrap\BootProviders::class,
    ];

    function earlyBootstrap()
    {
        foreach ($this->earlyBootstrapers as $bootstraper) {
            $this->app->bootstrapOne($bootstraper);
        }
    }
}