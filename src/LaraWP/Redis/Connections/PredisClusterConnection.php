<?php

namespace LaraWP\Redis\Connections;

use Predis\Command\ServerFlushDatabase;

class PredisClusterConnection extends PredisConnection
{
    /**
     * Flush the selected Redis database on all cluster nodes.
     *
     * @return void
     */
    public function flushdb()
    {
        $this->client->executeCommandOnNodes(
            lp_tap(new ServerFlushDatabase)->setArguments(func_get_args())
        );
    }
}
