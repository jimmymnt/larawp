<?php

namespace LaraWP\Events;

use Closure;

if (!function_exists('LaraWP\Events\queueable')) {
    /**
     * Create a new queued Closure event listener.
     *
     * @param \Closure $closure
     * @return \LaraWP\Events\QueuedClosure
     */
    function queueable(Closure $closure)
    {
        return new QueuedClosure($closure);
    }
}
