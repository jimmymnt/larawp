<?php

namespace LaraPress\Wordpress\Routing;

class Route extends \LaraPress\Routing\Route
{
    /**
     * @var \LaraPress\Http\Response
     */
    protected $response;

    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    function getContent()
    {
        if ($this->response) {
            return $this->response->getContent();
        }
        return '';
    }

}