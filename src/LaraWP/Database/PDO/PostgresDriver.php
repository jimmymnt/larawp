<?php

namespace LaraWP\Database\PDO;

use Doctrine\DBAL\Driver\AbstractPostgreSQLDriver;
use LaraWP\Database\PDO\Concerns\ConnectsToDatabase;

class PostgresDriver extends AbstractPostgreSQLDriver
{
    use ConnectsToDatabase;
}
