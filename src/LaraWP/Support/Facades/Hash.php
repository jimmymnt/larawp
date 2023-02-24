<?php

namespace LaraWP\Support\Facades;

/**
 * @method static array info(string $hashedValue)
 * @method static bool check(string $value, string $hashedValue, array $options = [])
 * @method static bool needsRehash(string $hashedValue, array $options = [])
 * @method static string make(string $value, array $options = [])
 * @method static \LaraWP\Hashing\HashManager extend($driver, \Closure $callback)
 *
 * @see \LaraWP\Hashing\HashManager
 */
class Hash extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'hash';
    }
}
