<?php

namespace LaraPress\Bus\Events;

use LaraPress\Bus\Batch;

class BatchDispatched
{
    /**
     * The batch instance.
     *
     * @var \LaraPress\Bus\Batch
     */
    public $batch;

    /**
     * Create a new event instance.
     *
     * @param \LaraPress\Bus\Batch $batch
     * @return void
     */
    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
    }
}
