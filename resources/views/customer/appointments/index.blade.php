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

                                    <td class="px-4 py-3" rowspan="{{ count($appointment->pets) }}">
                                        @if($appointment->status === 'pending')
                                            <form action="{{ route('customer.appointments.cancel', $appointment->id) }}" method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700">
                                                    Cancel
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs">Not Allowed</span>
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
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                    @if($appointment->status === 'pending')
                        <form action="{{ route('customer.appointments.cancel', $appointment->id) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="w-full px-3 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700">
                                Cancel Appointment
                            </button>
                        </form>
                    @else
                        <div class="text-center text-gray-500 text-sm">
                            No actions available
                        </div>
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

<!-- JavaScript for Mobile Dropdown -->
<script>
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