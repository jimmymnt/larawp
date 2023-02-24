<?php

namespace LaraWP\Contracts\Bus;

interface QueueingDispatcher extends Dispatcher
{
    /**
     * Attempt to find the batch with the given ID.
     *
     * @param string $batchId
     * @return \LaraWP\Bus\Batch|null
     */
    public function findBatch(string $batchId);

    /**
     * Create a new batch of queueable jobs.
     *
     * @param \LaraWP\Support\Collection|array $jobs
     * @return \LaraWP\Bus\PendingBatch
     */
    public function batch($jobs);

    /**
     * Dispatch a command to its appropriate handler behind a queue.
     *
     * @param mixed $command
     * @return mixed
     */
    public function dispatchToQueue($command);
}
