<?php

namespace LaraPress\Console\Events;

class ArtisanStarting
{
    /**
     * The Artisan application instance.
     *
     * @var \LaraPress\Console\Application
     */
    public $artisan;

    /**
     * Create a new event instance.
     *
     * @param \LaraPress\Console\Application $artisan
     * @return void
     */
    public function __construct($artisan)
    {
        $this->artisan = $artisan;
    }
}
