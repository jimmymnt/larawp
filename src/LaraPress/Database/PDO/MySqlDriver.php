<?php

namespace LaraPress\Database\PDO;

use Doctrine\DBAL\Driver\AbstractMySQLDriver;
use LaraPress\Database\PDO\Concerns\ConnectsToDatabase;

class MySqlDriver extends AbstractMySQLDriver
{
    use ConnectsToDatabase;
}
