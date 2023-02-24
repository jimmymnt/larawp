<?php

namespace LaraWP\Notifications;

use LaraWP\Bus\Queueable;
use LaraWP\Contracts\Queue\ShouldBeEncrypted;
use LaraWP\Contracts\Queue\ShouldQueue;
use LaraWP\Database\Eloquent\Collection as EloquentCollection;
use LaraWP\Database\Eloquent\Model;
use LaraWP\Queue\InteractsWithQueue;
use LaraWP\Queue\SerializesModels;
use LaraWP\Support\Collection;

class SendQueuedNotifications implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The notifiable entities that should receive the notification.
     *
     * @var \LaraWP\Support\Collection
     */
    public $notifiables;

    /**
     * The notification to be sent.
     *
     * @var \LaraWP\Notifications\Notification
     */
    public $notification;

    /**
     * All of the channels to send the notification to.
     *
     * @var array
     */
    public $channels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout;

    /**
     * Indicates if the job should be encrypted.
     *
     * @var bool
     */
    public $shouldBeEncrypted = false;

    /**
     * Create a new job instance.
     *
     * @param \LaraWP\Notifications\Notifiable|\LaraWP\Support\Collection $notifiables
     * @param \LaraWP\Notifications\Notification $notification
     * @param array|null $channels
     * @return void
     */
    public function __construct($notifiables, $notification, array $channels = null)
    {
        $this->channels = $channels;
        $this->notification = $notification;
        $this->notifiables = $this->wrapNotifiables($notifiables);
        $this->tries = property_exists($notification, 'tries') ? $notification->tries : null;
        $this->timeout = property_exists($notification, 'timeout') ? $notification->timeout : null;
        $this->afterCommit = property_exists($notification, 'afterCommit') ? $notification->afterCommit : null;
        $this->shouldBeEncrypted = $notification instanceof ShouldBeEncrypted;
    }

    /**
     * Wrap the notifiable(s) in a collection.
     *
     * @param \LaraWP\Notifications\Notifiable|\LaraWP\Support\Collection $notifiables
     * @return \LaraWP\Support\Collection
     */
    protected function wrapNotifiables($notifiables)
    {
        if ($notifiables instanceof Collection) {
            return $notifiables;
        } elseif ($notifiables instanceof Model) {
            return EloquentCollection::wrap($notifiables);
        }

        return Collection::wrap($notifiables);
    }

    /**
     * Send the notifications.
     *
     * @param \LaraWP\Notifications\ChannelManager $manager
     * @return void
     */
    public function handle(ChannelManager $manager)
    {
        $manager->sendNow($this->notifiables, $this->notification, $this->channels);
    }

    /**
     * Get the display name for the queued job.
     *
     * @return string
     */
    public function displayName()
    {
        return get_class($this->notification);
    }

    /**
     * Call the failed method on the notification instance.
     *
     * @param \Throwable $e
     * @return void
     */
    public function failed($e)
    {
        if (method_exists($this->notification, 'failed')) {
            $this->notification->failed($e);
        }
    }

    /**
     * Get the number of seconds before a released notification will be available.
     *
     * @return mixed
     */
    public function backoff()
    {
        if (!method_exists($this->notification, 'backoff') && !isset($this->notification->backoff)) {
            return;
        }

        return $this->notification->backoff ?? $this->notification->backoff();
    }

    /**
     * Get the expiration for the notification.
     *
     * @return mixed
     */
    public function retryUntil()
    {
        if (!method_exists($this->notification, 'retryUntil') && !isset($this->notification->retryUntil)) {
            return;
        }

        return $this->notification->retryUntil ?? $this->notification->retryUntil();
    }

    /**
     * Prepare the instance for cloning.
     *
     * @return void
     */
    public function __clone()
    {
        $this->notifiables = clone $this->notifiables;
        $this->notification = clone $this->notification;
    }
}
