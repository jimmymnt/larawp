<?php

namespace LaraWP\Wordpress\Middleware;

class StartSession extends \LaraWP\Session\Middleware\StartSession
{
    protected function saveSession($request)
    {
        add_action('shutdown', function () use ($request) {
            parent::saveSession($request);
        });

    }
}