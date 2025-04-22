@extends('layouts.admin')

@section('title', 'Manage Admins')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Manage Admins</h2>

    <!-- ✅ Success Message -->
    @if(session('success'))
        <p class="text-green-600 bg-green-100 p-3 rounded-md">{{ session('success') }}</p>
    @endif

    <!-- 🔍 Search & Add Admin -->
    <div class="flex justify-between items-center mb-4">
        <input type="text" id="searchBox" placeholder="Search admin..." class="w-96 p-2 border rounded">
        <a href="{{ route('admins.create') }}" class="px-6 bg-orange-500 text-white font-bold py-2 rounded hover:bg-gray-600 transition-colors">
             Add New Admin
        </a>
    </div>

    <!-- 📋 Admins Table -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
        <table class="w-full">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody id="adminTable">
                @foreach($admins as $admin)
                <tr class="border-b hover:bg-gray-100 admin-row">
                    <td class="p-3">{{ $admin->name }}</td>
                    <td class="p-3">{{ $admin->email }}</td>
                    <td class="p-3 flex gap-2">
                        <!--  Delete Button -->
                        <button data-id="{{ $admin->id }}" class="delete-admin-btn bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
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
        {{ $admins->links() }}
    </div>
</div>

<script>
    document.querySelectorAll(".delete-admin-btn").forEach(button => {
        button.addEventListener("click", function () {
            const adminId = this.dataset.id;
            const confirmed = confirm("Are you sure you want to delete this admin?");
            
            if (confirmed) {
                fetch(`/admin/${adminId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        // Remove the deleted admin row from the DOM
                        this.closest("tr").remove();
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        });
    });

    // 🔍 Search Function
    document.getElementById("searchBox").addEventListener("keyup", function () {
        let query = this.value.toLowerCase();
        document.querySelectorAll(".admin-row").forEach(row => {
            let name = row.children[0].textContent.toLowerCase();
            let email = row.children[1].textContent.toLowerCase();
            row.style.display = name.includes(query) || email.includes(query) ? "" : "none";
        });
    });
</script>

@endsection
