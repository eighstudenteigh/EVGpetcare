@extends('layouts.admin')

@section('title', 'Manage Customers')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">👤 Manage Customers</h2>

    <!-- ✅ Success Message -->
    @if(session('success'))
        <p class="text-green-600 bg-green-100 p-3 rounded-md">{{ session('success') }}</p>
    @endif

    <!-- 🔍 Search & Add Customer -->
    <div class="flex justify-between items-center mb-4">
        <div class="relative w-96">
            <input type="text" id="searchBox" placeholder="Search customers..." 
                class="w-full p-2 pl-10 border rounded focus:ring-2 focus:ring-orange-500 focus:outline-none">
            <svg class="absolute left-3 top-2.5 text-gray-500 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.2-5.2M15.5 10.5a5 5 0 11-10 0 5 5 0 0110 0z"/>
            </svg>
        </div>
        <a href="{{ route('admin.customers.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
            + Add Customer
        </a>
    </div>

    <!-- 📋 Customers Table -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
        <table class="w-full">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Phone</th>
                    <th class="p-3 text-left">Address</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr class="border-b hover:bg-gray-100 customer-row" data-id="{{ $customer->id }}">
                    <td class="p-3">{{ $customer->name }}</td>
                    <td class="p-3">{{ $customer->email }}</td>
                    <td class="p-3">{{ $customer->phone ?? 'N/A' }}</td>
                    <td class="p-3">{{ $customer->address ?? 'N/A' }}</td>
                    <td class="p-3 flex gap-2">
                        <!-- ✏️ Edit Button -->
                        <button class="edit-customer-btn bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded"
                            data-id="{{ $customer->id }}"
                            data-name="{{ $customer->name }}"
                            data-email="{{ $customer->email }}"
                            data-phone="{{ $customer->phone }}"
                            data-address="{{ $customer->address }}">
                            Edit
                        </button>

                        <!-- ❌ Delete Button -->
                        <button class="delete-customer-btn bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded"
                            data-id="{{ $customer->id }}">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- 🔄 Pagination -->
    <div class="mt-4">
        {{ $customers->links() }}
    </div>
</div>

<!-- 🛠 Edit Customer Modal -->
<div id="editCustomerModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">Edit Customer</h2>

        <form id="editCustomerForm">
            @csrf
            @method('PUT')

            <input type="hidden" id="editCustomerId">

            <div class="mb-4">
                <label class="text-gray-700 font-medium">Full Name</label>
                <input type="text" id="editCustomerName" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="text-gray-700 font-medium">Email</label>
                <input type="email" id="editCustomerEmail" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="text-gray-700 font-medium">Phone</label>
                <input type="text" id="editCustomerPhone" class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label class="text-gray-700 font-medium">Address</label>
                <textarea id="editCustomerAddress" class="w-full p-2 border rounded"></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
                    Save Changes
                </button>
                <button type="button" id="closeEditModal" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    Close
                </button>
            </div>
        </form>
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- ✅ AJAX SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".edit-customer-btn");
    const editCustomerModal = document.getElementById("editCustomerModal");
    const closeEditModal = document.getElementById("closeEditModal");
    const editCustomerForm = document.getElementById("editCustomerForm");

    
    // ✅ Open Edit Modal & Populate Fields
    editButtons.forEach(button => {
        button.addEventListener("click", function () {
            document.getElementById("editCustomerId").value = this.dataset.id;
            document.getElementById("editCustomerName").value = this.dataset.name;
            document.getElementById("editCustomerEmail").value = this.dataset.email;
            document.getElementById("editCustomerPhone").value = this.dataset.phone || "";
            document.getElementById("editCustomerAddress").value = this.dataset.address || "";

            editCustomerModal.classList.remove("hidden");
            editCustomerModal.classList.add("flex");
        });
    });

    // ✅ Close Modal
    closeEditModal.addEventListener("click", function () {
        editCustomerModal.classList.remove("flex");
        editCustomerModal.classList.add("hidden");
    });

    // ✅ AJAX Update Customer
    editCustomerForm.addEventListener("submit", function (e) {
        e.preventDefault();

        let customerId = document.getElementById("editCustomerId").value;
        let formData = new FormData(editCustomerForm);

        fetch(`/admin/customers/${customerId}`, {
    method: "PUT",  // ✅ Change from POST to PUT
    headers: {
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        "Content-Type": "application/json",
        "Accept": "application/json"
    },
    body: JSON.stringify({
        name: document.getElementById("editCustomerName").value,
        email: document.getElementById("editCustomerEmail").value,
        phone: document.getElementById("editCustomerPhone").value,
        address: document.getElementById("editCustomerAddress").value
    })
    }).then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Customer updated successfully.");
                location.reload();
            } else {
                alert("Failed to update customer.");
            }
        })
        .catch(error => console.error("Error:", error));
    });

    // ✅ Live Search
    document.getElementById("searchBox").addEventListener("keyup", function () {
        let input = this.value.toLowerCase();
        document.querySelectorAll(".customer-row").forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(input) ? "" : "none";
        });
    });
    // ✅ Delete Customer
const deleteButtons = document.querySelectorAll(".delete-customer-btn");

deleteButtons.forEach(button => {
    button.addEventListener("click", function () {
        const customerId = this.dataset.id;
        const confirmed = confirm("Are you sure you want to delete this customer?");
        
        if (confirmed) {
            fetch(`/admin/customers/${customerId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json"
                }
            })
            .then(response => {
                if (!response.ok) throw new Error("Failed to delete customer.");
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert("Customer deleted successfully.");
                    location.reload();
                } else {
                    alert("Failed to delete customer.");
                }
            })
            .catch(error => console.error("Error:", error));
        }
    });
});


});
</script>
@endsection
