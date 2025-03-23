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
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin created successfully.');
    }
}
