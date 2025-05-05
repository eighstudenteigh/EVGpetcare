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
        // Store in public/pets instead of storage/app/public/pets
        $imagePath = $request->file('image')->store('pets', 'public_direct');
        $validated['image'] = $imagePath; // Saves as 'pets/filename.jpg'
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
            if ($pet->image && file_exists(public_path('pets/' . basename($pet->image)))) {
                unlink(public_path('pets/' . basename($pet->image)));
            }
    
            // Store new image in public/pets
            $imagePath = $request->file('image')->store('pets', 'public_direct');
            $validated['image'] = $imagePath; // 'pets/filename.jpg'
        }
    
        $pet->update($validated);
        return redirect()->route('customer.pets.index')->with('success', 'Pet updated successfully.');
    }
    public function destroy(Request $request, Pet $pet)
    {
        if ($pet->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    
        if ($pet->image && file_exists(public_path($pet->image))) {
            unlink(public_path($pet->image));
        }
    
        $pet->delete();
    
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
    
        return redirect()->route('customer.pets.index')->with('success', 'Pet deleted successfully.');
    }
    
}