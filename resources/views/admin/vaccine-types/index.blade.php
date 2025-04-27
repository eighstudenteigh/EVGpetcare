@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Vaccine Types</h2>
        <a href="{{ route('admin.vaccine-types.create') }}" 
           class="bg-blue-500 text-white px-4 py-2 rounded">
            + New Vaccine Type
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Description</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vaccineTypes as $vaccine)
                <tr class="border-t">
                    <td class="px-6 py-4">{{ $vaccine->name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $vaccine->description ?? 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.vaccine-types.edit', $vaccine) }}" 
                           class="text-blue-500 hover:text-blue-700 mr-3">Edit</a>
                        <!-- Delete form -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection