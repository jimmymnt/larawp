<?php

namespace LaraWP\Console\Scheduling;

use DateTimeInterface;

interface SchedulingMutex
{
    /**
     * Attempt to obtain a scheduling mutex for the given event.
     *
     * @param \LaraWP\Console\Scheduling\Event $event
     * @param \DateTimeInterface $time
     * @return bool
     */
    public function create(Event $event, DateTimeInterface $time);

    /**
     * Determine if a scheduling mutex exists for the given event.
     *
     * @param \LaraWP\Console\Scheduling\Event $event
     * @param \DateTimeInterface $time
     * @return bool
     */
    public function exists(Event $event, DateTimeInterface $time);
}
