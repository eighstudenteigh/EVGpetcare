@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Add Surgery Record</h1>
        <div class="text-sm text-gray-600">
            <span class="font-medium">Appointment:</span> #{{ $appointment->id }}
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <div class="mb-4">
            <h2 class="text-lg font-semibold mb-2">Patient Information</h2>
            <p><span class="font-medium">Name:</span> {{ $pet->name }}</p>
            <p><span class="font-medium">Breed:</span> {{ $pet->breed }}</p>
        </div>

        <form action="{{ route('admin.records.store.surgery', ['appointment' => $appointment->id, 'pet' => $pet->id, 'service' => $service->id]) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="procedure_name">Procedure Name</label>
                    <input type="text" name="procedure_name" id="procedure_name" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="anesthesia_type">Anesthesia Type</label>
                    <select name="anesthesia_type" id="anesthesia_type" class="w-full px-4 py-2 border rounded-lg" required>
                        <option value="General">General</option>
                        <option value="Local">Local</option>
                        <option value="Sedation">Sedation</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="surgeon_name">Surgeon Name</label>
                    <input type="text" name="surgeon_name" id="surgeon_name" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="start_time">Start Time</label>
                    <input type="time" name="start_time" id="start_time" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="end_time">End Time</label>
                    <input type="time" name="end_time" id="end_time" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2" for="complications">Complications</label>
                    <textarea name="complications" id="complications" rows="2" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2" for="post_op_instructions">Post-Op Instructions</label>
                    <textarea name="post_op_instructions" id="post_op_instructions" rows="3" class="w-full px-4 py-2 border rounded-lg" required></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2" for="medications">Medications</label>
                    <textarea name="medications" id="medications" rows="2" class="w-full px-4 py-2 border rounded-lg"></textarea>
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
                    Save Surgery Record
                </button>
            </div>
        </form>
    </div>
</div>
@endsection