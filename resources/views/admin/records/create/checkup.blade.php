@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Add Checkup Record</h1>
        <div class="text-sm text-gray-600">
            <span class="font-medium">Appointment:</span> #{{ $appointment->id }}
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <div class="mb-4">
            <h2 class="text-lg font-semibold mb-2">Pet Information</h2>
            <p><span class="font-medium">Name:</span> {{ $pet->name }}</p>
            <p><span class="font-medium">Age:</span> {{ $pet->age }} years</p>
        </div>

        <form action="{{ route('admin.records.store.checkup', ['appointment' => $appointment->id, 'pet' => $pet->id, 'service' => $service->id]) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="weight">Weight (kg)</label>
                    <input type="number" step="0.01" name="weight" id="weight" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="temperature">Temperature (°C)</label>
                    <input type="number" step="0.1" name="temperature" id="temperature" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="heart_rate">Heart Rate (bpm)</label>
                    <input type="number" name="heart_rate" id="heart_rate" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="respiratory_rate">Respiratory Rate</label>
                    <input type="number" name="respiratory_rate" id="respiratory_rate" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2" for="diagnosis">Diagnosis</label>
                    <textarea name="diagnosis" id="diagnosis" rows="2" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2" for="treatment_plan">Treatment Plan</label>
                    <textarea name="treatment_plan" id="treatment_plan" rows="3" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2" for="notes">Notes</label>
                    <textarea name="notes" id="notes" rows="2" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('admin.appointments.show-completed', $appointment) }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                    Save Checkup Record
                </button>
            </div>
        </form>
    </div>
</div>
@endsection