<?php

namespace LaraPress\Database\Eloquent;

use LaraPress\Database\Events\ModelsPruned;
use LogicException;

trait MassPrunable
{
    /**
     * Prune all prunable models in the database.
     *
     * @param int $chunkSize
     * @return int
     */
    public function pruneAll(int $chunkSize = 1000)
    {
        $query = lp_tap($this->prunable(), function ($query) use ($chunkSize) {
            $query->when(!$query->getQuery()->limit, function ($query) use ($chunkSize) {
                $query->limit($chunkSize);
            });
        });

        $total = 0;

        do {
            $total += $count = in_array(SoftDeletes::class, lp_class_uses_recursive(get_class($this)))
                ? $query->forceDelete()
                : $query->delete();

            if ($count > 0) {
                lp_event(new ModelsPruned(static::class, $total));
            }
        } while ($count > 0);

        return $total;
    }

    /**
     * Get the prunable model query.
     *
     * @return \LaraPress\Database\Eloquent\Builder
     */
    public function prunable()
    {
        throw new LogicException('Please implement the prunable method on your model.');
    }
}
