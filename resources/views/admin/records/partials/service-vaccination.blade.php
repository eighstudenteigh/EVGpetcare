{{-- resources/views/admin/records/partials/service-vaccination.blade.php --}}
<div class="mt-4 pl-4 border-l-2 border-green-200 bg-green-50 rounded-lg p-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <p class="font-medium text-gray-700">Vaccine Type:</p>
            <p class="text-gray-900">{{ $record->vaccination->vaccine_type ?? 'Not specified' }}</p>
        </div>

        <div>
            <p class="font-medium text-gray-700">Batch Number:</p>
            <p class="text-gray-900">{{ $record->vaccination->batch_number ?? 'Not specified' }}</p>
        </div>

        <div>
            <p class="font-medium text-gray-700">Administered By:</p>
            <p class="text-gray-900">{{ $record->vaccination->administered_by ?? 'Not specified' }}</p>
        </div>

        <div>
            <p class="font-medium text-gray-700">Next Due Date:</p>
            <p class="text-gray-900">
                {{ $record->vaccination->next_due_date ? \Carbon\Carbon::parse($record->vaccination->next_due_date)->format('F d, Y') : 'Not specified' }}
            </p>
        </div>

        @if($record->vaccination->notes)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Notes:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->vaccination->notes }}</p>
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
           class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded text-sm">
            <i class="fas fa-edit mr-1"></i> Edit Vaccination Record
        </a>
    </div>
    @endunless
</div>
