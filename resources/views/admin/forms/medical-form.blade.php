@extends('layouts.admin')

@section('title', 'Medical Service Record')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Medical Record</h2>

    <form action="{{ route('admin.pet-records.store-medical', ['appointment' => $appointment->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="pet_id" value="{{ $pet->id }}">

        <div class="bg-white p-6 rounded-lg shadow border border-gray-200 mb-6">
            <h4 class="text-xl font-semibold text-orange-600 mb-4">Medical Details</h4>

            <label class="block mb-2 text-gray-700 font-medium">Pet Name</label>
            <input type="text" name="pet_name" class="w-full border rounded px-4 py-2 mb-4" required>

            <label class="block mb-2 text-gray-700 font-medium">Diagnosis</label>
            <input type="text" name="diagnosis" class="w-full border rounded px-4 py-2 mb-4" required>

            <label class="block mb-2 text-gray-700 font-medium">Treatment</label>
            <textarea name="treatment" rows="4" class="w-full border rounded px-4 py-2 mb-4"></textarea>
        </div>

        <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700">Submit</button>
    </form>
</div>
@endsection
