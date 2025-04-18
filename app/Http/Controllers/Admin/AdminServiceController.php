<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\PetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('animalTypes')->orderBy('name')->get();
        $petTypes = PetType::orderBy('name')->get();
        return view('admin.services.index', compact('services', 'petTypes'));
    }

    public function create()
    {
        $petTypes = PetType::orderBy('name')->get(); // Get all pet types
        return view('admin.services.create', compact('petTypes'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:services,name',
        'prices' => 'required|array', // Prices are required
        'prices.*' => 'required|numeric|min:0', // Each price must be a valid number
        'animal_types' => 'required|array', // At least one pet type must be selected
        'animal_types.*' => 'integer|exists:pet_types,id',
    ]);

    // ✅ Create the service (No animal_type column)
    $service = Service::create([
        'name' => $validated['name'],
    ]);

    // ✅ Attach pet types with individual prices
    $service->animalTypes()->sync(
        collect($validated['animal_types'])->mapWithKeys(function ($typeId) use ($validated) {
            return [$typeId => ['price' => $validated['prices'][$typeId] ?? 0]];
        })
    );

    return redirect()->route('admin.services.index')->with('success', 'Service added successfully.');
}
 
    public function edit(Service $service)
    {
        $petTypes = PetType::orderBy('name')->get();
        $selectedTypes = $service->animalTypes->pluck('id')->toArray();
        return view('admin.services.edit', compact('service', 'petTypes', 'selectedTypes'));
    }

    public function update(Request $request, Service $service)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:services,name,' . $service->id,
                'description' => 'required|string', // Add description validation
                'animal_types' => 'required|array',
                'animal_types.*' => 'integer|exists:pet_types,id',
                'prices' => 'required|array',
                'prices.*' => 'required|numeric|min:0',
            ]);
    
            // Update service
            $service->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
            ]);
    
            // Sync pet types with prices
            $syncData = [];
            foreach ($validated['animal_types'] as $petTypeId) {
                if (isset($validated['prices'][$petTypeId])) {
                    $syncData[$petTypeId] = ['price' => $validated['prices'][$petTypeId]];
                }
            }
            $service->animalTypes()->sync($syncData);
    
            return response()->json(['success' => true]);
    
        } catch (\Exception $e) {
            Log::error('Service update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to update service: ' . $e->getMessage()
            ], 500);
        }
    }
    public function destroy(Service $service)
    {
        try {
            // Detach all animal types first
            $service->animalTypes()->detach();
            
            // Then delete the service
            $service->delete();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Service deletion failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false, 
                'error' => 'Failed to delete service: ' . $e->getMessage()
            ], 500);
        }
    }
}