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
            </div>

            <!-- Appointment Info -->
            <div>
                <h2 class="text-xl font-semibold mb-2">Appointment Info</h2>
                <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
                <p><strong>Appointment Date:</strong> {{ $appointment->appointment_date->format('M d, Y h:i A') }}</p>
                <p><strong>Last Updated:</strong> {{ $appointment->updated_at->format('M d, Y h:i A') }}</p>
            </div>
        </div>

        <!-- Services -->
        <div>
            <h2 class="text-xl font-semibold mb-2">Services</h2>
            <ul class="list-disc list-inside text-gray-700">
                @foreach($appointment->services as $service)
                    <li>{{ $service->name }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Pets and Records -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Pets</h2>
            <div class="space-y-6">
                @foreach($appointment->pets as $pet)
                    <div class="border border-gray-200 rounded p-4">
                        <p class="text-lg font-medium mb-2">
                            {{ $pet->name }} ({{ ucfirst($pet->type) }})
                        </p>

                        @if($pet->groomingRecords->isNotEmpty())
                        <div class="mt-2 pl-4 border-l-2 border-blue-300">
                            <h3 class="font-semibold text-blue-700 mb-2">Grooming Records</h3>
                            <div class="space-y-4">
                                @foreach($pet->groomingRecords as $record)
                                    <div class="text-sm text-gray-700 border-b pb-3">
                                        <p><strong>Notes:</strong> {{ $record->notes ?? 'N/A' }}</p>
                                        <p><strong>Products Used:</strong> {{ $record->products_used ?? 'N/A' }}</p>
                                        <p><strong>Created At:</strong> {{ \Carbon\Carbon::parse($record->created_at)->format('M d, Y h:i A') }}</p>

                                        <div class="flex gap-4 mt-2">
                                            @if($record->before_photo_path)
                                                <div>
                                                    <p class="font-medium text-xs">Before</p>
                                                    <img src="{{ asset('storage/' . $record->before_photo_path) }}" alt="Before grooming" class="w-24 h-24 object-cover rounded border">
                                                </div>
                                            @endif

                                            @if($record->after_photo_path)
                                                <div>
                                                    <p class="font-medium text-xs">After</p>
                                                    <img src="{{ asset('storage/' . $record->after_photo_path) }}" alt="After grooming" class="w-24 h-24 object-cover rounded border">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="mt-2 space-x-4">
                            @if($pet->medicalRecords->isNotEmpty())
                                <span class="inline-block text-xs text-red-600 font-semibold">Has Medical Record</span>
                            @endif
                            @if($pet->boardingRecords->isNotEmpty())
                                <span class="inline-block text-xs text-yellow-600 font-semibold">Has Boarding Record</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
