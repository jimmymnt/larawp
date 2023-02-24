<?php

namespace LaraWP\Routing\Matching;

use LaraWP\Http\Request;
use LaraWP\Routing\Route;

class MethodValidator implements ValidatorInterface
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
        return in_array($request->getMethod(), $route->methods());
    }
}
