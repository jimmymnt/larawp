<?php

namespace LaraPress\Console\Scheduling;

use Cron\CronExpression;
use DateTimeZone;
use LaraPress\Console\Command;
use LaraPress\Support\Carbon;

class ScheduleListCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'schedule:list {--timezone= : The timezone that times should be displayed in}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List the scheduled commands';

    /**
     * Execute the console command.
     *
     * @param \LaraPress\Console\Scheduling\Schedule $schedule
     * @return void
     *
     * @throws \Exception
     */
    public function handle(Schedule $schedule)
    {
        foreach ($schedule->events() as $event) {
            $rows[] = [
                $event->command,
                $event->expression,
                $event->description,
                (new CronExpression($event->expression))
                    ->getNextRunDate(Carbon::now()->setTimezone($event->timezone))
                    ->setTimezone(new DateTimeZone($this->option('timezone') ?? lp_config('app.timezone')))
                    ->format('Y-m-d H:i:s P'),
            ];
        }

        $this->table([
            'Command',
            'Interval',
            'Description',
            'Next Due',
        ], $rows ?? []);
    }
}
