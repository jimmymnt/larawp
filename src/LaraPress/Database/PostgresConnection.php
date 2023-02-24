<?php

namespace LaraPress\Database;

use Doctrine\DBAL\Driver\PDOPgSql\Driver as DoctrineDriver;
use Doctrine\DBAL\Version;
use LaraPress\Database\PDO\PostgresDriver;
use LaraPress\Database\Query\Grammars\PostgresGrammar as QueryGrammar;
use LaraPress\Database\Query\Processors\PostgresProcessor;
use LaraPress\Database\Schema\Grammars\PostgresGrammar as SchemaGrammar;
use LaraPress\Database\Schema\PostgresBuilder;
use LaraPress\Database\Schema\PostgresSchemaState;
use LaraPress\Filesystem\Filesystem;
use PDO;

class PostgresConnection extends Connection
{
    /**
     * Bind values to their parameters in the given statement.
     *
     * @param \PDOStatement $statement
     * @param array $bindings
     * @return void
     */
    public function bindValues($statement, $bindings)
    {
        foreach ($bindings as $key => $value) {
            if (is_int($value)) {
                $pdoParam = PDO::PARAM_INT;
            } elseif (is_resource($value)) {
                $pdoParam = PDO::PARAM_LOB;
            } else {
                $pdoParam = PDO::PARAM_STR;
            }

            $statement->bindValue(
                is_string($key) ? $key : $key + 1,
                $value,
                $pdoParam
            );
        }
    }

    /**
     * Get the default query grammar instance.
     *
     * @return \LaraPress\Database\Query\Grammars\PostgresGrammar
     */
    protected function getDefaultQueryGrammar()
    {
        return $this->withTablePrefix(new QueryGrammar);
    }

    /**
     * Get a schema builder instance for the connection.
     *
     * @return \LaraPress\Database\Schema\PostgresBuilder
     */
    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new PostgresBuilder($this);
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return \LaraPress\Database\Schema\Grammars\PostgresGrammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new SchemaGrammar);
    }

    /**
     * Get the schema state for the connection.
     *
     * @param \LaraPress\Filesystem\Filesystem|null $files
     * @param callable|null $processFactory
     * @return \LaraPress\Database\Schema\PostgresSchemaState
     */
    public function getSchemaState(Filesystem $files = null, callable $processFactory = null)
    {
        return new PostgresSchemaState($this, $files, $processFactory);
    }

    /**
     * Get the default post processor instance.
     *
     * @return \LaraPress\Database\Query\Processors\PostgresProcessor
     */
    protected function getDefaultPostProcessor()
    {
        return new PostgresProcessor;
    }

    /**
     * Get the Doctrine DBAL driver.
     *
     * @return \Doctrine\DBAL\Driver\PDOPgSql\Driver|\LaraPress\Database\PDO\PostgresDriver
     */
    protected function getDoctrineDriver()
    {
        return class_exists(Version::class) ? new DoctrineDriver : new PostgresDriver;
    }
}
