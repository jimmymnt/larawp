<?php

namespace LaraPress\Foundation\Bootstrap;

use LaraPress\Contracts\Foundation\Application;

class BootProviders
{
    /**
     * Bootstrap the given application.
     *
     * @param \LaraPress\Contracts\Foundation\Application $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $app->boot();
    }
}
