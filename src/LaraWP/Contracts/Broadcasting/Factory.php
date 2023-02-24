<?php

namespace LaraWP\Contracts\Broadcasting;

interface Factory
{
    /**
     * Get a broadcaster implementation by name.
     *
     * @param string|null $name
     * @return \LaraWP\Contracts\Broadcasting\Broadcaster
     */
    public function connection($name = null);
}
