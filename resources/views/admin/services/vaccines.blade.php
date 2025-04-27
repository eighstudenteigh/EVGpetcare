@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-6">Manage Vaccines for: {{ $service->name }}</h2>

    <form action="{{ route('admin.services.vaccines.update', $service) }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($vaccineTypes as $vaccine)
            <label class="flex items-center space-x-2 p-3 border rounded-lg hover:bg-gray-50">
                <input type="checkbox" name="vaccine_types[]" value="{{ $vaccine->id }}"
                       @if(in_array($vaccine->id, $attachedVaccines)) checked @endif
                       class="h-5 w-5 text-blue-600">
                <span>{{ $vaccine->name }}</span>
            </label>
            @endforeach
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                Save Vaccine Assignments
            </button>
            <a href="{{ route('admin.services.edit', $service) }}" 
               class="ml-2 bg-gray-300 text-gray-800 px-4 py-2 rounded">
                Back to Service
            </a>
        </div>
    </form>
</div>
@endsection