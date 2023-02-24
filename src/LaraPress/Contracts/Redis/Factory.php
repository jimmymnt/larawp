<?php

namespace LaraPress\Contracts\Redis;

interface Factory
{
    /**
     * Get a Redis connection by name.
     *
     * @param string|null $name
     * @return \LaraPress\Redis\Connections\Connection
     */
    public function connection($name = null);
}
