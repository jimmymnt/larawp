<?php

namespace LaraPress\Auth\Passwords;

use LaraPress\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

interface TokenRepositoryInterface
{
    /**
     * Create a new token.
     *
     * @param \LaraPress\Contracts\Auth\CanResetPassword $user
     * @return string
     */
    public function create(CanResetPasswordContract $user);

    /**
     * Determine if a token record exists and is valid.
     *
     * @param \LaraPress\Contracts\Auth\CanResetPassword $user
     * @param string $token
     * @return bool
     */
    public function exists(CanResetPasswordContract $user, $token);

    /**
     * Determine if the given user recently created a password reset token.
     *
     * @param \LaraPress\Contracts\Auth\CanResetPassword $user
     * @return bool
     */
    public function recentlyCreatedToken(CanResetPasswordContract $user);

    /**
     * Delete a token record.
     *
     * @param \LaraPress\Contracts\Auth\CanResetPassword $user
     * @return void
     */
    public function delete(CanResetPasswordContract $user);

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired();
}
