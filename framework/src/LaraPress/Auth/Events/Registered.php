<?php

namespace LaraPress\Auth\Events;

use LaraPress\Queue\SerializesModels;

class Registered
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var \LaraPress\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param \LaraPress\Contracts\Auth\Authenticatable $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
