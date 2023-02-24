<?php

namespace LaraPress\Support\Facades;

/**
 * @method static \LaraPress\Redis\Connections\Connection connection(string $name = null)
 * @method static \LaraPress\Redis\Limiters\ConcurrencyLimiterBuilder funnel(string $name)
 * @method static \LaraPress\Redis\Limiters\DurationLimiterBuilder throttle(string $name)
 *
 * @see \LaraPress\Redis\RedisManager
 * @see \LaraPress\Contracts\Redis\Factory
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
