<?php

namespace LaraWP\Routing\Matching;

use LaraWP\Http\Request;
use LaraWP\Routing\Route;

class SchemeValidator implements ValidatorInterface
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
        if ($route->httpOnly()) {
            return !$request->secure();
        } elseif ($route->secure()) {
            return $request->secure();
        }

        return true;
    }
}
