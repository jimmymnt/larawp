<?php

namespace LaraPress\Foundation\Auth;

use LaraPress\Auth\Authenticatable;
use LaraPress\Auth\MustVerifyEmail;
use LaraPress\Auth\Passwords\CanResetPassword;
use LaraPress\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use LaraPress\Contracts\Auth\Authenticatable as AuthenticatableContract;
use LaraPress\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use LaraPress\Database\Eloquent\Model;
use LaraPress\Foundation\Auth\Access\Authorizable;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
}
