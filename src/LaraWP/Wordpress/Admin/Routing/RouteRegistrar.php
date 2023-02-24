<?php

namespace LaraWP\Wordpress\Admin\Routing;

use LaraWP\Support\Arr;

/**
 * @method \LaraWP\Wordpress\Admin\Routing\RouteRegistrar parent($parent)
 * @method \LaraWP\Wordpress\Admin\Routing\RouteRegistrar middleware(array|string|null $middleware)
 * @method \LaraWP\Wordpress\Admin\Routing\RouteRegistrar namespace(string|null $value)
 */
class RouteRegistrar
{
    /**
     * The router instance.
     *
     * @var \LaraWP\Wordpress\Admin\Routing\Router
     */
    protected $router;

    /**
     * The attributes to pass on to the router.
     *
     * @var array
     */
    protected $attributes = [];
    /**
     * The attributes that can be set through this class.
     *
     * @var string[]
     */
    protected $allowedAttributes = [
        'parent',
        'middleware',
        'namespace',
    ];

    /**
     * The attributes that are aliased.
     *
     * @var array
     */
    protected $aliases = [
        'children' => 'parent',
    ];

    /**
     * Create a new route registrar instance.
     *
     * @param \LaraWP\Routing\Router $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Set the value for a given attribute.
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function attribute($key, $value)
    {
        if (!in_array($key, $this->allowedAttributes)) {
            throw new \InvalidArgumentException("Attribute [{$key}] does not exist.");
        }

        if ($key === 'middleware') {
            foreach ($value as $index => $middleware) {
                $value[$index] = (string)$middleware;
            }
        }

        $attributeKey = Arr::get($this->aliases, $key, $key);

        if ($key === 'withoutMiddleware') {
            $value = array_merge(
                (array)($this->attributes[$attributeKey] ?? []), Arr::wrap($value)
            );
        }

        $this->attributes[$attributeKey] = $value;

        return $this;
    }

    /**
     * Create a route group with shared attributes.
     *
     * @param \Closure|string $callback
     * @return void
     */
    public function group($callback)
    {
        $this->router->group($this->attributes, $callback);
    }

    /**
     * Dynamically handle calls into the route registrar.
     *
     * @param string $method
     * @param array $parameters
     * @return \LaraWP\Routing\Route|$this
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (in_array($method, $this->allowedAttributes)) {
            if ($method === 'middleware') {
                return $this->attribute($method, is_array($parameters[0]) ? $parameters[0] : $parameters);
            }

            return $this->attribute($method, array_key_exists(0, $parameters) ? $parameters[0] : true);
        }

        throw new \BadMethodCallException(sprintf(
            'Method %s::%s does not exist.', static::class, $method
        ));
    }
}