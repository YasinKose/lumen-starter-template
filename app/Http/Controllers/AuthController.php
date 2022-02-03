<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Respond;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return mixed
     */
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

    /**
     * @param RegisterRequest $request
     * @return mixed
     */
    public function register(RegisterRequest $request)
    {
        return Respond::ok("OK", User::create($request->validated()));
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::select(['id', 'email'])
            ->where('email', $request->input("email"))
            ->first();

        if (!$user) {
            return Respond::notFound(__('lang.reset-password.user-not-found'));
        }

        $token = Str::random(32);

        DB::table('password_resets')->insert([
            'email' => $user->email,
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgot-password', ['token' => $token, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject(__('lang.mail.forgot-password.subject'));
        });

        return Respond::ok(__('lang.reset-password.successful'));
    }
}
