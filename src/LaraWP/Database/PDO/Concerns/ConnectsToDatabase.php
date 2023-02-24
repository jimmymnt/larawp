<?php

namespace LaraWP\Database\PDO\Concerns;

use LaraWP\Database\PDO\Connection;
use InvalidArgumentException;
use PDO;

trait ConnectsToDatabase
{
    /**
     * Create a new database connection.
     *
     * @param array $params
     * @return \LaraWP\Database\PDO\Connection
     *
     * @throws \InvalidArgumentException
     */
    public function connect(array $params)
    {
        if (!isset($params['pdo']) || !$params['pdo'] instanceof PDO) {
            throw new InvalidArgumentException('Laravel requires the "pdo" property to be set and be a PDO instance.');
        }

        return new Connection($params['pdo']);
    }
}