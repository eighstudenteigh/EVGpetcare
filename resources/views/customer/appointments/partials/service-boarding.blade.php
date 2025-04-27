{{-- resources/views/customer/appointments/partials/service-boarding.blade.php --}}
<div class="mt-4 p-4 bg-blue-50 rounded-lg border-l-2 border-blue-200">
    <h4 class="font-semibold text-lg mb-4 text-blue-800">Boarding Details</h4>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Left Column: Stay Details -->
        <div class="space-y-4">
            <h4 class="font-medium text-gray-800 border-b border-blue-100 pb-2">Stay Information</h4>
            
            <div class="flex flex-col">
                <span class="font-medium text-gray-700">Kennel Number:</span>
                <span>{{ $record->boarding->kennel_number ?? 'Not specified' }}</span>
            </div>
            
            <div class="flex flex-col">
                <span class="font-medium text-gray-700">Check-in Date:</span>
                <span>{{ $appointment->appointment_date->format('M j, Y') }}</span>
            </div>
            
            <div class="flex flex-col">
                <span class="font-medium text-gray-700">Check-in Time:</span>
                <span>
                    @if($record->boarding->check_in_time)
                        {{ \Carbon\Carbon::parse($record->boarding->check_in_time)->format('h:i A') }}
                    @else
                        Not recorded
                    @endif
                </span>
            </div>
            
            <div class="flex flex-col">
                <span class="font-medium text-gray-700">Check-out Time:</span>
                <span>
                    @if($record->boarding->check_out_time)
                        {{ \Carbon\Carbon::parse($record->boarding->check_out_time)->format('h:i A') }}
                    @else
                        Not recorded
                    @endif
                </span>
            </div>
            
            <div class="flex flex-col">
                <span class="font-medium text-gray-700">Feeding Schedule:</span>
                <span class="whitespace-pre-line">{{ $record->boarding->feeding_schedule ?? 'Standard feeding schedule was followed' }}</span>
            </div>
            
            @if($record->boarding->medications_administered)
            <div class="flex flex-col">
                <span class="font-medium text-gray-700">Medications Administered:</span>
                <span class="whitespace-pre-line">{{ $record->boarding->medications_administered }}</span>
            </div>
            @endif
            
            @if($record->boarding->special_instructions)
            <div class="flex flex-col">
                <span class="font-medium text-gray-700">Special Instructions Followed:</span>
                <span class="whitespace-pre-line">{{ $record->boarding->special_instructions }}</span>
            </div>
            @endif
        </div>
        
        <!-- Right Column: Pet Observations -->
        <div class="space-y-4">
            <h4 class="font-medium text-gray-800 border-b border-blue-100 pb-2">Pet Observations</h4>
            
            @if($record->boarding->activity_notes)
            <div class="flex flex-col">
                <span class="font-medium text-gray-700">Daily Activities:</span>
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
        </div>
    </div>

    <!-- Photo Gallery for Customer -->
    @if($record->boarding->photos_path)
    <div class="mt-6 border-t border-blue-100 pt-4">
        <h4 class="font-medium text-gray-700 mb-3">Your Pet's Stay</h4>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach(json_decode($record->boarding->photos_path) as $photo)
            <div class="relative group overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <img src="{{ Storage::url('boarding/'.$photo) }}" 
                     alt="{{ $pet->name }} during boarding"
                     class="h-40 w-full object-cover transition-transform group-hover:scale-105">
                
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition flex items-center justify-center">
                    <a href="{{ Storage::url('boarding/'.$photo) }}" 
                       target="_blank"
                       class="opacity-0 group-hover:opacity-100 transition text-white bg-black bg-opacity-50 rounded-full p-2">
                        <i class="fas fa-expand"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>