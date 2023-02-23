<?php

namespace LaraPress\Contracts\Filesystem;

interface Factory
{
    /**
     * Get a filesystem implementation.
     *
     * @param string|null $name
     * @return \LaraPress\Contracts\Filesystem\Filesystem
     */
    public function disk($name = null);
}
