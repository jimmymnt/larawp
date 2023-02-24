<?php

namespace LaraWP\Foundation\Http\Events;

class RequestHandled
{
    /**
     * The request instance.
     *
     * @var \LaraWP\Http\Request
     */
    public $request;

    /**
     * The response instance.
     *
     * @var \LaraWP\Http\Response
     */
    public $response;

    /**
     * Create a new event instance.
     *
     * @param \LaraWP\Http\Request $request
     * @param \LaraWP\Http\Response $response
     * @return void
     */
    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}
