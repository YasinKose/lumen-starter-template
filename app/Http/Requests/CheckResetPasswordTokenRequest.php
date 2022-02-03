<?php

namespace App\Http\Requests;

class CheckResetPasswordTokenRequest extends FormRequest
{
    /**
     * @return string
     */
    public function responseMessage(): string
    {
        return __('lang.check-reset-password-token.response-message');
    }

    /**
     * Auth::check to check login status
     * Add true if login status is not important
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'token' => [
                'required',
                'exists:password_resets,token'
            ]
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'token' => __('lang.validation.token')
        ];
    }
}
