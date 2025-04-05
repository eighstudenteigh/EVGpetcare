<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password-custom')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Reset the given user's password.
     */
    public function reset(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();

            // Add this to ensure the password is immediately updated
            $user->setRememberToken(Str::random(60));
            $user->save();
        }
    );

    if ($status == Password::PASSWORD_RESET) {
        return redirect()->route('login')
            ->with('success', 'Password reset successfully! You can now login with your new password.');
    }

    return back()->withInput($request->only('email'))
        ->withErrors(['email' => __($status)]);
}
}