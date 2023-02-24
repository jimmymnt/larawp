<?php

namespace LaraWP\Queue\Connectors;

interface ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @param array $config
     * @return \LaraWP\Contracts\Queue\Queue
     */
    public function connect(array $config);
}
