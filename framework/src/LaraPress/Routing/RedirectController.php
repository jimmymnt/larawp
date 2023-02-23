<?php

namespace LaraPress\Routing;

use LaraPress\Http\RedirectResponse;
use LaraPress\Http\Request;
use LaraPress\Support\Str;

class RedirectController extends Controller
{
    /**
     * Invoke the controller method.
     *
     * @param \LaraPress\Http\Request $request
     * @param \LaraPress\Routing\UrlGenerator $url
     * @return \LaraPress\Http\RedirectResponse
     */
    public function __invoke(Request $request, UrlGenerator $url)
    {
        $parameters = lp_collect($request->route()->parameters());

        $status = $parameters->get('status');

        $destination = $parameters->get('destination');

        $parameters->forget('status')->forget('destination');

        $route = (new Route('GET', $destination, [
            'as' => 'laravel_route_redirect_destination',
        ]))->bind($request);

        $parameters = $parameters->only(
            $route->getCompiled()->getPathVariables()
        )->toArray();

        $url = $url->toRoute($route, $parameters, false);

        if (!Str::startsWith($destination, '/') && Str::startsWith($url, '/')) {
            $url = Str::after($url, '/');
        }

        return new RedirectResponse($url, $status);
    }
}
