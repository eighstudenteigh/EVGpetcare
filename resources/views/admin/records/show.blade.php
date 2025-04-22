
@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Appointment Details - #{{ $appointment->id }}</h1>

    <div class="bg-white p-6 rounded-lg shadow space-y-6">
        <!-- Grid Layout -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Client Info -->
            <div>
                <h2 class="text-xl font-semibold mb-2">Client Information</h2>
                <p><strong>Name:</strong> {{ $appointment->user->name }}</p>
                <p><strong>Email:</strong> {{ $appointment->user->email }}</p>
                <p><strong>Phone:</strong> {{ $appointment->user->phone ?? 'N/A' }}</p>
            </div>

            <!-- Appointment Info -->
            <div>
                <h2 class="text-xl font-semibold mb-2">Appointment Details</h2>
                <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
                <p><strong>Date:</strong> {{ $appointment->appointment_date->format('M d, Y h:i A') }}</p>
            </div>
        </div>

        <!-- Services -->
        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <h3 class="text-lg font-medium mb-4">Services Provided</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($appointment->services as $service)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    {{ $service->name }}
                </span>
                @endforeach
            </div>
        </div>

        <!-- Pets and Records -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Pets & Records</h2>
            <div class="space-y-6">
                @foreach($appointment->pets as $pet)
                    <div class="border border-gray-200 rounded p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-lg font-medium">{{ $pet->name }} ({{ ucfirst($pet->type) }})</p>
                                <p class="text-sm text-gray-600">{{ $pet->breed ?? 'Unknown breed' }}</p>
                            </div>
                            
                        </div>

                        <!-- Appointment-specific records -->
                        <div class="mt-4 space-y-4">
                            @foreach($pet->groomingRecords->where('appointment_id', $appointment->id) as $record)
                                <div class="pl-4 border-l-2 border-blue-300">
                                    <h3 class="font-semibold text-blue-700">Grooming Record</h3>
                                    <div class="text-sm text-gray-700 mt-2">
                                        <p><strong>Notes:</strong> {{ $record->notes ?? 'N/A' }}</p>
                                        <p><strong>Products Used:</strong> {{ $record->products_used ?? 'N/A' }}</p>
                                        <div class="flex gap-4 mt-2">
                                            @if($record->before_photo_path)
                                                <div class="space-y-2">
                                                    <p class="font-medium text-xs">Before</p>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach(json_decode($record->before_photo_path) as $photo)
                                                            <div class="relative group">
                                                                <img src="{{ Storage::url('grooming/before/'.$photo) }}" 
                                                                     alt="Before grooming" 
                                                                     class="w-24 h-24 object-cover rounded border hover:opacity-75 transition-opacity">
                                                                <a href="{{ Storage::url('grooming/before/'.$photo) }}" 
                                                                   target="_blank" 
                                                                   class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white opacity-0 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        
                                            @if($record->after_photo_path)
                                                <div class="space-y-2">
                                                    <p class="font-medium text-xs">After</p>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach(json_decode($record->after_photo_path) as $photo)
                                                            <div class="relative group">
                                                                <img src="{{ Storage::url('grooming/after/'.$photo) }}" 
                                                                     alt="After grooming" 
                                                                     class="w-24 h-24 object-cover rounded border hover:opacity-75 transition-opacity">
                                                                <a href="{{ Storage::url('grooming/after/'.$photo) }}" 
                                                                   target="_blank" 
                                                                   class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white opacity-0 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @foreach($pet->medicalRecords->where('appointment_id', $appointment->id) as $record)
    <div class="pl-4 border-l-2 border-red-300 mt-4">
        <h3 class="font-semibold text-red-700">Medical Record</h3>
        <div class="text-sm text-gray-700 mt-2 space-y-2">
            <!-- Basic Information -->
            @if($record->service_name)
                <p><strong>Service:</strong> {{ $record->service_name }}</p>
            @endif
            
            @if($record->diagnosis)
                <p><strong>Diagnosis:</strong> {{ $record->diagnosis }}</p>
            @endif
            
            @if($record->treatment)
                <p><strong>Treatment:</strong> {{ $record->treatment }}</p>
            @endif

            <!-- Decode JSON fields with error handling -->
            @php
                $details = [];
                $medications = [];
                
                try {
                    $details = json_decode($record->details, true) ?? [];
                } catch (Exception $e) {
                    $details = [];
                }
                
                try {
                    $medications = json_decode($record->medications, true) ?? [];
                } catch (Exception $e) {
                    $medications = [];
                }
            @endphp

            <!-- Service Type Specific Details -->
            @if(!empty($details))
                <div class="mt-2">
                    @if(!empty($details['service_type']))
                        <p><strong>Service Type:</strong> {{ ucfirst($details['service_type']) }}</p>
                    @endif
                    
                    @if(!empty($details['vaccine_type']))
                        <p><strong>Vaccine Type:</strong> {{ $details['vaccine_type'] }}</p>
                    @endif
                    
                    @if(!empty($details['next_due_date']))
                        <p><strong>Next Due Date:</strong> {{ \Carbon\Carbon::parse($details['next_due_date'])->format('M d, Y') }}</p>
                    @endif
                    
                    @if(!empty($details['weight']))
                        <p><strong>Weight:</strong> {{ $details['weight'] }} kg</p>
                    @endif
                    
                    @if(!empty($details['temperature']))
                        <p><strong>Temperature:</strong> {{ $details['temperature'] }} °C</p>
                    @endif
                    
                    @if(!empty($details['checkup_items']))
                        <p><strong>Checkup Items:</strong> {{ $details['checkup_items'] }}</p>
                    @endif
                    
                    @if(!empty($details['surgery_type']))
                        <p><strong>Surgery Type:</strong> {{ $details['surgery_type'] }}</p>
                    @endif
                    
                    @if(!empty($details['anesthesia_type']))
                        <p><strong>Anesthesia Type:</strong> {{ $details['anesthesia_type'] }}</p>
                    @endif
                    
                    @if(!empty($details['post_op_instructions']))
                        <p><strong>Post-Op Instructions:</strong> {{ $details['post_op_instructions'] }}</p>
                    @endif
                </div>
            @endif

            <!-- Medications -->
            @if(!empty($medications) && count($medications) > 0)
                <div class="mt-2">
                    <p class="font-medium">Medications:</p>
                    <ul class="list-disc list-inside pl-4">
                        @foreach($medications as $med)
                            <li>
                                {{ $med['name'] ?? 'Unknown medication' }}
                                @if(!empty($med['dosage']))
                                    - {{ $med['dosage'] }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Attachments -->
            @php
                $attachments = [];
                try {
                    $attachments = json_decode($record->attachments) ?? [];
                } catch (Exception $e) {
                    $attachments = [];
                }
            @endphp
            
            @if(!empty($attachments) && count($attachments) > 0)
                <div class="mt-2">
                    <p class="font-medium">Attachments:</p>
                    <div class="flex flex-wrap gap-2 mt-1">
                        @foreach($attachments as $attachment)
                            @if(!empty($attachment))
                                <div class="relative group">
                                    <a href="{{ Storage::url('medical-records/'.$attachment) }}" 
                                       target="_blank"
                                       class="flex items-center gap-1 px-2 py-1 bg-gray-100 rounded hover:bg-gray-200">
                                        @if(in_array(pathinfo($attachment, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        @endif
                                        <span class="text-xs truncate max-w-xs">{{ $attachment }}</span>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Fallback if no data is present -->
            @if(empty($record->diagnosis) && empty($record->treatment) && empty($details) && empty($medications) && empty($attachments))
                <p class="text-gray-500 italic">No detailed medical record information available</p>
            @endif
        </div>
    </div>
@endforeach

@if($pet->medicalRecords->where('appointment_id', $appointment->id)->isEmpty())
    <div class="pl-4 border-l-2 border-gray-300 mt-4">
        <p class="text-gray-500 italic">No medical records found for this appointment</p>
    </div>
@endif

                            @foreach($pet->boardingRecords->where('appointment_id', $appointment->id) as $record)
                                <div class="pl-4 border-l-2 border-yellow-300">
                                    <h3 class="font-semibold text-yellow-700">Boarding Record</h3>
                                    <div class="text-sm text-gray-700 mt-2">
                                        <p><strong>Check-in:</strong> {{ $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format('M d, Y h:i A') : 'N/A' }}</p>
                                        <p><strong>Check-out:</strong> {{ $record->check_out ? \Carbon\Carbon::parse($record->check_out)->format('M d, Y h:i A') : 'N/A' }}</p>
                                        <p><strong>Notes:</strong> {{ $record->notes ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection