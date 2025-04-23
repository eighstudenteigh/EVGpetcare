{{-- resources/views/customer/appointments/partials/service-boarding.blade.php --}}
<div class="mt-4 pl-4 border-l-2 border-blue-200 bg-blue-50 rounded-lg p-4">
    <h4 class="font-semibold text-lg mb-4 text-blue-800">Boarding Details</h4>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Basic Information -->
        <div>
            <p class="font-medium text-gray-700">Kennel Number:</p>
            <p class="text-gray-900">{{ $record->boarding->kennel_number ?? 'Not specified' }}</p>
        </div>
        
        <div>
            <p class="font-medium text-gray-700">Check-in Date:</p>
            <p class="text-gray-900">{{ $appointment->appointment_date->format('M j, Y') }}</p>
        </div>
        
        <div>
            <p class="font-medium text-gray-700">Check-in Time:</p>
            <p class="text-gray-900">
                @if($record->boarding->check_in_time)
                    {{ \Carbon\Carbon::parse($record->boarding->check_in_time)->format('h:i A') }}
                @else
                    Not recorded
                @endif
            </p>
        </div>
        
        <div>
            <p class="font-medium text-gray-700">Check-out Time:</p>
            <p class="text-gray-900">
                @if($record->boarding->check_out_time)
                    {{ \Carbon\Carbon::parse($record->boarding->check_out_time)->format('h:i A') }}
                @else
                    Not recorded
                @endif
            </p>
        </div>
        
        <!-- Care Details -->
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Feeding Schedule:</p>
            <p class="text-gray-900 whitespace-pre-line">
                {{ $record->boarding->feeding_schedule ?? 'Standard feeding schedule was followed' }}
            </p>
        </div>
        
        @if($record->boarding->medications_administered)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Medications Administered:</p>
            <p class="text-gray-900 whitespace-pre-line">
                {{ $record->boarding->medications_administered }}
            </p>
        </div>
        @endif
        
        @if($record->boarding->activity_notes)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Daily Activities:</p>
            <p class="text-gray-900 whitespace-pre-line">
                {{ $record->boarding->activity_notes }}
            </p>
        </div>
        @endif
        
        @if($record->boarding->behavior_notes)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Behavior Notes:</p>
            <p class="text-gray-900 whitespace-pre-line">
                {{ $record->boarding->behavior_notes }}
            </p>
        </div>
        @endif
        
        @if($record->boarding->special_instructions)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Special Instructions Followed:</p>
            <p class="text-gray-900 whitespace-pre-line">
                {{ $record->boarding->special_instructions }}
            </p>
        </div>
        @endif
        
        @if($record->notes)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Additional Notes:</p>
            <p class="text-gray-900 whitespace-pre-line">
                {{ $record->notes }}
            </p>
        </div>
        @endif
    </div>

    <!-- Photo Gallery for Customer -->
    @if($record->boarding->photos_path)
    <div class="mt-6 border-t pt-4">
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

    {{-- <!-- Report Download Button -->
    <div class="mt-6 flex justify-end">
        <a href="{{ route('customer.appointments.download-report', ['appointment' => $appointment->id, 'service' => $service->id]) }}" 
           class="flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
            <i class="fas fa-file-pdf mr-2"></i> Download Boarding Report
        </a>
    </div> --}}
</div>