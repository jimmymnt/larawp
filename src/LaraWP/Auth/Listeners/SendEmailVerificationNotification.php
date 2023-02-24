<?php

namespace LaraWP\Auth\Listeners;

use LaraWP\Auth\Events\Registered;
use LaraWP\Contracts\Auth\MustVerifyEmail;

class SendEmailVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param \LaraWP\Auth\Events\Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if ($event->user instanceof MustVerifyEmail && !$event->user->hasVerifiedEmail()) {
            $event->user->sendEmailVerificationNotification();
        }
    }
}
