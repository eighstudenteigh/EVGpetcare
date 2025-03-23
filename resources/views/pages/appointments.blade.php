@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4 text-center">Book an Appointment</h2>
    
    <p class="text-gray-700 text-center mb-6">
        Schedule a veterinary check-up, grooming session, or emergency consultation easily.
    </p>

    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white shadow-md p-4 rounded-lg text-center">
            <h3 class="text-lg font-bold text-blue-500">Veterinary Consultation</h3>
            <p class="text-gray-600">Professional check-ups and treatments for your pets.</p>
            <a href="{{ route('customer.appointments.create') }}" class="inline-block mt-3 bg-blue-500 text-white px-4 py-2 rounded-lg">Book Now</a>
        </div>

        <div class="bg-white shadow-md p-4 rounded-lg text-center">
            <h3 class="text-lg font-bold text-green-500">Grooming Services</h3>
            <p class="text-gray-600">Pamper your pets with our grooming packages.</p>
            <a href="{{ route('customer.appointments.create') }}" class="inline-block mt-3 bg-green-500 text-white px-4 py-2 rounded-lg">Book Now</a>
        </div>

        <div class="bg-white shadow-md p-4 rounded-lg text-center">
            <h3 class="text-lg font-bold text-red-500">Emergency Cases</h3>
            <p class="text-gray-600">We are open for emergency cases until midnight.</p>
            <a href="{{ route('customer.appointments.create') }}" class="inline-block mt-3 bg-red-500 text-white px-4 py-2 rounded-lg">Book Now</a>
        </div>
    </div>

    <p class="text-center mt-6">
        <a href="{{ route('customer.register') }}" class="text-blue-500 underline">Don't have an account? Sign up now</a>
    </p>
</div>
@endsection
