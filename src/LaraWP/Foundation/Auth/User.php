<?php

namespace LaraWP\Foundation\Auth;

use LaraWP\Auth\Authenticatable;
use LaraWP\Auth\MustVerifyEmail;
use LaraWP\Auth\Passwords\CanResetPassword;
use LaraWP\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use LaraWP\Contracts\Auth\Authenticatable as AuthenticatableContract;
use LaraWP\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use LaraWP\Database\Eloquent\Model;
use LaraWP\Foundation\Auth\Access\Authorizable;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
}
