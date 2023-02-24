<?php

namespace LaraPress\Auth\Events;

use LaraPress\Queue\SerializesModels;

class PasswordReset
{
    use SerializesModels;

    /**
     * The user.
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
