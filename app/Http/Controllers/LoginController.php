<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Ensure you have this Blade file
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // ✅ Check if email is verified
        if ($user->email_verified_at === null) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Your email is not verified. Please check your inbox.',
            ])->withInput();
        }

        // Redirect based on role
        return $user->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('customer.dashboard');
    }

    return back()->withErrors([
        'email' => 'Invalid credentials.',
    ])->withInput();
}

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
