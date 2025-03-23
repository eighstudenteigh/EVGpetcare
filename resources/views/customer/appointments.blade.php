@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
<div id="calendar"></div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '{{ route('appointments.index') }}',
            selectable: true,
            select: function(info) {
                window.location.href = '{{ route('appointments.create') }}?date=' + info.startStr;
            }
        });
        calendar.render();
    });
</script>
@endsection
