<?php

namespace LaraWP\Notifications\Console;

use LaraWP\Console\Command;
use LaraWP\Filesystem\Filesystem;
use LaraWP\Support\Composer;

class NotificationTableCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'notifications:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the notifications table';

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
     * Create a new notifications table command instance.
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
        $fullPath = $this->createBaseMigration();

        $this->files->put($fullPath, $this->files->get(__DIR__ . '/stubs/notifications.stub'));

        $this->info('Migration created successfully!');

        $this->composer->dumpAutoloads();
    }

    /**
     * Create a base migration file for the notifications.
     *
     * @return string
     */
    protected function createBaseMigration()
    {
        $name = 'create_notifications_table';

        $path = $this->laravel->databasePath() . '/migrations';

        return $this->laravel['migration.creator']->create($name, $path);
    }
}
