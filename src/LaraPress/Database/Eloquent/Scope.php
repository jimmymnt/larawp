<?php

namespace LaraPress\Database\Eloquent;

use LaraPress\Database\Eloquent\Contracts\Model;

interface Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \LaraPress\Database\Eloquent\Builder $builder
     * @param \LaraPress\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model);
}
