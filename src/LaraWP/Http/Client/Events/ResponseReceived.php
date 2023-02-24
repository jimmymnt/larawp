<?php

namespace LaraWP\Http\Client\Events;

use LaraWP\Http\Client\Request;
use LaraWP\Http\Client\Response;

class ResponseReceived
{
    /**
     * The request instance.
     *
     * @var \LaraWP\Http\Client\Request
     */
    public $request;

    /**
     * The response instance.
     *
     * @var \LaraWP\Http\Client\Response
     */
    public $response;

    /**
     * Create a new event instance.
     *
     * @param \LaraWP\Http\Client\Request $request
     * @param \LaraWP\Http\Client\Response $response
     * @return void
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}
