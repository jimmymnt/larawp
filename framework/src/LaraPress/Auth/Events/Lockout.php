<?php

namespace LaraPress\Auth\Events;

use LaraPress\Http\Request;

class Lockout
{
    /**
     * The throttled request.
     *
     * @var \LaraPress\Http\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param \LaraPress\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
