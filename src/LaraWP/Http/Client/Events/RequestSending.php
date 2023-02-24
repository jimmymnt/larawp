<?php

namespace LaraWP\Http\Client\Events;

use LaraWP\Http\Client\Request;

class RequestSending
{
    /**
     * The request instance.
     *
     * @var \LaraWP\Http\Client\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param \LaraWP\Http\Client\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
