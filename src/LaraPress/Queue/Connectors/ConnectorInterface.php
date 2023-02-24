<?php

namespace LaraPress\Queue\Connectors;

interface ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @param array $config
     * @return \LaraPress\Contracts\Queue\Queue
     */
    public function connect(array $config);
}
