<?php

namespace LaraPress\Foundation\Events;

trait Dispatchable
{
    /**
     * Dispatch the event with the given arguments.
     *
     * @return void
     */
    public static function dispatch()
    {
        return lp_event(new static(...func_get_args()));
    }

    /**
     * Dispatch the event with the given arguments if the given truth test passes.
     *
     * @param bool $boolean
     * @param mixed ...$arguments
     * @return void
     */
    public static function dispatchIf($boolean, ...$arguments)
    {
        if ($boolean) {
            return lp_event(new static(...$arguments));
        }
    }

    /**
     * Dispatch the event with the given arguments unless the given truth test passes.
     *
     * @param bool $boolean
     * @param mixed ...$arguments
     * @return void
     */
    public static function dispatchUnless($boolean, ...$arguments)
    {
        if (!$boolean) {
            return lp_event(new static(...$arguments));
        }
    }

    /**
     * Broadcast the event with the given arguments.
     *
     * @return \LaraPress\Broadcasting\PendingBroadcast
     */
    public static function broadcast()
    {
        return lp_broadcast(new static(...func_get_args()));
    }
}
