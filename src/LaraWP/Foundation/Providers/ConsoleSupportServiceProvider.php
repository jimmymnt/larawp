<?php

namespace LaraWP\Foundation\Providers;

use LaraWP\Contracts\Support\DeferrableProvider;
use LaraWP\Database\MigrationServiceProvider;
use LaraWP\Support\AggregateServiceProvider;

class ConsoleSupportServiceProvider extends AggregateServiceProvider implements DeferrableProvider
{
    /**
     * The provider class names.
     *
     * @var string[]
     */
    protected $providers = [
        ArtisanServiceProvider::class,
        MigrationServiceProvider::class,
        ComposerServiceProvider::class,
    ];
}
