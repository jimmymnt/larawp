<?php

namespace LaraPress\Notifications;

use LaraPress\Contracts\Notifications\Dispatcher;
use LaraPress\Support\Str;

trait RoutesNotifications
{
    /**
     * Send the given notification.
     *
     * @param mixed $instance
     * @return void
     */
    public function notify($instance)
    {
        lp_app(Dispatcher::class)->send($this, $instance);
    }

    /**
     * Send the given notification immediately.
     *
     * @param mixed $instance
     * @param array|null $channels
     * @return void
     */
    public function notifyNow($instance, array $channels = null)
    {
        lp_app(Dispatcher::class)->sendNow($this, $instance, $channels);
    }

    /**
     * Get the notification routing information for the given driver.
     *
     * @param string $driver
     * @param \LaraPress\Notifications\Notification|null $notification
     * @return mixed
     */
    public function routeNotificationFor($driver, $notification = null)
    {
        if (method_exists($this, $method = 'routeNotificationFor' . Str::studly($driver))) {
            return $this->{$method}($notification);
        }

        switch ($driver) {
            case 'database':
                return $this->notifications();
            case 'mail':
                return $this->email;
        }
    }
}
