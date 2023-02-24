<?php

namespace LaraWP\Contracts\Broadcasting;

interface ShouldBroadcast
{
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \LaraWP\Broadcasting\Channel|\LaraWP\Broadcasting\Channel[]|string[]|string
     */
    public function broadcastOn();
}
