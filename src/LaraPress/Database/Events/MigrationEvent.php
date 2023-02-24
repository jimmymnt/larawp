<?php

namespace LaraPress\Database\Events;

use LaraPress\Contracts\Database\Events\MigrationEvent as MigrationEventContract;
use LaraPress\Database\Migrations\Migration;

abstract class MigrationEvent implements MigrationEventContract
{
    /**
     * A migration instance.
     *
     * @var \LaraPress\Database\Migrations\Migration
     */
    public $migration;

    /**
     * The migration method that was called.
     *
     * @var string
     */
    public $method;

    /**
     * Create a new event instance.
     *
     * @param \LaraPress\Database\Migrations\Migration $migration
     * @param string $method
     * @return void
     */
    public function __construct(Migration $migration, $method)
    {
        $this->method = $method;
        $this->migration = $migration;
    }
}
