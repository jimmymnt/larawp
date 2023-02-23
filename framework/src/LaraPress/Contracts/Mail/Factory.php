<?php

namespace LaraPress\Contracts\Mail;

interface Factory
{
    /**
     * Get a mailer instance by name.
     *
     * @param string|null $name
     * @return \LaraPress\Contracts\Mail\Mailer
     */
    public function mailer($name = null);
}
