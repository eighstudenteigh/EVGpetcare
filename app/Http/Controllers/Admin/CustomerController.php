<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * ✅ Display all customers.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'customer');

        // 🔍 Search functionality
        if ($request->has('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%")
                  ->orWhere('address', 'like', "%{$request->search}%");
        }

        $customers = $query->orderBy('name')->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * ✅ Show the form for creating a new customer.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    
    // Store a newly created customer.
     
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[A-Za-z\s]{2,255}$/'],
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
        'password' => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required|string|min:8',
        'phone' => 'required|digits_between:10,11',
        'address' => 'required|string|max:255',
    ], [
        'email.unique' => 'This email is already taken.',
        'password.confirmed' => 'Passwords do not match.',
        'phone.digits_between' => 'Phone number must be 10-11 digits.',
    ]);

    User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
        'phone' => $validatedData['phone'],
        'address' => $validatedData['address'],
        'role' => 'customer',
    ]);

    return redirect()->route('admin.customers.index')
                     ->with('success', 'Customer added successfully.');
}


    /**
     * ✅ Show the form for editing a customer.
     */
    public function edit(User $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * ✅ Update the specified customer.
     */
    public function update(Request $request, User $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $customer->update([
            'name' => trim($request->name),
            'email' => trim($request->email),
            'phone' => $request->phone ? trim($request->phone) : null,
            'address' => $request->address ? trim($request->address) : null,
        ]);

        return redirect()->route('admin.customers.index')
                         ->with('success', 'Customer updated successfully.');
    }

    /**
     * ✅ Remove the specified customer.
     */
    public function destroy(User $customer)
    {
        $customer->delete();

        return redirect()->route('admin.customers.index')
                         ->with('success', 'Customer deleted successfully.');
    }
}
