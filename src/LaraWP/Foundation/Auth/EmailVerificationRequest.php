<?php

namespace LaraWP\Foundation\Auth;

use LaraWP\Auth\Events\Verified;
use LaraWP\Foundation\Http\FormRequest;

class EmailVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!hash_equals((string)$this->user()->getKey(),
            (string)$this->route('id'))) {
            return false;
        }

        if (!hash_equals(sha1($this->user()->getEmailForVerification()),
            (string)$this->route('hash'))) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Fulfill the email verification request.
     *
     * @return void
     */
    public function fulfill()
    {
        if (!$this->user()->hasVerifiedEmail()) {
            $this->user()->markEmailAsVerified();

            lp_event(new Verified($this->user()));
        }
    }

    /**
     * Configure the validator instance.
     *
     * @param \LaraWP\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        return $validator;
    }
}
