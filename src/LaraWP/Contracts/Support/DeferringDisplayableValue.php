<?php

namespace LaraWP\Contracts\Support;

interface DeferringDisplayableValue
{
    /**
     * Resolve the displayable value that the class is deferring.
     *
     * @return \LaraWP\Contracts\Support\Htmlable|string
     */
    public function resolveDisplayableValue();
}
