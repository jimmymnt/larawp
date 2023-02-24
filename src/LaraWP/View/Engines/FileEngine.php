<?php

namespace LaraWP\View\Engines;

use LaraWP\Contracts\View\Engine;
use LaraWP\Filesystem\Filesystem;

class FileEngine implements Engine
{
    /**
     * The filesystem instance.
     *
     * @var \LaraWP\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new file engine instance.
     *
     * @param \LaraWP\Filesystem\Filesystem $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * Get the evaluated contents of the view.
     *
     * @param string $path
     * @param array $data
     * @return string
     */
    public function get($path, array $data = [])
    {
        return $this->files->get($path);
    }
}
