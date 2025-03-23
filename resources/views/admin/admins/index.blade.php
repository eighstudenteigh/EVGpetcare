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
        <a href="{{ route('admins.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
            + Add New Admin
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
                        <!-- ✏️ Edit Button -->
                        <a href="#" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded">
                            Edit
                        </a>

                        <!-- ❌ Delete Button -->
                        <form action="#" method="POST" onsubmit="return confirm('Delete this admin?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                Delete
                            </button>
                        </form>
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

<!-- 🔍 Search Function -->
<script>
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
