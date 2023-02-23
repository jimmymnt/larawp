<?php

namespace LaraPress\Database\Eloquent;

use LaraPress\Contracts\Queue\EntityNotFoundException;
use LaraPress\Contracts\Queue\EntityResolver as EntityResolverContract;

class QueueEntityResolver implements EntityResolverContract
{
    /**
     * Resolve the entity for the given ID.
     *
     * @param string $type
     * @param mixed $id
     * @return mixed
     *
     * @throws \LaraPress\Contracts\Queue\EntityNotFoundException
     */
    public function resolve($type, $id)
    {
        $instance = (new $type)->find($id);

        if ($instance) {
            return $instance;
        }

        throw new EntityNotFoundException($type, $id);
    }
}
