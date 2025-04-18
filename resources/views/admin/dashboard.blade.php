@extends('layouts.admin')

@section('content')
<div class="container">
    <!-- Header and Slots Tracking in a flex layout -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800 font-[Nunito] mb-4 md:mb-0">Admin Dashboard</h2>
        
        <!-- Max Appointments Update Form -->
        <form action="{{ route('admin.updateMaxAppointments') }}" method="POST" class="bg-white p-4 rounded-lg shadow-md">
            @csrf
            <div class="flex items-center">
                <label class="mr-2 font-semibold">Max Appointments:</label>
                <input 
                    type="number" 
                    name="max_appointments_per_day" 
                    id="maxAppointmentsInput"
                    value="{{ $maxAppointments }}" 
                    min="1" 
                    class="p-2 border rounded w-16 text-center"
                >
                <button 
                    type="submit" 
                    id="updateMaxAppointmentsBtn"
                    class="ml-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors">
                    Update
                </button>
            </div>
        </form>
    </div>
    
    <!-- Slots Tracking -->
    <div class="mb-6 p-5 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg shadow-lg">
        <p class="text-lg font-semibold">Today's Capacity ({{ now()->format('F j, Y') }}):</p>
        <div class="flex items-center justify-between my-2">
            <span class="text-xl font-bold">{{ $acceptedAppointmentsToday }}/{{ $maxAppointments }} slots filled</span>
            <span class="text-sm">{{ ($acceptedAppointmentsToday / $maxAppointments) * 100 }}%</span>
        </div>
        <div class="w-full bg-blue-900/50 rounded-full h-4 mt-2 overflow-hidden">
            <div class="h-4 bg-gradient-to-r from-green-400 to-blue-400 rounded-full" 
                 style="width: {{ ($acceptedAppointmentsToday / $maxAppointments) * 100 }}%;"></div>
        </div>
    </div>
    
    <!-- Stats Section - Three cards in one row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Card 1: Accepted Appointments -->
        <a href="{{ route('admin.appointments', ['status' => 'accepted']) }}" 
           class="bg-gradient-to-br from-emerald-500 to-teal-600 text-white p-5 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-white/80">Today's Accepted</p>
                    <p class="text-2xl font-bold mt-1">{{ $acceptedAppointmentsToday }}</p>
                </div>
                <div class="text-3xl opacity-80">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </a>
        
        <!-- Card 2: Pending Appointments -->
        <a href="{{ route('admin.appointments') }}" 
           class="bg-gradient-to-br from-amber-500 to-orange-600 text-white p-5 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-white/80">Pending Appointments</p>
                    <p class="text-2xl font-bold mt-1">{{ $pendingAppointments }}</p>
                </div>
                <div class="text-3xl opacity-80">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </a>
        
        <!-- Card 3: Upcoming Appointments -->
        <a href="{{ route('admin.appointments', ['status' => 'upcoming']) }}" 
           class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white p-5 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-white/80">Upcoming Appointments</p>
                    <p class="text-2xl font-bold mt-1">{{ $upcomingAppointments }}</p>
                </div>
                <div class="text-3xl opacity-80">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </a>
    </div>
    
    @if ($acceptedAppointmentsToday >= ($maxAppointments ?? 10))
        <div class="bg-gradient-to-r from-red-600 to-red-800 text-white p-4 rounded-lg shadow-md col-span-full mt-4 flex items-center">
            <span class="text-2xl mr-3">⚠️</span>
            <strong>Max Appointments Reached:</strong> No more appointments can be approved today.
        </div>
    @endif

    <!-- Closed Days Management -->
    <h3 class="text-xl font-semibold mb-4 mt-8"> Click to mark a day unavailable</h3>
    <div id="adminCalendar" class="bg-white p-4 rounded-lg shadow-md"></div>
</div>

<!-- FullCalendar.js for Closed Days -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
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