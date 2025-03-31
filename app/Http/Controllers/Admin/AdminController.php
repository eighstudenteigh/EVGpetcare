<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\User;
use App\Models\Service;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
{
    $admins = User::where('role', 'admin')->orderBy('name')->paginate(10);
    return view('admin.admins.index', compact('admins'));
}
    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ], [
        'name.required' => 'The name field is required.',
        'email.required' => 'The email field is required.',
        'email.unique' => 'The email has already been taken. Please use a different email.',
        'password.required' => 'The password field is required.',
        'password.min' => 'The password must be at least 8 characters.',
        'password.confirmed' => 'Password confirmation does not match.',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'admin',
    ]);

    return redirect()->route('admins.index')->with('success', 'Admin created successfully.');
}

    public function destroy($id)
{
    $admin = User::findOrFail($id);

    // Get the logged-in admin's email
    $loggedInAdminEmail = Auth::user()->email;

    // List of protected admin emails
    $protectedEmails = ['supacustoma333@gmail.com', 'evgadmintest@gmail.com'];

    // Prevent deleting the main super admin, protected admins, or own account
    if (in_array($admin->email, $protectedEmails)) {
        return response()->json(['success' => false, 'message' => 'Cannot delete a protected admin.']);
    }

    if ($admin->email === $loggedInAdminEmail) {
        return response()->json(['success' => false, 'message' => 'You cannot delete your own account.']);
    }

    $admin->delete();

    return response()->json(['success' => true, 'message' => 'Admin deleted successfully.']);
}

}
