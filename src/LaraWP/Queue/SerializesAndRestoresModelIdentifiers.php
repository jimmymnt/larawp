<?php

namespace LaraWP\Queue;

use LaraWP\Contracts\Database\ModelIdentifier;
use LaraWP\Contracts\Queue\QueueableCollection;
use LaraWP\Contracts\Queue\QueueableEntity;
use LaraWP\Database\Eloquent\Collection as EloquentCollection;
use LaraWP\Database\Eloquent\Relations\Concerns\AsPivot;
use LaraWP\Database\Eloquent\Relations\Pivot;

trait SerializesAndRestoresModelIdentifiers
{
    /**
     * Get the property value prepared for serialization.
     *
     * @param mixed $value
     * @return mixed
     */
    protected function getSerializedPropertyValue($value)
    {
        if ($value instanceof QueueableCollection) {
            return new ModelIdentifier(
                $value->getQueueableClass(),
                $value->getQueueableIds(),
                $value->getQueueableRelations(),
                $value->getQueueableConnection()
            );
        }

        if ($value instanceof QueueableEntity) {
            return new ModelIdentifier(
                get_class($value),
                $value->getQueueableId(),
                $value->getQueueableRelations(),
                $value->getQueueableConnection()
            );
        }

        return $value;
    }

    /**
     * Get the restored property value after deserialization.
     *
     * @param mixed $value
     * @return mixed
     */
    protected function getRestoredPropertyValue($value)
    {
        if (!$value instanceof ModelIdentifier) {
            return $value;
        }

        return is_array($value->id)
            ? $this->restoreCollection($value)
            : $this->restoreModel($value);
    }

    /**
     * Restore a queueable collection instance.
     *
     * @param \LaraWP\Contracts\Database\ModelIdentifier $value
     * @return \LaraWP\Database\Eloquent\Collection
     */
    protected function restoreCollection($value)
    {
        if (!$value->class || count($value->id) === 0) {
            return new EloquentCollection;
        }

        $collection = $this->getQueryForModelRestoration(
            (new $value->class)->setConnection($value->connection), $value->id
        )->useWritePdo()->get();

        if (is_a($value->class, Pivot::class, true) ||
            in_array(AsPivot::class, class_uses($value->class))) {
            return $collection;
        }

        $collection = $collection->keyBy->getKey();

        $collectionClass = get_class($collection);

        return new $collectionClass(
            lp_collect($value->id)->map(function ($id) use ($collection) {
                return $collection[$id] ?? null;
            })->filter()
        );
    }

    /**
     * Restore the model from the model identifier instance.
     *
     * @param \LaraWP\Contracts\Database\ModelIdentifier $value
     * @return \LaraWP\Database\Eloquent\Model
     */
    public function restoreModel($value)
    {
        return $this->getQueryForModelRestoration(
            (new $value->class)->setConnection($value->connection), $value->id
        )->useWritePdo()->firstOrFail()->load($value->relations ?? []);
    }

    /**
     * Get the query for model restoration.
     *
     * @param \LaraWP\Database\Eloquent\Model $model
     * @param array|int $ids
     * @return \LaraWP\Database\Eloquent\Builder
     */
    protected function getQueryForModelRestoration($model, $ids)
    {
        return $model->newQueryForRestoration($ids);
    }
}
