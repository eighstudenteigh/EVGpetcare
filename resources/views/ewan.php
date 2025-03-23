@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Admin dashdash Dashboard</h2>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gray-800 text-white p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold">Total Appointments</h3>
            <p class="text-3xl font-bold">{{ $totalAppointments }}</p>
        </div>
        <div class="bg-yellow-500 text-white p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold">Pending Approvals</h3>
            <p class="text-3xl font-bold">{{ $pendingApprovals }}</p>
        </div>
        <div class="bg-green-500 text-white p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold">Registered Customers</h3>
            <p class="text-3xl font-bold">{{ $totalCustomers }}</p>
        </div>
        <div class="bg-blue-500 text-white p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold">Available Slots Today</h3>
            <p class="text-3xl font-bold">{{ $availableSlots }}</p>
        </div>
    </div>
@endsection
