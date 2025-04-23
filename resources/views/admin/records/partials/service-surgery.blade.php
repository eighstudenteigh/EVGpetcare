{{-- resources/views/admin/records/partials/service-surgery.blade.php --}}
<div class="mt-4 pl-4 border-l-2 border-red-200 bg-red-50 rounded-lg p-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <p class="font-medium text-gray-700">Procedure Name:</p>
            <p class="text-gray-900">{{ $record->surgery->procedure_name ?? 'Not specified' }}</p>
        </div>

        <div>
            <p class="font-medium text-gray-700">Anesthesia Type:</p>
            <p class="text-gray-900">{{ $record->surgery->anesthesia_type ?? 'Not specified' }}</p>
        </div>

        <div>
            <p class="font-medium text-gray-700">Surgeon Name:</p>
            <p class="text-gray-900">{{ $record->surgery->surgeon_name ?? 'Not specified' }}</p>
        </div>

        <div>
            <p class="font-medium text-gray-700">Start Time:</p>
            <p class="text-gray-900">{{ $record->surgery->start_time ? \Carbon\Carbon::parse($record->surgery->start_time)->format('h:i A') : 'Not recorded' }}</p>
        </div>

        <div>
            <p class="font-medium text-gray-700">End Time:</p>
            <p class="text-gray-900">{{ $record->surgery->end_time ? \Carbon\Carbon::parse($record->surgery->end_time)->format('h:i A') : 'Not recorded' }}</p>
        </div>

        @if($record->surgery->complications)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Complications:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->surgery->complications }}</p>
        </div>
        @endif

        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Post-Op Instructions:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->surgery->post_op_instructions ?? 'Not provided' }}</p>
        </div>

        @if($record->surgery->medications)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Medications:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->surgery->medications }}</p>
        </div>
        @endif

        @if($record->notes)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Additional Notes:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->notes }}</p>
        </div>
        @endif
    </div>

    @unless($appointment->status === 'finalized')
    <div class="mt-6 flex justify-end">
        <a href="{{ route('admin.records.edit', [
            'appointment' => $appointment->id,
            'pet' => $pet->id,
            'service' => $service->id
        ]) }}" 
           class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
            <i class="fas fa-edit mr-1"></i> Edit Surgery Record
        </a>
    </div>
    @endunless
</div>
