@extends('layouts.app')

@section('title', 'Our Services')

@section('content')

<div class=" bg-gray-200 flex flex-col items-center py-6 px-4 md:px-16 relative">        <!-- Image Animation Container -->
        <div class="absolute inset-0 z-0 flex justify-center items-center" id="image-sequence">
            <img src="{{ asset('images/veterinary-service.jpeg') }}" alt="Veterinary Service" class="absolute img-overlay" id="img1">
            <img src="{{ asset('images/grooming-service.jpeg') }}" alt="Grooming Service" class="absolute img-overlay" id="img2">
            <img src="{{ asset('images/emergency-care.jpeg') }}" alt="Emergency Care" class="absolute img-overlay" id="img3">
            <img src="{{ asset('images/award-winning.jpg') }}" alt="Award Winning" class="absolute img-overlay" id="img4">
        </div>
<!-- Header Section -->
<section class="text-center z-10 mb-10" id="header-text" style="opacity: 0;">
    <h1 class="text-3xl md:text-5xl font-bold text-orange-600 mb-4">Compassionate Veterinary and Grooming Services</h1>
    <div class="flex flex-col md:flex-row items-center justify-center gap-4">
        <p class="text-gray-700 text-lg md:text-xl">Every pet receives the care they deserve.</p>
        <a href="{{ route('customer.appointments.create') }}" 
           class="bg-orange-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transform transition-all duration-300 hover:scale-105 flex items-center whitespace-nowrap">
            
            Book Now
        </a>
    </div>
</section>

        <!-- Feature Sections -->
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4 w-full max-w-7xl z-10" id="feature-cards">
            <!-- Veterinary Service -->
            <div class="feature-card">
                <div class="card-img-container">
                    <img src="{{ asset('images/veterinary-service.jpeg') }}" alt="Veterinary Service">
                </div>
                <h2 class="text-2xl font-bold mt-4">Comprehensive Veterinary</h2>
                <p class="text-gray-600 mt-2">Expert medical care for your pet's health and wellness.</p>
            </div>

            <!-- Grooming Service -->
            <div class="feature-card">
                <div class="card-img-container">
                    <img src="{{ asset('images/grooming-service.jpeg') }}" alt="Grooming Service">
                </div>
                <h2 class="text-2xl font-bold mt-4">Professional Grooming</h2>
                <p class="text-gray-600 mt-2">Keeping your pets stylish, clean, and comfortable.</p>
            </div>

            <!-- Emergency Care -->
            <div class="feature-card">
                <div class="card-img-container">
                    <img src="{{ asset('images/emergency-care.jpeg') }}" alt="Emergency Care">
                </div>
                <h2 class="text-2xl font-bold mt-4">Emergency Care</h2>
                <p class="text-gray-600 mt-2">Immediate and reliable emergency services when you need it most.</p>
            </div>

            <!-- Award-Winning Recognition -->
            <div class="feature-card">
                <div class="card-img-container">
                    <img src="{{ asset('images/award-winning.jpg') }}" alt="Award Winning">
                </div>
                <h2 class="text-2xl font-bold mt-4">Best Trusted Pet Care Center</h2>
                <p class="text-gray-600 mt-2">Recognized for our commitment to excellence in Zambales.</p>
            </div>
        </div>
           
</div>
@endsection

<style>
    .feature-card {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        opacity: 0;
        transform: translateY(30px);
        border: 2px solid transparent;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
        border-color: #f97316; /* Orange border on hover (using orange-500) */
    }

    .card-img-container {
        width: 100%;
        height: 180px;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 16px;
    }

    .card-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.5s ease;
    }
    
    .feature-card:hover .card-img-container img {
        transform: scale(1.05);
    }

    .img-overlay {
        width: 50%;
        height: 50%;
        object-fit: cover;
        opacity: 0;
        position: absolute;
        z-index: 1;
        filter: blur(0px);
    }
</style>

<script>document.addEventListener('DOMContentLoaded', function () {
    const images = document.querySelectorAll('.img-overlay');
    const headerText = document.getElementById('header-text');
    const featureCards = document.querySelectorAll('.feature-card');

    // Disable GSAP animations on mobile devices (less than 768px width)
    if (window.innerWidth >= 768) {
        // Create a GSAP timeline for larger screens
        const timeline = gsap.timeline();

        // Step 1: Sequential image animation
        images.forEach((img, index) => {
            timeline.to(img, {
                opacity: 1,
                duration: 1,
                zIndex: index + 1,
                ease: 'power2.inOut'
            });

            if (index > 0) {
                timeline.to(images[index - 1], {
                    filter: 'blur(3px)',
                    opacity: 0.8,
                    duration: 0.8,
                    ease: 'power2.inOut'
                }, "-=0.5");
            }
        });

        // Step 2: Pause for image sequence visibility
        timeline.to({}, { duration: 0.5 });

        // Step 3: Fade in header text
        timeline.to(headerText, {
            opacity: 1,
            duration: 1.5,
            ease: 'power2.out'
        });

        // Step 4: Pause for header visibility
        timeline.to({}, { duration: 1 });

        // Step 5: Reveal feature cards
        timeline.to(featureCards, {
            opacity: 1,
            y: 0,
            duration: 1,
            stagger: 0.5,
            ease: 'power2.out'
        });

        // Step 6: Hide floating images quickly
        timeline.to(images, {
            opacity: 0,
            duration: 0.3,
            ease: 'power1.out'
        }, "-=0.5");
    } else {
        // For mobile devices, make header text and feature cards visible immediately
        headerText.style.opacity = 1;
        featureCards.forEach(card => {
            card.style.opacity = 1;
            card.style.transform = 'translateY(0)';
        });
    }
});
</script>