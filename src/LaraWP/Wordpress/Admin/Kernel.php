<?php

namespace LaraWP\Wordpress\Admin;

use LaraWP\Contracts\Debug\ExceptionHandler;
use LaraWP\Contracts\Foundation\Application;
use LaraWP\Routing\Pipeline;
use LaraWP\Wordpress\Admin\Routing\Response;
use LaraWP\Wordpress\Admin\Routing\Router;

class Kernel implements Contracts\Kernel
{
    protected $dispatchPriority = 10;
    protected $registerPriority = 10;

    protected $router;
    /**
     * The application's middleware stack.
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [];


    /**
     * The priority-sorted list of middleware.
     *
     * Forces non-global middleware to always be in the given order.
     *
     * @var string[]
     */
    protected $middlewarePriority = [
        \LaraWP\Cookie\Middleware\EncryptCookies::class,
        \LaraWP\Session\Middleware\StartSession::class,
        \LaraWP\View\Middleware\ShareErrorsFromSession::class,
        \LaraWP\Routing\Middleware\ThrottleRequests::class,
        \LaraWP\Routing\Middleware\ThrottleRequestsWithRedis::class,
        \LaraWP\Routing\Middleware\SubstituteBindings::class,
    ];

    /**
     * Create a new HTTP kernel instance.
     *
     * @param \LaraWP\Contracts\Foundation\Application $app
     * @param \LaraWP\Wordpress\Admin\Routing\Router $router
     * @return void
     */
    public function __construct(Application $app, Router $router)
    {
        $this->app = $app;
        $this->router = $router;
        $this->syncMiddlewareToRouter();
    }

    /**
     * @param \LaraWP\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    function handle($request)
    {
        add_action('admin_menu', function () {
            $this->router->register();
        }, $this->registerPriority);
        add_action('current_screen', function ($screen) use ($request) {
            $this->handleAdmin($request, $screen->id);
        }, $this->dispatchPriority);
    }

    /**
     * @param \LaraWP\Http\Request $request
     * @param $screenId
     * @return
     */
    function handleAdmin($request, $screenId)
    {
        try {
            $request->setRouteNotFoundHttpException(false);
            $response = $this->sendRequestThroughRouter($request, $screenId);
        } catch (\Throwable $e) {
            $this->reportException($e);
            $response = $this->renderException($request, $e);
        }
        if (!$request->isNotFoundHttpExceptionFromRoute()) {
            //We just ignore no route matching exception and allow application continue running
            if ($response instanceof Response) {
                //Our responses converted from StringAble, we only send headers for them
                $response->sendHeaders();
            } else {//Normal response from controller middleware, etc...
                $response->send();
                $this->terminate($request, $response);
                exit;
            }
        }
        add_action('shutdown', function () use ($request, $response) {
            $this->terminate($request, $response);
        });

    }

    /**
     * Send the given request through the middleware / router.
     *
     * @param \LaraWP\Http\Request $request
     * @return \LaraWP\Http\Response
     */
    protected function sendRequestThroughRouter($request, $screenId)
    {
        return (new Pipeline($this->app))
            ->send($request)
            ->through($this->app->shouldSkipMiddleware() ? [] : $this->middleware)
            ->then($this->dispatchToAdminRouter($screenId));
    }

    function dispatchToAdminRouter($screenId)
    {
        return function ($request) use ($screenId) {
            return $this->router->dispatch($request, $screenId);
        };
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param \Throwable $e
     * @return void
     */
    protected function reportException(\Throwable $e)
    {
        $this->app[ExceptionHandler::class]->report($e);
    }

    /**
     * Render the exception to a response.
     *
     * @param \LaraWP\Http\Request $request
     * @param \Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderException($request, \Throwable $e)
    {
        return $this->app[ExceptionHandler::class]->render($request, $e);
    }

    /**
     * Call the terminate method on any terminable middleware.
     *
     * @param \LaraWP\Http\Request $request
     * @param \LaraWP\Http\Response $response
     * @return void
     */
    public function terminate($request, $response)
    {
        $this->terminateMiddleware($request, $response);

        $this->app->terminate();
    }

    /**
     * Call the terminate method on any terminable middleware.
     *
     * @param \LaraWP\Http\Request $request
     * @param \LaraWP\Http\Response $response
     * @return void
     */
    protected function terminateMiddleware($request, $response)
    {
        $middlewares = $this->app->shouldSkipMiddleware() ? [] : array_merge(
            $this->gatherRouteMiddleware($request),
            $this->middleware
        );

        foreach ($middlewares as $middleware) {
            if (!is_string($middleware)) {
                continue;
            }

            [$name] = $this->parseMiddleware($middleware);

            $instance = $this->app->make($name);

            if (method_exists($instance, 'terminate')) {
                $instance->terminate($request, $response);
            }
        }
    }

    /**
     * Gather the route middleware for the given request.
     *
     * @param \LaraWP\Http\Request $request
     * @return array
     */
    protected function gatherRouteMiddleware($request)
    {
        if ($menu = $this->router->current()) {
            return $this->router->gatherMenuMiddleware($menu);
        }

        return [];
    }

    /**
     * Parse a middleware string to get the name and parameters.
     *
     * @param string $middleware
     * @return array
     */
    protected function parseMiddleware($middleware)
    {
        [$name, $parameters] = array_pad(explode(':', $middleware, 2), 2, []);

        if (is_string($parameters)) {
            $parameters = explode(',', $parameters);
        }

        return [$name, $parameters];
    }

    /**
     * Determine if the kernel has a given middleware.
     *
     * @param string $middleware
     * @return bool
     */
    public function hasMiddleware($middleware)
    {
        return in_array($middleware, $this->middleware);
    }

    /**
     * Add a new middleware to the beginning of the stack if it does not already exist.
     *
     * @param string $middleware
     * @return $this
     */
    public function prependMiddleware($middleware)
    {
        if (array_search($middleware, $this->middleware) === false) {
            array_unshift($this->middleware, $middleware);
        }

        return $this;
    }

    /**
     * Add a new middleware to end of the stack if it does not already exist.
     *
     * @param string $middleware
     * @return $this
     */
    public function pushMiddleware($middleware)
    {
        if (array_search($middleware, $this->middleware) === false) {
            $this->middleware[] = $middleware;
        }

        return $this;
    }

    /**
     * Prepend the given middleware to the given middleware group.
     *
     * @param string $group
     * @param string $middleware
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function prependMiddlewareToGroup($group, $middleware)
    {
        if (!isset($this->middlewareGroups[$group])) {
            throw new \InvalidArgumentException("The [{$group}] middleware group has not been defined.");
        }

        if (array_search($middleware, $this->middlewareGroups[$group]) === false) {
            array_unshift($this->middlewareGroups[$group], $middleware);
        }

        $this->syncMiddlewareToRouter();

        return $this;
    }

    /**
     * Append the given middleware to the given middleware group.
     *
     * @param string $group
     * @param string $middleware
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function appendMiddlewareToGroup($group, $middleware)
    {
        if (!isset($this->middlewareGroups[$group])) {
            throw new \InvalidArgumentException("The [{$group}] middleware group has not been defined.");
        }

        if (array_search($middleware, $this->middlewareGroups[$group]) === false) {
            $this->middlewareGroups[$group][] = $middleware;
        }

        $this->syncMiddlewareToRouter();

        return $this;
    }

    /**
     * Prepend the given middleware to the middleware priority list.
     *
     * @param string $middleware
     * @return $this
     */
    public function prependToMiddlewarePriority($middleware)
    {
        if (!in_array($middleware, $this->middlewarePriority)) {
            array_unshift($this->middlewarePriority, $middleware);
        }

        $this->syncMiddlewareToRouter();

        return $this;
    }

    /**
     * Append the given middleware to the middleware priority list.
     *
     * @param string $middleware
     * @return $this
     */
    public function appendToMiddlewarePriority($middleware)
    {
        if (!in_array($middleware, $this->middlewarePriority)) {
            $this->middlewarePriority[] = $middleware;
        }

        $this->syncMiddlewareToRouter();

        return $this;
    }

    /**
     * Sync the current state of the middleware to the router.
     *
     * @return void
     */
    protected function syncMiddlewareToRouter()
    {
        $this->router->middlewarePriority = $this->middlewarePriority;

        foreach ($this->middlewareGroups as $key => $middleware) {
            $this->router->middlewareGroup($key, $middleware);
        }

        foreach ($this->routeMiddleware as $key => $middleware) {
            $this->router->aliasMiddleware($key, $middleware);
        }

    }

    public function bootstrap()
    {

    }

    public function getApplication()
    {
        return $this->app;
    }
}