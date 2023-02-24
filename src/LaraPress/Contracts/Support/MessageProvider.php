<?php

namespace LaraPress\Contracts\Support;

interface MessageProvider
{
    /**
     * Get the messages for the instance.
     *
     * @return \LaraPress\Contracts\Support\MessageBag
     */
    public function getMessageBag();
}
