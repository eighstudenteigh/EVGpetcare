<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PetType;
use Illuminate\Http\Request;

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
    public function destroy(PetType $petType)
    {
        $petType->delete();
        return redirect()->route('admin.pets.index')->with('success', 'Pet type deleted successfully.');
    }
}
