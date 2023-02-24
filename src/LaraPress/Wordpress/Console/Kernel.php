<?php

namespace LaraPress\Wordpress\Console;

use LaraPress\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $earlyBootstrapers = [
        \LaraPress\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \LaraPress\Foundation\Bootstrap\LoadConfiguration::class,
        \LaraPress\Wordpress\Bootstrap\HandleExceptions::class,
        \LaraPress\Foundation\Bootstrap\RegisterFacades::class,
    ];
    /**
     * The bootstrap classes for the application.
     *
     * @var string[]
     */
    protected $bootstrappers = [
        \LaraPress\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \LaraPress\Foundation\Bootstrap\LoadConfiguration::class,
        \LaraPress\Wordpress\Bootstrap\HandleExceptions::class,
        \LaraPress\Foundation\Bootstrap\RegisterFacades::class,
        \LaraPress\Foundation\Bootstrap\SetRequestForConsole::class,
        \LaraPress\Foundation\Bootstrap\RegisterProviders::class,
        \LaraPress\Foundation\Bootstrap\BootProviders::class,
    ];

    function earlyBootstrap()
    {
        foreach ($this->earlyBootstrapers as $bootstraper) {
            $this->app->bootstrapOne($bootstraper);
        }
    }
}