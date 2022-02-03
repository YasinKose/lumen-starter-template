<?php

namespace App\Http\Requests;

class RegisterRequest extends FormRequest
{
    /**
     * @return string
     */
    public function responseMessage(): string
    {
        return __('lang.register.response');
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
            'name' => __('lang.register.name'),
            'surname' => __('lang.register.surname'),
            'email' => __('lang.register.email'),
            'password' => __('lang.register.password')
        ];
    }
}
