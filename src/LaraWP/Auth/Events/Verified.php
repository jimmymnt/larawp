<?php

namespace LaraWP\Auth\Events;

use LaraWP\Queue\SerializesModels;

class Verified
{
    use SerializesModels;

    /**
     * The verified user.
     *
     * @var \LaraWP\Contracts\Auth\MustVerifyEmail
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param \LaraWP\Contracts\Auth\MustVerifyEmail $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
