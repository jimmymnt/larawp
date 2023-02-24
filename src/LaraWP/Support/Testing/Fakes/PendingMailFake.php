<?php

namespace LaraWP\Support\Testing\Fakes;

use LaraWP\Contracts\Mail\Mailable;
use LaraWP\Mail\PendingMail;

class PendingMailFake extends PendingMail
{
    /**
     * Create a new instance.
     *
     * @param \LaraWP\Support\Testing\Fakes\MailFake $mailer
     * @return void
     */
    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send a new mailable message instance.
     *
     * @param \LaraWP\Contracts\Mail\Mailable $mailable
     * @return void
     */
    public function send(Mailable $mailable)
    {
        $this->mailer->send($this->fill($mailable));
    }

    /**
     * Push the given mailable onto the queue.
     *
     * @param \LaraWP\Contracts\Mail\Mailable $mailable
     * @return mixed
     */
    public function queue(Mailable $mailable)
    {
        return $this->mailer->queue($this->fill($mailable));
    }
}
