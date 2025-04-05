<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EmailVerificationController extends Controller
{
    public function verify($id)
    {
        $user = User::findOrFail($id);

        if ($user->email_verified_at !== null) {
            return redirect('/login')->with('status', 'Email already verified.');
        }

        $user->email_verified_at = Carbon::now();
        $user->save();

        return redirect('/login')->with('status', 'Email verified successfully. You can now log in.');
    }
}

