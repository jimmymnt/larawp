<?php

namespace LaraPress\Support\Facades;

use Laravel\Ui\UiServiceProvider;
use RuntimeException;

/**
 * @method static \LaraPress\Auth\AuthManager extend(string $driver, \Closure $callback)
 * @method static \LaraPress\Auth\AuthManager provider(string $name, \Closure $callback)
 * @method static \LaraPress\Contracts\Auth\Authenticatable loginUsingId(mixed $id, bool $remember = false)
 * @method static \LaraPress\Contracts\Auth\Authenticatable|null user()
 * @method static \LaraPress\Contracts\Auth\Guard|\LaraPress\Contracts\Auth\StatefulGuard guard(string|null $name = null)
 * @method static \LaraPress\Contracts\Auth\UserProvider|null createUserProvider(string $provider = null)
 * @method static \Symfony\Component\HttpFoundation\Response|null onceBasic(string $field = 'email', array $extraConditions = [])
 * @method static bool attempt(array $credentials = [], bool $remember = false)
 * @method static bool hasUser()
 * @method static bool check()
 * @method static bool guest()
 * @method static bool once(array $credentials = [])
 * @method static bool onceUsingId(mixed $id)
 * @method static bool validate(array $credentials = [])
 * @method static bool viaRemember()
 * @method static bool|null logoutOtherDevices(string $password, string $attribute = 'password')
 * @method static int|string|null id()
 * @method static void login(\LaraPress\Contracts\Auth\Authenticatable $user, bool $remember = false)
 * @method static void logout()
 * @method static void logoutCurrentDevice()
 * @method static void setUser(\LaraPress\Contracts\Auth\Authenticatable $user)
 * @method static void shouldUse(string $name);
 *
 * @see \LaraPress\Auth\AuthManager
 * @see \LaraPress\Contracts\Auth\Factory
 * @see \LaraPress\Contracts\Auth\Guard
 * @see \LaraPress\Contracts\Auth\StatefulGuard
 */
class Auth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'auth';
    }

    /**
     * Register the typical authentication routes for an application.
     *
     * @param array $options
     * @return void
     *
     * @throws \RuntimeException
     */
    public static function routes(array $options = [])
    {
        if (!static::$app->providerIsLoaded(UiServiceProvider::class)) {
            throw new RuntimeException('In order to use the Auth::routes() method, please install the laravel/ui package.');
        }

        static::$app->make('router')->auth($options);
    }
}
