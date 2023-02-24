<?php

namespace LaraWP\Auth\Events;

use LaraWP\Queue\SerializesModels;

class Login
{
    use SerializesModels;

    /**
     * The authentication guard name.
     *
     * @var string
     */
    public $guard;

    /**
     * The authenticated user.
     *
     * @var \LaraWP\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * Indicates if the user should be "remembered".
     *
     * @var bool
     */
    public $remember;

    /**
     * Create a new event instance.
     *
     * @param string $guard
     * @param \LaraWP\Contracts\Auth\Authenticatable $user
     * @param bool $remember
     * @return void
     */
    public function __construct($guard, $user, $remember)
    {
        $this->user = $user;
        $this->guard = $guard;
        $this->remember = $remember;
    }
}
