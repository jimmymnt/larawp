<?php

namespace LaraWP\Queue\Events;

class JobProcessed
{
    /**
     * The connection name.
     *
     * @var string
     */
    public $connectionName;

    /**
     * The job instance.
     *
     * @var \LaraWP\Contracts\Queue\Job
     */
    public $job;

    /**
     * Create a new event instance.
     *
     * @param string $connectionName
     * @param \LaraWP\Contracts\Queue\Job $job
     * @return void
     */
    public function __construct($connectionName, $job)
    {
        $this->job = $job;
        $this->connectionName = $connectionName;
    }
}
