@extends('layouts.customer')

@section('content')
    <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800 py-8">
        Welcome, <span class="text-blue-700">{{ Auth::user()->name }}</span>!
    </h2>

    <!-- Book New Appointment Button -->
    <div class="flex justify-end mb-4">
        @if($petsCount === 0)
            <div class="text-center">
                <a href="#" 
                   class="px-6 bg-orange-400 text-white hover:bg-gray-500 transition-colors font-bold py-2 rounded opacity-50 cursor-not-allowed"
                   aria-disabled="true" tabindex="-1">
                     Book New Appointment
                </a>
                <p class="text-sm text-gray-400 mt-2">You need to register at least one pet to book an appointment.</p>
            </div>
        @else
            <a href="{{ route('customer.appointments.create') }}" 
               class="px-6 bg-orange-400 text-white font-bold py-2 rounded hover:bg-gray-500 transition-colors">
                 Book New Appointment
            </a>
        @endif
    </div>

    <!-- 🚨 Next Appointment Section -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6 ">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Next Appointment</h3>
        
        @if($nextAppointment)
            <div class="space-y-2">
                <p class="text-2xl font-bold text-blue-600">
                    {{ $nextAppointment->appointment_date }} at {{ $nextAppointment->appointment_time }}
                    <span class="text-lg font-normal text-gray-600 ml-2">
                        (in {{ Carbon\Carbon::parse($nextAppointment->appointment_date)->diffForHumans() }})
                    </span>
                </p>
                @if($nextAppointment->pets->count() > 0)
                    <p class="text-lg">
                        <span class="font-semibold">Pet(s):</span> 
                        {{ $nextAppointment->pets->pluck('name')->join(', ') }}
                    </p>
                @endif
                @if($nextAppointment->services->count() > 0)
                    <p class="text-lg">
                        <span class="font-semibold">Service(s):</span> 
                        {{ $nextAppointment->services->pluck('name')->join(', ') }}
                    </p>
                @endif
            </div>
        @else
            <div class="text-center ">
                <p class="text-gray-600 mb-4">You don't have any upcoming appointments.</p>
                <a href="{{ route('customer.appointments.create') }}" 
                   class="px-6 bg-orange-400 text-white font-bold py-2 rounded hover:bg-gray-500 transition-colors">
                    Book New Appointment
                </a>
            </div>
        @endif
    </div>

  <!-- 📊 Quick Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">
    <!-- Upcoming Appointments -->
    <div class="bg-white p-4 rounded-lg shadow-md">
        <h3 class="text-lg font-bold text-gray-700">Upcoming Appointments</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $upcomingCount }}</p>
    </div>

    <!-- Pending Appointments -->
    <div class="bg-white p-4 rounded-lg shadow-md">
        <h3 class="text-lg font-bold text-gray-700">Pending Appointments</h3>
        <p class="text-3xl font-bold text-yellow-600">{{ $pendingCount }}</p>
    </div>

    <!-- Total Pets -->
    <div class="bg-white p-4 rounded-lg shadow-md">
        <h3 class="text-lg font-bold text-gray-700">Total Pets</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $petsCount }}</p>
    </div>
</div>

    <!-- 🗓️ Recent Appointment History -->
    <div class="bg-white p-6 rounded-lg shadow-md mt-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Recent Appointments (Last 2 Weeks)</h3>
        
        @forelse($recentAppointments as $appointment)
            <div class="flex items-center justify-between border-b border-gray-200 py-3">
                <div class="flex items-center gap-3">
                    <span class="text-gray-500">📅</span>
                    <div>
                        <p class="text-gray-800">
                            {{ $appointment->appointment_date }} at {{ $appointment->appointment_time }}
                            @if($appointment->pets->count() > 0)
                                <span class="text-sm text-gray-600">
                                    ({{ $appointment->pets->pluck('name')->join(', ') }})
                                </span>
                            @endif
                        </p>
                        @if($appointment->services->count() > 0)
                            <p class="text-sm text-gray-600">
                                {{ $appointment->services->pluck('name')->join(', ') }}
                            </p>
                        @endif
                    </div>
                </div>
                <span class="px-2 py-1 text-sm font-bold rounded 
                    {{ $appointment->status === 'approved' ? 'bg-green-300 text-green-800' : '' }}
                    {{ $appointment->status === 'pending' ? 'bg-yellow-300 text-yellow-800' : '' }}
                    {{ $appointment->status === 'rejected' ? 'bg-red-300 text-red-800' : '' }}
                    {{ $appointment->status === 'completed' ? 'bg-blue-300 text-blue-800' : '' }}
                     {{ $appointment->status === 'finalized' ? 'bg-blue-700 text-white'  : '' }}"> 
                    {{ ucfirst($appointment->status) }}
                </span>
            </div>
        @empty
            <p class="text-gray-500 py-4 text-center">
                Your recent appointment history will appear here after bookings
            </p>
        @endforelse


        <div class="mt-4">
            <a href="{{ route('customer.appointments.index') }}" 
               class="px-6 bg-orange-400 text-white font-bold py-2 rounded hover:bg-gray-500 transition-colors">
                View Full History
            </a>
        </div>
    </div>

    
@endsection