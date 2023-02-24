<?php

namespace LaraWP\Console\Scheduling;

interface CacheAware
{
    /**
     * Specify the cache store that should be used.
     *
     * @param string $store
     * @return $this
     */
    public function useStore($store);
}
