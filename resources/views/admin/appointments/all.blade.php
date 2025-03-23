@extends('layouts.admin')

@section('title', 'All Appointments')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">📋 All Appointments</h2>

    <!-- 🔹 Status Filters (Navigation) -->
    <div class="flex gap-2 mb-6">
        <a href="{{ route('admin.appointments') }}" class="bg-orange-400 text-white px-4 py-2 rounded">Pending</a>
        <a href="{{ route('admin.appointments.approved') }}" class="bg-orange-600 text-white px-4 py-2 rounded">Approved</a>
        <a href="{{ route('admin.appointments.rejected') }}" class="bg-gray-700 text-white px-4 py-2 rounded">Rejected</a>
        <a href="{{ route('admin.appointments.all') }}" class="bg-gray-500 text-white px-4 py-2 rounded">All</a>
    </div>

    <!-- 🔹 Filtering Options -->
    <form method="GET" class="mb-6 flex gap-4">
        <select name="status" class="p-2 border rounded">
            <option value="">Filter by Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>

        <select name="sort_by" class="p-2 border rounded">
            <option value="">Sort by</option>
            <option value="appointment_date" {{ request('sort_by') == 'appointment_date' ? 'selected' : '' }}>Date</option>
            <option value="user_name" {{ request('sort_by') == 'user_name' ? 'selected' : '' }}>Owner Name</option>
            <option value="pet_name" {{ request('sort_by') == 'pet_name' ? 'selected' : '' }}>Pet Name</option>
        </select>

        <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded">Apply</button>
    </form>

    <!-- ✅ Appointments List -->
    <div class="space-y-4">
        @foreach ($appointments as $appointment)
            <div class="bg-white shadow rounded-lg p-4 border border-gray-300">
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
                        @if ($appointment->status == 'pending')
                            <span class="px-3 py-1 text-white bg-orange-400 rounded-lg">Pending</span>
                        @elseif ($appointment->status == 'approved')
                            <span class="px-3 py-1 text-white bg-orange-600 rounded-lg">Approved</span>
                        @elseif ($appointment->status == 'rejected')
                            <span class="px-3 py-1 text-white bg-gray-700 rounded-lg">Rejected</span>
                        @endif
                    </p>

                    <!-- ✅ Actions for Pending Appointments -->
                    @if ($appointment->status == 'pending')
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
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $appointments->links() }}
    </div>
</div>
@endsection
