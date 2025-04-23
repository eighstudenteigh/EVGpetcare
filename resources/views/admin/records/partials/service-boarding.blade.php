{{-- resources/views/admin/records/partials/service-boarding.blade.php --}}
<div class="mt-4 pl-4 border-l-2 border-blue-200 bg-blue-50 rounded-lg p-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <p class="font-medium text-gray-700">Kennel Number:</p>
            <p class="text-gray-900">{{ $record->boarding->kennel_number ?? 'Not specified' }}</p>
        </div>
        
        <div>
            <p class="font-medium text-gray-700">Check-in Time:</p>
            <p class="text-gray-900">{{ $record->boarding->check_in_time ? \Carbon\Carbon::parse($record->boarding->check_in_time)->format('h:i A') : 'Not recorded' }}</p>
        </div>
        
        <div>
            <p class="font-medium text-gray-700">Check-out Time:</p>
            <p class="text-gray-900">{{ $record->boarding->check_out_time ? \Carbon\Carbon::parse($record->boarding->check_out_time)->format('h:i A') : 'Not recorded' }}</p>
        </div>
        
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Feeding Schedule:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->boarding->feeding_schedule ?? 'No feeding schedule provided' }}</p>
        </div>
        
        @if($record->boarding->medications_administered)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Medications Administered:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->boarding->medications_administered }}</p>
        </div>
        @endif
        
        @if($record->boarding->activity_notes)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Activity Notes:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->boarding->activity_notes }}</p>
        </div>
        @endif
        
        @if($record->boarding->behavior_notes)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Behavior Notes:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->boarding->behavior_notes }}</p>
        </div>
        @endif
        
        @if($record->boarding->special_instructions)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Special Instructions:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->boarding->special_instructions }}</p>
        </div>
        @endif
        
        @if($record->notes)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Additional Notes:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->notes }}</p>
        </div>
        @endif
    </div>

    <!-- Photo Display Section (if applicable) -->
    @if($record->boarding->photos_path)
    <div class="mt-6 border-t pt-4">
        <h4 class="font-medium text-gray-700 mb-3">Boarding Photos</h4>
        <div class="flex flex-wrap gap-4">
            @foreach(json_decode($record->boarding->photos_path) as $photo)
            <div class="relative group">
                <img src="{{ Storage::url('boarding/'.$photo) }}" 
                     class="h-24 w-24 object-cover rounded border border-gray-200">
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition rounded">
                    <a href="{{ Storage::url('boarding/'.$photo) }}" 
                       target="_blank"
                       class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                        <span class="bg-white bg-opacity-80 p-1 rounded-full">
                            <i class="fas fa-expand text-gray-800"></i>
                        </span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Edit Button (if not finalized) -->
    @unless($appointment->status === 'finalized')
    <div class="mt-6 flex justify-end">
        <a href="{{ route('admin.records.edit', [
            'appointment' => $appointment->id,
            'pet' => $pet->id,
            'service' => $service->id
        ]) }}" 
           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
            <i class="fas fa-edit mr-1"></i> Edit Boarding Record
        </a>
    </div>
    @endunless
</div>