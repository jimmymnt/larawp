<?php

namespace LaraPress\Console\Events;

use LaraPress\Console\Scheduling\Event;

class ScheduledTaskFinished
{
    /**
     * The scheduled event that ran.
     *
     * @var \LaraPress\Console\Scheduling\Event
     */
    public $task;

    /**
     * The runtime of the scheduled event.
     *
     * @var float
     */
    public $runtime;

    /**
     * Create a new event instance.
     *
     * @param \LaraPress\Console\Scheduling\Event $task
     * @param float $runtime
     * @return void
     */
    public function __construct(Event $task, $runtime)
    {
        $this->task = $task;
        $this->runtime = $runtime;
    }
}
