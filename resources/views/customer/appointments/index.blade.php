@extends('layouts.customer')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
    <h2 class="text-2xl sm:text-3xl font-bold text-gray-700 mb-6">My Appointments</h2>

    <!-- Book New Appointment Button -->
    <div class="flex justify-end mb-4">
        @if($petsCount === 0)
            <div class="text-center">
                <a href="#" 
                class="px-6 bg-orange-500 text-white hover:bg-gray-600 transition-colors font-bold py-2 rounded opacity-50 cursor-not-allowed"
                aria-disabled="true" tabindex="-1">
                    Book New Appointment
                </a>
                <p class="text-sm text-gray-400 mt-2">You need to register at least one pet to book an appointment.</p>
            </div>
        @else
            <a href="{{ route('customer.appointments.create') }}" 
            class="px-6 bg-orange-500 text-white font-bold py-2 rounded hover:bg-gray-600 transition-colors">
                Book New Appointment
            </a>
        @endif
    </div>

    <!-- Filter Section -->
<div class="mb-6 bg-white p-4 rounded-lg shadow">
    <h3 class="font-semibold text-lg mb-4">Filter Appointments</h3>
    <form method="GET" action="{{ route('customer.appointments.index') }}">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm rounded-md">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <!-- Date Range Filter -->
            <div>
                <label for="date_range" class="block text-sm font-medium text-gray-700">Date Range</label>
                <select id="date_range" name="date_range" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm rounded-md">
                    <option value="upcoming" {{ request('date_range') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="past" {{ request('date_range') == 'past' ? 'selected' : '' }}>Past</option>
                    <option value="custom" {{ request('date_range') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                </select>
            </div>

            <!-- Custom Date Range Fields (hidden by default) -->
            <div id="custom_date_range" class="md:col-span-2 {{ request('date_range') != 'custom' ? 'hidden' : '' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm rounded-md">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm rounded-md">
                    </div>
                </div>
            </div>

            <!-- Pet Filter -->
            <div>
                <label for="pet_id" class="block text-sm font-medium text-gray-700">Pet</label>
                <select id="pet_id" name="pet_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm rounded-md">
                    <option value="all">All Pets</option>
                    @foreach($pets as $pet)
                        <option value="{{ $pet->id }}" {{ request('pet_id') == $pet->id ? 'selected' : '' }}>{{ $pet->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Service Filter -->
            <div>
                <label for="service_id" class="block text-sm font-medium text-gray-700">Service</label>
                <select id="service_id" name="service_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm rounded-md">
                    <option value="all">All Services</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-4 flex justify-end space-x-3">
            <a href="{{ route('customer.appointments.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                Reset Filters
            </a>
            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                Apply Filters
            </button>
        </div>
    </form>
</div>

    <!-- Desktop Table -->
    <div class="hidden sm:block shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">Pet</th>
                        <th class="px-4 py-3 text-left">Service(s)</th>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Time</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($appointments as $appointment)
                        @foreach ($appointment->pets as $index => $pet)
                            <tr class="border-b appointment-row bg-white hover:bg-gray-200 transition" data-appointment-id="{{ $appointment->id }}">
                                <!-- Pet Column -->
                                <td class="px-4 py-3 font-semibold text-gray-800">
                                    {{ $pet->name }} ({{ ucfirst($pet->type) }})
                                </td>

                                <!-- Services Column -->
                                <td class="px-4 py-3 text-gray-600">
                                    @php
                                        $servicesForPet = DB::table('appointment_service')
                                            ->where('appointment_id', $appointment->id)
                                            ->where('pet_id', $pet->id)
                                            ->join('services', 'appointment_service.service_id', '=', 'services.id')
                                            ->pluck('services.name')
                                            ->implode(', ');
                                    @endphp
                                    {{ $servicesForPet ?: 'No services selected' }}
                                </td>

                                <!-- Date, Time, Status, Actions -->
                                @if ($index === 0)
                                    <td class="px-4 py-3 text-gray-600" rowspan="{{ count($appointment->pets) }}">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-600" rowspan="{{ count($appointment->pets) }}">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                    </td>

                                    <td class="px-4 py-3" rowspan="{{ count($appointment->pets) }}">
                                        <span class="px-2 py-1 text-sm font-bold rounded 
                                            {{ $appointment->status === 'approved' ? 'bg-green-300 text-green-800' : '' }}
                                            {{ $appointment->status === 'pending' ? 'bg-yellow-300 text-yellow-800' : '' }}
                                            {{ $appointment->status === 'rejected' ? 'bg-red-300 text-red-800' : '' }}
                                            {{ $appointment->status === 'completed' ? 'bg-blue-300 text-blue-800' : '' }}
                                            {{ $appointment->status === 'finalized' ? 'bg-blue-700 text-white'  : '' }}"> 
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 space-x-2" rowspan="{{ count($appointment->pets) }}">
                                        <!-- View Button -->
                                        <a href="{{ route('customer.appointments.show', $appointment->id) }}" 
                                           class="px-3 py-1 text-xs font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                            View
                                        </a>
                                        
                                        @if($appointment->status === 'pending')
                                            <!-- Cancel Button -->
                                            <form action="{{ route('customer.appointments.cancel', $appointment->id) }}" method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to cancel this appointment?');"
                                                  class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No appointments found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="sm:hidden space-y-4">
        @forelse ($appointments as $appointment)
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <!-- Appointment Header -->
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                            </div>
                        </div>
                        <div>
                            @if ($appointment->status == 'pending')
                                <span class="px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-200 rounded-lg">
                                    Pending
                                </span>
                            @elseif ($appointment->status == 'approved')
                                <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded-lg">
                                    Approved
                                </span>
                            @elseif ($appointment->status == 'rejected')
                                <span class="px-3 py-1 text-xs font-semibold text-red-800 bg-red-200 rounded-lg">
                                    Rejected
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Pets List -->
                <div class="divide-y divide-gray-200">
                    @foreach ($appointment->pets as $pet)
                        <div class="pet-item">
                            <!-- Pet Header (always visible) -->
                            <div 
                                class="bg-white px-4 py-3 flex justify-between items-center cursor-pointer"
                                onclick="togglePetServices('pet-services-{{ $appointment->id }}-{{ $pet->id }}')">
                                <div class="font-medium text-gray-800">
                                    {{ $pet->name }} ({{ ucfirst($pet->type) }})
                                </div>
                                <div class="text-gray-500">
                                    <svg class="w-5 h-5 transform transition-transform pet-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Pet Services (collapsible) -->
                            <div id="pet-services-{{ $appointment->id }}-{{ $pet->id }}" class="hidden px-4 py-3 bg-gray-700 text-sm">
                                <div class="mb-2">
                                    <span class="font-medium text-white">Services:</span>
                                    @php
                                        $servicesForPet = DB::table('appointment_service')
                                            ->where('appointment_id', $appointment->id)
                                            ->where('pet_id', $pet->id)
                                            ->join('services', 'appointment_service.service_id', '=', 'services.id')
                                            ->pluck('services.name')
                                            ->implode(', ');
                                    @endphp
                                    <span class="text-gray-100">{{ $servicesForPet ?: 'No services selected' }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Appointment Footer with Actions -->
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                    <!-- View Button -->
                    <a href="{{ route('customer.appointments.show', $appointment->id) }}" 
                       class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        View Details
                    </a>
                    
                    @if($appointment->status === 'pending')
                        <!-- Cancel Button -->
                        <form action="{{ route('customer.appointments.cancel', $appointment->id) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700">
                                Cancel
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                No appointments found.
            </div>
        @endforelse
    </div>
</div>
<style>
    .filter-section {
    transition: all 0.3s ease;
}

.filter-option {
    min-width: 200px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .filter-grid {
        grid-template-columns: 1fr;
    }
}
</style>    
<!-- JavaScript for Mobile Dropdown -->
<script>
    // Show/hide custom date range fields
    document.getElementById('date_range').addEventListener('change', function() {
        const customDateRangeDiv = document.getElementById('custom_date_range');
        if (this.value === 'custom') {
            customDateRangeDiv.classList.remove('hidden');
        } else {
            customDateRangeDiv.classList.add('hidden');
        }
    });

    // Initialize the date fields if custom is selected
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('date_range').value === 'custom') {
            document.getElementById('custom_date_range').classList.remove('hidden');
        }
        
        // Set default dates for custom range if not set
        if (!document.getElementById('start_date').value) {
            document.getElementById('start_date').value = new Date().toISOString().split('T')[0];
        }
        if (!document.getElementById('end_date').value) {
            let endDate = new Date();
            endDate.setMonth(endDate.getMonth() + 1);
            document.getElementById('end_date').value = endDate.toISOString().split('T')[0];
        }
    });
    function togglePetServices(elementId) {
        const serviceDiv = document.getElementById(elementId);
        const parentElement = serviceDiv.previousElementSibling;
        const arrowIcon = parentElement.querySelector('.pet-icon');
        
        if (serviceDiv) {
            serviceDiv.classList.toggle("hidden");
            arrowIcon.classList.toggle("rotate-180");
        }
    }

    // Desktop: Hover entire appointment row
    document.addEventListener("DOMContentLoaded", function () {
        const appointmentRows = document.querySelectorAll(".appointment-row");

        appointmentRows.forEach(row => {
            row.addEventListener("mouseenter", function () {
                let appointmentId = this.getAttribute("data-appointment-id");
                document.querySelectorAll(`[data-appointment-id="${appointmentId}"]`).forEach(r => {
                    r.classList.add("bg-gray-100");
                });
            });

            row.addEventListener("mouseleave", function () {
                let appointmentId = this.getAttribute("data-appointment-id");
                document.querySelectorAll(`[data-appointment-id="${appointmentId}"]`).forEach(r => {
                    r.classList.remove("bg-gray-100");
                });
            });
        });
    });
</script>
@endsection