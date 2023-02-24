<?php

namespace LaraPress\Wordpress;

use LaraPress\Wordpress\Routing\RoutingServiceProvider;

class Application extends \LaraPress\Foundation\Application
{
    /**
     * The LaraPress framework version.
     *
     * @var string
     */
    const VERSION = '1.3.0';

    protected $bootstrappedList = [];

    protected function registerBaseServiceProviders()
    {
        parent::registerBaseServiceProviders();
        $this->register(new RoutingServiceProvider($this));
    }

    function bootstrapWith(array $bootstrappers)
    {
        $this->hasBeenBootstrapped = true;

        foreach ($bootstrappers as $bootstrapper) {
            $this->bootstrapOne($bootstrapper);
        }
    }

    function bootstrapOne($bootstrapper)
    {
        if (!isset($this->bootstrappedList[$bootstrapper])) {
            $this->bootstrappedList[$bootstrapper] = true;
            $this['events']->dispatch('bootstrapping: ' . $bootstrapper, [$this]);
            $this->make($bootstrapper)->bootstrap($this);
            $this['events']->dispatch('bootstrapped: ' . $bootstrapper, [$this]);
        }

    }
}