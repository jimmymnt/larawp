<?php

namespace LaraPress\Contracts\Cache;

interface Factory
{
    /**
     * Get a cache store instance by name.
     *
     * @param string|null $name
     * @return \LaraPress\Contracts\Cache\Repository
     */
    public function store($name = null);
}
