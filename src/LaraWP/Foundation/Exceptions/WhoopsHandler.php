<?php

namespace LaraWP\Foundation\Exceptions;

use LaraWP\Filesystem\Filesystem;
use LaraWP\Support\Arr;
use Whoops\Handler\PrettyPageHandler;

class WhoopsHandler
{
    /**
     * Create a new Whoops handler for debug mode.
     *
     * @return \Whoops\Handler\PrettyPageHandler
     */
    public function forDebug()
    {
        return lp_tap(new PrettyPageHandler, function ($handler) {
            $handler->handleUnconditionally(true);

            $this->registerApplicationPaths($handler)
                ->registerBlacklist($handler)
                ->registerEditor($handler);
        });
    }

    /**
     * Register the application paths with the handler.
     *
     * @param \Whoops\Handler\PrettyPageHandler $handler
     * @return $this
     */
    protected function registerApplicationPaths($handler)
    {
        $handler->setApplicationPaths(
            array_flip($this->directoriesExceptVendor())
        );

        return $this;
    }

    /**
     * Get the application paths except for the "vendor" directory.
     *
     * @return array
     */
    protected function directoriesExceptVendor()
    {
        return Arr::except(
            array_flip((new Filesystem)->directories(lp_base_path())),
            [lp_base_path('vendor')]
        );
    }

    /**
     * Register the blacklist with the handler.
     *
     * @param \Whoops\Handler\PrettyPageHandler $handler
     * @return $this
     */
    protected function registerBlacklist($handler)
    {
        foreach (lp_config('app.debug_blacklist', lp_config('app.debug_hide', [])) as $key => $secrets) {
            foreach ($secrets as $secret) {
                $handler->blacklist($key, $secret);
            }
        }

        return $this;
    }

    /**
     * Register the editor with the handler.
     *
     * @param \Whoops\Handler\PrettyPageHandler $handler
     * @return $this
     */
    protected function registerEditor($handler)
    {
        if (lp_config('app.editor', false)) {
            $handler->setEditor(lp_config('app.editor'));
        }

        return $this;
    }
}
