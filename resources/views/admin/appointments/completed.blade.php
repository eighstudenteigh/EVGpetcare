{{-- resources/views/admin/appointments/completed.blade.php --}}
@extends('layouts.admin')

@section('title', 'Completed Appointments')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Need to Update Records</h2>

    

    <h4 class="text-2xl font-bold mb-6 text-gray-800">Appointments Status links</h4>

    <!-- status routes -->
    <div class="flex gap-2 mb-6">
        <a href="{{ route('admin.appointments') }}" class="bg-orange-400 text-white px-4 py-2 rounded">Pending</a>
        <a href="{{ route('admin.appointments.approved') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Approved</a>
        <a href="{{ route('admin.appointments.completed') }}" class="bg-blue-800 text-white px-4 py-2 rounded">Needs Records</a>
        <a href="{{ route('admin.appointments.rejected') }}" class="bg-gray-700 text-white px-4 py-2 rounded">Rejected</a>
        {{-- <a href="{{ route('admin.appointments.all') }}" class="bg-gray-500 text-white px-4 py-2 rounded">All</a> --}}
    </div>

    <!-- ✅ Completed Appointments List -->
    <div class="space-y-4">
        @foreach ($appointments as $appointment)
            <div class="bg-white shadow rounded-lg p-4 border border-gray-300 appointment-card" data-status="{{ $appointment->status }}">
                <!-- Appointment Header -->
                <div class="flex justify-between items-center border-b pb-2 mb-3">
                    <p class="text-lg font-semibold">
                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }} - 
                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                    </p>
                    <p class="text-gray-600">
                        Owner: <span class="font-semibold">{{ $appointment->user->name }}</span> 
                        <span class="text-sm text-gray-500"> | {{ $appointment->user->email }} | 📞 {{ $appointment->user->phone }}</span>
                    </p>
                </div>

                <!-- ✅ Pets & Services -->
<div class="space-y-3">
    @foreach ($appointment->pets as $pet)
        <div class="flex justify-between items-center p-3 bg-gray-100 rounded mb-2">
            <p class="font-semibold text-gray-800">
                {{ $pet->name }} ({{ ucfirst($pet->type) }})
            </p>
            <p class="text-gray-600">
                <span class="font-medium text-gray-700">Services:</span>
                @php
                    // Method 1: Using appointmentServices relationship
                    $services = $appointment->appointmentServices
                        ->where('pet_id', $pet->id)
                        ->pluck('service.name');
                    
                    // OR Method 2: Using services relationship with pivot
                    // $services = $appointment->services
                    //     ->where('pivot.pet_id', $pet->id)
                    //     ->pluck('name');
                @endphp
                {{ $services->join(', ') ?: 'None' }}
            </p>
        </div>
    @endforeach
</div>

                <!-- ✅ Status & Finalization Button -->
                <div class="flex justify-between items-center mt-4">
                    <div class="flex items-center">
                        <span class="px-3 py-1 text-white bg-green-600 rounded-lg">Completed</span>
                        @if(\Carbon\Carbon::parse($appointment->appointment_date)->isToday())
                            <span class="ml-2 px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                Completed Today
                            </span>
                        @endif
                    </div>
                    
                    @if($appointment->status === 'completed')
                        <div class="flex gap-2">
                            <a href="{{ route('admin.appointments.show-completed', $appointment->id) }}" 
                               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                View Records
                            </a>
                           
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection