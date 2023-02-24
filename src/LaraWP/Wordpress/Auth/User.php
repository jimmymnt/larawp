<?php

namespace LaraWP\Wordpress\Auth;

use LaraWP\Wordpress\Model\User as Model;
use LaraWP\Auth\Authenticatable;
use LaraWP\Auth\MustVerifyEmail;
use LaraWP\Auth\Passwords\CanResetPassword;
use LaraWP\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use LaraWP\Contracts\Auth\Authenticatable as AuthenticatableContract;
use LaraWP\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use LaraWP\Foundation\Auth\Access\Authorizable;

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