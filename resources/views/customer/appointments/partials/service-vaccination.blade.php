{{-- resources/views/customer/appointments/partials/service-vaccination.blade.php --}}
<div class="mt-4 pl-4 border-l-2 border-green-200 bg-green-50 rounded-lg p-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <p class="font-medium text-gray-700">Vaccine Type:</p>
            <p class="text-gray-900">{{ $record->vaccination->vaccine_type ?? 'Not specified' }}</p>
        </div>

        <div>
            <p class="font-medium text-gray-700">Administered By:</p>
            <p class="text-gray-900">{{ $record->vaccination->administered_by ?? 'Not specified' }}</p>
        </div>

        <div>
            <p class="font-medium text-gray-700">Date Administered:</p>
            <p class="text-gray-900">
                {{ $appointment->appointment_date->format('F d, Y') }}
            </p>
        </div>

        <div>
            <p class="font-medium text-gray-700">Next Due Date:</p>
            <p class="text-gray-900">
                @if($record->vaccination->next_due_date)
                    {{ \Carbon\Carbon::parse($record->vaccination->next_due_date)->format('F d, Y') }}
                    <span class="text-xs text-gray-500 ml-1">
                        (in {{ \Carbon\Carbon::parse($record->vaccination->next_due_date)->diffForHumans() }})
                    </span>
                @else
                    Not specified
                @endif
            </p>
        </div>

        @if($record->vaccination->notes)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Notes:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->vaccination->notes }}</p>
        </div>
        @endif
    </div>

    <!-- Vaccination Card Download -->
    @if($record->vaccination->certificate_path)
    <div class="mt-6 border-t pt-4">
        <h4 class="font-medium text-gray-700 mb-3">Vaccination Certificate</h4>
        <a href="{{ Storage::url($record->vaccination->certificate_path) }}" 
           target="_blank"
           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded text-sm">
            <i class="fas fa-download mr-2"></i> Download Certificate
        </a>
    </div>
    @endif
</div>