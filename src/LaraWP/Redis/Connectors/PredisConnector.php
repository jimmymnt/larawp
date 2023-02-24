<?php

namespace LaraWP\Redis\Connectors;

use LaraWP\Contracts\Redis\Connector;
use LaraWP\Redis\Connections\PredisClusterConnection;
use LaraWP\Redis\Connections\PredisConnection;
use LaraWP\Support\Arr;
use Predis\Client;

class PredisConnector implements Connector
{
    /**
     * Create a new clustered Predis connection.
     *
     * @param array $config
     * @param array $options
     * @return \LaraWP\Redis\Connections\PredisConnection
     */
    public function connect(array $config, array $options)
    {
        $formattedOptions = array_merge(
            ['timeout' => 10.0], $options, Arr::pull($config, 'options', [])
        );

        if (isset($config['prefix'])) {
            $formattedOptions['prefix'] = $config['prefix'];
        }

        return new PredisConnection(new Client($config, $formattedOptions));
    }

    /**
     * Create a new clustered Predis connection.
     *
     * @param array $config
     * @param array $clusterOptions
     * @param array $options
     * @return \LaraWP\Redis\Connections\PredisClusterConnection
     */
    public function connectToCluster(array $config, array $clusterOptions, array $options)
    {
        $clusterSpecificOptions = Arr::pull($config, 'options', []);

        if (isset($config['prefix'])) {
            $clusterSpecificOptions['prefix'] = $config['prefix'];
        }

        return new PredisClusterConnection(new Client(array_values($config), array_merge(
            $options, $clusterOptions, $clusterSpecificOptions
        )));
    }
}
