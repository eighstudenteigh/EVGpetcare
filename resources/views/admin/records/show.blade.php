@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-6 px-4">
    <!-- Header with finalized status -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">
                Finalized Record #{{ $appointment->id }}
                <span class="ml-2 text-sm bg-green-100 text-green-800 px-2 py-1 rounded-full">LOCKED</span>
            </h1>
            <div class="flex items-center mt-2 text-sm text-gray-600 space-x-4">
                <span>
                    <span class="font-medium">Appointment:</span> 
                    {{ $appointment->appointment_date->format('M d, Y') }} at {{ $appointment->appointment_time }}
                </span>
                <span>
                    <span class="font-medium">Finalized:</span>
                    {{ $appointment->updated_at->format('M d, Y h:i A') }}
                </span>
            </div>
        </div>
        <div class="bg-blue-50 text-blue-800 px-3 py-2 rounded text-sm">
            <i class="fas fa-lock mr-1"></i> Read Only
        </div>
    </div>

    <!-- Client Info -->
    <div class="bg-white p-4 rounded shadow mb-6">
        <h2 class="font-semibold text-lg mb-2">Client Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="font-medium">{{ $appointment->user->name }}</p>
                <p class="text-gray-600">{{ $appointment->user->email }}</p>
                <p class="text-gray-600">{{ $appointment->user->phone }}</p>
            </div>
            <div>
                @if($appointment->user->address)
                    <p class="text-gray-600">Address: {{ $appointment->user->address }}</p>
                    
                @else
                    <p class="text-gray-400">No address on file</p>
                @endif
            </div>
        </div>
    </div>

  

        <!-- Services by Pet -->
        @foreach($appointment->pets as $pet)
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-4 border-b">
                    <h3 class="font-semibold">{{ $pet->name }}</h3>
                </div>

                <div class="divide-y divide-gray-200">
                    @foreach($appointment->services as $service)
                        @php
                            $record = $appointment->records
                                ->where('pet_id', $pet->id)
                                ->where('service_id', $service->id)
                                ->first();
                        @endphp

                        <div class="p-4">
                            <div class="flex justify-between items-center">
                                <h4 class="font-medium">Service: {{ $service->name }}</h4>
                                
                                
                            </div>

                            @if(view()->exists('admin.records.partials.service-' . strtolower($record->type)))
                                @include('admin.records.partials.service-' . strtolower($record->type), [
                                    'record' => $record,
                                    'service' => $service,
                                    'appointment' => $appointment,
                                    'pet' => $record->pet,
                                ])
                            @else
                                <p class="text-red-500">Partial for type "{{ $record->type }}" not found.</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>


    <!-- Footer -->
    <div class="mt-8 flex justify-between items-center border-t pt-4">
        <a href="{{ route('admin.records.index') }}" 
           class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
            ← Back to All Records
        </a>
        
        
    </div>
</div>
@endsection