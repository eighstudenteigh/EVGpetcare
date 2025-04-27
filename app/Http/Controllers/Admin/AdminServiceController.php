<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\PetType;
use App\Models\VaccineType;
use App\Models\ServiceVaccinePricing;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = Service::with(['petTypes', 'vaccinePricings.vaccineType', 'vaccinePricings.petType'])
            ->orderBy('name')
            ->get();
            
        return view('admin.services.index', [
            'services' => $services,
            'petTypes' => PetType::orderBy('name')->get(),
            'vaccineTypes' => VaccineType::orderBy('name')->get()
        ]);
    }
    public function create()
    {
        $service = new Service([
            'is_vaccination' => false
        ]);
    
        return view('admin.services.create', [
            'service' => $service,
            'petTypes' => PetType::orderBy('name')->get(),
            'vaccineTypes' => VaccineType::orderBy('name')->get(),
            'vaccinePrices' => [] // Empty array for create form
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:services,name',
            'description' => 'required|string',
            'is_vaccination' => 'required|boolean',
            'animal_types' => $request->is_vaccination ? 'sometimes|array|min:0' : 'required|array|min:1',
            'animal_types.*' => 'integer|exists:pet_types,id',
            'prices' => 'sometimes|array',
            'prices.*' => 'nullable|numeric|min:0',
            'vaccine_types' => 'required_if:is_vaccination,true|array',
            'vaccine_types.*' => 'integer|exists:vaccine_types,id',
            'vaccine_prices' => 'required_if:is_vaccination,true|array',
            'vaccine_prices.*.*' => 'nullable|numeric|min:0',
            'universal_vaccines' => 'sometimes|array',
            'universal_vaccines.*' => 'integer|exists:vaccine_types,id',
            'universal_prices' => 'sometimes|array',
            'universal_prices.*' => 'nullable|numeric|min:0',
        ]);
    
        $service = Service::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'is_vaccination' => $validated['is_vaccination']
        ]);
    
        // Sync base pet types and prices
        if (isset($validated['animal_types'])) {
            $petSyncData = [];
            foreach ($validated['animal_types'] as $petTypeId) {
                $petSyncData[$petTypeId] = ['price' => $validated['prices'][$petTypeId] ?? null];
            }
            $service->petTypes()->sync($petSyncData);
        }
    
        // Handle vaccine pricing
        if ($service->is_vaccination) {
            $vaccinePricingData = [];
            
            // Universal vaccines
            foreach ($validated['universal_vaccines'] ?? [] as $vaccineId) {
                if (isset($validated['universal_prices'][$vaccineId])) {
                    $vaccinePricingData[] = [
                        'service_id' => $service->id,
                        'vaccine_type_id' => $vaccineId,
                        'pet_type_id' => null, // Null indicates universal vaccine
                        'price' => $validated['universal_prices'][$vaccineId],
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
            
            // Pet-specific vaccines
            foreach ($validated['vaccine_prices'] ?? [] as $vaccineId => $petPrices) {
                foreach ($petPrices as $petTypeId => $price) {
                    if ($price !== null) {
                        $vaccinePricingData[] = [
                            'service_id' => $service->id,
                            'vaccine_type_id' => $vaccineId,
                            'pet_type_id' => $petTypeId,
                            'price' => $price,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                }
            }
            
            ServiceVaccinePricing::where('service_id', $service->id)->delete();
            if (!empty($vaccinePricingData)) {
                ServiceVaccinePricing::insert($vaccinePricingData);
            }
        }
    
        return redirect()->route('admin.services.index')
               ->with('success', 'Service created successfully!');
    }
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:services,name',
            'description' => 'required|string',
            'is_vaccination' => 'required|boolean',
            'animal_types' => $request->is_vaccination ? 'sometimes|array|min:0' : 'required|array|min:1',
            'animal_types.*' => 'integer|exists:pet_types,id',
            'prices' => 'sometimes|array', // Changed from 'required'
            'prices.*' => 'nullable|numeric|min:0',
            'vaccine_types' => 'required_if:is_vaccination,true|array',
            'vaccine_types.*' => 'integer|exists:vaccine_types,id',
            'vaccine_prices' => 'sometimes|array', 
            'vaccine_prices.*.*' => 'nullable|numeric|min:0',
            'universal_vaccines' => 'sometimes|array',
            'universal_vaccines.*' => 'integer|exists:vaccine_types,id',
            'universal_prices' => 'sometimes|array',
            'universal_prices.*' => 'nullable|numeric|min:0',
            'vaccine_pet_types' => 'sometimes|array',
            'vaccine_pet_types.*' => 'sometimes|array',
            'vaccine_pet_types.*.*' => 'integer|exists:pet_types,id',
            
            'vaccine_prices.*' => 'sometimes|array',
           
        ]);
    
        $service = Service::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'is_vaccination' => $validated['is_vaccination']
        ]);
    
        // Sync pet types and prices
$petSyncData = [];
if (isset($validated['animal_types'])) {
    foreach ($validated['animal_types'] as $petTypeId) {
        $petSyncData[$petTypeId] = ['price' => $validated['prices'][$petTypeId] ?? null];
    }
    $service->petTypes()->sync($petSyncData);
}
        // Handle vaccine pricing
if ($service->is_vaccination) {
    $vaccinePricingData = [];
    
    // Universal vaccines
    foreach ($validated['universal_vaccines'] ?? [] as $vaccineId) {
        if (isset($validated['universal_prices'][$vaccineId])) {
            $vaccinePricingData[] = [
                'service_id' => $service->id,
                'vaccine_type_id' => $vaccineId,
                'pet_type_id' => null,
                'price' => $validated['universal_prices'][$vaccineId],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
    }
    
    // Pet-specific vaccines
    foreach ($validated['vaccine_prices'] ?? [] as $vaccineId => $petPrices) {
        foreach ($petPrices as $petTypeId => $price) {
            if (in_array($petTypeId, $validated['vaccine_pet_types'][$vaccineId] ?? [])) {
                $vaccinePricingData[] = [
                    'service_id' => $service->id,
                    'vaccine_type_id' => $vaccineId,
                    'pet_type_id' => $petTypeId,
                    'price' => $price,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
    }
    
    ServiceVaccinePricing::where('service_id', $service->id)->delete();
    if (!empty($vaccinePricingData)) {
        ServiceVaccinePricing::insert($vaccinePricingData);
    }
}
$service->update([
    'name' => $validated['name'],
    'description' => $validated['description'],
    'is_vaccination' => $validated['is_vaccination']
]);
    
        return redirect()->route('admin.services.index')
               ->with('success', 'Service updated successfully!');
    }


    public function edit(Service $service)
    {
        $vaccinePrices = [];
        foreach ($service->vaccinePricings as $pricing) {
            $vaccinePrices[$pricing->vaccine_type_id][$pricing->pet_type_id] = $pricing->price;
        }

        return view('admin.services.edit', [
            'service' => $service,
            'petTypes' => PetType::orderBy('name')->get(),
            'vaccineTypes' => VaccineType::orderBy('name')->get(),
            'vaccinePrices' => $vaccinePrices
        ]);
    }

   

    public function destroy(Service $service)
    {
        $service->petTypes()->detach();
        $service->vaccinePricings()->delete();
        $service->delete();
        
        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully!');
    }
}