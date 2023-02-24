<?php

namespace LaraWP\Contracts\Validation;

interface ValidatorAwareRule
{
    /**
     * Set the current validator.
     *
     * @param \LaraWP\Validation\Validator $validator
     * @return $this
     */
    public function setValidator($validator);
}
