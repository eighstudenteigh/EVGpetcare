@extends('layouts.admin')

@section('title', 'Manage Pets')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">🐾 Manage Pets</h2>

    <!-- ✅ Success Message -->
    @if(session('success'))
        <p class="text-green-600 bg-green-100 p-3 rounded-md">{{ session('success') }}</p>
    @endif

     <!-- ✅ Add Pet Type Section -->
<div class="bg-white shadow-md rounded-lg p-4 mb-6">
    <h3 class="text-xl font-semibold text-gray-700 mb-2">Add a New Pet Type</h3>
    <form action="{{ route('admin.pet-types.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="flex items-center gap-2">
            <input type="text" name="type" placeholder="Enter pet type (e.g., Dog, Cat)" 
                class="w-full p-2 border rounded" required>
            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
                Add
            </button>
        </div>
    </form>

    <!-- ✅ List of Existing Pet Types -->
    <h4 class="text-lg font-medium text-gray-700 mb-2">Existing Pet Types</h4>
    <div class="flex flex-wrap gap-2">
        @foreach ($petTypes as $type)
            <span class="bg-gray-300 text-gray-800 px-3 py-1 rounded">
                {{ ucfirst($type->name) }}
            </span>
        @endforeach
    </div>
</div>



    <!-- 🔍 Search Bar -->
    <div class="mb-4">
        <input type="text" id="searchBox" placeholder="Search by pet name, type, or owner..."
               class="w-full p-2 border rounded" onkeyup="searchPets()">
    </div>

    <!-- ✅ Pets Table -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
        <table class="w-full">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="p-3 text-left">Pet Name</th>
                    <th class="p-3 text-left">Type</th>
                    <th class="p-3 text-left">Breed</th>
                    <th class="p-3 text-left">Age</th>
                    <th class="p-3 text-left">Owner</th>
                    <th class="p-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pets as $pet)
                <tr class="border-b pet-row" data-id="{{ $pet->id }}">
                    <td class="p-3">{{ $pet->name }}</td>
                    <td class="p-3">{{ ucfirst($pet->type) }}</td>
                    <td class="p-3">{{ $pet->breed ?: 'N/A' }}</td>
                    <td class="p-3">{{ $pet->age ? $pet->age . ' years' : 'N/A' }}</td>
                    <td class="p-3">{{ $pet->customer->name }} ({{ $pet->customer->email }})</td>
                    <td class="p-3 flex justify-center gap-2">
                        <!-- ✅ Edit Button -->
                        <button class="edit-pet-btn bg-gray-500 hover:bg-gray-700 text-white px-3 py-1 rounded"
                                data-id="{{ $pet->id }}" data-name="{{ $pet->name }}"
                                data-type="{{ $pet->type }}" data-breed="{{ $pet->breed }}"
                                data-age="{{ $pet->age }}" data-gender="{{ $pet->gender }}">
                            Edit
                        </button>

                        <!-- ❌ Delete Button -->
                        <button class="delete-pet-btn bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded"
                                data-id="{{ $pet->id }}">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- ✅ Pagination -->
    <div class="mt-4">
        {{ $pets->links() }}
    </div>
</div>
<!-- 🐾 Pet Edit Modal -->
<div id="editPetModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 max-h-[90vh] overflow-y-auto">
        <h2 class="text-xl font-bold mb-4">Edit Pet Details</h2>

        <form id="editPetForm">
            @csrf
            @method('PUT')

            <input type="hidden" id="editPetId">

            <div class="space-y-4">
                <!-- 🐶 Pet Name -->
                <div>
                    <label class="text-gray-700 font-medium">Pet Name</label>
                    <input type="text" id="editPetName" class="w-full p-2 border rounded" required>
                </div>

                <!-- 🐕 Pet Type -->
                <div>
                    <label class="text-gray-700 font-medium">Pet Type</label>
                    <select id="editPetType" class="w-full p-2 border rounded" required>
                        @foreach ($petTypes as $type)
                            <option value="{{ $type->name }}">{{ ucfirst($type->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- 🦴 Breed -->
                <div>
                    <label class="text-gray-700 font-medium">Breed</label>
                    <input type="text" id="editPetBreed" class="w-full p-2 border rounded">
                </div>

                <!-- 🔢 Age -->
                <div>
                    <label class="text-gray-700 font-medium">Age (Years)</label>
                    <input type="number" id="editPetAge" class="w-full p-2 border rounded" min="0">
                </div>

                <!-- ♂️ Gender -->
                <div>
                    <label class="text-gray-700 font-medium">Gender</label>
                    <select id="editPetGender" class="w-full p-2 border rounded" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <!-- 👤 Owner Selection (Only Customers) -->
                <div>
                    <label class="text-gray-700 font-medium">Owner</label>
                    <select id="editPetOwner" class="w-full p-2 border rounded" required>
                        @foreach ($owners as $owner)
                            <option value="{{ $owner->id }}" {{ $owner->id == old('owner', $pet->customer_id) ? 'selected' : '' }}>
                                {{ $owner->name }} ({{ $owner->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- ✅ Save / Close Buttons -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
                    Save Changes
                </button>
                <button type="button" id="closeModal" class="bg-gray-600 hover:bg-gray-800 text-white px-4 py-2 rounded">
                    Close
                </button>
            </div>
        </form>
    </div>
</div>






<!-- ✅ CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".edit-pet-btn");
    const editPetModal = document.getElementById("editPetModal");
    const closeModal = document.getElementById("closeModal");
    const editPetForm = document.getElementById("editPetForm");

    // ✅ Open Edit Modal and Populate Fields
    editButtons.forEach(button => {
        button.addEventListener("click", function () {
            const petId = this.dataset.id;
            const petName = this.dataset.name;
            const petType = this.dataset.type;
            const petBreed = this.dataset.breed;
            const petAge = this.dataset.age;
            const petGender = this.dataset.gender;
            const petOwner = this.dataset.owner;

            document.getElementById("editPetId").value = petId;
            document.getElementById("editPetName").value = petName;
            document.getElementById("editPetType").value = petType;
            document.getElementById("editPetBreed").value = petBreed;
            document.getElementById("editPetAge").value = petAge;
            document.getElementById("editPetGender").value = petGender;
            document.getElementById("editPetOwner").value = petOwner;

            // ✅ Show modal (Only toggle `hidden` and `flex`)
            editPetModal.classList.remove("hidden");
            editPetModal.classList.add("flex");
        });
    });

    // ✅ Close Modal
    closeModal.addEventListener("click", function () {
        editPetModal.classList.remove("flex");
        editPetModal.classList.add("hidden");
    });

    // ✅ Close modal when clicking outside
    editPetModal.addEventListener("click", function (e) {
        if (e.target === editPetModal) {
            editPetModal.classList.remove("flex");
            editPetModal.classList.add("hidden");
        }
    });

    // ✅ Handle AJAX Edit Pet Form Submission
    editPetForm.addEventListener("submit", function (e) {
        e.preventDefault();
        
        let petId = document.getElementById("editPetId").value;
        let formData = new FormData(editPetForm);

        fetch(`/admin/pets/${petId}`, {
            method: "PUT",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json"
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Pet updated successfully.");
                editPetModal.classList.remove("flex"); 
                editPetModal.classList.add("hidden"); 
                location.reload(); // ✅ Refresh the page to reflect changes
            } else {
                alert(data.error || "Failed to update pet.");
            }
        })
        .catch(error => console.error("Error:", error));
    });





    // ✅ DELETE FUNCTION
    document.querySelectorAll(".delete-pet-btn").forEach(button => {
        button.addEventListener("click", function () {
            let petId = this.dataset.id;

            if (confirm("Are you sure you want to delete this pet?")) {
                fetch(`/admin/pets/${petId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Pet deleted successfully.");
                        document.querySelector(`tr[data-id="${petId}"]`).remove();
                    } else {
                        alert(data.error || "Failed to delete pet.");
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        });
    });

    // ✅ SEARCH FUNCTION
    document.getElementById("searchBox").addEventListener("keyup", function () {
        let input = this.value.toLowerCase();
        document.querySelectorAll(".pet-row").forEach(row => {
            let petName = row.children[0].textContent.toLowerCase();
            let petType = row.children[1].textContent.toLowerCase();
            let owner = row.children[4].textContent.toLowerCase();

            row.style.display = (petName.includes(input) || petType.includes(input) || owner.includes(input)) ? "" : "none";
        });
    });
});
</script>
@endsection
