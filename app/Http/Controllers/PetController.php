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
        'image' => ['nullable', 'image', 'max:5120'],
    ]);

    $validated['customer_id'] = Auth::id();

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = $image->hashName(); // Unique filename (e.g., "abc123.jpg")
        $image->move(public_path('pets'), $filename); // Save to `public/pets/abc123.jpg`
        $validated['image'] = 'pets/' . $filename; // Store "pets/abc123.jpg" in DB
    }

    Pet::create($validated);
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
            'image' => ['nullable', 'image', 'max:5120'],
        ]);
    
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($pet->image && file_exists(public_path($pet->image))) {
                unlink(public_path($pet->image));
            }
    
            // Save new image
            $image = $request->file('image');
            $filename = $image->hashName();
            $image->move(public_path('pets'), $filename);
            $validated['image'] = 'pets/' . $filename;
        }
    
        $pet->update($validated);
        return redirect()->route('customer.pets.index')->with('success', 'Pet updated successfully.');
    }
    public function destroy(Pet $pet)
{
    if ($pet->customer_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    // Delete image file if it exists
    if ($pet->image && file_exists(public_path($pet->image))) {
        unlink(public_path($pet->image));
    }

    $pet->delete();
    return redirect()->route('customer.pets.index')->with('success', 'Pet deleted successfully.');
}
    
}