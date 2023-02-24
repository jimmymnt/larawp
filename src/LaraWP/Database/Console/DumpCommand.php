<?php

namespace LaraWP\Database\Console;

use LaraWP\Console\Command;
use LaraWP\Contracts\Events\Dispatcher;
use LaraWP\Database\Connection;
use LaraWP\Database\ConnectionResolverInterface;
use LaraWP\Database\Events\SchemaDumped;
use LaraWP\Filesystem\Filesystem;
use LaraWP\Support\Facades\Config;

class DumpCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'schema:dump
                {--database= : The database connection to use}
                {--path= : The path where the schema dump file should be stored}
                {--prune : Delete all existing migration files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump the given database schema';

    /**
     * Execute the console command.
     *
     * @param \LaraWP\Database\ConnectionResolverInterface $connections
     * @param \LaraWP\Contracts\Events\Dispatcher $dispatcher
     * @return int
     */
    public function handle(ConnectionResolverInterface $connections, Dispatcher $dispatcher)
    {
        $connection = $connections->connection($database = $this->input->getOption('database'));

        $this->schemaState($connection)->dump(
            $connection, $path = $this->path($connection)
        );

        $dispatcher->dispatch(new SchemaDumped($connection, $path));

        $this->info('Database schema dumped successfully.');

        if ($this->option('prune')) {
            (new Filesystem)->deleteDirectory(
                lp_database_path('migrations'), $preserve = false
            );

            $this->info('Migrations pruned successfully.');
        }
    }

    /**
     * Create a schema state instance for the given connection.
     *
     * @param \LaraWP\Database\Connection $connection
     * @return mixed
     */
    protected function schemaState(Connection $connection)
    {
        return $connection->getSchemaState()
            ->withMigrationTable($connection->getTablePrefix() . Config::get('database.migrations', 'migrations'))
            ->handleOutputUsing(function ($type, $buffer) {
                $this->output->write($buffer);
            });
    }

    /**
     * Get the path that the dump should be written to.
     *
     * @param \LaraWP\Database\Connection $connection
     */
    protected function path(Connection $connection)
    {
        return lp_tap($this->option('path') ?: lp_database_path('schema/' . $connection->getName() . '-schema.dump'), function ($path) {
            (new Filesystem)->ensureDirectoryExists(dirname($path));
        });
    }
}
