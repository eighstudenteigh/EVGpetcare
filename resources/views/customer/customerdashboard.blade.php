@extends('layouts.customer')

@section('content')
    <h2 class="text-2xl font-bold mb-4">
        Welcome, <span class="text-orange-500">{{ Auth::user()->name }}</span>!
    </h2>

    <!-- 📊 Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <div class="bg-darkGray text-white p-4 rounded-lg shadow-soft">
            <h3 class="text-lg font-semibold">Total Appointments</h3>
            <p class="text-3xl font-bold">{{ $appointmentsCount }}</p>
        </div>
        <div class="bg-darkGray text-white p-4 rounded-lg shadow-soft">
            <h3 class="text-lg font-semibold">Total Pets</h3>
            <p class="text-3xl font-bold">{{ $petsCount }}</p>
        </div>
        <div class="bg-darkGray text-white p-4 rounded-lg shadow-soft">
            <h3 class="text-lg font-semibold">Next Appointment</h3>
            <p class="text-xl">{{ $nextAppointment ? $nextAppointment->appointment_date . ' at ' . $nextAppointment->appointment_time : 'None' }}</p>
        </div>
    </div>

    <!-- 🟠 New Appointment Button -->
    <div class="flex justify-start sm:justify-center mt-4">
        <a href="{{ route('customer.appointments.create') }}" 
           class="px-6 bg-orange-500 text-white font-semibold py-2 rounded hover:bg-orange-600">
            + Book New Appointment
        </a>
    </div>

    <!-- 🗓️ Appointment History -->
    <div class="bg-darkGray text-white p-4 rounded-lg shadow-soft mt-6">
        <h3 class="text-xl font-semibold">Appointment History</h3>
        @foreach($appointments as $appointment)
            <div class="flex items-center justify-between border-b border-orange-300 py-2">
                <div class="flex items-center gap-2">
                    <span>📅</span>
                    <span>{{ $appointment->appointment_date }} at {{ $appointment->appointment_time }} -</span>
                    <span class="bg-pantone7408 text-black px-2 py-1 text-sm font-semibold rounded">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>
            </div>
        @endforeach

        <div class="flex flex-col sm:flex-row gap-2 mt-3">
            
            </a>
            <a href="{{ route('customer.appointments.index') }}" 
               class="px-6 bg-orange-500 text-white font-semibold py-2 rounded hover:bg-orange-600">
                View All Appointments
            </a>
        </div>
    </div>

    <!-- 🐾 Your Pets -->
    <div class="bg-darkGray text-white p-4 rounded-lg shadow-soft mt-6">
        <h3 class="text-xl font-semibold">Your Pets</h3>
        @foreach($pets as $pet)
            <div class="flex items-center gap-2 py-2">
                <span>🐶</span>
                <p><strong>{{ $pet->name }}</strong> ({{ ucfirst($pet->type) }} - {{ $pet->breed }})</p>
            </div>
        @endforeach

        <!-- 🔘 Pet Management Buttons -->
        <div class="flex flex-col sm:flex-row gap-2 mt-3">
            <a href="{{ route('customer.pets.create') }}" 
               class="px-6 bg-orange-500 text-white font-semibold py-2 rounded hover:bg-orange-600 text-center">
                Register a New Pet
            </a>
            <a href="{{ route('customer.pets.index') }}" 
               class="px-6 bg-orange-500 text-white font-semibold py-2 rounded hover:bg-orange-600 text-center">
                View Pet Profiles
            </a>
        </div>
    </div>

    
@endsection
