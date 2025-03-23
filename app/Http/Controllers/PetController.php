<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    /**
     * Display a list of the user's pets.
     */
    public function index()
    {
        if (Auth::check()) {
            $pets = Auth::user()->pets;
            return view('customer.pets.index', compact('pets'));
        }

        return redirect()->route('login');
    }

    /**
     * Store a new pet in the database.
     */
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

        // ✅ Return JSON response if request is AJAX
        if ($request->ajax()) {
            return response()->json([
                'id' => $pet->id,
                'name' => $pet->name,
                'type' => ucfirst($pet->type),
                'breed' => $pet->breed ?: 'N/A',
                'age' => $pet->age . ' years'
            ]);
        }

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
