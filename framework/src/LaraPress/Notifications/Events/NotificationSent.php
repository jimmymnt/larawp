<?php

namespace LaraPress\Notifications\Events;

use LaraPress\Bus\Queueable;
use LaraPress\Queue\SerializesModels;

class NotificationSent
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
     * The channel's response.
     *
     * @var mixed
     */
    public $response;

    /**
     * Create a new event instance.
     *
     * @param mixed $notifiable
     * @param \LaraPress\Notifications\Notification $notification
     * @param string $channel
     * @param mixed $response
     * @return void
     */
    public function __construct($notifiable, $notification, $channel, $response = null)
    {
        $this->channel = $channel;
        $this->response = $response;
        $this->notifiable = $notifiable;
        $this->notification = $notification;
    }
}
