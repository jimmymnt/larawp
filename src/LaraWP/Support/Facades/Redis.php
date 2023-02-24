<?php

namespace LaraWP\Support\Facades;

/**
 * @method static \LaraWP\Redis\Connections\Connection connection(string $name = null)
 * @method static \LaraWP\Redis\Limiters\ConcurrencyLimiterBuilder funnel(string $name)
 * @method static \LaraWP\Redis\Limiters\DurationLimiterBuilder throttle(string $name)
 *
 * @see \LaraWP\Redis\RedisManager
 * @see \LaraWP\Contracts\Redis\Factory
 */
class Redis extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'redis';
    }
}
