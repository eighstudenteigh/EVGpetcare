{{-- resources/views/admin/records/partials/service-grooming.blade.php --}}
<div class="mt-4 pl-4 border-l-2 border-blue-200 bg-blue-50 rounded-lg p-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <p class="font-medium text-gray-700">Groomer Name:</p>
            <p class="text-gray-900">{{ $record->grooming->groomer_name ?? 'Not specified' }}</p>
        </div>
        
        <div>
            <p class="font-medium text-gray-700">Grooming Type:</p>
            <p class="text-gray-900">{{ $record->grooming->grooming_type ?? 'Not specified' }}</p>
        </div>
        
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Products Used:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->grooming->products_used ?? 'None listed' }}</p>
        </div>
        
        <div>
            <p class="font-medium text-gray-700">Coat Condition:</p>
            <p class="text-gray-900">{{ $record->grooming->coat_condition ?? 'Not specified' }}</p>
        </div>
        
        <div>
            <p class="font-medium text-gray-700">Skin Condition:</p>
            <p class="text-gray-900">{{ $record->grooming->skin_condition ?? 'Not specified' }}</p>
        </div>
        
        @if($record->grooming->behavior_notes)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Behavior Notes:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->grooming->behavior_notes }}</p>
        </div>
        @endif
        
        @if($record->grooming->special_instructions)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Special Instructions:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->grooming->special_instructions }}</p>
        </div>
        @endif
        
        @if($record->notes)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Additional Notes:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->notes }}</p>
        </div>
        @endif
    </div>

    <!-- Photo Display Section -->
    @if($record->before_photo_path || $record->after_photo_path)
    <div class="mt-6 border-t pt-4">
        <h4 class="font-medium text-gray-700 mb-3">Grooming Photos</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @if($record->before_photo_path)
            <div>
                <p class="font-medium text-sm text-gray-600 mb-1">Before Photos</p>
                <div class="flex flex-wrap gap-2">
                    @foreach(json_decode($record->before_photo_path) as $photo)
                    <div class="relative group">
                        <img src="{{ Storage::url('grooming/before/'.$photo) }}" 
                             class="h-24 w-24 object-cover rounded border border-gray-200">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition rounded">
                            <a href="{{ Storage::url('grooming/before/'.$photo) }}" 
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
            
            @if($record->after_photo_path)
            <div>
                <p class="font-medium text-sm text-gray-600 mb-1">After Photos</p>
                <div class="flex flex-wrap gap-2">
                    @foreach(json_decode($record->after_photo_path) as $photo)
                    <div class="relative group">
                        <img src="{{ Storage::url('grooming/after/'.$photo) }}" 
                             class="h-24 w-24 object-cover rounded border border-gray-200">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition rounded">
                            <a href="{{ Storage::url('grooming/after/'.$photo) }}" 
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
            <i class="fas fa-edit mr-1"></i> Edit Grooming Record
        </a>
    </div>
    @endunless
</div>