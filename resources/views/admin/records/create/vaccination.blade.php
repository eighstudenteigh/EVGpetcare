@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Add Vaccination Record</h1>
        <div class="text-sm text-gray-600">
            <span class="font-medium">Appointment:</span> #{{ $appointment->id }}
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <div class="mb-4">
            <h2 class="text-lg font-semibold mb-2">Pet Information</h2>
            <p><span class="font-medium">Name:</span> {{ $pet->name }}</p>
            <p><span class="font-medium">Type:</span> {{ ucfirst($pet->type) }}</p>
        </div>

        <form action="{{ route('admin.records.store.vaccination', ['appointment' => $appointment->id, 'pet' => $pet->id, 'service' => $service->id]) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="vaccine_type">Vaccine Type</label>
                    <input type="text" name="vaccine_type" id="vaccine_type" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="batch_number">Batch Number</label>
                    <input type="text" name="batch_number" id="batch_number" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="administered_by">Administered By</label>
                    <input type="text" name="administered_by" id="administered_by" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="next_due_date">Next Due Date</label>
                    <input type="date" name="next_due_date" id="next_due_date" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2" for="notes">Notes</label>
                    <textarea name="notes" id="notes" rows="3" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('admin.appointments.show-completed', $appointment) }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                    Save Vaccination Record
                </button>
            </div>
        </form>
    </div>
</div>
@endsection