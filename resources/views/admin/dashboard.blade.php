@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">🐾 Admin Dashboard</h2>
    <!-- 🔹 Slots Tracking -->
    <div class="mb-4 p-3 bg-gray-800 text-white rounded-md">
        <p class="text-lg font-semibold">Today's Capacity  ({{ now()->format('F j, Y') }}): <span class="text-orange-400">{{ $acceptedAppointmentsToday }}/{{ $maxAppointments }} slots filled</span></p>
        <div class="w-full bg-gray-600 rounded-full h-4 mt-2">
            
            <div class="h-4 bg-orange-500 rounded-full" style="width: {{ ($acceptedAppointmentsToday / $maxAppointments) * 100 }}%;"></div>
        </div>
    </div>
    <!-- 🔹 Stats Section -->
    <div class="grid grid-cols-2 gap-4 mb-6">
        @php
            $stats = [
                ['label' => 'Today\'s Accepted Appointments', 'value' => $acceptedAppointmentsToday, 'link' => route('admin.appointments', ['status' => 'accepted'])],
                ['label' => 'Pending Appointments', 'value' => $pendingAppointments, 'link' => route('admin.appointments')],
                ['label' => 'Total Customers', 'value' => $totalCustomers, 'link' => route('admin.customers.index')],
                ['label' => 'Total Pets', 'value' => $totalPets, 'link' => route('admin.pets.index')],
                ['label' => 'Services Offered', 'value' => $totalServices, 'link' => route('admin.services.index')],
            ];
        @endphp
    
        @foreach ($stats as $stat)
            <a href="{{ $stat['link'] }}" 
               class="bg-gray-700 text-white p-4 rounded shadow hover:bg-orange-500 transition duration-300">
                <p><strong>{{ $stat['label'] }}:</strong> {{ $stat['value'] }}</p>
            </a>
        @endforeach
    
        @if ($acceptedAppointmentsToday >= ($maxAppointments ?? 10))
            <div class="bg-red-500 text-white p-2 rounded col-span-2 mt-4">
                <strong>⚠️ Max Appointments Reached:</strong> No more appointments can be approved today.
            </div>
        @endif

        
    </div>
    
    

    <!-- 🔹 Closed Days Management -->
    <h3 class="text-xl font-semibold mb-4">📅 Click to mark a day unavailable</h3>
    <div id="adminCalendar" class="bg-white p-4 rounded shadow"></div>

    <!-- 🔹 Upcoming Appointments -->
    <h3 class="text-xl font-semibold mt-8">🐕 Upcoming Appointments</h3>
<table class="w-full bg-white rounded shadow mt-4">
    <thead class="bg-gray-700 text-white">
        <tr>
            <th class="p-3">#</th>
            <th class="p-3">Pet Name</th>
            <th class="p-3">Owner</th>
            <th class="p-3">Service(s)</th>
            <th class="p-3">Date</th>
            <th class="p-3">Time</th>
            <th class="p-3">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($upcomingAppointments as $index => $appointment)
        <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200 border-b">
            <td class="p-3">{{ $index + 1 }}</td>
    
            <!-- ✅ Pets with Dynamic Type -->
            <td class="p-3">
                @if ($appointment->pets->isNotEmpty())
                    @foreach ($appointment->pets as $pet)
                        <span class="inline-flex items-center">
                            {{ $pet->name }}
                            <span class="ml-1 text-xs text-gray-500">
                                ({{ ucfirst($pet->pivot->pet_type) }})
                            </span>
                        </span><br>
                    @endforeach
                @else
                    <span class="text-red-500 italic">Pet Deleted</span>
                @endif
            </td>
    
            <!-- ✅ Owner -->
            <td class="p-3">{{ $appointment->user->name }}</td>
    
            <!-- ✅ Services -->
            <td class="p-3">
                @if ($appointment->pets->isNotEmpty())
                    @foreach ($appointment->pets as $pet)
                        <strong>{{ $pet->name }}:</strong>
                        @if ($pet->services->isNotEmpty())
                            {{ implode(', ', $pet->services->pluck('name')->toArray()) }}
                        @else
                            <span class="text-gray-500">No services assigned</span>
                        @endif
                        <br>
                    @endforeach
                @else
                    <span class="text-red-500 italic">No services assigned</span>
                @endif
            </td>
    
            <!-- ✅ Date & Time -->
            <td class="p-3">{{ $appointment->appointment_date }}</td>
            <td class="p-3">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
    
            <!-- ✅ Status -->
            <td class="p-3">
                @if ($appointment->status === 'pending')
                    <span class="px-2 py-1 text-yellow-700 bg-yellow-200 rounded">Pending</span>
                @elseif ($appointment->status === 'completed')
                    <span class="px-2 py-1 text-green-700 bg-green-200 rounded">Completed</span>
                @elseif ($appointment->status === 'canceled')
                    <span class="px-2 py-1 text-red-700 bg-red-200 rounded">Canceled</span>
                @else
                    <span class="px-2 py-1 text-gray-700 bg-gray-200 rounded">{{ ucfirst($appointment->status) }}</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
    
</table>


    <!-- 🔹 Update Max Appointments -->
    <form action="{{ route('admin.updateMaxAppointments') }}" method="POST" class="bg-white p-6 rounded shadow my-6">
        @csrf
        <label class="block text-lg font-semibold">Max Appointments Per Day:</label>
        <div class="flex items-center mt-2">
            <input 
                type="number" 
                name="max_appointments_per_day" 
                value="{{ $maxAppointments }}" 
                min="1" 
                class="p-2 border rounded w-20"
            >
            <button 
                type="submit" 
                class="ml-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">
                Update
            </button>
        </div>
    </form>

    <!-- 🔹 Recent Activity Log -->
    <h3 class="text-xl font-semibold mt-8">📋 Recent Activity</h3>
    <ul class="bg-white p-4 rounded shadow mt-4">
        @foreach($recentActivities as $activity)
            <li class="border-b p-3">
                {{ $activity->description }} 
                <span class="text-gray-500">({{ $activity->created_at->format('M d, h:i A') }})</span>
            </li>
        @endforeach
    </ul>
</div>

<!-- 🔹 FullCalendar.js for Closed Days -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>

<script>document.addEventListener('DOMContentLoaded', function() {
    var adminCalendarEl = document.getElementById('adminCalendar');
    
    function loadClosedDays() {
        fetch("{{ route('admin.closed-days.index') }}")
            .then(response => response.json())
            .then(closedDays => {
                renderCalendar(closedDays);
            })
            .catch(error => {
                console.error('Error fetching closed days:', error);
                alert('Failed to load calendar data. Please refresh and try again.');
            });
    }

    function renderCalendar(closedDays) {
        var adminCalendar = new FullCalendar.Calendar(adminCalendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            weekends: false,
            validRange: { start: new Date() },
            events: closedDays,
            dateClick: function(info) {
                const existingEvent = adminCalendar.getEvents().find(event => event.startStr === info.dateStr);

                if (existingEvent) {
                    if (confirm('Re-enable this day?')) {
                        fetch("{{ url('admin/closed-days') }}/" + info.dateStr, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            existingEvent.remove();
                            alert('Day has been re-enabled.');
                            refreshClosedDays(); // ✅ Reload closed days
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to re-enable the day.');
                        });
                    }
                } else {
                    if (confirm('Mark this day as unavailable?')) {
                        fetch("{{ route('admin.closed-days.store') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({ date: info.dateStr })
                        })
                        .then(response => response.json())
                        .then(data => {
                            adminCalendar.addEvent({
                                title: 'Closed',
                                start: info.dateStr,
                                allDay: true,
                                backgroundColor: '#ff4d4d',
                                borderColor: '#ff4d4d'
                            });
                            alert('Day has been marked as unavailable.');
                            refreshClosedDays(); // ✅ Reload closed days
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to mark the day as unavailable.');
                        });
                    }
                }
            }
        });

        adminCalendar.render();
    }

    // ✅ Reload closed days dynamically
    function refreshClosedDays() {
        fetch("{{ route('admin.closed-days.index') }}")
            .then(response => response.json())
            .then(closedDays => {
                var calendar = FullCalendar.getCalendar(adminCalendarEl);
                if (calendar) {
                    calendar.getEvents().forEach(event => event.remove());
                    closedDays.forEach(event => calendar.addEvent(event));
                }
            })
            .catch(error => console.error("Error refreshing closed days:", error));
    }

    // Load closed days on page load
    loadClosedDays();

    // ✅ Update Max Appointments Without Reload
    document.getElementById("updateMaxAppointmentsBtn").addEventListener("click", function() {
        let newMax = document.getElementById("maxAppointmentsInput").value;

        fetch("{{ route('admin.updateMaxAppointments') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ max_appointments_per_day: newMax })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Max Appointments Updated!");
                document.getElementById("currentMaxAppointments").innerText = newMax; // ✅ Update UI dynamically
            } else {
                alert("Failed to update. Please try again.");
            }
        })
        .catch(error => {
            console.error("Error updating max appointments:", error);
            alert("Error updating max appointments.");
        });
    });
});

</script>
@endsection
