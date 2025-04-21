@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Appointment Details - #{{ $appointment->id }}</h1>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-2">Client Information</h2>
        <p><strong>Name:</strong> {{ $appointment->user->name }}</p>
        <p><strong>Email:</strong> {{ $appointment->user->email }}</p>

        <hr class="my-4">

        <h2 class="text-xl font-semibold mb-2">Pets</h2>
        @foreach($appointment->pets as $pet)
            <div class="mb-2">
                <p><strong>Name:</strong> {{ $pet->name }} ({{ ucfirst($pet->type) }})</p>
                @if($pet->groomingRecords->isNotEmpty())
                    <p class="text-sm text-blue-600">Has Grooming Record</p>
                @endif
                @if($pet->medicalRecords->isNotEmpty())
                    <p class="text-sm text-red-600">Has Medical Record</p>
                @endif
                @if($pet->boardingRecords->isNotEmpty())
                    <p class="text-sm text-yellow-600">Has Boarding Record</p>
                @endif
            </div>
        @endforeach

        <hr class="my-4">

        <h2 class="text-xl font-semibold mb-2">Services</h2>
        <ul>
            @foreach($appointment->services as $service)
                <li>{{ $service->name }} ({{ ucfirst($service->service_type) }})</li>
            @endforeach
        </ul>

        <hr class="my-4">

        <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
        <p><strong>Appointment Date:</strong> {{ $appointment->appointment_date->format('M d, Y h:i A') }}</p>
        <p><strong>Last Updated:</strong> {{ $appointment->updated_at->format('M d, Y h:i A') }}</p>
    </div>
</div>
@endsection
