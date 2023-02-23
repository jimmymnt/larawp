<?php

namespace LaraPress\Database\Eloquent\Casts;

use ArrayObject as BaseArrayObject;
use LaraPress\Contracts\Support\Arrayable;
use JsonSerializable;

class ArrayObject extends BaseArrayObject implements Arrayable, JsonSerializable
{
    /**
     * Get a collection containing the underlying array.
     *
     * @return \LaraPress\Support\Collection
     */
    public function collect()
    {
        return lp_collect($this->getArrayCopy());
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getArrayCopy();
    }

    /**
     * Get the array that should be JSON serialized.
     *
     * @return array
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->getArrayCopy();
    }
}
