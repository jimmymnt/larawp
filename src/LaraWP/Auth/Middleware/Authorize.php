<?php

namespace LaraWP\Auth\Middleware;

use Closure;
use LaraWP\Contracts\Auth\Access\Gate;
use LaraWP\Database\Eloquent\Model;

class Authorize
{
    /**
     * The gate instance.
     *
     * @var \LaraWP\Contracts\Auth\Access\Gate
     */
    protected $gate;

    /**
     * Create a new middleware instance.
     *
     * @param \LaraWP\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function __construct(Gate $gate)
    {
        $this->gate = $gate;
    }

    /**
     * Handle an incoming request.
     *
     * @param \LaraWP\Http\Request $request
     * @param \Closure $next
     * @param string $ability
     * @param array|null ...$models
     * @return mixed
     *
     * @throws \LaraWP\Auth\AuthenticationException
     * @throws \LaraWP\Auth\Access\AuthorizationException
     */
    public function handle($request, Closure $next, $ability, ...$models)
    {
        $this->gate->authorize($ability, $this->getGateArguments($request, $models));

        return $next($request);
    }

    /**
     * Get the arguments parameter for the gate.
     *
     * @param \LaraWP\Http\Request $request
     * @param array|null $models
     * @return \LaraWP\Database\Eloquent\Model|array|string
     */
    protected function getGateArguments($request, $models)
    {
        if (is_null($models)) {
            return [];
        }

        return lp_collect($models)->map(function ($model) use ($request) {
            return $model instanceof Model ? $model : $this->getModel($request, $model);
        })->all();
    }

    /**
     * Get the model to authorize.
     *
     * @param \LaraWP\Http\Request $request
     * @param string $model
     * @return \LaraWP\Database\Eloquent\Model|string
     */
    protected function getModel($request, $model)
    {
        if ($this->isClassName($model)) {
            return trim($model);
        } else {
            return $request->route($model, null) ?:
                ((preg_match("/^['\"](.*)['\"]$/", trim($model), $matches)) ? $matches[1] : null);
        }
    }

    /**
     * Checks if the given string looks like a fully qualified class name.
     *
     * @param string $value
     * @return bool
     */
    protected function isClassName($value)
    {
        return strpos($value, '\\') !== false;
    }
}
