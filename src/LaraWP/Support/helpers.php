<?php

use LaraWP\Contracts\Support\DeferringDisplayableValue;
use LaraWP\Contracts\Support\Htmlable;
use LaraWP\Support\Arr;
use LaraWP\Support\Env;
use LaraWP\Support\HigherOrderTapProxy;
use LaraWP\Support\Optional;

if (!function_exists('lp_append_config')) {
    /**
     * Assign high numeric IDs to a config item to force appending.
     *
     * @param array $array
     * @return array
     */
    function lp_append_config(array $array)
    {
        $start = 9999;

        foreach ($array as $key => $value) {
            if (is_numeric($key)) {
                $start++;

                $array[$start] = Arr::pull($array, $key);
            }
        }

        return $array;
    }
}

if (!function_exists('lp_blank')) {
    /**
     * Determine if the given value is "blank".
     *
     * @param mixed $value
     * @return bool
     */
    function lp_blank($value)
    {
        if (is_null($value)) {
            return true;
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        if (is_numeric($value) || is_bool($value)) {
            return false;
        }

        if ($value instanceof Countable) {
            return count($value) === 0;
        }

        return empty($value);
    }
}

if (!function_exists('lp_class_basename')) {
    /**
     * Get the class "basename" of the given object / class.
     *
     * @param string|object $class
     * @return string
     */
    function lp_class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
}

if (!function_exists('lp_class_uses_recursive')) {
    /**
     * Returns all traits used by a class, its parent classes and trait of their traits.
     *
     * @param object|string $class
     * @return array
     */
    function lp_class_uses_recursive($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $results = [];

        foreach (array_reverse(class_parents($class)) + [$class => $class] as $class) {
            $results += lp_trait_uses_recursive($class);
        }

        return array_unique($results);
    }
}

if (!function_exists('lp_e')) {
    /**
     * Encode HTML special characters in a string.
     *
     * @param \LaraWP\Contracts\Support\DeferringDisplayableValue|\LaraWP\Contracts\Support\Htmlable|string|null $value
     * @param bool $doubleEncode
     * @return string
     */
    function lp_e($value, $doubleEncode = true)
    {
        if ($value instanceof DeferringDisplayableValue) {
            $value = $value->resolveDisplayableValue();
        }

        if ($value instanceof Htmlable) {
            return $value->toHtml();
        }

        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8', $doubleEncode);
    }
}

if (!function_exists('lp_env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function lp_env(string $key, $default = null)
    {
        return Env::get($key, $default);
    }
}

if (!function_exists('lp_filled')) {
    /**
     * Determine if a value is "filled".
     *
     * @param mixed $value
     * @return bool
     */
    function lp_filled($value): bool
    {
        return !lp_blank($value);
    }
}

if (!function_exists('lp_object_get')) {
    /**
     * Get an item from an object using "dot" notation.
     *
     * @param object $object
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    function lp_object_get($object, $key, $default = null)
    {
        if (is_null($key) || trim($key) === '') {
            return $object;
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_object($object) || !isset($object->{$segment})) {
                return lp_value($default);
            }

            $object = $object->{$segment};
        }

        return $object;
    }
}

if (!function_exists('lp_optional')) {
    /**
     * Provide access to optional objects.
     *
     * @param mixed $value
     * @param callable|null $callback
     * @return mixed
     */
    function lp_optional($value = null, callable $callback = null)
    {
        if (is_null($callback)) {
            return new Optional($value);
        } elseif (!is_null($value)) {
            return $callback($value);
        }
    }
}

if (!function_exists('lp_preg_replace_array')) {
    /**
     * Replace a given pattern with each value in the array in sequentially.
     *
     * @param string $pattern
     * @param array $replacements
     * @param string $subject
     * @return string
     */
    function lp_preg_replace_array($pattern, array $replacements, $subject)
    {
        return preg_replace_callback($pattern, function () use (&$replacements) {
            foreach ($replacements as $key => $value) {
                return array_shift($replacements);
            }
        }, $subject);
    }
}

if (!function_exists('lp_retry')) {
    /**
     * Retry an operation a given number of times.
     *
     * @param int $times
     * @param callable $callback
     * @param int|\Closure $sleepMilliseconds
     * @param callable|null $when
     * @return mixed
     *
     * @throws \Exception
     */
    function lp_retry($times, callable $callback, $sleepMilliseconds = 0, $when = null)
    {
        $attempts = 0;

        beginning:
        $attempts++;
        $times--;

        try {
            return $callback($attempts);
        } catch (Exception $e) {
            if ($times < 1 || ($when && !$when($e))) {
                throw $e;
            }

            if ($sleepMilliseconds) {
                usleep(lp_value($sleepMilliseconds, $attempts) * 1000);
            }

            goto beginning;
        }
    }
}

if (!function_exists('lp_tap')) {
    /**
     * Call the given Closure with the given value then return the value.
     *
     * @param mixed $value
     * @param callable|null $callback
     * @return mixed
     */
    function lp_tap($value, $callback = null)
    {
        if (is_null($callback)) {
            return new HigherOrderTapProxy($value);
        }

        $callback($value);

        return $value;
    }
}

if (!function_exists('lp_throw_if')) {
    /**
     * Throw the given exception if the given condition is true.
     *
     * @param mixed $condition
     * @param \Throwable|string $exception
     * @param mixed ...$parameters
     * @return mixed
     *
     * @throws \Throwable
     */
    function lp_throw_if($condition, $exception = 'RuntimeException', ...$parameters)
    {
        if ($condition) {
            if (is_string($exception) && class_exists($exception)) {
                $exception = new $exception(...$parameters);
            }

            throw is_string($exception) ? new RuntimeException($exception) : $exception;
        }

        return $condition;
    }
}

if (!function_exists('lp_throw_unless')) {
    /**
     * Throw the given exception unless the given condition is true.
     *
     * @param mixed $condition
     * @param \Throwable|string $exception
     * @param mixed ...$parameters
     * @return mixed
     *
     * @throws \Throwable
     */
    function lp_throw_unless($condition, $exception = 'RuntimeException', ...$parameters)
    {
        lp_throw_if(!$condition, $exception, ...$parameters);

        return $condition;
    }
}

if (!function_exists('lp_trait_uses_recursive')) {
    /**
     * Returns all traits used by a trait and its traits.
     *
     * @param string $trait
     * @return array
     */
    function lp_trait_uses_recursive($trait)
    {
        $traits = class_uses($trait) ?: [];

        foreach ($traits as $trait) {
            $traits += lp_trait_uses_recursive($trait);
        }

        return $traits;
    }
}

if (!function_exists('lp_transform')) {
    /**
     * Transform the given value if it is present.
     *
     * @param mixed $value
     * @param callable $callback
     * @param mixed $default
     * @return mixed|null
     */
    function lp_transform($value, callable $callback, $default = null)
    {
        if (lp_filled($value)) {
            return $callback($value);
        }

        if (is_callable($default)) {
            return $default($value);
        }

        return $default;
    }
}

if (!function_exists('lp_windolp_os')) {
    /**
     * Determine whether the current environment is Windows based.
     *
     * @return bool
     */
    function lp_windolp_os()
    {
        return PHP_OS_FAMILY === 'Windows';
    }
}

if (!function_exists('lp_with')) {
    /**
     * Return the given value, optionally passed through the given callback.
     *
     * @param mixed $value
     * @param callable|null $callback
     * @return mixed
     */
    function lp_with($value, callable $callback = null)
    {
        return is_null($callback) ? $value : $callback($value);
    }
}
