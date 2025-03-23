@extends('layouts.admin')

@section('content')
<h2>Closed Days Management</h2>

<!-- Add New Closed Day -->
<form action="{{ route('admin.closed-days.store') }}" method="POST">
    @csrf
    <label for="date">Select a Date:</label>
    <input type="date" name="date" required>
    <button type="submit">Add Closed Day</button>
</form>

<!-- Closed Days List -->
<h3>Closed Days</h3>
<ul>
    @foreach ($closedDays as $day)
        <li>{{ $day }} 
            <form action="{{ route('admin.closed-days.destroy', $day) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit">Remove</button>
            </form>
        </li>
    @endforeach
</ul>

<!-- Auto-Closed Weekends -->
<h3>Weekends (Auto-Closed)</h3>
<ul>
    @foreach ($weekendDays as $weekend)
        <li>{{ $weekend }}</li>
    @endforeach
</ul>
@endsection
