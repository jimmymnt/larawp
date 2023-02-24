<?php

namespace LaraWP\Contracts\Redis;

interface Factory
{
    /**
     * Get a Redis connection by name.
     *
     * @param string|null $name
     * @return \LaraWP\Redis\Connections\Connection
     */
    public function connection($name = null);
}
