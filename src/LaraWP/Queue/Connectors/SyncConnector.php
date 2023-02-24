<?php

namespace LaraWP\Queue\Connectors;

use LaraWP\Queue\SyncQueue;

class SyncConnector implements ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @param array $config
     * @return \LaraWP\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        return new SyncQueue;
    }
}
