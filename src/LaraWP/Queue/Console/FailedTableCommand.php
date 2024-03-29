<?php

namespace LaraWP\Queue\Console;

use LaraWP\Console\Command;
use LaraWP\Filesystem\Filesystem;
use LaraWP\Support\Composer;
use LaraWP\Support\Str;

class FailedTableCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'queue:failed-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the failed queue jobs database table';

    /**
     * The filesystem instance.
     *
     * @var \LaraWP\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var \LaraWP\Support\Composer
     */
    protected $composer;

    /**
     * Create a new failed queue jobs table command instance.
     *
     * @param \LaraWP\Filesystem\Filesystem $files
     * @param \LaraWP\Support\Composer $composer
     * @return void
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct();

        $this->files = $files;
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $table = $this->laravel['config']['queue.failed.table'];

        $this->replaceMigration(
            $this->createBaseMigration($table), $table, Str::studly($table)
        );

        $this->info('Migration created successfully!');

        $this->composer->dumpAutoloads();
    }

    /**
     * Create a base migration file for the table.
     *
     * @param string $table
     * @return string
     */
    protected function createBaseMigration($table = 'failed_jobs')
    {
        return $this->laravel['migration.creator']->create(
            'create_' . $table . '_table', $this->laravel->databasePath() . '/migrations'
        );
    }

    /**
     * Replace the generated migration with the failed job table stub.
     *
     * @param string $path
     * @param string $table
     * @param string $tableClassName
     * @return void
     */
    protected function replaceMigration($path, $table, $tableClassName)
    {
        $stub = str_replace(
            ['{{table}}', '{{tableClassName}}'],
            [$table, $tableClassName],
            $this->files->get(__DIR__ . '/stubs/failed_jobs.stub')
        );

        $this->files->put($path, $stub);
    }
}
