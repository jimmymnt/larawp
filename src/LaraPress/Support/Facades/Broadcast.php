<?php

namespace LaraPress\Support\Facades;

use LaraPress\Contracts\Broadcasting\Factory as BroadcastingFactoryContract;

/**
 * @method static \LaraPress\Broadcasting\Broadcasters\Broadcaster channel(string $channel, callable|string $callback, array $options = [])
 * @method static mixed auth(\LaraPress\Http\Request $request)
 * @method static \LaraPress\Contracts\Broadcasting\Broadcaster connection($name = null);
 * @method static void routes(array $attributes = null)
 * @method static \LaraPress\Broadcasting\BroadcastManager socket($request = null)
 *
 * @see \LaraPress\Contracts\Broadcasting\Factory
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
