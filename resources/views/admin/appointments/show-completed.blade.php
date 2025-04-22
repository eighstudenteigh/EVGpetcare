@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Completed Appointment #{{ $appointment->id }}</h1>
        <div class="text-sm text-gray-600">
            <span class="font-medium">Date:</span> 
            {{ $appointment->appointment_date->format('M d, Y') }}
            at {{ $appointment->appointment_time }}
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
                    <p class="text-gray-600">{{ $appointment->user->address }}</p>
                    <p class="text-gray-600">
                        {{ $appointment->user->city }}, 
                        {{ $appointment->user->state }} 
                        {{ $appointment->user->zip_code }}
                    </p>
                @else
                    <p class="text-gray-400">No address on file</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Pets and Services -->
    <div class="space-y-6">
        @foreach($appointment->pets as $pet)
            <div class="bg-white p-4 rounded shadow">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-semibold text-lg">
                        {{ $pet->name }} 
                        <span class="text-sm font-normal text-gray-600">
                            ({{ ucfirst($pet->type) }})<br>
                            Breed: {{ $pet->breed }}
                        </span>
                    </h3>
                    <span class="text-sm bg-gray-100 px-2 py-1 rounded">
                        {{ $pet->age }} years old
                    </span>
                </div>
                
                <!-- Get only services for this pet in this appointment -->
                @php
                    $petServices = $appointment->services->filter(function($service) use ($pet, $appointment) {
                        return $appointment->services->contains($service->id) && 
                               $pet->services->contains($service->id);
                    });
                @endphp

                <div class="space-y-3 mt-4">
                    @foreach($petServices as $service)
                        @php
                            $record = $appointment->records
                                ->where('pet_id', $pet->id)
                                ->where('service_id', $service->id)
                                ->first();
                        @endphp

                        <div class="p-3 border rounded-lg">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="font-medium">{{ $service->name }}</h4>
                                    
                                </div>
                                
                                @if($record)
                                    <a href="{{ route('admin.records.edit', [
                                        'appointment' => $appointment->id,
                                        'pet' => $pet->id,
                                        'service' => $service->id
                                    ]) }}" 
                                       class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
                                        Edit Record
                                    </a>
                                @else
                                    <!-- Dynamic Add Record link based on service type -->
                                    @switch($service->name)
                                        @case('Vaccination')
                                            <a href="{{ route('admin.records.create.vaccination', [
                                                'appointment' => $appointment->id,
                                                'pet' => $pet->id,
                                                'service' => $service->id
                                            ]) }}" 
                                            class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-sm">
                                                Add Vaccination Records
                                            </a>
                                            @break
                                        
                                        @case('Check-Up / Wellness Exams') 
                                            <a href="{{ route('admin.records.create.checkup', [
                                                'appointment' => $appointment->id,
                                                'pet' => $pet->id,
                                                'service' => $service->id
                                            ]) }}" 
                                            class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-sm">
                                                Add Checkup Records
                                            </a>
                                            @break
                                        
                                        @case('Surgery')
                                            <a href="{{ route('admin.records.create.surgery', [
                                                'appointment' => $appointment->id,
                                                'pet' => $pet->id,
                                                'service' => $service->id
                                            ]) }}" 
                                            class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-sm">
                                                Add Surgery Records
                                            </a>
                                            @break
                                        
                                        @case('Grooming')
                                            <a href="{{ route('admin.records.create.grooming', [
                                                'appointment' => $appointment->id,
                                                'pet' => $pet->id,
                                                'service' => $service->id
                                            ]) }}" 
                                            class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-sm">
                                                Add Grooming Records
                                            </a>
                                            @break
                                        
                                        @case('Boarding')
                                            <a href="{{ route('admin.records.create.boarding', [
                                                'appointment' => $appointment->id,
                                                'pet' => $pet->id,
                                                'service' => $service->id
                                            ]) }}" 
                                            class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-sm">
                                                Add Boarding Records
                                            </a>
                                            @break
                                        
                                        @default
                                            <a href="#" class="px-3 py-1 bg-gray-500 text-white rounded text-sm">
                                                Unknown Service Type
                                            </a>
                                    @endswitch
                                @endif
                            </div>

                            @if($record)
                                <div class="mt-3 pl-3 border-l-2 border-gray-200 space-y-2">
                                    <p><span class="font-medium">Notes:</span> {{ $record->notes ?? 'N/A' }}</p>
                                    
                                    @if($service->name === 'Grooming' && $record->products_used)
                                        <p><span class="font-medium">Products Used:</span> {{ $record->products_used }}</p>
                                    @endif
                                    
                                    @if($service->name === 'Check-Up' && $record->diagnosis)
                                        <p><span class="font-medium">Diagnosis:</span> {{ $record->diagnosis }}</p>
                                    @endif
                                    
                                    @if($service->name === 'Vaccination' && $record->vaccine_type)
                                        <p><span class="font-medium">Vaccine:</span> {{ $record->vaccine_type }}</p>
                                        <p><span class="font-medium">Batch #:</span> {{ $record->batch_number }}</p>
                                    @endif
                                    
                                    @if($record->created_at)
                                        <p class="text-xs text-gray-500 mt-2">
                                            Record created: {{ $record->created_at->format('M d, Y h:i A') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Finalize Button -->
    @php
        $requiredRecords = $appointment->pets->count() * $appointment->services->count();
        $hasAllRecords = $appointment->records->count() >= $requiredRecords;
        $missingRecords = $requiredRecords - $appointment->records->count();
    @endphp

    <div class="mt-8 flex justify-between items-center">
        <a href="{{ route('admin.appointments.completed') }}" 
           class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
            ← Back to Completed Appointments
        </a>
        
        @if($hasAllRecords)
            <form action="{{ route('admin.appointments.finalize', $appointment) }}" method="POST">
                @csrf
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Finalize Appointment
                </button>
            </form>
        @else
            <div class="p-4 bg-yellow-50 text-yellow-800 rounded border border-yellow-200">
                <p class="font-medium">Cannot finalize yet</p>
                <p class="text-sm">Missing {{ $missingRecords }} record(s) for this appointment.</p>
            </div>
        @endif
    </div>
</div>
@endsection