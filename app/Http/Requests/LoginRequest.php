<?php

namespace App\Http\Requests;

class LoginRequest extends FormRequest
{
    /**
     * @return string
     */
    public function responseMessage(): string
    {
        return __('lang.login.response-message');
    }

    /**
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
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
                'min:10',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#\?&]/'
            ]
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'email' => __('lang.login.email'),
            'password' => __('lang.login.password')
        ];
    }
}
