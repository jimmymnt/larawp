<?php

namespace LaraWP\Wordpress\View;

use LaraWP\Contracts\Support\Arrayable;

class Factory
{
    function make($view, $data, $mergeData)
    {
        if (is_string($view)) {
            $view = lp_view($view, $data, $mergeData);
        }
        if ($view instanceof \Closure) {
            $view = new ClosureComponent($view);
        }
        if ($view instanceof Component) {
            $view->setData(array_merge($mergeData, $this->parseData($data)));
        }

        return $view;
    }

    /**
     * Parse the given data into a raw array.
     *
     * @param mixed $data
     * @return array
     */
    protected function parseData($data)
    {
        return $data instanceof Arrayable ? $data->toArray() : $data;
    }
}