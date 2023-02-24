<?php

namespace LaraWP\Database\Eloquent;

use LaraWP\Database\Eloquent\Contracts\Model;

interface Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \LaraWP\Database\Eloquent\Builder $builder
     * @param \LaraWP\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model);
}
