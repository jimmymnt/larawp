<?php

namespace LaraWP\Bus\Events;

use LaraWP\Bus\Batch;

class BatchDispatched
{
    /**
     * The batch instance.
     *
     * @var \LaraWP\Bus\Batch
     */
    public $batch;

    /**
     * Create a new event instance.
     *
     * @param \LaraWP\Bus\Batch $batch
     * @return void
     */
    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
    }
}
