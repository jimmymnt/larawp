<?php

namespace LaraPress\Http\Client\Events;

use LaraPress\Http\Client\Request;
use LaraPress\Http\Client\Response;

class ResponseReceived
{
    /**
     * The request instance.
     *
     * @var \LaraPress\Http\Client\Request
     */
    public $request;

    /**
     * The response instance.
     *
     * @var \LaraPress\Http\Client\Response
     */
    public $response;

    /**
     * Create a new event instance.
     *
     * @param \LaraPress\Http\Client\Request $request
     * @param \LaraPress\Http\Client\Response $response
     * @return void
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}
