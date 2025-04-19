@extends('layouts.app')

@section('title', 'Meet Our Team - EVG Juico Pet Care Center')

@section('content')
<div class="team-page">
    <div class="container py-5">
        <!-- Page Header -->
        <div class="text-center mb-5">
            <h1 class="display-4">Meet Our Team</h1>
            <p class="lead">
                At EVG Juico Pet Care Center, our dedicated team provides compassionate, 
                expert care for your pets. Get to know the faces behind our clinic.
            </p>
        </div>

        <!-- Team Members -->
        <!-- 1. Dr. Mikhail Santiago (Image Left) -->
        <div class="row align-items-center mb-5">
            <div class="col-md-5">
                <img src="{{ asset('images/team/dr-mikhail.jpg') }}" 
                     alt="Dr. Mikhail Santiago" 
                     class="img-fluid rounded shadow">
            </div>
            <div class="col-md-7">
                <h2 class="mb-3">Dr. Mikhail Santiago</h2>
                <p class="text-primary fw-bold">Veterinarian</p>
                <p class="text-muted"><em>Licensed since 2022</em></p>
                <p>
                    A Palawan native, Dr. Santiago earned his degree at Central Luzon State University 
                    and joined EVG Juico as a senior veterinarian. Passionate about surgery and preventive care, 
                    he treats every pet like family. When not at the clinic, he's exploring on his motorcycle.
                </p>
            </div>
        </div>

        <!-- 2. Arnold Villanueva (Image Right) -->
        <div class="row align-items-center mb-5 flex-md-row-reverse">
            <div class="col-md-5">
                <img src="{{ asset('images/team/arnold.jpg') }}" 
                     alt="Arnold Villanueva" 
                     class="img-fluid rounded shadow">
            </div>
            <div class="col-md-7">
                <h2 class="mb-3">Arnold Villanueva</h2>
                <p class="text-primary fw-bold">PCCI-Certified Groomer</p>
                <p class="text-muted"><em>10+ years of experience</em></p>
                <p>
                    A Pangasinan native, Arnold began grooming in Olongapo (2015) and honed his skills 
                    as a vet aide in Zambales. Now PCCI-certified, he blends technical expertise with 
                    gentle care—just as he does for his own pets at home.
                </p>
            </div>
        </div>

        <!-- 3. Wendell Dumalag Villanueva (Image Left) -->
        <div class="row align-items-center mb-5">
            <div class="col-md-5">
                <img src="{{ asset('images/team/wendell.jpg') }}" 
                     alt="Wendell Dumalag Villanueva" 
                     class="img-fluid rounded shadow">
            </div>
            <div class="col-md-7">
                <h2 class="mb-3">Wendell Dumalag Villanueva</h2>
                <p class="text-primary fw-bold">Groomer & Vet Aide</p>
                <p class="text-muted"><em>Dedicated to lifelong learning</em></p>
                <p>
                    From raising livestock in Pangasinan to mastering grooming at EVG Juico, 
                    Wendell's hands-on experience shines in both roles. His patience and diligence 
                    make him a favorite among pets and clients alike.
                </p>
            </div>
        </div>

        <!-- 4. Maylyn Pascual Laluna (Image Right) -->
        <div class="row align-items-center mb-5 flex-md-row-reverse">
            <div class="col-md-5">
                <img src="{{ asset('images/team/maylyn.jpg') }}" 
                     alt="Maylyn Pascual Laluna" 
                     class="img-fluid rounded shadow">
            </div>
            <div class="col-md-7">
                <h2 class="mb-3">Maylyn Pascual Laluna</h2>
                <p class="text-primary fw-bold">Front Desk Staff</p>
                <p class="text-muted"><em>The welcoming voice of EVG Juico</em></p>
                <p>
                    Maylyn ensures every visit starts with a smile. Her organizational skills and 
                    love for animals keep the clinic running smoothly, so pets and owners feel at ease.
                </p>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center py-4 bg-light rounded">
            <h3 class="mb-3">Ready to meet us in person?</h3>
            <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-lg">
                Schedule an Appointment
            </a>
        </div>
    </div>
</div>
@endsection