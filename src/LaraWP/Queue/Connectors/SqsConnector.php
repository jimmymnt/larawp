<?php

namespace LaraWP\Queue\Connectors;

use Aws\Sqs\SqsClient;
use LaraWP\Queue\SqsQueue;
use LaraWP\Support\Arr;

class SqsConnector implements ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @param array $config
     * @return \LaraWP\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        $config = $this->getDefaultConfiguration($config);

        if (!empty($config['key']) && !empty($config['secret'])) {
            $config['credentials'] = Arr::only($config, ['key', 'secret', 'token']);
        }

        return new SqsQueue(
            new SqsClient($config),
            $config['queue'],
            $config['prefix'] ?? '',
            $config['suffix'] ?? '',
            $config['after_commit'] ?? null
        );
    }

    /**
     * Get the default configuration for SQS.
     *
     * @param array $config
     * @return array
     */
    protected function getDefaultConfiguration(array $config)
    {
        return array_merge([
            'version' => 'latest',
            'http' => [
                'timeout' => 60,
                'connect_timeout' => 60,
            ],
        ], $config);
    }
}
