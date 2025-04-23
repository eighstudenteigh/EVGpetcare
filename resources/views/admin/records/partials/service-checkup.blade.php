<div class="mt-4">
    <h5 class="text-md font-semibold mb-2">Checkup Details</h5>

    @php
        $checkup = $record->checkup;
    @endphp

    @if($checkup)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <p><span class="font-medium">Weight:</span> {{ $checkup->weight }} kg</p>
                <p><span class="font-medium">Temperature:</span> {{ $checkup->temperature }} °C</p>
                <p><span class="font-medium">Heart Rate:</span> {{ $checkup->heart_rate }} bpm</p>
            </div>
            <div>
                <p><span class="font-medium">Respiratory Rate:</span> {{ $checkup->respiratory_rate }} bpm</p>
                <p><span class="font-medium">Diagnosis:</span> {{ $checkup->diagnosis }}</p>
                <p><span class="font-medium">Treatment Plan:</span> {{ $checkup->treatment_plan }}</p>
            </div>
        </div>

        @if($checkup->notes)
            <div class="mt-4">
                <p class="text-sm"><span class="font-medium">Notes:</span> {{ $checkup->notes }}</p>
            </div>
        @endif
    @else
        <p class="text-red-500">No checkup data available for this record.</p>
    @endif
</div>
