@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Create New Service</h1>

    {{-- Validation Error Block --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 border border-red-400 p-4 rounded">
            <strong class="block mb-2">Please fix the following errors:</strong>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.services.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Service Name</label>
            <input type="text" name="name" value="{{ old('name') }}" 
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2" 
                      rows="3" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Service Type</label>
            <select name="is_vaccination" id="isVaccination" class="w-full border rounded px-3 py-2" required>
                <option value="0" {{ old('is_vaccination') == '0' ? 'selected' : '' }}>Regular Service</option>
                <option value="1" {{ old('is_vaccination') == '1' ? 'selected' : '' }}>Vaccination Service</option>
            </select>
        </div>

        <div id="pet-types-section" class="mb-6 {{ old('is_vaccination') == '1' ? 'hidden' : '' }}">

            <label class="block text-gray-700 font-medium mb-2">Pet Types & Base Prices</label>
            @foreach($petTypes as $petType)
                <div class="flex items-center mb-2">
                    <input type="checkbox" name="animal_types[]" value="{{ $petType->id }}" 
                           class="mr-2 pet-type-checkbox" 
                           {{ in_array($petType->id, old('animal_types', [])) ? 'checked' : '' }}>
                    <span class="w-32">{{ $petType->name }}</span>
                    <input type="number" name="prices[{{ $petType->id }}]" 
                           class="border rounded px-2 py-1 w-24 ml-2" 
                           placeholder="₱" 
                           value="{{ old("prices.$petType->id") }}" 
                           step="0.01" min="0">
                </div>
            @endforeach
        </div>

        <div id="vaccine-section" class="{{ old('is_vaccination') ? '' : 'hidden' }} mb-6">
            <h3 class="font-medium text-gray-700 mb-3">Vaccine Pricing</h3>
            
            @foreach($vaccineTypes as $vaccine)
            <div class="vaccine-option mb-4 p-3 border rounded">
                <div class="flex items-center mb-2">
                    <input type="checkbox" name="vaccine_types[]" value="{{ $vaccine->id }}" 
                           id="vaccine_{{ $vaccine->id }}" class="vaccine-checkbox mr-2"
                           {{ in_array($vaccine->id, old('vaccine_types', [])) ? 'checked' : '' }}>
                    <label for="vaccine_{{ $vaccine->id }}" class="font-medium">{{ $vaccine->name }}</label>
                </div>
        
                <div class="vaccine-prices pl-5 {{ in_array($vaccine->id, old('vaccine_types', [])) ? '' : 'hidden' }}">
                    <div class="mb-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="universal_vaccines[]" value="{{ $vaccine->id }}"
                                   class="universal-checkbox mr-2"
                                   {{ in_array($vaccine->id, old('universal_vaccines', [])) ? 'checked' : '' }}>
                            <span>Universal Price (applies to all pets)</span>
                        </label>
                        <input type="number" name="universal_prices[{{ $vaccine->id }}]"
                               class="border rounded px-2 py-1 w-24 ml-3"
                               placeholder="₱" 
                               value="{{ old("universal_prices.$vaccine->id") }}"
                               step="0.01" min="0">
                    </div>
        
                    <div class="animal-specific-prices {{ in_array($vaccine->id, old('universal_vaccines', [])) ? 'hidden' : '' }}">
                        <h4 class="text-sm font-medium mb-2">Pet-specific Prices:</h4>
                        @foreach($petTypes as $petType)
                        <div class="flex items-center mb-1">
                            <input type="checkbox" name="vaccine_pet_types[{{ $vaccine->id }}][]" 
                                   value="{{ $petType->id }}"
                                   class="mr-2"
                                   {{ in_array($petType->id, old("vaccine_pet_types.$vaccine->id", [])) ? 'checked' : '' }}>
                            <span class="w-32">{{ $petType->name }}</span>
                            <input type="number" name="vaccine_prices[{{ $vaccine->id }}][{{ $petType->id }}]"
                                   class="border rounded px-2 py-1 w-24 ml-2"
                                   placeholder="₱"
                                   value="{{ old("vaccine_prices.$vaccine->id.$petType->id") }}"
                                   step="0.01" min="0">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="flex justify-end mt-6">
            <a href="{{ route('admin.services.index') }}" 
               class="bg-gray-400 text-white px-4 py-2 rounded mr-2">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create Service</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle vaccine sections
    const isVaccination = document.getElementById('isVaccination');
    const vaccineSection = document.getElementById('vaccine-section');
    
    function toggleVaccineSection() {
        vaccineSection.classList.toggle('hidden', isVaccination.value !== '1');
    }
    
    isVaccination.addEventListener('change', toggleVaccineSection);
    toggleVaccineSection(); // Initialize
    
    // Toggle individual vaccine options
    document.querySelectorAll('.vaccine-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            this.closest('.vaccine-option').querySelector('.vaccine-prices')
                .classList.toggle('hidden', !this.checked);
        });
    });
    
    // Toggle between universal and pet-specific pricing
    document.querySelectorAll('.universal-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const vaccineOption = this.closest('.vaccine-option');
            vaccineOption.querySelector('.animal-specific-prices')
                .classList.toggle('hidden', this.checked);
        });
    });
});
</script>
@endsection
