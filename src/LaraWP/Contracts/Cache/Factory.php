<?php

namespace LaraWP\Contracts\Cache;

interface Factory
{
    /**
     * Get a cache store instance by name.
     *
     * @param string|null $name
     * @return \LaraWP\Contracts\Cache\Repository
     */
    public function store($name = null);
}
