<?php

namespace LaraWP\Mail;

use LaraWP\Contracts\Mail\Mailable as MailableContract;
use LaraWP\Contracts\Mail\Mailer as MailerContract;
use LaraWP\Contracts\Translation\HasLocalePreference;
use LaraWP\Support\Traits\Conditionable;

class PendingMail
{
    use Conditionable;

    /**
     * The mailer instance.
     *
     * @var \LaraWP\Contracts\Mail\Mailer
     */
    protected $mailer;

    /**
     * The locale of the message.
     *
     * @var string
     */
    protected $locale;

    /**
     * The "to" recipients of the message.
     *
     * @var array
     */
    protected $to = [];

    /**
     * The "cc" recipients of the message.
     *
     * @var array
     */
    protected $cc = [];

    /**
     * The "bcc" recipients of the message.
     *
     * @var array
     */
    protected $bcc = [];

    /**
     * Create a new mailable mailer instance.
     *
     * @param \LaraWP\Contracts\Mail\Mailer $mailer
     * @return void
     */
    public function __construct(MailerContract $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Set the locale of the message.
     *
     * @param string $locale
     * @return $this
     */
    public function locale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Set the recipients of the message.
     *
     * @param mixed $users
     * @return $this
     */
    public function to($users)
    {
        $this->to = $users;

        if (!$this->locale && $users instanceof HasLocalePreference) {
            $this->locale($users->preferredLocale());
        }

        return $this;
    }

    /**
     * Set the recipients of the message.
     *
     * @param mixed $users
     * @return $this
     */
    public function cc($users)
    {
        $this->cc = $users;

        return $this;
    }

    /**
     * Set the recipients of the message.
     *
     * @param mixed $users
     * @return $this
     */
    public function bcc($users)
    {
        $this->bcc = $users;

        return $this;
    }

    /**
     * Send a new mailable message instance.
     *
     * @param \LaraWP\Contracts\Mail\Mailable $mailable
     * @return void
     */
    public function send(MailableContract $mailable)
    {
        $this->mailer->send($this->fill($mailable));
    }

    /**
     * Push the given mailable onto the queue.
     *
     * @param \LaraWP\Contracts\Mail\Mailable $mailable
     * @return mixed
     */
    public function queue(MailableContract $mailable)
    {
        return $this->mailer->queue($this->fill($mailable));
    }

    /**
     * Deliver the queued message after the given delay.
     *
     * @param \DateTimeInterface|\DateInterval|int $delay
     * @param \LaraWP\Contracts\Mail\Mailable $mailable
     * @return mixed
     */
    public function later($delay, MailableContract $mailable)
    {
        return $this->mailer->later($delay, $this->fill($mailable));
    }

    /**
     * Populate the mailable with the addresses.
     *
     * @param \LaraWP\Contracts\Mail\Mailable $mailable
     * @return \LaraWP\Mail\Mailable
     */
    protected function fill(MailableContract $mailable)
    {
        return lp_tap($mailable->to($this->to)
            ->cc($this->cc)
            ->bcc($this->bcc), function (MailableContract $mailable) {
            if ($this->locale) {
                $mailable->locale($this->locale);
            }
        });
    }
}
