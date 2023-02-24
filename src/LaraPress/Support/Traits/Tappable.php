<?php

namespace LaraPress\Support\Traits;

trait Tappable
{
    /**
     * Call the given Closure with this instance then return the instance.
     *
     * @param callable|null $callback
     * @return $this|\LaraPress\Support\HigherOrderTapProxy
     */
    public function tap($callback = null)
    {
        return lp_tap($this, $callback);
    }
}
