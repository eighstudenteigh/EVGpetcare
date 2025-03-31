<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\PetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $pets = Auth::user()->pets;
            $petTypes = PetType::all(); // Fetch pet types
            return view('customer.pets.index', compact('pets', 'petTypes'));
        }

        return redirect()->route('login');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'breed' => ['nullable', 'string', 'max:255'],
            'gender' => ['required', 'string'],
            'age' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['customer_id'] = Auth::id();
        $pet = Pet::create($validated);

        return redirect()->route('customer.pets.index')->with('success', 'Pet added successfully.');
    }
    
    public function update(Request $request, Pet $pet)
    {
        if ($pet->customer_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized action'], 403);
        }
    
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'breed' => ['nullable', 'string', 'max:255'],
            'gender' => ['required', 'string'],
            'age' => ['nullable', 'integer', 'min:0'],
        ]);
    
        $pet->update($validated);
    
        return response()->json(['success' => 'Pet updated successfully.']);
    }
    
    public function destroy(Request $request, Pet $pet)
    {
        if ($pet->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $pet->delete();

        // ✅ Return JSON response for AJAX deletion
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('customer.pets.index')->with('success', 'Pet deleted successfully.');
    }
    
}
