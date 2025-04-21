@extends('layouts.admin')

@section('title', 'Rejected Appointments')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800"> Rejected Appointments</h2>
    <h4 class="text-2xl font-bold mb-6 text-gray-800"> Appointments Status links</h4>
    <!-- status routes -->
    <div class="flex gap-2 mb-6">
        <a href="{{ route('admin.appointments') }}" class="bg-orange-400 text-white px-4 py-2 rounded">Pending</a>
        <a href="{{ route('admin.appointments.approved') }}" class="bg-orange-600 text-white px-4 py-2 rounded">Approved</a>
        <a href="{{ route('admin.appointments.rejected') }}" class="bg-gray-700 text-white px-4 py-2 rounded">Rejected</a>
        <a href="{{ route('admin.appointments.all') }}" class="bg-gray-500 text-white px-4 py-2 rounded">All</a>
    </div>

    <!-- ✅ Rejected Appointments List -->
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
                                {{ $pet->services->pluck('name')->unique()->join(', ') ?: 'None' }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <!-- ✅ Status Indicator -->
                <div class="flex justify-between items-center mt-4">
                    <p class="font-semibold">
                        <span class="px-3 py-1 text-white bg-gray-700 rounded-lg">Rejected</span>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
