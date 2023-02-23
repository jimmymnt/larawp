<?php

namespace LaraPress\Routing\Matching;

use LaraPress\Http\Request;
use LaraPress\Routing\Route;

class SchemeValidator implements ValidatorInterface
{
    /**
     * Validate a given rule against a route and request.
     *
     * @param \LaraPress\Routing\Route $route
     * @param \LaraPress\Http\Request $request
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
