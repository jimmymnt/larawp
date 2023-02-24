<?php

namespace LaraPress\Support\Facades;

/**
 * @method static \LaraPress\Http\RedirectResponse action(string $action, mixed $parameters = [], int $status = 302, array $headers = [])
 * @method static \LaraPress\Http\RedirectResponse away(string $path, int $status = 302, array $headers = [])
 * @method static \LaraPress\Http\RedirectResponse back(int $status = 302, array $headers = [], $fallback = false)
 * @method static \LaraPress\Http\RedirectResponse guest(string $path, int $status = 302, array $headers = [], bool $secure = null)
 * @method static \LaraPress\Http\RedirectResponse home(int $status = 302)
 * @method static \LaraPress\Http\RedirectResponse intended(string $default = '/', int $status = 302, array $headers = [], bool $secure = null)
 * @method static \LaraPress\Http\RedirectResponse refresh(int $status = 302, array $headers = [])
 * @method static \LaraPress\Http\RedirectResponse route(string $route, mixed $parameters = [], int $status = 302, array $headers = [])
 * @method static \LaraPress\Http\RedirectResponse secure(string $path, int $status = 302, array $headers = [])
 * @method static \LaraPress\Http\RedirectResponse signedRoute(string $name, mixed $parameters = [], \DateTimeInterface|\DateInterval|int $expiration = null, int $status = 302, array $headers = [])
 * @method static \LaraPress\Http\RedirectResponse temporarySignedRoute(string $name, \DateTimeInterface|\DateInterval|int $expiration, mixed $parameters = [], int $status = 302, array $headers = [])
 * @method static \LaraPress\Http\RedirectResponse to(string $path, int $status = 302, array $headers = [], bool $secure = null)
 * @method static \LaraPress\Routing\UrlGenerator getUrlGenerator()
 * @method static void setSession(\LaraPress\Session\Store $session)
 * @method static void setIntendedUrl(string $url)
 *
 * @see \LaraPress\Routing\Redirector
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
