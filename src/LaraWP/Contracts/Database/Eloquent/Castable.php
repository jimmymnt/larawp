<?php

namespace LaraWP\Contracts\Database\Eloquent;

interface Castable
{
    /**
     * Get the name of the caster class to use when casting from / to this cast target.
     *
     * @param array $arguments
     * @return string
     * @return string|\LaraWP\Contracts\Database\Eloquent\CastsAttributes|\LaraWP\Contracts\Database\Eloquent\CastsInboundAttributes
     */
    public static function castUsing(array $arguments);
}
