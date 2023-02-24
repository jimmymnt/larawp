<?php

namespace LaraWP\Support\Facades;

/**
 * @method static \LaraWP\Routing\PendingResourceRegistration apiResource(string $name, string $controller, array $options = [])
 * @method static \LaraWP\Routing\PendingResourceRegistration resource(string $name, string $controller, array $options = [])
 * @method static \LaraWP\Routing\Route any(string $uri, array|string|callable|null $action = null)
 * @method static \LaraWP\Routing\Route|null current()
 * @method static \LaraWP\Routing\Route delete(string $uri, array|string|callable|null $action = null)
 * @method static \LaraWP\Routing\Route fallback(array|string|callable|null $action = null)
 * @method static \LaraWP\Routing\Route get(string $uri, array|string|callable|null $action = null)
 * @method static \LaraWP\Routing\Route|null getCurrentRoute()
 * @method static \LaraWP\Routing\RouteCollectionInterface getRoutes()
 * @method static \LaraWP\Routing\Route match(array|string $methods, string $uri, array|string|callable|null $action = null)
 * @method static \LaraWP\Routing\Route options(string $uri, array|string|callable|null $action = null)
 * @method static \LaraWP\Routing\Route patch(string $uri, array|string|callable|null $action = null)
 * @method static \LaraWP\Routing\Route permanentRedirect(string $uri, string $destination)
 * @method static \LaraWP\Routing\Route post(string $uri, array|string|callable|null $action = null)
 * @method static \LaraWP\Routing\Route put(string $uri, array|string|callable|null $action = null)
 * @method static \LaraWP\Routing\Route redirect(string $uri, string $destination, int $status = 302)
 * @method static \LaraWP\Routing\Route substituteBindings(\LaraWP\Support\Facades\Route $route)
 * @method static \LaraWP\Routing\Route view(string $uri, string $view, array $data = [], int|array $status = 200, array $headers = [])
 * @method static \LaraWP\Routing\RouteRegistrar as(string $value)
 * @method static \LaraWP\Routing\RouteRegistrar controller(string $controller)
 * @method static \LaraWP\Routing\RouteRegistrar domain(string $value)
 * @method static \LaraWP\Routing\RouteRegistrar middleware(array|string|null $middleware)
 * @method static \LaraWP\Routing\RouteRegistrar name(string $value)
 * @method static \LaraWP\Routing\RouteRegistrar namespace(string|null $value)
 * @method static \LaraWP\Routing\RouteRegistrar prefix(string $prefix)
 * @method static \LaraWP\Routing\RouteRegistrar scopeBindings()
 * @method static \LaraWP\Routing\RouteRegistrar where(array $where)
 * @method static \LaraWP\Routing\RouteRegistrar withoutMiddleware(array|string $middleware)
 * @method static \LaraWP\Routing\Router|\LaraWP\Routing\RouteRegistrar group(\Closure|string|array $attributes, \Closure|string $routes)
 * @method static \LaraWP\Routing\ResourceRegistrar resourceVerbs(array $verbs = [])
 * @method static string|null currentRouteAction()
 * @method static string|null currentRouteName()
 * @method static void apiResources(array $resources, array $options = [])
 * @method static void bind(string $key, string|callable $binder)
 * @method static void model(string $key, string $class, \Closure|null $callback = null)
 * @method static void pattern(string $key, string $pattern)
 * @method static void resources(array $resources, array $options = [])
 * @method static void substituteImplicitBindings(\LaraWP\Support\Facades\Route $route)
 * @method static boolean uses(...$patterns)
 * @method static boolean is(...$patterns)
 * @method static boolean has(string $name)
 * @method static mixed input(string $key, string|null $default = null)
 *
 * @see \LaraWP\Routing\Router
 */
class Route extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'router';
    }
}
