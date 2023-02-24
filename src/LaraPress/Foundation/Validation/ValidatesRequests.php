<?php

namespace LaraPress\Foundation\Validation;

use LaraPress\Contracts\Validation\Factory;
use LaraPress\Http\Request;
use LaraPress\Validation\ValidationException;

trait ValidatesRequests
{
    /**
     * Run the validation routine against the given validator.
     *
     * @param \LaraPress\Contracts\Validation\Validator|array $validator
     * @param \LaraPress\Http\Request|null $request
     * @return array
     *
     * @throws \LaraPress\Validation\ValidationException
     */
    public function validateWith($validator, Request $request = null)
    {
        $request = $request ?: lp_request();

        if (is_array($validator)) {
            $validator = $this->getValidationFactory()->make($request->all(), $validator);
        }

        return $validator->validate();
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param \LaraPress\Http\Request $request
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     * @return array
     *
     * @throws \LaraPress\Validation\ValidationException
     */
    public function validate(Request $request, array $rules,
                             array   $messages = [], array $customAttributes = [])
    {
        return $this->getValidationFactory()->make(
            $request->all(), $rules, $messages, $customAttributes
        )->validate();
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param string $errorBag
     * @param \LaraPress\Http\Request $request
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     * @return array
     *
     * @throws \LaraPress\Validation\ValidationException
     */
    public function validateWithBag($errorBag, Request $request, array $rules,
                                    array $messages = [], array $customAttributes = [])
    {
        try {
            return $this->validate($request, $rules, $messages, $customAttributes);
        } catch (ValidationException $e) {
            $e->errorBag = $errorBag;

            throw $e;
        }
    }

    /**
     * Get a validation factory instance.
     *
     * @return \LaraPress\Contracts\Validation\Factory
     */
    protected function getValidationFactory()
    {
        return lp_app(Factory::class);
    }
}
