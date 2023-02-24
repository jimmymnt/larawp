<?php

namespace LaraWP\Wordpress;

use LaraWP\Contracts\Foundation\Application;
use LaraWP\Foundation\Http\Kernel as HttpKernel;
use LaraWP\Routing\Pipeline;
use LaraWP\Routing\Router;
use LaraWP\Wordpress\Routing\Router as ShortcodeRouter;

class Kernel extends HttpKernel
{
    protected $wpHandleHook = ['template_redirect', 1];
    /**
     * @var \LaraWP\Wordpress\Application
     */
    protected $app;
    protected $earlyBootstrapers = [
        \LaraWP\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \LaraWP\Foundation\Bootstrap\LoadConfiguration::class,
        \LaraWP\Wordpress\Bootstrap\HandleExceptions::class,
        \LaraWP\Foundation\Bootstrap\RegisterFacades::class,
    ];
    /**
     * The bootstrap classes for the application.
     *
     * @var string[]
     */
    protected $bootstrappers = [
        \LaraWP\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \LaraWP\Foundation\Bootstrap\LoadConfiguration::class,
        \LaraWP\Wordpress\Bootstrap\HandleExceptions::class,
        \LaraWP\Foundation\Bootstrap\RegisterFacades::class,
        \LaraWP\Foundation\Bootstrap\RegisterProviders::class,
        \LaraWP\Foundation\Bootstrap\BootProviders::class,
    ];
    protected $wpRouter;

    public function __construct(Application $app, Router $router, ShortcodeRouter $wpRouter)
    {
        $this->wpRouter = $wpRouter;
        parent::__construct($app, $router);
    }

    public function handle($request)
    {
        $response = parent::handle($request);
        if (!$request->isNotFoundHttpExceptionFromRoute()) {
            $this->processResponse($request, $response);
        } else {
            $this->registerWpHandler($request);
        }
        return $response;
    }

    /**
     * Process response
     * @param $request
     * @param $response
     * @return void
     */
    protected function processResponse($request, $response)
    {
        //Not a not found response from router
        if ($response instanceof \LaraWP\Wordpress\Http\Response) {
            //Got a WordPress response, process it
            $handler = $this->app->make(\LaraWP\Wordpress\Http\Response\Handler::class);
            /**
             * @var \LaraWP\Wordpress\Http\Response\Handler $handler
             */
            $handler->handle($this, $request, $response);
        } else {//Normal response
            $response->send();
            $this->terminate($request, $response);
            die;
        }

    }

    function registerWpHandler($request)
    {
        $hook = (array)$this->wpHandleHook;
        add_action($hook[0] ?? 'template_redirect', function () use ($request) {
            $this->handleWp($request);
        }, $hook[1] ?? 1);
    }


    function handleWp($request)
    {
        try {
            $request->setRouteNotFoundHttpException(false);
            $response = $this->wpSendRequestThroughRouter($request);
        } catch (\Throwable $e) {
            $this->reportException($e);
            $response = $this->renderException($request, $e);
        }
        if (!$request->isNotFoundHttpExceptionFromRoute()) {
            $this->processResponse($request, $response);
        }

    }

    /**
     * Send the given request through the middleware / router.
     *
     * @param \LaraWP\Http\Request $request
     * @return \LaraWP\Http\Response
     */
    protected function wpSendRequestThroughRouter($request)
    {
        return (new Pipeline($this->app))
            ->send($request)
            ->through($this->app->shouldSkipMiddleware() ? [] : $this->middleware)
            ->then($this->dispatchToWpRouter());
    }

    function dispatchToWpRouter($route = null)
    {
        return function ($request) use ($route) {
            return $this->wpRouter->dispatch($request);
        };
    }

    /**
     * Sync the current state of the middleware to the router.
     *
     * @return void
     */
    protected function syncMiddlewareToRouter()
    {
        parent::syncMiddlewareToRouter();
        $this->wpRouter->middlewarePriority = $this->middlewarePriority;

        foreach ($this->middlewareGroups as $key => $middleware) {
            $this->wpRouter->middlewareGroup($key, $middleware);
        }

        foreach ($this->routeMiddleware as $key => $middleware) {
            $this->wpRouter->aliasMiddleware($key, $middleware);
        }

    }


    function earlyBootstrap()
    {
        foreach ($this->earlyBootstrapers as $bootstraper) {
            $this->app->bootstrapOne($bootstraper);
        }
    }
}