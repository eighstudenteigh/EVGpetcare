<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminPetTypeController extends Controller
{
 
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255|unique:pet_types,name',
        ]);

        PetType::create(['name' => ucfirst($request->type)]);

        return redirect()->route('admin.pets.index')->with('success', 'Pet type added successfully.');
    }
    
    public function update(Request $request, PetType $petType)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:pet_types,name,' . $petType->id,
            ]);

            $petType->update([
                'name' => ucfirst($validated['name']),
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Pet type update failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false, 
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function destroy(PetType $petType)
    {
        $petType->delete();
        return redirect()->route('admin.pets.index')->with('success', 'Pet type deleted successfully.');
    }
    
}