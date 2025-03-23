@extends('layouts.admin')

@section('title', 'Approved Appointments')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Approved Appointments</h2>

     <!-- 🔹 Slots Tracking -->
     <div class="mb-4 p-3 bg-gray-800 text-white rounded-md">
        <p class="text-lg font-semibold">Today's Capacity  ({{ now()->format('F j, Y') }}): <span class="text-orange-400">{{ $acceptedAppointmentsToday }}/{{ $maxAppointments }} slots filled</span></p>
        
        <div class="w-full bg-gray-600 rounded-full h-4 mt-2">
            
            <div class="h-4 bg-orange-500 rounded-full" style="width: {{ ($acceptedAppointmentsToday / $maxAppointments) * 100 }}%;"></div>
        </div>
    </div>

    <h4 class="text-2xl font-bold mb-6 text-gray-800"> Appointments Status links</h4>

    <!-- status routes -->
    <div class="flex gap-2 mb-6">
        <a href="{{ route('admin.appointments') }}" class="bg-orange-400 text-white px-4 py-2 rounded">Pending</a>
        <a href="{{ route('admin.appointments.approved') }}" class="bg-orange-600 text-white px-4 py-2 rounded">Approved</a>
        <a href="{{ route('admin.appointments.rejected') }}" class="bg-gray-700 text-white px-4 py-2 rounded">Rejected</a>
        <a href="{{ route('admin.appointments.all') }}" class="bg-gray-500 text-white px-4 py-2 rounded">All</a>
    </div>


<!-- ✅ Approved Appointments List -->
<div class="space-y-4">
    @foreach ($appointments->where('status', 'approved') as $appointment)
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
                    <span class="px-3 py-1 text-white bg-orange-600 rounded-lg">Approved</span>
                </p>
            </div>
        </div>
    @endforeach
</div>


    
    <!-- ✅ Status Filters -->
    <div class="flex gap-2 mb-6">
        <button class="filter-btn bg-orange-400 text-white px-4 py-2 rounded" data-status="pending">Pending</button>
        <button class="filter-btn bg-orange-600 text-white px-4 py-2 rounded" data-status="approved">Approved</button>
        <button class="filter-btn bg-gray-700 text-white px-4 py-2 rounded" data-status="rejected">Rejected</button>
        <button class="filter-btn bg-gray-500 text-white px-4 py-2 rounded" data-status="all">All</button>
    </div>

    <!-- ✅ Pending Appointments List -->
<div class="space-y-4">
    @foreach ($appointments->where('status', 'pending') as $appointment)
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

            <!-- ✅ Status & Actions -->
            <div class="flex justify-between items-center mt-4">
                <p class="font-semibold">
                    <span class="px-3 py-1 text-white bg-orange-400 rounded-lg">Pending</span>
                </p>

                <div class="flex gap-2">
                    <form action="{{ route('admin.appointments.approve', $appointment) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
                            Approve
                        </button>
                    </form>
                    <form action="{{ route('admin.appointments.reject', $appointment) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded">
                            Reject
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

</div>

@endsection
