<?php

namespace LaraPress\Contracts\Support;

interface DeferringDisplayableValue
{
    /**
     * Resolve the displayable value that the class is deferring.
     *
     * @return \LaraPress\Contracts\Support\Htmlable|string
     */
    public function resolveDisplayableValue();
}
