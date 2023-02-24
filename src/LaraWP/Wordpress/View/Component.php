<?php

namespace LaraWP\Wordpress\View;

use LaraWP\Contracts\Support\Renderable;
use LaraWP\Wordpress\Http\Response;

/**
 * method boot()
 * method mount()
 */
abstract class Component implements Renderable
{
    protected $data = [];
    /**
     * @var Response|Response\Content|Response\Page|Response\Shortcode
     */
    protected $response;


    function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    function getResponse()
    {
        return $this->response;
    }

    function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

}