<?php

namespace LaraWP\Wordpress\Admin\Notice;

abstract class Store
{
    abstract function put($notices);

    abstract function get();

    abstract function pull();

    abstract function forget();
}