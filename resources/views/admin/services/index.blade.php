@extends('layouts.admin')

@section('title', 'Manage Services')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">🛠 Manage Services</h2>

    <!-- 🔍 Search and Filter Box -->
    <div class="mb-4 flex flex-col md:flex-row gap-4">
        <div class="relative flex-grow">
            <input type="text" id="searchBox" placeholder="Search services..." 
                class="w-full p-2 pl-10 border rounded focus:border-orange-500 focus:outline-none">
            <div class="absolute left-3 top-2.5 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
        
        
    </div>
    
    <a href="{{ route('admin.services.create') }}" class="bg-orange-500 hover:bg-gray-700 text-white px-4 py-2 rounded mb-4 inline-block">
        + Add New Service
    </a>
    
    @if(session('success'))
        <p class="text-green-600 bg-green-100 p-3 rounded-md">{{ session('success') }}</p>
    @endif

    <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
        <table class="w-full border-collapse">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="p-3 text-left">Service Name</th>
                    <th class="p-3 text-left">Type</th>
                    <th class="p-3 text-left">Animal Type</th>
                    <th class="p-3 text-left">Price</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    @if ($service->animalTypes->isNotEmpty())
                        @foreach ($service->animalTypes as $index => $animal)
                            <tr class="border-b service-row" data-id="{{ $service->id }}" data-type="{{ $service->service_type }}">
                                @if ($index === 0)
                                    <!-- Service Name (Only on the first row per service) -->
                                    <td class="p-3 font-semibold align-top" rowspan="{{ $service->animalTypes->count() }}">
                                        {{ $service->name }}
                                    </td>
                                    <!-- Service Type (Only on the first row per service) -->
                                    <td class="p-3 align-top" rowspan="{{ $service->animalTypes->count() }}">
                                        <span class="px-2 py-1 rounded-full text-xs 
                                            @if($service->service_type === 'grooming') 
                                            @elseif($service->service_type === 'medical')
                                             @endif">
                                            {{ ucfirst($service->service_type) }}
                                        </span>
                                    </td>
                                @endif
                                <!-- Animal Type -->
                                <td class="p-3">{{ ucfirst($animal->name) }}</td>
                                <!-- Price -->
                                <td class="p-3">₱{{ number_format($animal->pivot->price, 2) }}</td>
                                <!-- Actions (Only on the first row per service) -->
                                @if ($index === 0)
                                    <td class="p-3 flex gap-2 align-top" rowspan="{{ $service->animalTypes->count() }}">
                                        <!-- 🛠 Edit Button -->
                                        <button class="edit-service-btn bg-orange-500 hover:bg-gray-700 text-white px-3 py-1 rounded"
                                            data-id="{{ $service->id }}"
                                            data-name="{{ $service->name }}"
                                            data-service-type="{{ $service->service_type }}"
                                            data-description="{{ $service->description }}"
                                            data-prices="{{ json_encode($service->animalTypes->pluck('pivot.price', 'id')) }}"
                                            data-animals="{{ json_encode($service->animalTypes->pluck('id')->toArray()) }}">
                                            Edit
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <!-- If no animal types are linked -->
                        <tr class="border-b service-row" data-id="{{ $service->id }}" data-type="{{ $service->service_type }}">
                            <td class="p-3 font-semibold">{{ $service->name }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded-full text-xs 
                                    @if($service->service_type === 'grooming')
                                    @elseif($service->service_type === 'medical') 
                                     @endif">
                                    {{ ucfirst($service->service_type) }}
                                </span>
                            </td>
                            <td class="p-3 text-gray-500">No animal types assigned</td>
                            <td class="p-3">-</td>
                            <td class="p-3 flex gap-2">
                                <button class="edit-service-btn bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded"
                                    data-id="{{ $service->id }}"
                                    data-name="{{ $service->name }}"
                                    data-service-type="{{ $service->service_type }}"
                                    data-description="{{ $service->description }}">
                                    Edit
                                </button>
                                <button class="delete-service-btn bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded"
                                    data-id="{{ $service->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- 🛠 Edit Service Modal -->
    <div id="editServiceModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <h2 class="text-xl font-bold mb-4">Edit Service</h2>
            
            <form id="editServiceForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="editServiceId" name="id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <!-- Service Name -->
                        <div>
                            <label class="text-gray-700 font-medium block mb-1">Service Name *</label>
                            <input type="text" id="editServiceName" name="service_name" 
                                class="w-full p-2 border rounded focus:border-orange-500 focus:outline-none" required>
                        </div>

                        <!-- Service Type -->
                        <div>
                            <label class="text-gray-700 font-medium block mb-1">Service Type *</label>
                            <select id="editServiceType" name="service_type" 
                                class="w-full p-2 border rounded focus:border-orange-500 focus:outline-none" required>
                                <option value="grooming">Grooming</option>
                                <option value="medical">Medical</option>
                                <option value="boarding">Boarding</option>
                            </select>
                        </div>

                        <!-- Pet Types -->
                        <div>
                            <label class="text-gray-700 font-medium block mb-1">Available for Pet Types *</label>
                            <div id="petTypeSelection" class="flex flex-wrap gap-2">
                                @foreach($petTypes as $petType)
                                <label class="flex items-center space-x-2 bg-gray-100 px-3 py-2 rounded cursor-pointer">
                                    <input type="checkbox" name="pet_types[]" value="{{ $petType->id }}" 
                                        class="pet-type-checkbox">
                                    <span>{{ $petType->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Inputs -->
                        <div id="priceInputsContainer" class="space-y-3">
                            <label class="text-gray-700 font-medium block mb-1">Pricing by Pet Type *</label>
                            <!-- Dynamic price inputs will be inserted here -->
                        </div>
                    </div>

                    <!-- Right Column - Description -->
                    <div>
                        <div class="h-full flex flex-col">
                            <label class="text-gray-700 font-medium block mb-1">Service Description *</label>
                            <textarea id="editServiceDescription" name="description" rows="10"
                                class="flex-grow w-full p-2 border rounded focus:border-orange-500 focus:outline-none whitespace-pre-wrap"></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" id="closeEditModal" class="bg-gray-600 hover:bg-gray-800 text-white px-4 py-2 rounded transition">
                        Cancel
                    </button>
                    <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".edit-service-btn");
    const editServiceModal = document.getElementById("editServiceModal");
    const closeEditModal = document.getElementById("closeEditModal");
    const editServiceForm = document.getElementById("editServiceForm");
    const priceInputsContainer = document.getElementById("priceInputsContainer");

    function updatePriceInputs() {
        if (!priceInputsContainer) return;
        const existingInputs = {};

        document.querySelectorAll("#priceInputsContainer input").forEach(input => {
            existingInputs[input.name] = input.value; 
        });

        priceInputsContainer.innerHTML = "";

        const existingPrices = JSON.parse(document.getElementById("editServiceId").dataset.prices || "{}");

        document.querySelectorAll(".pet-type-checkbox:checked").forEach(checkbox => {
            const petTypeId = checkbox.value;
            const petTypeName = checkbox.nextElementSibling.textContent;
            const previousPrice = existingPrices[petTypeId] ?? existingInputs[`prices[${petTypeId}]`] ?? "";
            const placeholderText = previousPrice !== "" ? `₱${previousPrice}` : "No price set";

            const priceField = document.createElement("div");
            priceField.classList.add("mb-2");
            priceField.innerHTML = `
                <label class="text-gray-700 font-medium">${petTypeName} Price (₱)</label>
                <input type="number" name="prices[${petTypeId}]" class="w-full p-2 border rounded"
                    min="0" step="0.01" value="${previousPrice}" placeholder="${placeholderText}" required>
            `;

            priceInputsContainer.appendChild(priceField);
        });
    }

    // Open Edit Modal & Populate Fields
    editButtons.forEach(button => {
        button.addEventListener("click", function () {
            const serviceId = this.dataset.id;
            const serviceName = this.dataset.name;
            const serviceType = this.dataset.serviceType;
            const serviceDescription = this.dataset.description || '';
            const serviceAnimals = JSON.parse(this.dataset.animals || "[]");
            const servicePrices = JSON.parse(this.dataset.prices || "{}");

            // Set form fields
            document.getElementById("editServiceId").value = serviceId;
            document.getElementById("editServiceName").value = serviceName;
            document.getElementById("editServiceType").value = serviceType;
            document.getElementById("editServiceDescription").value = serviceDescription;
            document.getElementById("editServiceId").dataset.prices = JSON.stringify(servicePrices);

            // Set checkboxes
            document.querySelectorAll(".pet-type-checkbox").forEach(checkbox => {
                checkbox.checked = serviceAnimals.includes(parseInt(checkbox.value));
            });

            updatePriceInputs();
            editServiceModal.classList.remove("hidden");
            editServiceModal.classList.add("flex");
        });
    });

    // Service Type Filter
    const serviceTypeFilter = document.getElementById("serviceTypeFilter");
    if (serviceTypeFilter) {
        serviceTypeFilter.addEventListener("change", function() {
            const selectedType = this.value;
            const serviceRows = document.querySelectorAll(".service-row");
            
            serviceRows.forEach(row => {
                const rowType = row.dataset.type;
                if (!selectedType || rowType === selectedType) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    }
    // Close Modal
    closeEditModal.addEventListener("click", function () {
        editServiceModal.classList.remove("flex");
        editServiceModal.classList.add("hidden");
    });

    // Close modal when clicking outside
    editServiceModal.addEventListener("click", function (e) {
        if (e.target === editServiceModal) {
            editServiceModal.classList.remove("flex");
            editServiceModal.classList.add("hidden");
        }
    });

    // Attach event listeners to checkboxes
    document.querySelectorAll(".pet-type-checkbox").forEach(checkbox => {
        checkbox.addEventListener("change", updatePriceInputs);
    });

    // Handle AJAX Edit Form Submission
    editServiceForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const serviceId = document.getElementById("editServiceId").value;
        const formData = new FormData(editServiceForm);

        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        formData.append('_method', 'PUT');
        formData.append('name', document.getElementById("editServiceName").value);
        formData.append('description', document.getElementById("editServiceDescription").value);

        document.querySelectorAll(".pet-type-checkbox:checked").forEach(checkbox => {
            formData.append('animal_types[]', checkbox.value);
        });

        document.querySelectorAll("#priceInputsContainer input").forEach(input => {
            if (input.value.trim() !== "") {
                formData.append(input.name, input.value);
            }
        });

        fetch(`/admin/services/${serviceId}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json"
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Service updated successfully.");
                editServiceModal.classList.add("hidden");
                location.reload();
            } else {
                console.error("Error Response:", data);
                alert("Failed to update service: " + (data.error || "Unknown error"));
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while updating the service.");
        });
    });

    // Handle AJAX Delete
    document.querySelectorAll(".delete-service-btn").forEach(button => {
        button.addEventListener("click", function () {
            const serviceId = this.dataset.id;

            if (confirm("Are you sure you want to delete this service?")) {
                fetch(`/admin/services/${serviceId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Service deleted successfully.");
                        document.querySelector(`.service-row[data-id="${serviceId}"]`).remove();
                    } else {
                        alert(data.error || "Failed to delete service.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred while deleting the service.");
                });
            }
        });
    });

    // Search Functionality
    const searchBox = document.getElementById("searchBox");
    if (searchBox) {
        searchBox.addEventListener("keyup", function () {
            const input = this.value.toLowerCase();
            const matchedServiceIds = new Set();
            const serviceRows = document.querySelectorAll(".service-row");
            
            serviceRows.forEach(row => {
                const serviceId = row.dataset.id;
                const serviceName = row.querySelector("td:first-child").textContent.toLowerCase();
                
                if (serviceName.includes(input)) {
                    matchedServiceIds.add(serviceId);
                }
            });
            
            serviceRows.forEach(row => {
                const serviceId = row.dataset.id;
                row.style.display = matchedServiceIds.has(serviceId) ? "" : "none";
            });
        });
    }
});
</script>
@endsection