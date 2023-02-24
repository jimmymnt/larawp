<?php

namespace LaraWP\Console\Events;

use LaraWP\Console\Scheduling\Event;

class ScheduledTaskStarting
{
    /**
     * The scheduled event being run.
     *
     * @var \LaraWP\Console\Scheduling\Event
     */
    public $task;

    /**
     * Create a new event instance.
     *
     * @param \LaraWP\Console\Scheduling\Event $task
     * @return void
     */
    public function __construct(Event $task)
    {
        $this->task = $task;
    }
}
