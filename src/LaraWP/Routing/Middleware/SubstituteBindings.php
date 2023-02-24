<?php

namespace LaraWP\Routing\Middleware;

use Closure;
use LaraWP\Contracts\Routing\Registrar;
use LaraWP\Database\Eloquent\ModelNotFoundException;

class SubstituteBindings
{
    /**
     * The router instance.
     *
     * @var \LaraWP\Contracts\Routing\Registrar
     */
    protected $router;

    /**
     * Create a new bindings substitutor.
     *
     * @param \LaraWP\Contracts\Routing\Registrar $router
     * @return void
     */
    public function __construct(Registrar $router)
    {
        $this->router = $router;
    }

    /**
     * Handle an incoming request.
     *
     * @param \LaraWP\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $this->router->substituteBindings($route = $request->route());

            $this->router->substituteImplicitBindings($route);
        } catch (ModelNotFoundException $exception) {
            if ($route->getMissing()) {
                return $route->getMissing()($request, $exception);
            }

            throw $exception;
        }

        return $next($request);
    }
}
