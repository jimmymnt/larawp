<?php

namespace LaraWP\Console\Events;

class ArtisanStarting
{
    /**
     * The Artisan application instance.
     *
     * @var \LaraWP\Console\Application
     */
    public $artisan;

    /**
     * Create a new event instance.
     *
     * @param \LaraWP\Console\Application $artisan
     * @return void
     */
    public function __construct($artisan)
    {
        $this->artisan = $artisan;
    }
}
