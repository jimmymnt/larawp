<?php

namespace LaraWP\Contracts\Support;

interface MessageProvider
{
    /**
     * Get the messages for the instance.
     *
     * @return \LaraWP\Contracts\Support\MessageBag
     */
    public function getMessageBag();
}
