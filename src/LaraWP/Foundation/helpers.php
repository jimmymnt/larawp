<?php

use LaraWP\Container\Container;
use LaraWP\Contracts\Auth\Access\Gate;
use LaraWP\Contracts\Auth\Factory as AuthFactory;
use LaraWP\Contracts\Broadcasting\Factory as BroadcastFactory;
use LaraWP\Contracts\Bus\Dispatcher;
use LaraWP\Contracts\Cookie\Factory as CookieFactory;
use LaraWP\Contracts\Debug\ExceptionHandler;
use LaraWP\Contracts\Routing\ResponseFactory;
use LaraWP\Contracts\Routing\UrlGenerator;
use LaraWP\Contracts\Support\Responsable;
use LaraWP\Contracts\Validation\Factory as ValidationFactory;
use LaraWP\Contracts\View\Factory as ViewFactory;
use LaraWP\Foundation\Bus\PendingClosureDispatch;
use LaraWP\Foundation\Bus\PendingDispatch;
use LaraWP\Foundation\Mix;
use LaraWP\Http\Exceptions\HttpResponseException;
use LaraWP\Queue\CallQueuedClosure;
use LaraWP\Support\Facades\Date;
use LaraWP\Support\HtmlString;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('lp_abort')) {
    /**
     * Throw an HttpException with the given data.
     *
     * @param \Symfony\Component\HttpFoundation\Response|\LaraWP\Contracts\Support\Responsable|int $code
     * @param string $message
     * @param array $headers
     * @return never
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    function lp_abort($code, $message = '', array $headers = [])
    {
        if ($code instanceof Response) {
            throw new HttpResponseException($code);
        } elseif ($code instanceof Responsable) {
            throw new HttpResponseException($code->toResponse(lp_request()));
        }

        lp_app()->abort($code, $message, $headers);
    }
}

if (!function_exists('lp_abort_if')) {
    /**
     * Throw an HttpException with the given data if the given condition is true.
     *
     * @param bool $boolean
     * @param \Symfony\Component\HttpFoundation\Response|\LaraWP\Contracts\Support\Responsable|int $code
     * @param string $message
     * @param array $headers
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    function lp_abort_if($boolean, $code, $message = '', array $headers = [])
    {
        if ($boolean) {
            lp_abort($code, $message, $headers);
        }
    }
}

if (!function_exists('lp_abort_unless')) {
    /**
     * Throw an HttpException with the given data unless the given condition is true.
     *
     * @param bool $boolean
     * @param \Symfony\Component\HttpFoundation\Response|\LaraWP\Contracts\Support\Responsable|int $code
     * @param string $message
     * @param array $headers
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    function lp_abort_unless($boolean, $code, $message = '', array $headers = [])
    {
        if (!$boolean) {
            lp_abort($code, $message, $headers);
        }
    }
}

if (!function_exists('lp_action')) {
    /**
     * Generate the URL to a controller action.
     *
     * @param string|array $name
     * @param mixed $parameters
     * @param bool $absolute
     * @return string
     */
    function lp_action($name, $parameters = [], $absolute = true)
    {
        return lp_app('url')->action($name, $parameters, $absolute);
    }
}

if (!function_exists('lp_app')) {
    /**
     * Get the available container instance.
     *
     * @param string|null $abstract
     * @param array $parameters
     * @return mixed|\LaraWP\Contracts\Foundation\Application
     */
    function lp_app($abstract = null, array $parameters = [])
    {
        if (is_null($abstract)) {
            return Container::getInstance();
        }

        return Container::getInstance()->make($abstract, $parameters);
    }
}

if (!function_exists('lp_app_path')) {
    /**
     * Get the path to the application folder.
     *
     * @param string $path
     * @return string
     */
    function lp_app_path($path = '')
    {
        return lp_app()->path($path);
    }
}

if (!function_exists('lp_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function lp_asset($path, $secure = null)
    {
        return lp_app('url')->asset($path, $secure);
    }
}

if (!function_exists('lp_auth')) {
    /**
     * Get the available auth instance.
     *
     * @param string|null $guard
     * @return \LaraWP\Contracts\Auth\Factory|\LaraWP\Contracts\Auth\Guard|\LaraWP\Contracts\Auth\StatefulGuard
     */
    function lp_auth($guard = null)
    {
        if (is_null($guard)) {
            return lp_app(AuthFactory::class);
        }

        return lp_app(AuthFactory::class)->guard($guard);
    }
}

if (!function_exists('lp_back')) {
    /**
     * Create a new redirect response to the previous location.
     *
     * @param int $status
     * @param array $headers
     * @param mixed $fallback
     * @return \LaraWP\Http\RedirectResponse
     */
    function lp_back($status = 302, $headers = [], $fallback = false)
    {
        return lp_app('redirect')->back($status, $headers, $fallback);
    }
}

if (!function_exists('lp_base_path')) {
    /**
     * Get the path to the base of the install.
     *
     * @param string $path
     * @return string
     */
    function lp_base_path($path = '')
    {
        return lp_app()->basePath($path);
    }
}

if (!function_exists('lp_bcrypt')) {
    /**
     * Hash the given value against the bcrypt algorithm.
     *
     * @param string $value
     * @param array $options
     * @return string
     */
    function lp_bcrypt($value, $options = [])
    {
        return lp_app('hash')->driver('bcrypt')->make($value, $options);
    }
}

if (!function_exists('lp_broadcast')) {
    /**
     * Begin broadcasting an event.
     *
     * @param mixed|null $event
     * @return \LaraWP\Broadcasting\PendingBroadcast
     */
    function lp_broadcast($event = null)
    {
        return lp_app(BroadcastFactory::class)->event($event);
    }
}

if (!function_exists('lp_cache')) {
    /**
     * Get / set the specified cache value.
     *
     * If an array is passed, we'll assume you want to put to the cache.
     *
     * @param dynamic  key|key,default|data,expiration|null
     * @return mixed|\LaraWP\Cache\CacheManager
     *
     * @throws \Exception
     */
    function lp_cache()
    {
        $arguments = func_get_args();

        if (empty($arguments)) {
            return lp_app('cache');
        }

        if (is_string($arguments[0])) {
            return lp_app('cache')->get(...$arguments);
        }

        if (!is_array($arguments[0])) {
            throw new Exception(
                'When setting a value in the cache, you must pass an array of key / value pairs.'
            );
        }

        return lp_app('cache')->put(key($arguments[0]), reset($arguments[0]), $arguments[1] ?? null);
    }
}

if (!function_exists('lp_config')) {
    /**
     * Get / set the specified configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param array|string|null $key
     * @param mixed $default
     * @return mixed|\LaraWP\Config\Repository
     */
    function lp_config($key = null, $default = null)
    {
        if (is_null($key)) {
            return lp_app('config');
        }

        if (is_array($key)) {
            return lp_app('config')->set($key);
        }

        return lp_app('config')->get($key, $default);
    }
}

if (!function_exists('lp_config_path')) {
    /**
     * Get the configuration path.
     *
     * @param string $path
     * @return string
     */
    function lp_config_path($path = '')
    {
        return lp_app()->configPath($path);
    }
}

if (!function_exists('lp_cookie')) {
    /**
     * Create a new cookie instance.
     *
     * @param string|null $name
     * @param string|null $value
     * @param int $minutes
     * @param string|null $path
     * @param string|null $domain
     * @param bool|null $secure
     * @param bool $httpOnly
     * @param bool $raw
     * @param string|null $sameSite
     * @return \LaraWP\Cookie\CookieJar|\Symfony\Component\HttpFoundation\Cookie
     */
    function lp_cookie($name = null, $value = null, $minutes = 0, $path = null, $domain = null, $secure = null, $httpOnly = true, $raw = false, $sameSite = null)
    {
        $cookie = lp_app(CookieFactory::class);

        if (is_null($name)) {
            return $cookie;
        }

        return $cookie->make($name, $value, $minutes, $path, $domain, $secure, $httpOnly, $raw, $sameSite);
    }
}

if (!function_exists('lp_csrf_field')) {
    /**
     * Generate a CSRF token form field.
     *
     * @return \LaraWP\Support\HtmlString
     */
    function lp_csrf_field()
    {
        return new HtmlString('<input type="hidden" name="_token" value="' . lp_csrf_token() . '">');
    }
}

if (!function_exists('lp_csrf_token')) {
    /**
     * Get the CSRF token value.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    function lp_csrf_token()
    {
        $session = lp_app('session');

        if (isset($session)) {
            return $session->token();
        }

        throw new RuntimeException('Application session store not set.');
    }
}

if (!function_exists('lp_database_path')) {
    /**
     * Get the database path.
     *
     * @param string $path
     * @return string
     */
    function lp_database_path($path = '')
    {
        return lp_app()->databasePath($path);
    }
}

if (!function_exists('lp_decrypt')) {
    /**
     * Decrypt the given value.
     *
     * @param string $value
     * @param bool $unserialize
     * @return mixed
     */
    function lp_decrypt($value, $unserialize = true)
    {
        return lp_app('encrypter')->decrypt($value, $unserialize);
    }
}

if (!function_exists('lp_dispatch')) {
    /**
     * Dispatch a job to its appropriate handler.
     *
     * @param mixed $job
     * @return \LaraWP\Foundation\Bus\PendingDispatch
     */
    function lp_dispatch($job)
    {
        return $job instanceof Closure
            ? new PendingClosureDispatch(CallQueuedClosure::create($job))
            : new PendingDispatch($job);
    }
}

if (!function_exists('lp_dispatch_sync')) {
    /**
     * Dispatch a command to its appropriate handler in the current process.
     *
     * Queueable jobs will be dispatched to the "sync" queue.
     *
     * @param mixed $job
     * @param mixed $handler
     * @return mixed
     */
    function lp_dispatch_sync($job, $handler = null)
    {
        return lp_app(Dispatcher::class)->dispatchSync($job, $handler);
    }
}

if (!function_exists('lp_dispatch_now')) {
    /**
     * Dispatch a command to its appropriate handler in the current process.
     *
     * @param mixed $job
     * @param mixed $handler
     * @return mixed
     *
     * @deprecated Will be removed in a future Laravel version.
     */
    function lp_dispatch_now($job, $handler = null)
    {
        return lp_app(Dispatcher::class)->dispatchNow($job, $handler);
    }
}

if (!function_exists('lp_encrypt')) {
    /**
     * Encrypt the given value.
     *
     * @param mixed $value
     * @param bool $serialize
     * @return string
     */
    function lp_encrypt($value, $serialize = true)
    {
        return lp_app('encrypter')->encrypt($value, $serialize);
    }
}

if (!function_exists('lp_event')) {
    /**
     * Dispatch an event and call the listeners.
     *
     * @param string|object $event
     * @param mixed $payload
     * @param bool $halt
     * @return array|null
     */
    function lp_event(...$args)
    {
        return lp_app('events')->dispatch(...$args);
    }
}

if (!function_exists('lp_info')) {
    /**
     * Write some information to the log.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    function lp_info($message, $context = [])
    {
        lp_app('log')->info($message, $context);
    }
}

if (!function_exists('lp_logger')) {
    /**
     * Log a debug message to the logs.
     *
     * @param string|null $message
     * @param array $context
     * @return \LaraWP\Log\LogManager|null
     */
    function lp_logger($message = null, array $context = [])
    {
        if (is_null($message)) {
            return lp_app('log');
        }

        return lp_app('log')->debug($message, $context);
    }
}

if (!function_exists('lp_lang_path')) {
    /**
     * Get the path to the language folder.
     *
     * @param string $path
     * @return string
     */
    function lp_lang_path($path = '')
    {
        return lp_app('path.lang') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('lp_logs')) {
    /**
     * Get a log driver instance.
     *
     * @param string|null $driver
     * @return \LaraWP\Log\LogManager|\Psr\Log\LoggerInterface
     */
    function lp_logs($driver = null)
    {
        return $driver ? lp_app('log')->driver($driver) : lp_app('log');
    }
}

if (!function_exists('lp_method_field')) {
    /**
     * Generate a form field to spoof the HTTP verb used by forms.
     *
     * @param string $method
     * @return \LaraWP\Support\HtmlString
     */
    function lp_method_field($method)
    {
        return new HtmlString('<input type="hidden" name="_method" value="' . $method . '">');
    }
}

if (!function_exists('lp_mix')) {
    /**
     * Get the path to a versioned Mix file.
     *
     * @param string $path
     * @param string $manifestDirectory
     * @return \LaraWP\Support\HtmlString|string
     *
     * @throws \Exception
     */
    function lp_mix($path, $manifestDirectory = '')
    {
        return lp_app(Mix::class)(...func_get_args());
    }
}

if (!function_exists('lp_now')) {
    /**
     * Create a new Carbon instance for the current time.
     *
     * @param \DateTimeZone|string|null $tz
     * @return \LaraWP\Support\Carbon
     */
    function lp_now($tz = null)
    {
        return Date::now($tz);
    }
}

if (!function_exists('lp_old')) {
    /**
     * Retrieve an old input item.
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    function lp_old($key = null, $default = null)
    {
        return lp_app('request')->old($key, $default);
    }
}

if (!function_exists('lp_policy')) {
    /**
     * Get a policy instance for a given class.
     *
     * @param object|string $class
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    function lp_policy($class)
    {
        return lp_app(Gate::class)->getPolicyFor($class);
    }
}

if (!function_exists('lp_public_path')) {
    /**
     * Get the path to the public folder.
     *
     * @param string $path
     * @return string
     */
    function lp_public_path($path = '')
    {
        return lp_app()->make('path.public') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : $path);
    }
}

if (!function_exists('lp_redirect')) {
    /**
     * Get an instance of the redirector.
     *
     * @param string|null $to
     * @param int $status
     * @param array $headers
     * @param bool|null $secure
     * @return \LaraWP\Routing\Redirector|\LaraWP\Http\RedirectResponse
     */
    function lp_redirect($to = null, $status = 302, $headers = [], $secure = null)
    {
        if (is_null($to)) {
            return lp_app('redirect');
        }

        return lp_app('redirect')->to($to, $status, $headers, $secure);
    }
}

if (!function_exists('lp_report')) {
    /**
     * Report an exception.
     *
     * @param \Throwable|string $exception
     * @return void
     */
    function lp_report($exception)
    {
        if (is_string($exception)) {
            $exception = new Exception($exception);
        }

        lp_app(ExceptionHandler::class)->report($exception);
    }
}

if (!function_exists('lp_request')) {
    /**
     * Get an instance of the current request or an input item from the request.
     *
     * @param array|string|null $key
     * @param mixed $default
     * @return \LaraWP\Http\Request|string|array|null
     */
    function lp_request($key = null, $default = null)
    {
        if (is_null($key)) {
            return lp_app('request');
        }

        if (is_array($key)) {
            return lp_app('request')->only($key);
        }

        $value = lp_app('request')->__get($key);

        return is_null($value) ? lp_value($default) : $value;
    }
}

if (!function_exists('lp_rescue')) {
    /**
     * Catch a potential exception and return a default value.
     *
     * @param callable $callback
     * @param mixed $rescue
     * @param bool $report
     * @return mixed
     */
    function lp_rescue(callable $callback, $rescue = null, $report = true)
    {
        try {
            return $callback();
        } catch (Throwable $e) {
            if ($report) {
                lp_report($e);
            }

            return lp_value($rescue, $e);
        }
    }
}

if (!function_exists('lp_resolve')) {
    /**
     * Resolve a service from the container.
     *
     * @param string $name
     * @param array $parameters
     * @return mixed
     */
    function lp_resolve($name, array $parameters = [])
    {
        return lp_app($name, $parameters);
    }
}

if (!function_exists('lp_resource_path')) {
    /**
     * Get the path to the resources folder.
     *
     * @param string $path
     * @return string
     */
    function lp_resource_path($path = '')
    {
        return lp_app()->resourcePath($path);
    }
}

if (!function_exists('lp_response')) {
    /**
     * Return a new response from the application.
     *
     * @param \LaraWP\Contracts\View\View|string|array|null $content
     * @param int $status
     * @param array $headers
     * @return \LaraWP\Http\Response|\LaraWP\Contracts\Routing\ResponseFactory
     */
    function lp_response($content = '', $status = 200, array $headers = [])
    {
        $factory = lp_app(ResponseFactory::class);

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($content, $status, $headers);
    }
}

if (!function_exists('lp_route')) {
    /**
     * Generate the URL to a named route.
     *
     * @param array|string $name
     * @param mixed $parameters
     * @param bool $absolute
     * @return string
     */
    function lp_route($name, $parameters = [], $absolute = true)
    {
        return lp_app('url')->route($name, $parameters, $absolute);
    }
}

if (!function_exists('lp_secure_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @return string
     */
    function lp_secure_asset($path)
    {
        return lp_asset($path, true);
    }
}

if (!function_exists('lp_secure_url')) {
    /**
     * Generate a HTTPS url for the application.
     *
     * @param string $path
     * @param mixed $parameters
     * @return string
     */
    function lp_secure_url($path, $parameters = [])
    {
        return lp_url($path, $parameters, true);
    }
}

if (!function_exists('lp_session')) {
    /**
     * Get / set the specified session value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param array|string|null $key
     * @param mixed $default
     * @return mixed|\LaraWP\Session\Store|\LaraWP\Session\SessionManager
     */
    function lp_session($key = null, $default = null)
    {
        if (is_null($key)) {
            return lp_app('session');
        }

        if (is_array($key)) {
            return lp_app('session')->put($key);
        }

        return lp_app('session')->get($key, $default);
    }
}

if (!function_exists('lp_storage_path')) {
    /**
     * Get the path to the storage folder.
     *
     * @param string $path
     * @return string
     */
    function lp_storage_path($path = '')
    {
        return lp_app('path.storage') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('lp_today')) {
    /**
     * Create a new Carbon instance for the current date.
     *
     * @param \DateTimeZone|string|null $tz
     * @return \LaraWP\Support\Carbon
     */
    function lp_today($tz = null)
    {
        return Date::today($tz);
    }
}

if (!function_exists('lp_trans')) {
    /**
     * Translate the given message.
     *
     * @param string|null $key
     * @param array $replace
     * @param string|null $locale
     * @return \LaraWP\Contracts\Translation\Translator|string|array|null
     */
    function lp_trans($key = null, $replace = [], $locale = null)
    {
        if (is_null($key)) {
            return lp_app('translator');
        }

        return lp_app('translator')->get($key, $replace, $locale);
    }
}

if (!function_exists('lp_trans_choice')) {
    /**
     * Translates the given message based on a count.
     *
     * @param string $key
     * @param \Countable|int|array $number
     * @param array $replace
     * @param string|null $locale
     * @return string
     */
    function lp_trans_choice($key, $number, array $replace = [], $locale = null)
    {
        return lp_app('translator')->choice($key, $number, $replace, $locale);
    }
}

if (!function_exists('lp___')) {
    /**
     * Translate the given message.
     *
     * @param string|null $key
     * @param array $replace
     * @param string|null $locale
     * @return string|array|null
     */
    function lp___($key = null, $replace = [], $locale = null)
    {
        if (is_null($key)) {
            return $key;
        }

        return lp_trans($key, $replace, $locale);
    }
}

if (!function_exists('lp_url')) {
    /**
     * Generate a url for the application.
     *
     * @param string|null $path
     * @param mixed $parameters
     * @param bool|null $secure
     * @return \LaraWP\Contracts\Routing\UrlGenerator|string
     */
    function lp_url($path = null, $parameters = [], $secure = null)
    {
        if (is_null($path)) {
            return lp_app(UrlGenerator::class);
        }

        return lp_app(UrlGenerator::class)->to($path, $parameters, $secure);
    }
}

if (!function_exists('lp_validator')) {
    /**
     * Create a new Validator instance.
     *
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     * @return \LaraWP\Contracts\Validation\Validator|\LaraWP\Contracts\Validation\Factory
     */
    function lp_validator(array $data = [], array $rules = [], array $messages = [], array $customAttributes = [])
    {
        $factory = lp_app(ValidationFactory::class);

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($data, $rules, $messages, $customAttributes);
    }
}

if (!function_exists('lp_view')) {
    /**
     * Get the evaluated view contents for the given view.
     *
     * @param string|null $view
     * @param \LaraWP\Contracts\Support\Arrayable|array $data
     * @param array $mergeData
     * @return \LaraWP\Contracts\View\View|\LaraWP\Contracts\View\Factory
     */
    function lp_view($view = null, $data = [], $mergeData = [])
    {
        $factory = lp_app(ViewFactory::class);

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($view, $data, $mergeData);
    }
}
