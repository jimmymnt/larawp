<?php

namespace LaraWP\Contracts\Mail;

interface Factory
{
    /**
     * Get a mailer instance by name.
     *
     * @param string|null $name
     * @return \LaraWP\Contracts\Mail\Mailer
     */
    public function mailer($name = null);
}
