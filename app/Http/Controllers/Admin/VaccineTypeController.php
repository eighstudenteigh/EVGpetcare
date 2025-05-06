<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\PetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\VaccineType;

class VaccineTypeController extends Controller
{
    public function index()
    {
        return view('admin.vaccine-types.index', [
            'vaccineTypes' => VaccineType::all()
        ]);
    }

    public function create()
    {
        return view('admin.vaccine-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:vaccine_types,name',
            'description' => 'nullable|string'
        ]);

        VaccineType::create($request->all());

        return redirect()->route('admin.vaccine-types.index')
               ->with('success', 'Vaccine type created!');
    }

    public function edit(VaccineType $vaccineType)
{
    return view('admin.vaccine-types.edit', compact('vaccineType'));
}

public function update(Request $request, VaccineType $vaccineType)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:vaccine_types,name,' . $vaccineType->id,
        'description' => 'nullable|string'
    ]);

    $vaccineType->update($request->all());

    return redirect()->route('admin.vaccine-types.index')
           ->with('success', 'Vaccine type updated successfully!');
}
}