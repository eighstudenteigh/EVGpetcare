@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Add Boarding Record</h1>
        <div class="text-sm text-gray-600">
            <span class="font-medium">Appointment:</span> #{{ $appointment->id }}
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <div class="mb-4">
            <h2 class="text-lg font-semibold mb-2">Pet Information</h2>
            <p><span class="font-medium">Name:</span> {{ $pet->name }}</p>
            <p><span class="font-medium">Special Needs:</span> {{ $pet->special_needs ?? 'None' }}</p>
        </div>

        <form action="{{ route('admin.records.store.boarding', ['appointment' => $appointment->id, 'pet' => $pet->id, 'service' => $service->id]) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="kennel_number">Kennel Number</label>
                    <input type="text" name="kennel_number" id="kennel_number" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="check_in_time">Check-in Time</label>
                    <input type="time" name="check_in_time" id="check_in_time" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="check_out_time">Check-out Time</label>
                    <input type="time" name="check_out_time" id="check_out_time" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2" for="feeding_schedule">Feeding Schedule</label>
                    <textarea name="feeding_schedule" id="feeding_schedule" rows="2" class="w-full px-4 py-2 border rounded-lg" required></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2" for="medications_administered">Medications Administered</label>
                    <textarea name="medications_administered" id="medications_administered" rows="2" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2" for="activity_notes">Activity Notes</label>
                    <textarea name="activity_notes" id="activity_notes" rows="2" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2" for="behavior_notes">Behavior Notes</label>
                    <textarea name="behavior_notes" id="behavior_notes" rows="2" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2" for="special_instructions">Special Instructions</label>
                    <textarea name="special_instructions" id="special_instructions" rows="2" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2" for="notes">Additional Notes</label>
                    <textarea name="notes" id="notes" rows="2" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('admin.appointments.show-completed', $appointment) }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                    Save Boarding Record
                </button>
            </div>
        </form>
    </div>
</div>
@endsection