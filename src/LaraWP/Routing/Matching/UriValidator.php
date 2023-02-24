<?php

namespace LaraWP\Routing\Matching;

use LaraWP\Http\Request;
use LaraWP\Routing\Route;

class UriValidator implements ValidatorInterface
{
    /**
     * Validate a given rule against a route and request.
     *
     * @param \LaraWP\Routing\Route $route
     * @param \LaraWP\Http\Request $request
     * @return bool
     */
    public function matches(Route $route, Request $request)
    {
        $path = rtrim($request->getPathInfo(), '/') ?: '/';

        return preg_match($route->getCompiled()->getRegex(), rawurldecode($path));
    }
}
