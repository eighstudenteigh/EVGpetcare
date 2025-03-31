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
            <button 
                type="button" 
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-3 py-1 rounded flex items-center gap-1"
                onclick="openEditPetTypeModal({{ $type->id }}, '{{ $type->name }}')"
            >
                {{ ucfirst($type->name) }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
            </button>
        @endforeach
    </div>
</div>
<!-- Edit Pet Type Modal -->
<div id="editPetTypeModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-700">Edit Pet Type</h3>
            <button type="button" class="text-gray-500 hover:text-gray-800" onclick="closeEditPetTypeModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <form id="editPetTypeForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="petTypeId" name="id">
            
            <div class="mb-4">
                <label for="petTypeName" class="block text-gray-700 mb-2">Pet Type Name</label>
                <input type="text" id="petTypeName" name="name" class="w-full p-2 border rounded" required>
            </div>
            
            <div class="flex gap-2 justify-end">
                <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded" onclick="closeEditPetTypeModal()">
                    Cancel
                </button>
                <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
                    Save Changes
                </button>
            </div>
        </form>
        
        <div class="mt-4 pt-4 border-t">
            <button id="deletePetTypeBtn" type="button" class="text-red-600 hover:text-red-800 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete Pet Type
            </button>
        </div>
    </div>
</div>

    <!-- 🔍 Search Bar -->
    <div class="mb-4">
        <input type="text" id="searchBox" placeholder="Search by pet name, type, or owner..."
               class="w-full p-2 border rounded">
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
                <tr class="border-b pet-row" data-id="{{ $pet->id }}" data-owner-id="{{ $pet->customer_id }}">
                    <td class="p-3">{{ $pet->name }}</td>
                    <td class="p-3">{{ ucfirst($pet->type) }}</td>
                    <td class="p-3">{{ $pet->breed ?: 'N/A' }}</td>
                    <td class="p-3">{{ $pet->age ? $pet->age . ' years' : 'N/A' }}</td>
                    <td class="p-3">{{ $pet->customer->name }} ({{ $pet->customer->email }})</td>
                    <td class="p-3 flex justify-center gap-2">
                        <!-- ✅ Edit Button - added data-gender attribute -->
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
<div id="editPetModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 max-h-[80vh] overflow-y-auto">

        <h2 class="text-xl font-bold mb-4">Edit Pet Details</h2>

        <form id="editPetForm">
            @csrf
            @method('PUT')

            <input type="hidden" id="editPetId">
            <input type="hidden" id="editPetOwner">

            <div class="space-y-4">
                <!-- 🐶 Pet Name -->
                <div>
                    <label class="text-gray-700 font-medium">Pet Name</label>
                    <input type="text" id="editPetName" name="name" class="w-full p-2 border rounded" required>
                </div>

                <!-- 🐕 Pet Type -->
                <div>
                    <label class="text-gray-700 font-medium">Pet Type</label>
                    <select id="editPetType" name="type" class="w-full p-2 border rounded" required>
                        @foreach ($petTypes as $type)
                            <option value="{{ $type->name }}">{{ ucfirst($type->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- 🦴 Breed -->
                <div>
                    <label class="text-gray-700 font-medium">Breed</label>
                    <input type="text" id="editPetBreed" name="breed" class="w-full p-2 border rounded">
                </div>

                <!-- 🔢 Age -->
                <div>
                    <label class="text-gray-700 font-medium">Age (Years)</label>
                    <input type="number" id="editPetAge" name="age" class="w-full p-2 border rounded" min="0">
                </div>

                <!-- ♂️ Gender -->
                <div>
                    <label class="text-gray-700 font-medium">Gender</label>
                    <select id="editPetGender" name="gender" class="w-full p-2 border rounded" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <!-- 👤 Owner Information (Read Only) -->
                <div>
                    <label class="text-gray-700 font-medium">Owner</label>
                    <div id="ownerDisplay" class="w-full p-2 border rounded bg-gray-100 text-gray-700"></div>
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
// Function to close the edit pet type modal
function closeEditPetTypeModal() {
    const editPetTypeModal = document.getElementById('editPetTypeModal');
    if(!editPetTypeModal) return;
    
    editPetTypeModal.classList.remove('flex');
    editPetTypeModal.classList.add('hidden');
}

// Function to open the edit pet type modal
function openEditPetTypeModal(id, name) {
    const editPetTypeModal = document.getElementById('editPetTypeModal');
    if(!editPetTypeModal) return;
    
    document.getElementById('petTypeId').value = id;
    document.getElementById('petTypeName').value = name;
    
    // Show modal
    editPetTypeModal.classList.remove('hidden');
    editPetTypeModal.classList.add('flex');
}

document.addEventListener("DOMContentLoaded", function () {
    // Existing code for pet editing/management
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
            const petBreed = this.dataset.breed || '';
            const petAge = this.dataset.age || '';
            const petGender = this.dataset.gender;
            
            // Get owner info from the table row
            const petRow = this.closest('tr');
            const ownerInfo = petRow.querySelector('td:nth-child(5)').textContent;
            const ownerId = this.closest('tr').dataset.ownerId;

            document.getElementById("editPetId").value = petId;
            document.getElementById("editPetName").value = petName;
            document.getElementById("editPetType").value = petType;
            document.getElementById("editPetBreed").value = petBreed;
            document.getElementById("editPetAge").value = petAge;
            document.getElementById("editPetGender").value = petGender;
            document.getElementById("editPetOwner").value = ownerId;
            document.getElementById("ownerDisplay").textContent = ownerInfo;

            // ✅ Show modal (Only toggle `hidden` and `flex`)
            editPetModal.classList.remove("hidden");
            editPetModal.classList.add("flex");
        });
    });

    // ✅ Close Modal
    if(closeModal) {
        closeModal.addEventListener("click", function () {
            editPetModal.classList.remove("flex");
            editPetModal.classList.add("hidden");
        });
    }

    // ✅ Close modal when clicking outside
    if(editPetModal) {
        editPetModal.addEventListener("click", function (e) {
            if (e.target === editPetModal) {
                editPetModal.classList.remove("flex");
                editPetModal.classList.add("hidden");
            }
        });
    }

    // ✅ Handle AJAX Edit Pet Form Submission
    if(editPetForm) {
        editPetForm.addEventListener("submit", function (e) {
            e.preventDefault();
            
            const petId = document.getElementById("editPetId").value;
            const ownerId = document.getElementById("editPetOwner").value;
            
            // Create form data object
            const formData = new FormData();
            formData.append('name', document.getElementById("editPetName").value);
            formData.append('type', document.getElementById("editPetType").value);
            formData.append('breed', document.getElementById("editPetBreed").value);
            formData.append('age', document.getElementById("editPetAge").value);
            formData.append('gender', document.getElementById("editPetGender").value);
            formData.append('customer_id', ownerId);
            formData.append('_method', 'PUT');
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            fetch(`/admin/pets/${petId}`, {
                method: "POST", // Use POST with _method=PUT for Laravel
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
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred while updating the pet.");
            });
        });
    }

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
    const searchBox = document.getElementById("searchBox");
    if(searchBox) {
        searchBox.addEventListener("keyup", function () {
            let input = this.value.toLowerCase();
            document.querySelectorAll(".pet-row").forEach(row => {
                let petName = row.children[0].textContent.toLowerCase();
                let petType = row.children[1].textContent.toLowerCase();
                let owner = row.children[4].textContent.toLowerCase();

                row.style.display = (petName.includes(input) || petType.includes(input) || owner.includes(input)) ? "" : "none";
            });
        });
    }

    // ✅✅✅ NEW CODE FOR PET TYPE MODAL ✅✅✅
    const editPetTypeModal = document.getElementById("editPetTypeModal");
    const editPetTypeForm = document.getElementById("editPetTypeForm");
    
    // Handle AJAX Edit Pet Type Form Submission
    if(editPetTypeForm) {
        editPetTypeForm.addEventListener("submit", function(e) {
            e.preventDefault();
            
            const petTypeId = document.getElementById("petTypeId").value;
            
            // Create form data object
            const formData = new FormData();
            formData.append('name', document.getElementById("petTypeName").value);
            formData.append('_method', 'PUT');
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            
            fetch(`/admin/pet-types/${petTypeId}`, {
                method: "POST", // Use POST with _method=PUT for Laravel
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Pet type updated successfully.");
                    closeEditPetTypeModal();
                    location.reload(); // Refresh the page to reflect changes
                } else {
                    alert(data.error || "Failed to update pet type.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred while updating the pet type.");
            });
        });
    }
    
    // Delete Pet Type button handler
    const deletePetTypeBtn = document.getElementById("deletePetTypeBtn");
    if(deletePetTypeBtn) {
        deletePetTypeBtn.addEventListener("click", function() {
            const petTypeId = document.getElementById("petTypeId").value;
            
            if (confirm("Are you sure you want to delete this pet type? This may affect existing services.")) {
                fetch(`/admin/pet-types/${petTypeId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Pet type deleted successfully.");
                        location.reload(); // Refresh the page to reflect changes
                    } else {
                        alert(data.error || "Failed to delete pet type: " + (data.error || "Unknown error"));
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred while deleting the pet type.");
                });
            }
        });
    }
});
</script>
@endsection