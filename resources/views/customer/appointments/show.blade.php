@extends('layouts.customer')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        Appointment Details - {{ $appointment->appointment_date->format('M d, Y') }}
                    </h2>
                    <a href="{{ route('customer.pets.show', $appointment->pets->first()) }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Back to Pet
                    </a>
                </div>

                <!-- Appointment Info -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-2">Appointment Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <p class="font-medium">Date:</p>
                            <p>{{ $appointment->appointment_date->format('F j, Y') }}</p>
                        </div>
                        <div>
                            <p class="font-medium">Time:</p>
                            <p>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                        </div>
                        <div>
                            <p class="font-medium">Status:</p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($appointment->status == 'completed') bg-green-300 text-green-800
                                @elseif($appointment->status == 'approved') bg-blue-300 text-blue-800
                                @elseif($appointment->status == 'pending') bg-yellow-300 text-yellow-800
                                @else bg-red-300 text-red-800 @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Services by Pet -->
                @foreach($appointment->pets as $pet)
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4">{{ $pet->name }}'s Services</h3>
                        
                        @foreach($appointment->services as $service)
                            @php
                                $record = $appointment->records->where('pet_id', $pet->id)
                                    ->where('service_id', $service->id)
                                    ->first();
                            @endphp
                            
                            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                <h4 class="font-medium text-lg mb-2">{{ $service->name }}</h4>
                                
                                @if($record)
                                    @if(view()->exists('customer.appointments.partials.service-' . strtolower($record->type)))
                                        @include('customer.appointments.partials.service-' . strtolower($record->type), [
                                            'record' => $record,
                                            'service' => $service,
                                            'appointment' => $appointment,
                                            'pet' => $pet,
                                        ])
                                    @else
                                        <div class="bg-white p-4 rounded shadow">
                                            <p class="text-gray-700">{{ $record->notes ?? 'No details available' }}</p>
                                        </div>
                                    @endif
                                @else
                                    <p class="text-gray-500">No record available for this service.</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection