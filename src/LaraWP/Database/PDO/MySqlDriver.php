<?php

namespace LaraWP\Database\PDO;

use Doctrine\DBAL\Driver\AbstractMySQLDriver;
use LaraWP\Database\PDO\Concerns\ConnectsToDatabase;

class MySqlDriver extends AbstractMySQLDriver
{
    use ConnectsToDatabase;
}
