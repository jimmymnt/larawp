<?php

namespace LaraPress\Database\PDO;

use Doctrine\DBAL\Driver\AbstractSQLiteDriver;
use LaraPress\Database\PDO\Concerns\ConnectsToDatabase;

class SQLiteDriver extends AbstractSQLiteDriver
{
    use ConnectsToDatabase;
}
