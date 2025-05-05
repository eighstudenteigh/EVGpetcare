<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Add this for Hash
use App\Models\User; // Add this for User model

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login'); 
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
    
        // Check if user exists and is verified BEFORE attempting login
        $user = User::where('email', $credentials['email'])->first();
    
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }
    
        // ✅ Check verification status
        if ($user->email_verified_at === null) {
            return back()->withErrors([
                'email' => 'Your email is not verified. Please check your inbox.',
            ])->withInput();
        }
    
        // Manually log in the user
        Auth::login($user);
    
        // Redirect based on role
        return $user->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('customer.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
