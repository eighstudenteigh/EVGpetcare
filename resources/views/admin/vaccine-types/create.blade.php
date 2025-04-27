@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8 max-w-xl">
    <h1 class="text-2xl font-bold mb-6">Create Vaccine Type</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.vaccine-types.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                class="w-full mt-1 p-2 border rounded shadow-sm focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label for="description" class="block text-sm font-medium">Description (optional)</label>
            <textarea name="description" id="description" rows="4"
                class="w-full mt-1 p-2 border rounded shadow-sm focus:ring focus:ring-blue-200">{{ old('description') }}</textarea>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.vaccine-types.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded mr-2">Cancel</a>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Create</button>
        </div>
    </form>
</div>
@endsection
