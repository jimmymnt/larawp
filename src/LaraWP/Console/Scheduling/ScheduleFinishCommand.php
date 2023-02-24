<?php

namespace LaraWP\Console\Scheduling;

use LaraWP\Console\Command;
use LaraWP\Console\Events\ScheduledBackgroundTaskFinished;
use LaraWP\Contracts\Events\Dispatcher;

class ScheduleFinishCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'schedule:finish {id} {code=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle the completion of a scheduled command';

    /**
     * Indicates whether the command should be shown in the Artisan command list.
     *
     * @var bool
     */
    protected $hidden = true;

    /**
     * Execute the console command.
     *
     * @param \LaraWP\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function handle(Schedule $schedule)
    {
        lp_collect($schedule->events())->filter(function ($value) {
            return $value->mutexName() == $this->argument('id');
        })->each(function ($event) {
            $event->callafterCallbacksWithExitCode($this->laravel, $this->argument('code'));

            $this->laravel->make(Dispatcher::class)->dispatch(new ScheduledBackgroundTaskFinished($event));
        });
    }
}
