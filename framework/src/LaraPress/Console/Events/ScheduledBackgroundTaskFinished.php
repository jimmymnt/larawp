<?php

namespace LaraPress\Console\Events;

use LaraPress\Console\Scheduling\Event;

class ScheduledBackgroundTaskFinished
{
    /**
     * The scheduled event that ran.
     *
     * @var \LaraPress\Console\Scheduling\Event
     */
    public $task;

    /**
     * Create a new event instance.
     *
     * @param \LaraPress\Console\Scheduling\Event $task
     * @return void
     */
    public function __construct(Event $task)
    {
        $this->task = $task;
    }
}
