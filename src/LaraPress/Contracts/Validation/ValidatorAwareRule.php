<?php

namespace LaraPress\Contracts\Validation;

interface ValidatorAwareRule
{
    /**
     * Set the current validator.
     *
     * @param \LaraPress\Validation\Validator $validator
     * @return $this
     */
    public function setValidator($validator);
}
