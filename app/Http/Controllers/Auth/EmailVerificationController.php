<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class EmailVerificationController extends Controller
{
    public function verify(Request $request, $id)
    {
        if (!$request->hasValidSignature()) {
            return redirect('/login')->with('error', 'Invalid or expired verification link.');
        }

        $user = User::findOrFail($id);

        if ($user->email_verified_at !== null) {
            return redirect('/login')->with('status', 'Email already verified.');
        }

        $user->email_verified_at = Carbon::now();
        $user->save();

        return redirect('/login')->with('status', 'Email verified successfully. You can now log in.');
    }
}