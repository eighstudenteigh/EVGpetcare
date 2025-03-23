@extends('layouts.customer')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
    <h2 class="text-2xl sm:text-3xl font-bold text-gray-700 mb-6">My Pets</h2>

    <!-- ✅ Flash Message -->
    @if (session('success'))
        <div id="flashMessage" class="bg-orange-600 text-white text-center py-2 px-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- ✅ Add New Pet Button -->
    <div class="flex justify-end mb-4">
        <button onclick="openAddPetModal()" 
            class="px-5 py-2 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition">
            + Add New Pet
        </button>
    </div>

    <!-- ✅ Pet List -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-gray-700 text-white hidden sm:table-header-group">
                    <tr>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Type</th>
                        <th class="px-4 py-3 text-left">Breed</th>
                        <th class="px-4 py-3 text-left">Gender</th>
                        <th class="px-4 py-3 text-left">Age</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pets as $pet)
                    <!-- ✅ Clickable Row for Mobile Accordion -->
                    <tr class="border-b hover:bg-gray-100 sm:hidden">
                        <td class="px-4 py-3 font-semibold text-gray-800 cursor-pointer" onclick="togglePetDetails({{ $pet->id }})">
                            {{ $pet->name }}  
                            <span class="float-right text-orange-600">▼</span>
                        </td>
                    </tr>
                    <tr id="pet-details-{{ $pet->id }}" class="hidden sm:hidden transition-all duration-300 ease-in-out">
                        <td colspan="1" class="px-4 py-3 text-gray-700">
                            <div class="bg-gray-200 p-3 rounded-md">
                                <p><strong>Type:</strong> {{ ucfirst($pet->type) }}</p>
                                <p><strong>Breed:</strong> {{ $pet->breed ?: 'N/A' }}</p>
                                <p><strong>Gender:</strong> {{ ucfirst($pet->gender) }}</p>
                                <p><strong>Age:</strong> {{ $pet->age }} years</p>
                                <div class="mt-2 flex gap-2">
                                    <button onclick="openEditModal({{ $pet }})" 
                                        class="px-3 py-1 text-xs font-semibold text-white bg-orange-600 rounded-lg hover:bg-orange-700">
                                        Edit
                                    </button>
                                    <button onclick="deletePet({{ $pet->id }})" 
                                        class="px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- ✅ Desktop View -->
                    <tr class="border-b hover:bg-gray-100 hidden sm:table-row">
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $pet->name }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ ucfirst($pet->type) }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $pet->breed ?: 'N/A' }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ ucfirst($pet->gender) }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $pet->age }} years</td>
                        <td class="px-4 py-3 flex gap-2">
                            <button onclick="openEditModal({{ $pet }})" 
                                class="px-3 py-1 text-xs font-semibold text-white bg-orange-600 rounded-lg hover:bg-orange-700">
                                Edit
                            </button>
                            <button onclick="deletePet({{ $pet->id }})" 
                                class="px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No pets found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ✅ Add Pet Modal -->
<div id="addPetModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
        <h3 class="text-xl font-bold mb-4">Add New Pet</h3>
        <form action="{{ route('customer.pets.store') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Pet Name" required class="w-full p-2 border rounded mb-2">
            <input type="text" name="type" placeholder="Pet Type" required class="w-full p-2 border rounded mb-2">
            <input type="text" name="breed" placeholder="Breed (Optional)" class="w-full p-2 border rounded mb-2">
            <select name="gender" required class="w-full p-2 border rounded mb-2">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <input type="number" name="age" placeholder="Age" required class="w-full p-2 border rounded mb-2">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeAddPetModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ✅ Edit Pet Modal -->
<div id="editPetModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
        <h3 class="text-xl font-bold mb-4">Edit Pet</h3>
        <form id="editPetForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="pet_id" id="editPetId">
            <input type="text" name="name" id="editPetName" required class="w-full p-2 border rounded mb-2">
            <input type="text" name="type" id="editPetType" required class="w-full p-2 border rounded mb-2">
            <input type="text" name="breed" id="editPetBreed" class="w-full p-2 border rounded mb-2">
            <select name="gender" id="editPetGender" required class="w-full p-2 border rounded mb-2">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <input type="number" name="age" id="editPetAge" required class="w-full p-2 border rounded mb-2">
            
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    
        // ✅ Toggle Pet Details (Accordion for Mobile)
        function togglePetDetails(petId) {
            let detailsRow = document.getElementById(`pet-details-${petId}`);
            if (detailsRow) {
                detailsRow.classList.toggle("hidden");
            }
        }
    
        // ✅ Open Add Pet Modal
        function openAddPetModal() {
            let modal = document.getElementById("addPetModal");
            if (modal) {
                modal.classList.remove("hidden");
                modal.classList.add("flex");
            }
        }
    
        // ✅ Close Add Pet Modal
        function closeAddPetModal() {
            let modal = document.getElementById("addPetModal");
            if (modal) {
                modal.classList.remove("flex");
                modal.classList.add("hidden");
            }
        }
    
        // ✅ Open Edit Pet Modal
function openEditModal(pet) {
    let modal = document.getElementById("editPetModal");
    if (modal) {
        modal.classList.remove("hidden");  // Make the modal visible
        modal.classList.add("flex");       // Apply flex to center the modal

        // Populate the form fields
        document.getElementById("editPetId").value = pet.id;
        document.getElementById("editPetName").value = pet.name;
        document.getElementById("editPetType").value = pet.type;
        document.getElementById("editPetBreed").value = pet.breed || '';  // Ensure breed is either the value or empty
        document.getElementById("editPetGender").value = pet.gender;
        document.getElementById("editPetAge").value = pet.age;

        // Set the form's action URL dynamically
        document.getElementById("editPetForm").action = `/pets/${pet.id}/update`;
    }
}

// ✅ Close Edit Pet Modal
function closeEditModal() {
    let modal = document.getElementById("editPetModal");
    if (modal) {
        modal.classList.remove("flex");    
        modal.classList.add("hidden");     
    }
}
    
        // ✅ Delete Pet
        function deletePet(petId) {
            if (confirm("Are you sure you want to delete this pet?")) {
                fetch(`/pets/${petId}/delete`, {
                    method: "DELETE",
                    headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
                })
                .then(() => location.reload())
                .catch(err => console.error("Error deleting pet:", err));
            }
        }
    
        // ✅ Auto-hide Flash Message
        setTimeout(() => {
            let flashMessage = document.getElementById("flashMessage");
            if (flashMessage) {
                flashMessage.style.display = "none";
            }
        }, 3000);
    
        // ✅ Expose functions globally for inline onclick events
        window.togglePetDetails = togglePetDetails;
        window.openAddPetModal = openAddPetModal;
        window.closeAddPetModal = closeAddPetModal;
        window.openEditModal = openEditModal;
        window.closeEditModal = closeEditModal;
        window.deletePet = deletePet;
    });
    </script>
    
@endsection
    