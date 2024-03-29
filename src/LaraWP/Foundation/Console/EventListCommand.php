<?php

namespace LaraWP\Foundation\Console;

use LaraWP\Console\Command;
use LaraWP\Foundation\Support\Providers\EventServiceProvider;
use LaraWP\Support\Str;

class EventListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:list {--event= : Filter the events by name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "List the application's events and listeners";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $events = $this->getEvents();

        if (empty($events)) {
            return $this->error("Your application doesn't have any events matching the given criteria.");
        }

        $this->table(['Event', 'Listeners'], $events);
    }

    /**
     * Get all of the events and listeners configured for the application.
     *
     * @return array
     */
    protected function getEvents()
    {
        $events = [];

        foreach ($this->laravel->getProviders(EventServiceProvider::class) as $provider) {
            $providerEvents = array_merge_recursive($provider->shouldDiscoverEvents() ? $provider->discoverEvents() : [], $provider->listens());

            $events = array_merge_recursive($events, $providerEvents);
        }

        if ($this->filteringByEvent()) {
            $events = $this->filterEvents($events);
        }

        return lp_collect($events)->map(function ($listeners, $event) {
            return ['Event' => $event, 'Listeners' => implode(PHP_EOL, $listeners)];
        })->sortBy('lp_event')->values()->toArray();
    }

    /**
     * Filter the given events using the provided event name filter.
     *
     * @param array $events
     * @return array
     */
    protected function filterEvents(array $events)
    {
        if (!$eventName = $this->option('event')) {
            return $events;
        }

        return lp_collect($events)->filter(function ($listeners, $event) use ($eventName) {
            return Str::contains($event, $eventName);
        })->toArray();
    }

    /**
     * Determine whether the user is filtering by an event name.
     *
     * @return bool
     */
    protected function filteringByEvent()
    {
        return !empty($this->option('event'));
    }
}
