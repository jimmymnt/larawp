<?php

namespace LaraPress\Events;

use Closure;

if (!function_exists('LaraPress\Events\queueable')) {
    /**
     * Create a new queued Closure event listener.
     *
     * @param \Closure $closure
     * @return \LaraPress\Events\QueuedClosure
     */
    function queueable(Closure $closure)
    {
        return new QueuedClosure($closure);
    }
}
