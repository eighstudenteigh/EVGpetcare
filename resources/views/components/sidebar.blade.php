<div class="sidebar">
    <ul>
        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
        
        @if(auth()->user()->role === 'customer')
            <li><a href="{{ route('customer.appointments.create') }}">Book Appointment</a></li>
            <li><a href="{{ route('customer.pets.index') }}">My Pets</a></li>
        @endif
        
        @if(auth()->user()->role === 'admin')
            <li><a href="{{ route('admin.appointments') }}">Appointments</a></li>
            <li><a href="{{ route('admin.customers.index') }}">Customers</a></li>
            <li><a href="{{ route('admin.pets.index') }}">Pets</a></li>
            <li><a href="{{ route('admin.services') }}">Services</a></li>
            <li><a href="{{ route('admin.closed-days.index') }}">Closed Days</a></li>
        @endif
    </ul>
</div>
