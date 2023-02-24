<?php

namespace LaraPress\Foundation\Http\Events;

class RequestHandled
{
    /**
     * The request instance.
     *
     * @var \LaraPress\Http\Request
     */
    public $request;

    /**
     * The response instance.
     *
     * @var \LaraPress\Http\Response
     */
    public $response;

    /**
     * Create a new event instance.
     *
     * @param \LaraPress\Http\Request $request
     * @param \LaraPress\Http\Response $response
     * @return void
     */
    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}
