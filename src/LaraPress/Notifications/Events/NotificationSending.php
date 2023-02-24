<?php

namespace LaraPress\Notifications\Events;

use LaraPress\Bus\Queueable;
use LaraPress\Queue\SerializesModels;

class NotificationSending
{
    use Queueable, SerializesModels;

    /**
     * The notifiable entity who received the notification.
     *
     * @var mixed
     */
    public $notifiable;

    /**
     * The notification instance.
     *
     * @var \LaraPress\Notifications\Notification
     */
    public $notification;

    /**
     * The channel name.
     *
     * @var string
     */
    public $channel;

    /**
     * Create a new event instance.
     *
     * @param mixed $notifiable
     * @param \LaraPress\Notifications\Notification $notification
     * @param string $channel
     * @return void
     */
    public function __construct($notifiable, $notification, $channel)
    {
        $this->channel = $channel;
        $this->notifiable = $notifiable;
        $this->notification = $notification;
    }
}
