<?php

namespace LaraPress\Wordpress\Middleware;

class StartSession extends \LaraPress\Session\Middleware\StartSession
{
    protected function saveSession($request)
    {
        add_action('shutdown', function () use ($request) {
            parent::saveSession($request);
        });

    }
}