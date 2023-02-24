<?php

namespace LaraWP\Database;

use Doctrine\DBAL\Driver\PDOMySql\Driver as DoctrineDriver;
use Doctrine\DBAL\Version;
use LaraWP\Database\PDO\MySqlDriver;
use LaraWP\Database\Query\Grammars\MySqlGrammar as QueryGrammar;
use LaraWP\Database\Query\Processors\MySqlProcessor;
use LaraWP\Database\Schema\Grammars\MySqlGrammar as SchemaGrammar;
use LaraWP\Database\Schema\MySqlBuilder;
use LaraWP\Database\Schema\MySqlSchemaState;
use LaraWP\Filesystem\Filesystem;
use PDO;

class MySqlConnection extends Connection
{
    /**
     * Determine if the connected database is a MariaDB database.
     *
     * @return bool
     */
    public function isMaria()
    {
        return strpos($this->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION), 'MariaDB') !== false;
    }

    /**
     * Get the default query grammar instance.
     *
     * @return \LaraWP\Database\Query\Grammars\MySqlGrammar
     */
    protected function getDefaultQueryGrammar()
    {
        return $this->withTablePrefix(new QueryGrammar);
    }

    /**
     * Get a schema builder instance for the connection.
     *
     * @return \LaraWP\Database\Schema\MySqlBuilder
     */
    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new MySqlBuilder($this);
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return \LaraWP\Database\Schema\Grammars\MySqlGrammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new SchemaGrammar);
    }

    /**
     * Get the schema state for the connection.
     *
     * @param \LaraWP\Filesystem\Filesystem|null $files
     * @param callable|null $processFactory
     * @return \LaraWP\Database\Schema\MySqlSchemaState
     */
    public function getSchemaState(Filesystem $files = null, callable $processFactory = null)
    {
        return new MySqlSchemaState($this, $files, $processFactory);
    }

    /**
     * Get the default post processor instance.
     *
     * @return \LaraWP\Database\Query\Processors\MySqlProcessor
     */
    protected function getDefaultPostProcessor()
    {
        return new MySqlProcessor;
    }

    /**
     * Get the Doctrine DBAL driver.
     *
     * @return \Doctrine\DBAL\Driver\PDOMySql\Driver|\LaraWP\Database\PDO\MySqlDriver
     */
    protected function getDoctrineDriver()
    {
        return class_exists(Version::class) ? new DoctrineDriver : new MySqlDriver;
    }
}
