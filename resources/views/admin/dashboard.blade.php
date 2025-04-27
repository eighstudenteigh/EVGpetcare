@extends('layouts.admin')

@section('content')
<div class="container">
    <!-- Header and Slots Tracking in a flex layout -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800 font-[Nunito] mb-4 md:mb-0">Admin Dashboard</h2>
        
        <!-- Max Appointments Update Form -->
        <form action="{{ route('admin.updateMaxAppointments') }}" method="POST" class="bg-gray-100 p-4 rounded-lg shadow-md">
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
                    class="ml-2 bg-orange-500 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition-colors">
                    Update
                </button>
            </div>
        </form>
    </div>
    

     <!-- 🔹 Slots Tracking -->
   <div class="mb-4 p-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-md">
    <p class="text-lg font-semibold">Today's Capacity ({{ now()->format('F j, Y') }}): 
        <span class="">{{ $acceptedAppointmentsToday }}/{{ $maxAppointments }} slots filled</span>
    </p>
        <div class="w-full bg-gray-300 rounded-full h-4 mt-2">
            <div class="h-4 bg-gradient-to-r from-green-400 to-blue-400 rounded-full" style="width: {{ ($acceptedAppointmentsToday / $maxAppointments) * 100 }}%;"></div>
        </div>
    </div>
    
    <!-- Stats Section - Three cards in one row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Card 1: Accepted Appointments -->
        <a href="{{ route('admin.appointments', ['status' => 'accepted']) }}" 
            class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white p-5 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
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
                    <p class="text-2xl font-bold mt-1">{{ $upcomingAppointmentsCount }}</p>
                </div>
                <div class="text-3xl opacity-80">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </a>
            
        @if ($acceptedAppointmentsToday >= ($maxAppointments ?? 10))
            <div class="bg-gradient-to-r from-red-600 to-red-800 text-white p-4 rounded-lg shadow-md col-span-full mt-4 flex items-center">
                <span class="text-2xl mr-3">⚠️</span>
                <strong>Max Appointments Reached:</strong> No more appointments can be approved today.
            </div>
        @endif
    </div>

    <!-- Closed Days Management -->
    <h3 class="text-xl font-semibold mb-4 mt-8">Click to mark a day unavailable</h3>
    <div id="adminCalendar" class="bg-white p-4 rounded-lg shadow-md"></div>
</div>

<!-- FullCalendar.js  -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<style>
    .fc-daygrid-day-frame {
        position: relative;
    }

    .fc-daygrid-day-number {
    position: absolute !important;
    top: 50% !important;
    left: 50% !important;
   
    font-size: 1.4rem !important;
    
    color: #1e293b !important;
}
.fc-daygrid-event {
    display: none !important;
}
    .appointment-count-badge {
    position: absolute;
    top: 4px;
    right: 4px;
    background: #3B82F6;
    color: white;
    border-radius: 50%;
    min-width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px%;
    z-index: 10;
    padding: 0 2px;
    font-weight: bold;
}
.fc-daygrid-day-top {
    position: relative;
}

    .closed-day .fc-daygrid-day-number {
        color: #FF0000;
        text-decoration: line-through;
    }
    
    #adminCalendar {
        max-width: 100%;
        height: 600px;
        margin: 0 auto;
    }
    
    .fc-day-disabled .appointment-count-badge {
    background: #FF0000;
    }
    
    .fc-day-past:not(.fc-day-disabled) {
        background-color: #f8f9fa;
    }
    
    .fc-toolbar-title {
        font-size: 1.25rem;
        font-weight: 600;
    }
    
    .fc-button {
        background-color: #3b82f6 !important;
        border-color: #3b82f6 !important;
    }
    
    .fc-button:hover {
        background-color: #2563eb !important;
        border-color: #2563eb !important;
    }
    .closed-day .fc-daygrid-day-number {
        color: #FF0000;
        text-decoration: line-through;
    }

    
    .fc-daygrid-day.closed-day {
        background-color: #fee2e2 !important; /* Light red */
        position: relative;
        cursor: not-allowed;
    }

    .fc-daygrid-day.closed-day:hover {
        background-color: #fca5a5 !important; 
    }

    .closed-day .fc-daygrid-day-number {
        color: #b91c1c !important;
        font-weight: bold;
        text-decoration: line-through;
    }
    .fc-daygrid-day.closed-day::after {
        content: '🔒';
        position: absolute;
        top: 4px;
        right: 4px;
        font-size: 1rem;
        color: #991b1b;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var adminCalendarEl = document.getElementById('adminCalendar');
    
    function loadCalendarData() {
        fetch("{{ route('admin.dashboard.calendar-data') }}")
            .then(response => response.json())
            .then(events => {
                renderCalendar(events);
            })
            .catch(error => {
                console.error('Error fetching calendar data:', error);
                alert('Failed to load calendar data. Please refresh and try again.');
            });
    }

    function renderCalendar(events) {
        var adminCalendar = new FullCalendar.Calendar(adminCalendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            weekends: false,
            validRange: { start: new Date() },
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                
            },
            events: events,
            dayCellClassNames: function(arg) {
                if (arg.date < new Date()) {
                    return ['fc-day-past'];
                }
            },
            eventDidMount: function(info) {
                // For approved appointment counts
                if (info.event.extendedProps && info.event.extendedProps.count) {
                    const dayEl = info.el.closest('.fc-daygrid-day');
                    if (dayEl) {
                        const badge = document.createElement('span');
                        badge.className = 'appointment-count-badge';
                        badge.innerText = info.event.extendedProps.count;
                        dayEl.querySelector('.fc-daygrid-day-top').appendChild(badge);
                    }
                }
                
                // For closed days
                if (info.event.title === 'Closed') {
                    const dayEl = info.el.closest('.fc-daygrid-day');
                    if (dayEl) {
                        dayEl.classList.add('closed-day');
                    }
                }
            }, 
            dateClick: function(info) {
                // Prevent actions on past dates
                if (info.date < new Date()) {
                    return;
                }

                const existingEvent = adminCalendar.getEvents().find(event => 
                    event.startStr === info.dateStr && event.title.includes('Closed')
                );

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
                            // Remove all classes and styling related to closed days
                            info.dayEl.classList.remove('closed-day');
                            info.dayEl.classList.remove('fc-day-disabled');
                            
                            // Remove the lock emoji if it exists
                            const lockEmoji = info.dayEl.querySelector('.fc-daygrid-day-frame::after');
                            if (lockEmoji) {
                                lockEmoji.remove();
                            }
                            
                            // Reset the day number styling
                            const dayNumber = info.dayEl.querySelector('.fc-daygrid-day-number');
                            if (dayNumber) {
                                dayNumber.style.color = '';
                                dayNumber.style.textDecoration = '';
                            }
                            
                            // Fully refresh the day's appearance
                            adminCalendar.refetchEvents();
                            
                            alert('Day has been re-enabled.');
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
                            info.dayEl.classList.add('closed-day');
                            alert('Day has been marked as unavailable.');
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

    // Call the function to load calendar data
    loadCalendarData();

    // Update Max Appointments Without Reload
    document.getElementById("updateMaxAppointmentsBtn").addEventListener("click", function(e) {
        e.preventDefault();
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
            } else {
                alert("Failed to update. Please try again.");
            }
        })
        .catch(error => {
            console.error("Error updating max appointments:", error);
            alert("Error updating max appointments.");
        });
    });
});</script>
@endsection