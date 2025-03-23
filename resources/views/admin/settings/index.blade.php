@extends('layouts.admin')

@section('content')
<div class="bg-white shadow-md rounded-md p-6">
    <h2 class="text-xl font-semibold text-orange-600 mb-4">Settings</h2>

    <!-- Max Appointments Per Day -->
    <form action="{{ route('admin.settings.maxAppointments') }}" method="POST" class="mb-4">
        @csrf
        <label for="maxAppointments" class="block text-gray-700 mb-2">Max Appointments Per Day:</label>
        <div class="flex items-center gap-2">
            <input type="number" id="maxAppointments" name="max_appointments_per_day"
                   value="{{ $maxAppointments }}" 
                   class="w-24 border border-gray-300 rounded-md p-2 focus:ring-orange-500 focus:border-orange-500" 
                   min="1" required>
            <button type="submit" 
                    class="bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-500">
                Update
            </button>
        </div>
    </form>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded-md">
            {{ session('success') }}
        </div>
    @endif
</div>
@endsection
