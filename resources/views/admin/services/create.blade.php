@extends('layouts.admin')

@section('title', 'Add New Service')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">➕ Add New Service</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-md mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.services.store') }}" method="POST">
        @csrf

        <!-- 🏷 Service Name -->
        <div class="mb-4">
            <label class="text-gray-700 font-medium">Service Name</label>
            <input type="text" name="name" class="w-full p-2 border rounded focus:border-orange-500 focus:outline-none" required>
        </div>

        <!-- 🐾 Select Pet Types -->
        <div class="mb-4">
            <label class="text-gray-700 font-medium">Available for Pet Types</label>
            <div class="flex flex-wrap gap-2">
                @foreach ($petTypes as $type)
                    <label class="flex items-center space-x-2 bg-gray-100 px-3 py-2 rounded cursor-pointer">
                        <input type="checkbox" name="animal_types[]" value="{{ $type->id }}" class="pet-type-checkbox">
                        <span>{{ ucfirst($type->name) }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- 💰 Price Inputs (Dynamically Added) -->
        <div id="priceInputsContainer"></div>

        <div class="flex justify-end gap-2 mt-4">
            <a href="{{ route('admin.services.index') }}" class="bg-gray-600 hover:bg-gray-800 text-white px-4 py-2 rounded">
                Cancel
            </a>
            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
                Save Service
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const priceInputsContainer = document.getElementById("priceInputsContainer");
    
        function updatePriceInputs() {
            priceInputsContainer.innerHTML = ""; // Clear previous fields
    
            document.querySelectorAll(".pet-type-checkbox:checked").forEach(checkbox => {
                const petTypeId = checkbox.value;
                const petTypeName = checkbox.nextElementSibling.textContent;
    
                // ✅ Create price input field for the selected pet type
                const priceField = document.createElement("div");
                priceField.classList.add("mb-2");
                priceField.innerHTML = `
                    <label class="text-gray-700 font-medium">${petTypeName} Price (₱)</label>
                    <input type="number" name="prices[${petTypeId}]" class="w-full p-2 border rounded"
                        min="0" step="0.01" required>
                `;
    
                priceInputsContainer.appendChild(priceField);
            });
        }
    
        document.querySelectorAll(".pet-type-checkbox").forEach(checkbox => {
            checkbox.addEventListener("change", updatePriceInputs);
        });
    });
    </script>


@endsection
