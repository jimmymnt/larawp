<?php

namespace LaraWP\Auth\Events;

use LaraWP\Http\Request;

class Lockout
{
    /**
     * The throttled request.
     *
     * @var \LaraWP\Http\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param \LaraWP\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
