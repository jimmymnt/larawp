<?php

namespace LaraPress\Http\Client\Events;

use LaraPress\Http\Client\Request;

class RequestSending
{
    /**
     * The request instance.
     *
     * @var \LaraPress\Http\Client\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param \LaraPress\Http\Client\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
