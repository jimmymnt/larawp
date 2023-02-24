<?php

namespace LaraWP\Support\Facades;

/**
 * @method static \LaraWP\Http\RedirectResponse action(string $action, mixed $parameters = [], int $status = 302, array $headers = [])
 * @method static \LaraWP\Http\RedirectResponse away(string $path, int $status = 302, array $headers = [])
 * @method static \LaraWP\Http\RedirectResponse back(int $status = 302, array $headers = [], $fallback = false)
 * @method static \LaraWP\Http\RedirectResponse guest(string $path, int $status = 302, array $headers = [], bool $secure = null)
 * @method static \LaraWP\Http\RedirectResponse home(int $status = 302)
 * @method static \LaraWP\Http\RedirectResponse intended(string $default = '/', int $status = 302, array $headers = [], bool $secure = null)
 * @method static \LaraWP\Http\RedirectResponse refresh(int $status = 302, array $headers = [])
 * @method static \LaraWP\Http\RedirectResponse route(string $route, mixed $parameters = [], int $status = 302, array $headers = [])
 * @method static \LaraWP\Http\RedirectResponse secure(string $path, int $status = 302, array $headers = [])
 * @method static \LaraWP\Http\RedirectResponse signedRoute(string $name, mixed $parameters = [], \DateTimeInterface|\DateInterval|int $expiration = null, int $status = 302, array $headers = [])
 * @method static \LaraWP\Http\RedirectResponse temporarySignedRoute(string $name, \DateTimeInterface|\DateInterval|int $expiration, mixed $parameters = [], int $status = 302, array $headers = [])
 * @method static \LaraWP\Http\RedirectResponse to(string $path, int $status = 302, array $headers = [], bool $secure = null)
 * @method static \LaraWP\Routing\UrlGenerator getUrlGenerator()
 * @method static void setSession(\LaraWP\Session\Store $session)
 * @method static void setIntendedUrl(string $url)
 *
 * @see \LaraWP\Routing\Redirector
 */
class Redirect extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'redirect';
    }
}
