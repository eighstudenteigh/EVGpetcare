@extends('layouts.admin')

@section('title', 'Manage Services')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold">Manage Services</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mt-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add New Service Button -->
    <a href="{{ route('admin.services.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded inline-block mt-4">
        + Add Service
    </a>

    <!-- Services Table -->
    <table class="w-full mt-4 border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Name</th>
                <th class="border p-2">Animal Type</th>
                <th class="border p-2">Price</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
                <tr>
                    <td class="border p-2">{{ $service->name }}</td>
                    <td class="border p-2">{{ ucfirst($service->animal_type) }}</td>
                    <td class="border p-2">${{ $service->price }}</td>
                    <td class="border p-2">
                        <a href="{{ route('admin.services.edit', $service) }}" class="text-blue-600">Edit</a> |
                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600" onclick="return confirm('Delete this service?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $services->links() }}
    </div>
</div>
@endsection
