<?php

namespace LaraPress\Foundation\Bus;

use LaraPress\Contracts\Bus\Dispatcher;
use LaraPress\Support\Fluent;

trait Dispatchable
{
    /**
     * Dispatch the job with the given arguments.
     *
     * @return \LaraPress\Foundation\Bus\PendingDispatch
     */
    public static function dispatch(...$arguments)
    {
        return new PendingDispatch(new static(...$arguments));
    }

    /**
     * Dispatch the job with the given arguments if the given truth test passes.
     *
     * @param bool $boolean
     * @param mixed ...$arguments
     * @return \LaraPress\Foundation\Bus\PendingDispatch|\LaraPress\Support\Fluent
     */
    public static function dispatchIf($boolean, ...$arguments)
    {
        return $boolean
            ? new PendingDispatch(new static(...$arguments))
            : new Fluent;
    }

    /**
     * Dispatch the job with the given arguments unless the given truth test passes.
     *
     * @param bool $boolean
     * @param mixed ...$arguments
     * @return \LaraPress\Foundation\Bus\PendingDispatch|\LaraPress\Support\Fluent
     */
    public static function dispatchUnless($boolean, ...$arguments)
    {
        return !$boolean
            ? new PendingDispatch(new static(...$arguments))
            : new Fluent;
    }

    /**
     * Dispatch a command to its appropriate handler in the current process.
     *
     * Queueable jobs will be dispatched to the "sync" queue.
     *
     * @return mixed
     */
    public static function dispatchSync(...$arguments)
    {
        return lp_app(Dispatcher::class)->dispatchSync(new static(...$arguments));
    }

    /**
     * Dispatch a command to its appropriate handler in the current process.
     *
     * @return mixed
     *
     * @deprecated Will be removed in a future Laravel version.
     */
    public static function dispatchNow(...$arguments)
    {
        return lp_app(Dispatcher::class)->dispatchNow(new static(...$arguments));
    }

    /**
     * Dispatch a command to its appropriate handler after the current process.
     *
     * @return mixed
     */
    public static function dispatchAfterResponse(...$arguments)
    {
        return lp_app(Dispatcher::class)->dispatchAfterResponse(new static(...$arguments));
    }

    /**
     * Set the jobs that should run if this job is successful.
     *
     * @param array $chain
     * @return \LaraPress\Foundation\Bus\PendingChain
     */
    public static function withChain($chain)
    {
        return new PendingChain(static::class, $chain);
    }
}
