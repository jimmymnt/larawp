<?php

namespace LaraWP\Database\PDO;

use Doctrine\DBAL\Driver\AbstractSQLiteDriver;
use LaraWP\Database\PDO\Concerns\ConnectsToDatabase;

class SQLiteDriver extends AbstractSQLiteDriver
{
    use ConnectsToDatabase;
}
