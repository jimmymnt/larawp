<?php

namespace LaraPress\Auth\Listeners;

use LaraPress\Auth\Events\Registered;
use LaraPress\Contracts\Auth\MustVerifyEmail;

class SendEmailVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param \LaraPress\Auth\Events\Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if ($event->user instanceof MustVerifyEmail && !$event->user->hasVerifiedEmail()) {
            $event->user->sendEmailVerificationNotification();
        }
    }
}
