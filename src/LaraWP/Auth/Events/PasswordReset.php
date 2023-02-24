<?php

namespace LaraWP\Auth\Events;

use LaraWP\Queue\SerializesModels;

class PasswordReset
{
    use SerializesModels;

    /**
     * The user.
     *
     * @var \LaraWP\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param \LaraWP\Contracts\Auth\Authenticatable $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
