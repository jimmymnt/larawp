<?php

namespace LaraWP\Contracts\Filesystem;

interface Factory
{
    /**
     * Get a filesystem implementation.
     *
     * @param string|null $name
     * @return \LaraWP\Contracts\Filesystem\Filesystem
     */
    public function disk($name = null);
}
