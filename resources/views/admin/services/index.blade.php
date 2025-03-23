@extends('layouts.admin')

@section('title', 'Manage Services')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">🛠 Manage Services</h2>
    Service Search Box

    <!-- 🔍 Search Box -->
    <div class="mb-4">
        <div class="relative">
            <input type="text" id="searchBox" placeholder="Search services or animal types..." 
                class="w-full p-2 pl-10 border rounded focus:border-orange-500 focus:outline-none">
            <div class="absolute left-3 top-2.5 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div>
    
    <a href="{{ route('admin.services.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded mb-4 inline-block">
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
                    <th class="p-3 text-left">Animal Type</th>
                    <th class="p-3 text-left">Price</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    @if ($service->animalTypes->isNotEmpty())
                        @foreach ($service->animalTypes as $index => $animal)
                            <tr class="border-b service-row" data-id="{{ $service->id }}">
                                @if ($index === 0)
                                    <!-- Service Name (Only on the first row per service) -->
                                    <td class="p-3 font-semibold align-top" rowspan="{{ $service->animalTypes->count() }}">
                                        {{ $service->name }}
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
                                        <button class="edit-service-btn bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded"
                                            data-id="{{ $service->id }}"
                                            data-name="{{ $service->name }}"
                                            data-prices="{{ json_encode($service->animalTypes->pluck('pivot.price', 'id')) }}"
                                            data-animals="{{ json_encode($service->animalTypes->pluck('id')->toArray()) }}">
                                            Edit
                                        </button>

                                        <!-- ❌ Delete Button -->
                                        <button class="delete-service-btn bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded"
                                            data-id="{{ $service->id }}">
                                            Delete
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <!-- If no animal types are linked, show the service with "No animal types assigned" -->
                        <tr class="border-b service-row" data-id="{{ $service->id }}">
                            <td class="p-3 font-semibold">{{ $service->name }}</td>
                            <td class="p-3 text-gray-500">No animal types assigned</td>
                            <td class="p-3">-</td>
                            <td class="p-3 flex gap-2">
                                <button class="edit-service-btn bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded"
                                    data-id="{{ $service->id }}"
                                    data-name="{{ $service->name }}">
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
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 max-h-[90vh] overflow-y-auto">
        <h2 class="text-xl font-bold mb-4">Edit Service</h2>

        <form id="editServiceForm">
            @csrf
            @method('PUT')

            <input type="hidden" id="editServiceId" name="id">

            <!-- 🏷 Service Name -->
            <div class="mb-4">
                <label class="text-gray-700 font-medium block mb-1">Service Name</label>
                <input type="text" id="editServiceName" name="name" class="w-full p-2 border rounded focus:border-orange-500 focus:outline-none" required>
            </div>

            <!-- 🐾 Select Pet Types -->
            <div class="mb-4">
                <label class="text-gray-700 font-medium block mb-1">Available for Pet Types</label>
                <div id="petTypeSelection" class="flex flex-wrap gap-2">
                    @foreach ($petTypes as $type)  
                        <label class="flex items-center space-x-2 bg-gray-100 px-3 py-2 rounded cursor-pointer">
                            <input type="checkbox" name="animal_types[]" value="{{ $type->id }}" 
                                class="pet-type-checkbox">
                            <span>{{ ucfirst($type->name) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <!-- 💰 Price -->
            <div id="priceInputsContainer" class="mt-4">
                <label class="text-gray-700 font-medium block mb-1">Price (₱)</label>
                <input type="number" id="editServicePrice" name="price" class="w-full p-2 border rounded focus:border-orange-500 focus:outline-none" min="0" step="0.01" required>
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
<!-- ✅ CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".edit-service-btn");
    const editServiceModal = document.getElementById("editServiceModal");
    const closeEditModal = document.getElementById("closeEditModal");
    const editServiceForm = document.getElementById("editServiceForm");
    const priceInputsContainer = document.getElementById("priceInputsContainer");

    function updatePriceInputs() {
    if (!priceInputsContainer) return; // ✅ Prevent null errors
    const existingInputs = {}; // ✅ Store current values before clearing

    // ✅ Save existing price values before clearing
    document.querySelectorAll("#priceInputsContainer input").forEach(input => {
        existingInputs[input.name] = input.value; 
    });

    priceInputsContainer.innerHTML = ""; // ✅ Clear previous price fields

    const existingPrices = JSON.parse(document.getElementById("editServiceId").dataset.prices || "{}");

    document.querySelectorAll(".pet-type-checkbox:checked").forEach(checkbox => {
        const petTypeId = checkbox.value;
        const petTypeName = checkbox.nextElementSibling.textContent;
        
        // ✅ Use existing price if set, else fallback to previous price input
        const previousPrice = existingPrices[petTypeId] ?? existingInputs[`prices[${petTypeId}]`] ?? "";
        const placeholderText = previousPrice !== "" ? `₱${previousPrice}` : "No price set";

        // ✅ Create price input field
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

// ✅ Open Edit Modal & Populate Fields
    editButtons.forEach(button => {
    button.addEventListener("click", function () {
        const serviceId = this.dataset.id;
        const serviceName = this.dataset.name;
        const serviceAnimals = JSON.parse(this.dataset.animals || "[]");
        const servicePrices = JSON.parse(this.dataset.prices || "{}"); // ✅ Get previous prices

        document.getElementById("editServiceId").value = serviceId;
        document.getElementById("editServiceId").dataset.prices = JSON.stringify(servicePrices); // ✅ Store prices in dataset
        document.getElementById("editServiceName").value = serviceName;

        document.querySelectorAll(".pet-type-checkbox").forEach(checkbox => {
            checkbox.checked = serviceAnimals.includes(parseInt(checkbox.value));
        });

        updatePriceInputs(); // ✅ Ensure prices are updated

        editServiceModal.classList.remove("hidden");
        editServiceModal.classList.add("flex");
    });
});


    // ✅ Close Modal
    closeEditModal.addEventListener("click", function () {
        editServiceModal.classList.remove("flex");
        editServiceModal.classList.add("hidden");
    });

    // ✅ Close modal when clicking outside
    editServiceModal.addEventListener("click", function (e) {
        if (e.target === editServiceModal) {
            editServiceModal.classList.remove("flex");
            editServiceModal.classList.add("hidden");
        }
    });

    // ✅ Attach event listeners to checkboxes
    document.querySelectorAll(".pet-type-checkbox").forEach(checkbox => {
        checkbox.addEventListener("change", updatePriceInputs);
    });

    // ✅ Handle AJAX Edit Form Submission
    editServiceForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const serviceId = document.getElementById("editServiceId").value;
        const formData = new FormData(editServiceForm);

        // Add basic fields
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
    formData.append('_method', 'PUT');
    formData.append('name', document.getElementById("editServiceName").value);

    // ✅ Collect selected pet types
    document.querySelectorAll(".pet-type-checkbox:checked").forEach(checkbox => {
        formData.append('animal_types[]', checkbox.value);
    });

    // ✅ Collect associated prices
    document.querySelectorAll("#priceInputsContainer input").forEach(input => {
        if (input.value.trim() !== "") {
            formData.append(input.name, input.value); // ✅ `prices[petTypeId]`
        }
    });

    fetch(`/admin/services/${serviceId}`, {
        method: "POST", // Laravel requires method spoofing for PUT
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
    // ✅ Handle AJAX Delete
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

    // ✅ Search Functionality
    const searchBox = document.getElementById("searchBox");
    if (searchBox) {
        searchBox.addEventListener("keyup", function () {
            const input = this.value.toLowerCase();
            document.querySelectorAll(".service-row").forEach(row => {
                const serviceName = row.querySelector("td:first-child").textContent.toLowerCase();
                const petTypes = row.querySelector("td:nth-child(3)").textContent.toLowerCase();

                row.style.display = (serviceName.includes(input) || petTypes.includes(input)) ? "" : "none";
            });
        });
    }
});
</script>
@endsection
				