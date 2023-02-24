<?php

namespace LaraWP\Wordpress\Auth;

use LaraWP\Auth\GuardHelpers;
use LaraWP\Contracts\Auth\Guard;
use LaraWP\Contracts\Auth\UserProvider;

class WpGuard implements Guard
{
    use GuardHelpers;

    public function __construct(UserProvider $provider)
    {
        $this->provider = $provider;
    }

    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }
        return $this->provider->retrieveById(lp_get_current_user());
    }

    public function validate(array $credentials = [])
    {
        return lp_authenticate($credentials['username'], $credentials['password']);
    }
}