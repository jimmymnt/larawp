<?php

namespace LaraWP\Support\Testing\Fakes;

use LaraWP\Bus\PendingBatch;
use LaraWP\Support\Collection;

class PendingBatchFake extends PendingBatch
{
    /**
     * The fake bus instance.
     *
     * @var \LaraWP\Support\Testing\Fakes\BusFake
     */
    protected $bus;

    /**
     * Create a new pending batch instance.
     *
     * @param \LaraWP\Support\Testing\Fakes\BusFake $bus
     * @param \LaraWP\Support\Collection $jobs
     * @return void
     */
    public function __construct(BusFake $bus, Collection $jobs)
    {
        $this->bus = $bus;
        $this->jobs = $jobs;
    }

    /**
     * Dispatch the batch.
     *
     * @return \LaraWP\Bus\Batch
     */
    public function dispatch()
    {
        return $this->bus->recordPendingBatch($this);
    }
}
