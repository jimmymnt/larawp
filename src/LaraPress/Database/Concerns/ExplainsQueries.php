<?php

namespace LaraPress\Database\Concerns;

use LaraPress\Support\Collection;

trait ExplainsQueries
{
    /**
     * Explains the query.
     *
     * @return \LaraPress\Support\Collection
     */
    public function explain()
    {
        $sql = $this->toSql();

        $bindings = $this->getBindings();

        $explanation = $this->getConnection()->select('EXPLAIN ' . $sql, $bindings);

        return new Collection($explanation);
    }
}
