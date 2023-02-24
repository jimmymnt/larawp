<?php

namespace LaraWP\Contracts\Queue;

interface Factory
{
    /**
     * Resolve a queue connection instance.
     *
     * @param string|null $name
     * @return \LaraWP\Contracts\Queue\Queue
     */
    public function connection($name = null);
}
