{{-- resources/views/admin/records/partials/service-boarding.blade.php --}}
<div class="mt-4 p-4 bg-blue-50 rounded-lg border-l-2 border-blue-200">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Left Column: Stay Details -->
        <div class="space-y-4">
            <h4 class="font-medium text-gray-800 border-b border-blue-100 pb-2">Stay Information</h4>
            
            <div class="flex flex-col">
                <span class="font-medium text-gray-700">Kennel Number:</span>
                <span>{{ $record->boarding->kennel_number ?? 'Not specified' }}</span>
            </div>
            
            <div class="flex flex-col">
                <span class="font-medium text-gray-700">Check-in Time:</span>
                <span>{{ $record->boarding->check_in_time ? \Carbon\Carbon::parse($record->boarding->check_in_time)->format('h:i A') : 'Not recorded' }}</span>
            </div>
            
            <div class="flex flex-col">
                <span class="font-medium text-gray-700">Check-out Time:</span>
                <span>{{ $record->boarding->check_out_time ? \Carbon\Carbon::parse($record->boarding->check_out_time)->format('h:i A') : 'Not recorded' }}</span>
            </div>
            
            <div class="flex flex-col">
                <span class="font-medium text-gray-700">Feeding Schedule:</span>
                <span class="whitespace-pre-line">{{ $record->boarding->feeding_schedule ?? 'No feeding schedule provided' }}</span>
            </div>
            
            @if($record->boarding->medications_administered)
            <div class="flex flex-col">
                <span class="font-medium text-gray-700">Medications:</span>
                <span class="whitespace-pre-line">{{ $record->boarding->medications_administered }}</span>
            </div>
            @endif
            
            @if($record->boarding->special_instructions)
            <div class="flex flex-col">
                <span class="font-medium text-gray-700">Special Instructions:</span>
                <span class="whitespace-pre-line">{{ $record->boarding->special_instructions }}</span>
            </div>
            @endif
        </div>
        
        <!-- Right Column: Pet Observations -->
        <div class="space-y-4">
            <h4 class="font-medium text-gray-800 border-b border-blue-100 pb-2">Pet Observations</h4>
            
            @if($record->boarding->activity_notes)
            <div class="flex flex-col">
                <span class="font-medium text-gray-700">Activity Notes:</span>
                <span class="whitespace-pre-line">{{ $record->boarding->activity_notes }}</span>
            </div>
            @endif
            
            @if($record->boarding->behavior_notes)
            <div class="flex flex-col">
                <span class="font-medium text-gray-700">Behavior Notes:</span>
                <span class="whitespace-pre-line">{{ $record->boarding->behavior_notes }}</span>
            </div>
            @endif
            
            @if($record->notes)
            <div class="flex flex-col">
                <span class="font-medium text-gray-700">Additional Notes:</span>
                <span class="whitespace-pre-line">{{ $record->notes }}</span>
            </div>
            @endif
            
            <!-- Photo Display Section -->
            @if($record->boarding->photos_path)
            <div class="mt-4">
                <span class="font-medium text-gray-700 block mb-2">Boarding Photos:</span>
                <div class="flex flex-wrap gap-2">
                    @foreach(json_decode($record->boarding->photos_path) as $photo)
                    <div class="relative group">
                        <img src="{{ Storage::url('boarding/'.$photo) }}" 
                             class="h-16 w-16 object-cover rounded border border-gray-200">
                        <a href="{{ Storage::url('boarding/'.$photo) }}" 
                           target="_blank"
                           class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-black bg-opacity-10 group-hover:bg-opacity-20 transition rounded">
                            <span class="bg-white p-1 rounded-full">
                                <i class="fas fa-expand text-gray-700 text-xs"></i>
                            </span>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Edit Button -->
    @unless($appointment->status === 'finalized')
    <div class="mt-4 flex justify-end border-t border-blue-100 pt-4">
        <a href="{{ route('admin.records.edit', [
            'appointment' => $appointment->id,
            'pet' => $pet->id,
            'service' => $service->id
        ]) }}" 
           class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
            <i class="fas fa-edit mr-1"></i> Edit Boarding Details
        </a>
    </div>
    @endunless
</div>