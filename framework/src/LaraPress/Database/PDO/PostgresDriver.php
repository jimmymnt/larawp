<?php

namespace LaraPress\Database\PDO;

use Doctrine\DBAL\Driver\AbstractPostgreSQLDriver;
use LaraPress\Database\PDO\Concerns\ConnectsToDatabase;

class PostgresDriver extends AbstractPostgreSQLDriver
{
    use ConnectsToDatabase;
}
