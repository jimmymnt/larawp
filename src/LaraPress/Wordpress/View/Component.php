<?php

namespace LaraPress\Wordpress\View;

use LaraPress\Contracts\Support\Renderable;
use LaraPress\Wordpress\Http\Response;

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