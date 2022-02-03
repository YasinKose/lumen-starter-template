<?php

namespace App\Http\Requests;

class RegisterRequest extends FormRequest
{
    /**
     * @return string
     */
    public function responseMessage(): string
    {
        return __('lang.register.response-message');
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
            'name' => [
                'required',
            ],
            'surname' => [
                'required',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'confirmed',
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
            'name' => __('lang.validation.name'),
            'surname' => __('lang.validation.surname'),
            'email' => __('lang.validation.email'),
            'password' => __('lang.validation.password')
        ];
    }
}
