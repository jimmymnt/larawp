<?php

namespace LaraWP\Support\Facades;

use LaraWP\Contracts\Broadcasting\Factory as BroadcastingFactoryContract;

/**
 * @method static \LaraWP\Broadcasting\Broadcasters\Broadcaster channel(string $channel, callable|string $callback, array $options = [])
 * @method static mixed auth(\LaraWP\Http\Request $request)
 * @method static \LaraWP\Contracts\Broadcasting\Broadcaster connection($name = null);
 * @method static void routes(array $attributes = null)
 * @method static \LaraWP\Broadcasting\BroadcastManager socket($request = null)
 *
 * @see \LaraWP\Contracts\Broadcasting\Factory
 */
class Broadcast extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BroadcastingFactoryContract::class;
    }
}
