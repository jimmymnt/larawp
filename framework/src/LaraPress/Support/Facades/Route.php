<?php

namespace LaraPress\Support\Facades;

/**
 * @method static \LaraPress\Routing\PendingResourceRegistration apiResource(string $name, string $controller, array $options = [])
 * @method static \LaraPress\Routing\PendingResourceRegistration resource(string $name, string $controller, array $options = [])
 * @method static \LaraPress\Routing\Route any(string $uri, array|string|callable|null $action = null)
 * @method static \LaraPress\Routing\Route|null current()
 * @method static \LaraPress\Routing\Route delete(string $uri, array|string|callable|null $action = null)
 * @method static \LaraPress\Routing\Route fallback(array|string|callable|null $action = null)
 * @method static \LaraPress\Routing\Route get(string $uri, array|string|callable|null $action = null)
 * @method static \LaraPress\Routing\Route|null getCurrentRoute()
 * @method static \LaraPress\Routing\RouteCollectionInterface getRoutes()
 * @method static \LaraPress\Routing\Route match(array|string $methods, string $uri, array|string|callable|null $action = null)
 * @method static \LaraPress\Routing\Route options(string $uri, array|string|callable|null $action = null)
 * @method static \LaraPress\Routing\Route patch(string $uri, array|string|callable|null $action = null)
 * @method static \LaraPress\Routing\Route permanentRedirect(string $uri, string $destination)
 * @method static \LaraPress\Routing\Route post(string $uri, array|string|callable|null $action = null)
 * @method static \LaraPress\Routing\Route put(string $uri, array|string|callable|null $action = null)
 * @method static \LaraPress\Routing\Route redirect(string $uri, string $destination, int $status = 302)
 * @method static \LaraPress\Routing\Route substituteBindings(\LaraPress\Support\Facades\Route $route)
 * @method static \LaraPress\Routing\Route view(string $uri, string $view, array $data = [], int|array $status = 200, array $headers = [])
 * @method static \LaraPress\Routing\RouteRegistrar as(string $value)
 * @method static \LaraPress\Routing\RouteRegistrar controller(string $controller)
 * @method static \LaraPress\Routing\RouteRegistrar domain(string $value)
 * @method static \LaraPress\Routing\RouteRegistrar middleware(array|string|null $middleware)
 * @method static \LaraPress\Routing\RouteRegistrar name(string $value)
 * @method static \LaraPress\Routing\RouteRegistrar namespace(string|null $value)
 * @method static \LaraPress\Routing\RouteRegistrar prefix(string $prefix)
 * @method static \LaraPress\Routing\RouteRegistrar scopeBindings()
 * @method static \LaraPress\Routing\RouteRegistrar where(array $where)
 * @method static \LaraPress\Routing\RouteRegistrar withoutMiddleware(array|string $middleware)
 * @method static \LaraPress\Routing\Router|\LaraPress\Routing\RouteRegistrar group(\Closure|string|array $attributes, \Closure|string $routes)
 * @method static \LaraPress\Routing\ResourceRegistrar resourceVerbs(array $verbs = [])
 * @method static string|null currentRouteAction()
 * @method static string|null currentRouteName()
 * @method static void apiResources(array $resources, array $options = [])
 * @method static void bind(string $key, string|callable $binder)
 * @method static void model(string $key, string $class, \Closure|null $callback = null)
 * @method static void pattern(string $key, string $pattern)
 * @method static void resources(array $resources, array $options = [])
 * @method static void substituteImplicitBindings(\LaraPress\Support\Facades\Route $route)
 * @method static boolean uses(...$patterns)
 * @method static boolean is(...$patterns)
 * @method static boolean has(string $name)
 * @method static mixed input(string $key, string|null $default = null)
 *
 * @see \LaraPress\Routing\Router
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
