<?php

namespace LaraWP\Support\Facades;

use Laravel\Ui\UiServiceProvider;
use RuntimeException;

/**
 * @method static \LaraWP\Auth\AuthManager extend(string $driver, \Closure $callback)
 * @method static \LaraWP\Auth\AuthManager provider(string $name, \Closure $callback)
 * @method static \LaraWP\Contracts\Auth\Authenticatable loginUsingId(mixed $id, bool $remember = false)
 * @method static \LaraWP\Contracts\Auth\Authenticatable|null user()
 * @method static \LaraWP\Contracts\Auth\Guard|\LaraWP\Contracts\Auth\StatefulGuard guard(string|null $name = null)
 * @method static \LaraWP\Contracts\Auth\UserProvider|null createUserProvider(string $provider = null)
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
 * @method static void login(\LaraWP\Contracts\Auth\Authenticatable $user, bool $remember = false)
 * @method static void logout()
 * @method static void logoutCurrentDevice()
 * @method static void setUser(\LaraWP\Contracts\Auth\Authenticatable $user)
 * @method static void shouldUse(string $name);
 *
 * @see \LaraWP\Auth\AuthManager
 * @see \LaraWP\Contracts\Auth\Factory
 * @see \LaraWP\Contracts\Auth\Guard
 * @see \LaraWP\Contracts\Auth\StatefulGuard
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
