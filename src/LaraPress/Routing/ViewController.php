<?php

namespace LaraPress\Routing;

use LaraPress\Contracts\Routing\ResponseFactory;

class ViewController extends Controller
{
    /**
     * The response factory implementation.
     *
     * @var \LaraPress\Contracts\Routing\ResponseFactory
     */
    protected $response;

    /**
     * Create a new controller instance.
     *
     * @param \LaraPress\Contracts\Routing\ResponseFactory $response
     * @return void
     */
    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;
    }

    /**
     * Invoke the controller method.
     *
     * @param array $args
     * @return \LaraPress\Http\Response
     */
    public function __invoke(...$args)
    {
        [$view, $data, $status, $headers] = array_slice($args, -4);

        return $this->response->view($view, $data, $status, $headers);
    }
}
