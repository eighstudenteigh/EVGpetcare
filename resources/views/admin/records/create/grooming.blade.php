@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Add Grooming Record</h1>
        <div class="text-sm text-gray-600">
            <span class="font-medium">Appointment:</span> #{{ $appointment->id }}
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <div class="mb-4">
            <h2 class="text-lg font-semibold mb-2">Pet Information</h2>
            <p><span class="font-medium">Name:</span> {{ $pet->name }}</p>
            <p><span class="font-medium">Coat Type:</span> {{ $pet->coat_type ?? 'Not specified' }}</p>
        </div>

        <form action="{{ route('admin.records.store.grooming', ['appointment' => $appointment->id, 'pet' => $pet->id, 'service' => $service->id]) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="groomer_name">Groomer Name</label>
                    <input type="text" name="groomer_name" id="groomer_name" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="grooming_type">Grooming Type</label>
                    <select name="grooming_type" id="grooming_type" class="w-full px-4 py-2 border rounded-lg" required>
                        <option value="Full Groom">Full Groom</option>
                        <option value="Bath & Brush">Bath & Brush</option>
                        <option value="Haircut">Haircut</option>
                        <option value="Nail Trim">Nail Trim</option>
                        <option value="Teeth Cleaning">Teeth Cleaning</option>
                    </select>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2" for="products_used">Products Used</label>
                    <textarea name="products_used" id="products_used" rows="2" class="w-full px-4 py-2 border rounded-lg" required></textarea>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="coat_condition">Coat Condition</label>
                    <select name="coat_condition" id="coat_condition" class="w-full px-4 py-2 border rounded-lg" required>
                        <option value="Excellent">Excellent</option>
                        <option value="Good">Good</option>
                        <option value="Fair">Fair</option>
                        <option value="Poor">Poor</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2" for="skin_condition">Skin Condition</label>
                    <select name="skin_condition" id="skin_condition" class="w-full px-4 py-2 border rounded-lg" required>
                        <option value="Healthy">Healthy</option>
                        <option value="Dry">Dry</option>
                        <option value="Irritated">Irritated</option>
                        <option value="Other">Other</option>
                    </select>
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
                    Save Grooming Record
                </button>
            </div>
        </form>
    </div>
</div>
@endsection