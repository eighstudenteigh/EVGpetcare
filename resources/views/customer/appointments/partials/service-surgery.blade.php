{{-- resources/views/customer/appointments/partials/service-surgery.blade.php --}}
<div class="mt-4 pl-4 border-l-2 border-red-200 bg-red-50 rounded-lg p-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <p class="font-medium text-gray-700">Procedure Performed:</p>
            <p class="text-gray-900">{{ $record->surgery->procedure_name ?? 'Not specified' }}</p>
        </div>

        <div>
            <p class="font-medium text-gray-700">Performed By:</p>
            <p class="text-gray-900">{{ $record->surgery->surgeon_name ?? 'Not specified' }}</p>
        </div>

        <div>
            <p class="font-medium text-gray-700">Date:</p>
            <p class="text-gray-900">{{ $appointment->appointment_date->format('F j, Y') }}</p>
        </div>

        <div>
            <p class="font-medium text-gray-700">Duration:</p>
            <p class="text-gray-900">
                @if($record->surgery->start_time && $record->surgery->end_time)
                    {{ \Carbon\Carbon::parse($record->surgery->start_time)->format('h:i A') }} - 
                    {{ \Carbon\Carbon::parse($record->surgery->end_time)->format('h:i A') }}
                @else
                    Not recorded
                @endif
            </p>
        </div>

        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Post-Operative Care Instructions:</p>
            <div class="bg-white p-3 rounded border border-gray-200">
                <p class="text-gray-900 whitespace-pre-line">{{ $record->surgery->post_op_instructions ?? 'No specific instructions provided' }}</p>
            </div>
        </div>

        @if($record->surgery->medications)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Prescribed Medications:</p>
            <div class="bg-white p-3 rounded border border-gray-200">
                <p class="text-gray-900 whitespace-pre-line">{{ $record->surgery->medications }}</p>
            </div>
        </div>
        @endif

        @if($record->surgery->complications)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Important Notes About the Procedure:</p>
            <div class="bg-white p-3 rounded border border-gray-200">
                <p class="text-gray-900 whitespace-pre-line">{{ $record->surgery->complications }}</p>
            </div>
        </div>
        @endif

        @if($record->notes)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Additional Notes:</p>
            <div class="bg-white p-3 rounded border border-gray-200">
                <p class="text-gray-900 whitespace-pre-line">{{ $record->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Emergency Contact Section -->
    <div class="mt-6 border-t pt-4">
        <h4 class="font-medium text-gray-700 mb-2">Emergency Contact</h4>
        <p class="text-sm text-gray-600">If you have any concerns after the procedure, please contact us immediately:</p>
        <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="font-medium text-gray-700">Clinic Phone:</p>
                <p class="text-gray-900">{{ config('app.clinic_phone') ?? 'Not available' }}</p>
            </div>
            <div>
                <p class="font-medium text-gray-700">Emergency Hours:</p>
                <p class="text-gray-900">{{ config('app.emergency_hours') ?? '24/7' }}</p>
            </div>
        </div>
    </div>
</div>