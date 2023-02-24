<?php

namespace LaraPress\Support\Testing\Fakes;

use LaraPress\Contracts\Mail\Mailable;
use LaraPress\Mail\PendingMail;

class PendingMailFake extends PendingMail
{
    /**
     * Create a new instance.
     *
     * @param \LaraPress\Support\Testing\Fakes\MailFake $mailer
     * @return void
     */
    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send a new mailable message instance.
     *
     * @param \LaraPress\Contracts\Mail\Mailable $mailable
     * @return void
     */
    public function send(Mailable $mailable)
    {
        $this->mailer->send($this->fill($mailable));
    }

    /**
     * Push the given mailable onto the queue.
     *
     * @param \LaraPress\Contracts\Mail\Mailable $mailable
     * @return mixed
     */
    public function queue(Mailable $mailable)
    {
        return $this->mailer->queue($this->fill($mailable));
    }
}
