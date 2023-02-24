<?php

namespace LaraPress\Contracts\Queue;

interface Factory
{
    /**
     * Resolve a queue connection instance.
     *
     * @param string|null $name
     * @return \LaraPress\Contracts\Queue\Queue
     */
    public function connection($name = null);
}
