<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PetType;

class AdminPetController extends Controller
{
    public function index(Request $request)
    {
        $query = Pet::with(['customer', 'petType']); // ✅ Load pet type relationship
        $petTypes = PetType::orderBy('name')->get();
        $owners = User::where('role', 'customer')->get(); // ✅ Fetch only customers
    
        // 🔍 Search by Pet Name, Type, or Owner
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhereHas('petType', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%"); // ✅ Search pet type name
                  })
                  ->orWhereHas('customer', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
        }
    
        $pets = $query->orderBy('name')->paginate(10);
        return view('admin.pets.index', compact('pets', 'owners', 'petTypes'));
    }
    
    public function update(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'gender' => 'required|string',
            'age' => 'nullable|integer|min:0',
            'customer_id' => 'required|exists:users,id', // Ensure owner exists
        ]);

        $pet->update($validated);

        return response()->json(['success' => 'Pet updated successfully.']);
    }

    public function destroy(Pet $pet)
    {
        if ($pet->appointments()->exists()) {
            return response()->json(['error' => 'Cannot delete pet with active appointments.'], 403);
        }

        $pet->delete();
        return response()->json(['success' => 'Pet deleted successfully.']);
    }
}
