<?php

namespace LaraPress\Wordpress\Model\Concerns;

use LaraPress\Database\Eloquent\Builder;

class QueryBuilder extends Builder
{
    public function setModel($model)
    {
        $this->model = $model;
        $this->query->from($model->getTable());
        return $this;
    }
}