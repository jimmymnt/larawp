<?php

namespace LaraPress\Wordpress\Auth;

use LaraPress\Wordpress\Model\User as Model;
use LaraPress\Auth\Authenticatable;
use LaraPress\Auth\MustVerifyEmail;
use LaraPress\Auth\Passwords\CanResetPassword;
use LaraPress\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use LaraPress\Contracts\Auth\Authenticatable as AuthenticatableContract;
use LaraPress\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use LaraPress\Foundation\Auth\Access\Authorizable;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * @param \WP_User|null $lp_user
     * @return static|null
     */
    public static function fromWpUser(\WP_User $lp_user = null)
    {
        if (!$lp_user) {
            return null;
        }
        $user = new static();
        $user->init($lp_user->data, $lp_user->get_site_id());
        return $user;
    }
}