<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\PetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function create()
    {
        $petTypes = PetType::all();
        return view('customer.pets.create', compact('petTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'breed' => ['nullable', 'string', 'max:255'],
            'gender' => ['required', 'string'],
            'age' => ['nullable', 'integer', 'min:0'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'], // 5MB max
        ]);

        $validated['customer_id'] = Auth::id();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('pets', 'public');
        }
        
        $pet = Pet::create($validated);

        return redirect()->route('customer.pets.index')->with('success', 'Pet added successfully.');
    }
    
    public function show(Pet $pet)
{
    if ($pet->customer_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }
    
    // Get pet's appointment history with services and records
    $appointments = $pet->appointments()->with([
        'services',
        'records' => function($query) use ($pet) {
            $query->where('pet_id', $pet->id);
        }
    ])->latest()->get();
    
    return view('customer.pets.show', compact('pet', 'appointments'));
}
    public function edit(Pet $pet)
    {
        if ($pet->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $petTypes = PetType::all();
        return view('customer.pets.edit', compact('pet', 'petTypes'));
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
            'weight' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'], // 5MB max
        ]);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($pet->image) {
                Storage::disk('public')->delete($pet->image);
            }
            $validated['image'] = $request->file('image')->store('pets', 'public');
        }
    
        $pet->update($validated);
        
        // Check if the request is AJAX
        if ($request->ajax()) {
            return response()->json(['success' => 'Pet updated successfully.']);
        }
    
        return redirect()->route('customer.pets.index')->with('success', 'Pet updated successfully.');
    }
    
    public function destroy(Request $request, Pet $pet)
    {
        if ($pet->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete pet image if exists
        if ($pet->image) {
            Storage::disk('public')->delete($pet->image);
        }

        $pet->delete();

        // Return JSON response for AJAX deletion
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('customer.pets.index')->with('success', 'Pet deleted successfully.');
    }
}