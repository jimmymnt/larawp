<?php

namespace LaraWP\Console\Scheduling;

use LaraWP\Console\Command;
use LaraWP\Console\Events\ScheduledTaskFailed;
use LaraWP\Console\Events\ScheduledTaskFinished;
use LaraWP\Console\Events\ScheduledTaskSkipped;
use LaraWP\Console\Events\ScheduledTaskStarting;
use LaraWP\Contracts\Debug\ExceptionHandler;
use LaraWP\Contracts\Events\Dispatcher;
use LaraWP\Support\Facades\Date;
use Throwable;

class ScheduleRunCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'schedule:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the scheduled commands';

    /**
     * The schedule instance.
     *
     * @var \LaraWP\Console\Scheduling\Schedule
     */
    protected $schedule;

    /**
     * The 24 hour timestamp this scheduler command started running.
     *
     * @var \LaraWP\Support\Carbon
     */
    protected $startedAt;

    /**
     * Check if any events ran.
     *
     * @var bool
     */
    protected $eventsRan = false;

    /**
     * The event dispatcher.
     *
     * @var \LaraWP\Contracts\Events\Dispatcher
     */
    protected $dispatcher;

    /**
     * The exception handler.
     *
     * @var \LaraWP\Contracts\Debug\ExceptionHandler
     */
    protected $handler;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->startedAt = Date::now();

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param \LaraWP\Console\Scheduling\Schedule $schedule
     * @param \LaraWP\Contracts\Events\Dispatcher $dispatcher
     * @param \LaraWP\Contracts\Debug\ExceptionHandler $handler
     * @return void
     */
    public function handle(Schedule $schedule, Dispatcher $dispatcher, ExceptionHandler $handler)
    {
        $this->schedule = $schedule;
        $this->dispatcher = $dispatcher;
        $this->handler = $handler;

        foreach ($this->schedule->dueEvents($this->laravel) as $event) {
            if (!$event->filtersPass($this->laravel)) {
                $this->dispatcher->dispatch(new ScheduledTaskSkipped($event));

                continue;
            }

            if ($event->onOneServer) {
                $this->runSingleServerEvent($event);
            } else {
                $this->runEvent($event);
            }

            $this->eventsRan = true;
        }

        if (!$this->eventsRan) {
            $this->info('No scheduled commands are ready to run.');
        }
    }

    /**
     * Run the given single server event.
     *
     * @param \LaraWP\Console\Scheduling\Event $event
     * @return void
     */
    protected function runSingleServerEvent($event)
    {
        if ($this->schedule->serverShouldRun($event, $this->startedAt)) {
            $this->runEvent($event);
        } else {
            $this->line('<info>Skipping command (has already run on another server):</info> ' . $event->getSummaryForDisplay());
        }
    }

    /**
     * Run the given event.
     *
     * @param \LaraWP\Console\Scheduling\Event $event
     * @return void
     */
    protected function runEvent($event)
    {
        $this->line('<info>[' . date('c') . '] Running scheduled command:</info> ' . $event->getSummaryForDisplay());

        $this->dispatcher->dispatch(new ScheduledTaskStarting($event));

        $start = microtime(true);

        try {
            $event->run($this->laravel);

            $this->dispatcher->dispatch(new ScheduledTaskFinished(
                $event,
                round(microtime(true) - $start, 2)
            ));

            $this->eventsRan = true;
        } catch (Throwable $e) {
            $this->dispatcher->dispatch(new ScheduledTaskFailed($event, $e));

            $this->handler->report($e);
        }
    }
}
