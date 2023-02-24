<?php

namespace LaraWP\Contracts\Auth;

interface UserProvider
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param mixed $identifier
     * @return \LaraWP\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier);

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param mixed $identifier
     * @param string $token
     * @return \LaraWP\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token);

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param \LaraWP\Contracts\Auth\Authenticatable $user
     * @param string $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token);

    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     * @return \LaraWP\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials);

    /**
     * Validate a user against the given credentials.
     *
     * @param \LaraWP\Contracts\Auth\Authenticatable $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials);
}
