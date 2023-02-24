<?php

namespace LaraPress\Contracts\Broadcasting;

interface ShouldBroadcast
{
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \LaraPress\Broadcasting\Channel|\LaraPress\Broadcasting\Channel[]|string[]|string
     */
    public function broadcastOn();
}
