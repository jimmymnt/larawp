<?php

namespace LaraPress\Auth;

use LaraPress\Contracts\Auth\Authenticatable as AuthenticatableContract;
use LaraPress\Contracts\Auth\UserProvider;

/**
 * These methods are typically the same across all guards.
 */
trait GuardHelpers
{
    /**
     * The currently authenticated user.
     *
     * @var \LaraPress\Contracts\Auth\Authenticatable
     */
    protected $user;

    /**
     * The user provider implementation.
     *
     * @var \LaraPress\Contracts\Auth\UserProvider
     */
    protected $provider;

    /**
     * Determine if the current user is authenticated. If not, throw an exception.
     *
     * @return \LaraPress\Contracts\Auth\Authenticatable
     *
     * @throws \LaraPress\Auth\AuthenticationException
     */
    public function authenticate()
    {
        if (!is_null($user = $this->user())) {
            return $user;
        }

        throw new AuthenticationException;
    }

    /**
     * Determine if the guard has a user instance.
     *
     * @return bool
     */
    public function hasUser()
    {
        return !is_null($this->user);
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return !is_null($this->user());
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id()
    {
        if ($this->user()) {
            return $this->user()->getAuthIdentifier();
        }
    }

    /**
     * Set the current user.
     *
     * @param \LaraPress\Contracts\Auth\Authenticatable $user
     * @return $this
     */
    public function setUser(AuthenticatableContract $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the user provider used by the guard.
     *
     * @return \LaraPress\Contracts\Auth\UserProvider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set the user provider used by the guard.
     *
     * @param \LaraPress\Contracts\Auth\UserProvider $provider
     * @return void
     */
    public function setProvider(UserProvider $provider)
    {
        $this->provider = $provider;
    }
}
