@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Edit Service: {{ $service->name }}</h1>
    
    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Service Name</label>
            <input type="text" name="name" value="{{ old('name', $service->name) }}" 
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2" 
                      rows="3" required>{{ old('description', $service->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Service Type</label>
            <select name="is_vaccination" id="isVaccination" class="w-full border rounded px-3 py-2" required>
                <option value="0" {{ !$service->is_vaccination ? 'selected' : '' }}>Regular Service</option>
                <option value="1" {{ $service->is_vaccination ? 'selected' : '' }}>Vaccination Service</option>
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Pet Types & Base Prices</label>
            @foreach($petTypes as $petType)
                @php
                    $selected = $service->petTypes->contains('id', $petType->id);
                    $price = $selected ? $service->petTypes->firstWhere('id', $petType->id)->pivot->price : '';
                @endphp
                <div class="flex items-center mb-2">
                    <input type="checkbox" name="animal_types[]" value="{{ $petType->id }}" 
                           class="mr-2 pet-type-checkbox" 
                           {{ $selected || in_array($petType->id, old('animal_types', [])) ? 'checked' : '' }}>
                    <span class="w-32">{{ $petType->name }}</span>
                    <input type="number" name="prices[{{ $petType->id }}]" 
                           class="border rounded px-2 py-1 w-24 ml-2" 
                           placeholder="₱" 
                           value="{{ old("prices.$petType->id", $price) }}" 
                           step="0.01" min="0">
                </div>
            @endforeach
        </div>

        <div id="vaccine-section" class="{{ $service->is_vaccination ? '' : 'hidden' }}">
            <label class="block text-gray-700 font-medium mb-2">Vaccine Types & Pricing</label>
            @foreach($vaccineTypes as $vaccine)
                @php
                    $hasVaccine = isset($vaccinePrices[$vaccine->id]) || 
                                 in_array($vaccine->id, old('vaccine_types', []));
                @endphp
                <div class="border rounded p-4 mb-4">
                    <div class="flex items-center mb-3">
                        <input type="checkbox" name="vaccine_types[]" value="{{ $vaccine->id }}" 
                               class="mr-2 vaccine-checkbox" 
                               data-vaccine-id="{{ $vaccine->id }}"
                               {{ $hasVaccine ? 'checked' : '' }}>
                        <span class="font-medium">{{ $vaccine->name }}</span>
                    </div>

                    <div id="vaccine-prices-{{ $vaccine->id }}" 
                         class="pl-6 {{ $hasVaccine ? '' : 'hidden' }}">
                        @foreach($petTypes as $petType)
                            @php
                                $price = old("vaccine_prices.$vaccine->id.$petType->id", 
                                           $vaccinePrices[$vaccine->id][$petType->id] ?? '');
                            @endphp
                            <div class="flex items-center mb-2">
                                <span class="w-32">{{ $petType->name }}</span>
                                <input type="number" 
                                       name="vaccine_prices[{{ $vaccine->id }}][{{ $petType->id }}]" 
                                       class="border rounded px-2 py-1 w-24 ml-2" 
                                       placeholder="₱" 
                                       value="{{ $price }}" 
                                       step="0.01" min="0">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-end mt-6">
            <a href="{{ route('admin.services.index') }}" 
               class="bg-gray-400 text-white px-4 py-2 rounded mr-2">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Service</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isVaccination = document.getElementById('isVaccination');
    const vaccineSection = document.getElementById('vaccine-section');
    const vaccineCheckboxes = document.querySelectorAll('.vaccine-checkbox');

    // Toggle vaccine section visibility
    isVaccination.addEventListener('change', function() {
        vaccineSection.classList.toggle('hidden', this.value !== '1');
    });

    // Toggle vaccine price sections
    vaccineCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const priceSection = document.getElementById(`vaccine-prices-${this.dataset.vaccineId}`);
            priceSection.classList.toggle('hidden', !this.checked);
        });
    });
});
</script>
@endsection