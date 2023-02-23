<?php

namespace LaraPress\Foundation\Bootstrap;

use LaraPress\Contracts\Foundation\Application;
use LaraPress\Foundation\AliasLoader;
use LaraPress\Foundation\PackageManifest;
use LaraPress\Support\Facades\Facade;

class RegisterFacades
{
    /**
     * Bootstrap the given application.
     *
     * @param \LaraPress\Contracts\Foundation\Application $app
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
