<?php

namespace LaraPress\Wordpress;

use LaraPress\Wordpress\Auth\User as UserModel;
use LaraPress\Wordpress\Model\WpUserQuery;

class User extends UserModel
{
    use WpUserQuery;
}