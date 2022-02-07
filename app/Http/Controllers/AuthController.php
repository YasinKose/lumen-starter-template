<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckResetPasswordTokenRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ResetPasswordTokenRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
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

    /**
     * @param ResetPasswordTokenRequest $request
     * @return JsonResponse
     */
    public function resetPasswordToken(ResetPasswordTokenRequest $request): JsonResponse
    {
        $token = DB::table('password_resets')
            ->where('token', $request->input('token'))
            ->first();

        if (!$token) {
            return Respond::notFound(__('lang.reset-password-token.invalid-token'));
        }

        if (dateLessThan($token->created_at, 15)) {
            DB::table('password_resets')->delete($token->id);
            return Respond::error(__('lang.reset-password-token.expired'));
        }

        User::find($token->user_id)->update([
            'password' => $request->input('password')
        ]);

        DB::table('password_resets')->delete($token->id);

        return Respond::ok(__('lang.reset-password-token.successful'));
    }

    public function checkResetPasswordToken(CheckResetPasswordTokenRequest $request)
    {
        $token = DB::table('password_resets')->select(['token', 'created_at'])->where('token', $request->input('token'))->first();

        if (!$token) {
            return Respond::notFound(__('lang.check-reset-password-token.invalid-token'));
        }

        if (dateLessThan($token->created_at, 15)) {
            DB::table('password_resets')->where('token', $request->input('token'))->delete();
            return Respond::error(__('lang.check-reset-password-token.expired'));
        }

        return Respond::ok(__('lang.check-reset-password-token.successful'), $token);
    }
}
