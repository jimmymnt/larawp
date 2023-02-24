<?php

namespace LaraWP\Foundation\Bootstrap;

use LaraWP\Contracts\Foundation\Application;

class RegisterProviders
{
    /**
     * Bootstrap the given application.
     *
     * @param \LaraWP\Contracts\Foundation\Application $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $app->registerConfiguredProviders();
    }
}
