<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Respond;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!$token = auth()->attempt($request->validated())) {
            return Respond::error(__('lang.login.no-matching-account-found'));
        }

        return Respond::ok(__('lang.login.successful'), [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
