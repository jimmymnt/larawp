<?php

namespace LaraWP\Wordpress;

use LaraWP\Wordpress\Auth\User as UserModel;
use LaraWP\Wordpress\Model\WpUserQuery;

class User extends UserModel
{
    use WpUserQuery;
}