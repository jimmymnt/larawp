<?php

namespace LaraWP\Foundation\Bootstrap;

use LaraWP\Contracts\Foundation\Application;
use LaraWP\Foundation\AliasLoader;
use LaraWP\Foundation\PackageManifest;
use LaraWP\Support\Facades\Facade;

class RegisterFacades
{
    /**
     * Bootstrap the given application.
     *
     * @param \LaraWP\Contracts\Foundation\Application $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        Facade::clearResolvedInstances();

        Facade::setFacadeApplication($app);

        AliasLoader::getInstance(array_merge(
            $app->make('config')->get('app.aliases', []),
            $app->make(PackageManifest::class)->aliases()
        ))->register();
    }
}
