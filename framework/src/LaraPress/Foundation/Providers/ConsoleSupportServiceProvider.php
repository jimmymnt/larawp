<?php

namespace LaraPress\Foundation\Providers;

use LaraPress\Contracts\Support\DeferrableProvider;
use LaraPress\Database\MigrationServiceProvider;
use LaraPress\Support\AggregateServiceProvider;

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
