@extends('layouts.app')

@section('title', 'Meet Our Team')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="text-center mb-16">
        <h1 class="text-5xl md:text-6xl font-bold text-gray-800 mb-6">Meet Our Team</h1>
        <p class="text-2xl md:text-3xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
            At EVG Juico Pet Care Center, our dedicated team provides compassionate, 
            expert care for your pets. Get to know the faces behind our clinic.
        </p>
    </div>

    <!-- Team Members -->
<!-- 1. Dr. Mikhail Santiago (Image Left) -->
<div class="flex flex-col md:flex-row items-center mb-16 gap-8">
    <div class="w-full md:w-5/12">
        <img src="{{ asset('images/dr-mikhail.jpg') }}" 
             alt="Dr. Mikhail Santiago" 
             class="w-full h-96 object-cover rounded-lg shadow-md">
    </div>
    <div class="w-full md:w-7/12">
        <h2 class="text-4xl lg:text-5xl font-semibold text-gray-800 mb-3">Dr. Mikhail Santiago</h2>
        <p class="text-xl lg:text-2xl text-blue-600 font-medium mb-1">Veterinarian</p>
        <p class="text-lg lg:text-xl text-gray-500 italic mb-6">Licensed since 2022</p>
        <p class="text-xl lg:text-2xl text-gray-700 leading-relaxed">
            A Palawan native, Dr. Santiago earned his degree at Central Luzon State University 
            and joined EVG Juico as a senior veterinarian. Passionate about surgery and preventive care, 
            he treats every pet like family. When not at the clinic, he's exploring on his motorcycle.
        </p>
    </div>
</div>

<!-- 2. Arnold Villanueva (Image Right) -->
<div class="flex flex-col md:flex-row-reverse items-center mb-16 gap-8">
    <div class="w-full md:w-5/12">
        <img src="{{ asset('images/arnold.jpg') }}" 
             alt="Arnold Villanueva" 
             class="w-full h-96 object-cover rounded-lg shadow-md">
    </div>
    <div class="w-full md:w-7/12">
        <h2 class="text-4xl lg:text-5xl font-semibold text-gray-800 mb-3">Arnold Villanueva</h2>
        <p class="text-xl lg:text-2xl text-blue-600 font-medium mb-1">PCCI-Certified Groomer</p>
        <p class="text-lg lg:text-xl text-gray-500 italic mb-6">10+ years of experience</p>
        <p class="text-xl lg:text-2xl text-gray-700 leading-relaxed">
            A Pangasinan native, Arnold began grooming in Olongapo (2015) and honed his skills 
            as a vet aide in Zambales. Now PCCI-certified, he blends technical expertise with 
            gentle care—just as he does for his own pets at home.
        </p>
    </div>
</div>

<!-- 3. Wendell Dumalag Villanueva (Image Left) -->
<div class="flex flex-col md:flex-row items-center mb-16 gap-8">
    <div class="w-full md:w-5/12">
        <img src="{{ asset('images/wendell.jpg') }}" 
             alt="Wendell Dumalag Villanueva" 
             class="w-full h-96 object-cover rounded-lg shadow-md">
    </div>
    <div class="w-full md:w-7/12">
        <h2 class="text-4xl lg:text-5xl font-semibold text-gray-800 mb-3">Wendell Dumalag Villanueva</h2>
        <p class="text-xl lg:text-2xl text-blue-600 font-medium mb-1">Groomer & Vet Aide</p>
        <p class="text-lg lg:text-xl text-gray-500 italic mb-6">Dedicated to lifelong learning</p>
        <p class="text-xl lg:text-2xl text-gray-700 leading-relaxed">
            From raising livestock in Pangasinan to mastering grooming at EVG Juico, 
            Wendell's hands-on experience shines in both roles. His patience and diligence 
            make him a favorite among pets and clients alike.
        </p>
    </div>
</div>

<!-- 4. Maylyn Pascual Laluna (Image Right) -->
<div class="flex flex-col md:flex-row-reverse items-center mb-16 gap-8">
    <div class="w-full md:w-5/12">
        <img src="{{ asset('images/maylyn.jpg') }}" 
             alt="Maylyn Pascual Laluna" 
             class="w-full h-96 object-cover rounded-lg shadow-md">
    </div>
    <div class="w-full md:w-7/12">
        <h2 class="text-4xl lg:text-5xl font-semibold text-gray-800 mb-3">Maylyn Pascual Laluna</h2>
        <p class="text-xl lg:text-2xl text-blue-600 font-medium mb-1">Front Desk Staff</p>
        <p class="text-lg lg:text-xl text-gray-500 italic mb-6">The welcoming voice of EVG Juico</p>
        <p class="text-xl lg:text-2xl text-gray-700 leading-relaxed">
            Maylyn ensures every visit starts with a smile. Her organizational skills and 
            love for animals keep the clinic running smoothly, so pets and owners feel at ease.
        </p>
    </div>
</div>

    <!-- CTA Section -->
    <div class="bg-gray-100 rounded-xl p-8 text-center">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Ready to meet us in person?</h3>
        <a href="{{ route('customer.appointments.create') }}" 
           class="inline-block bg-orange-500 text-white font-bold py-2  hover:bg-gray-600   px-6 rounded-lg transition-colors duration-300">
            Schedule an Appointment
        </a>
    </div>
</div>
@endsection