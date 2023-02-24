<?php

namespace LaraPress\Contracts\Auth;

interface Factory
{
    /**
     * Get a guard instance by name.
     *
     * @param string|null $name
     * @return \LaraPress\Contracts\Auth\Guard|\LaraPress\Contracts\Auth\StatefulGuard
     */
    public function guard($name = null);

    /**
     * Set the default guard the factory should serve.
     *
     * @param string $name
     * @return void
     */
    public function shouldUse($name);
}
