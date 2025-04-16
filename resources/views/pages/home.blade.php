@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="bg-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col-reverse md:flex-row items-center justify-between gap-10 py-12 md:py-20">
        
        <!-- Left Column -->
        <div class="md:w-1/2 text-center md:text-left">
          <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight mb-6">
            Caring Hands for Your <span class="text-orange-500">Beloved Pets</span>
          </h1>
          
          <p class="text-lg text-gray-600 mb-8 max-w-md mx-auto md:mx-0">
            Professional pet care clinic and grooming services dedicated to keeping your furry friends happy, healthy, and looking their best.
          </p>
          
          <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4">
            <!-- Location Button -->
            <div class="flex items-center bg-white hover:bg-gray-100 border border-gray-300 rounded-lg px-4 py-3 transition cursor-pointer">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span class="font-medium text-gray-700">Our Locations</span>
            </div>
  
            <!-- Book Button -->
            <a href="{{ route('customer.appointments.create') }}" class="px-6 py-3 bg-orange-500 text-white font-semibold rounded-lg shadow hover:bg-orange-600 transition duration-300">
              Book Appointment
            </a>
          </div>
        </div>
  
        <!-- Right Column (Image) -->
        <div class="md:w-1/2" min-h-[86vh]>
          <img src="{{ asset('images/hero image cat.jpg') }}" alt="Pet Care Hero Image" class="rounded-xl shadow-lg w-full h-auto object-cover max-h-[86vh]">
        </div>
  
      </div>
    </div>
  </section>
  

<!-- Highlight Services CTA Section -->
<section class="bg-orange-500 text-white py-20" id="highlight-services min-h-[90vh]">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col lg:flex-row items-center gap-10">
      
      <!-- Image Placeholder (replace src with your image) -->
      <div class="w-full lg:w-1/2">
        <img src="/images/pet-clinic.jpg" alt="Happy pet and vet" class="rounded-2xl shadow-xl w-full object-cover h-80 lg:h-96">
      </div>
  
      <!-- Text Content -->
      <div class="w-full lg:w-1/2 text-center lg:text-left">
        <h2 class="text-4xl font-extrabold mb-6 leading-tight ">
          Caring for Your Pets with <span class="underline decoration-white/30">Passion & Expertise</span>
        </h2>
        <p class="text-lg mb-8 text-orange-100">
          From regular check-ups to emergency surgeries, our experienced team is here to provide complete and compassionate care for your furry family members.
        </p>
        <a href="#services" class="inline-block bg-white text-gray-900 font-semibold px-6 py-3 rounded-full shadow hover:bg-orange-100 transition">
          Explore Our Services
        </a>
      </div>
  
    </div>
  </section>
  

{{-- <!-- Why Choose Us Section - Horizontal Layout -->
<section class="py-12 bg-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
            <h2 class="text-5xl font-extrabold text-gray-900 inline-block pb-3 border-b-4 border-orange-400">Why Choose Us</h2>
        <p class="mt-4 text-lg text-gray-900 max-w-2xl mx-auto">
          Trusted care. Compassionate service. Excellence in every visit.
        </p>
      </div>
  
      <!-- Flex Row Layout -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Left: Image -->
        <div class="rounded-2xl overflow-hidden shadow-lg">
          <img src="/mnt/data/490984368_641987588660302_7427716606766130483_n.jpg" alt="Vet Clinic" class="w-full h-auto object-cover">
        </div>
  
        <!-- Right: Text Content -->
        <div>
          <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
            <p class="text-gray-700 text-lg leading-relaxed">
              Founded by Dr. Ericko Vien G. Juico, <strong>EVG Juico Pet Care Center</strong> offers full-service vet care across Zambales. From checkups to life-saving treatment—your pets are family, and we treat them that way.
            </p>
          </div>
  
          <!-- Features -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Licensed Professionals -->
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
              <div class="inline-flex bg-orange-100 p-3 rounded-full mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016..." />
                </svg>
              </div>
              <h3 class="text-md font-semibold text-gray-900">Licensed Professionals</h3>
              <p class="text-sm text-gray-600">Led by three experienced, licensed veterinarians.</p>
            </div>
  
            <!-- Comprehensive Services -->
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
              <div class="inline-flex bg-orange-100 p-3 rounded-full mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2..." />
                </svg>
              </div>
              <h3 class="text-md font-semibold text-gray-900">Comprehensive Services</h3>
              <p class="text-sm text-gray-600">From wellness visits to surgery, we do it all.</p>
            </div>
  
            <!-- Multiple Locations -->
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
              <div class="inline-flex bg-orange-100 p-3 rounded-full mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2..." />
                </svg>
              </div>
              <h3 class="text-md font-semibold text-gray-900">Multiple Locations</h3>
              <p class="text-sm text-gray-600">Now serving Castillejos and Subic areas.</p>
            </div>
  
            <!-- Digital Convenience -->
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
              <div class="inline-flex bg-orange-100 p-3 rounded-full mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01..." />
                </svg>
              </div>
              <h3 class="text-md font-semibold text-gray-900">Digital Convenience</h3>
              <p class="text-sm text-gray-600">Book online. View records anytime, anywhere.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> --}}
  
          
<!-- Mission & Vision Section -->
<section class="py-20 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-4xl font-extrabold text-center text-gray-900 mb-12">Our Commitment</h2>
  
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-8">
        <!-- Vision Text -->
        <div class="bg-white p-8 rounded-2xl shadow-md">
          <h3 class="text-2xl font-semibold text-orange-500 mb-4">Vision</h3>
          <p class="text-gray-700 text-lg leading-relaxed">
            Our veterinary clinic strives for absolute excellence and to rise to such a high level of business and medical excellence, 
            that through education and example, we will inspire our Evg Juico petcare community to care for its pets and people as God intended.
          </p>
        </div>
        <!-- Vision Image -->
        <div class="rounded-2xl overflow-hidden shadow-md  max-h-[38vh]">
          <img src="{{ asset('images/vision.jpg') }}" alt="Vision Image" class="w-full h-full object-cover max-h-[500px]">
        </div>
      </div>
  
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Mission Image -->
        <div class="rounded-2xl overflow-hidden shadow-md  max-h-[38vh]">
          <img src="{{ asset('images/mission.jpg') }}" alt="Mission Image" class="w-full h-full object-cover max-h-[500px]">
        </div>
        <!-- Mission Text -->
        <div class="bg-white p-8 rounded-2xl shadow-md">
          <h3 class="text-2xl font-semibold text-orange-500 mb-4">Mission</h3>
          <p class="text-gray-700 text-lg leading-relaxed">
            Animal Care Clinic is dedicated to exemplary veterinary medicine and patient care, client service and employee well-being; 
            while maintaining honesty, integrity, profitability and community involvement along the way.
          </p>
        </div>
      </div>
    </div>
  </section>
  
  

<!-- Meet Our Team Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Meet Our Team</h2>
            <p class="mt-4 text-xl text-gray-600 max-w-3xl mx-auto">Dedicated professionals committed to your pet's health and happiness</p>
        </div>
        
        <!-- Featured Team Member -->
        <div class="bg-gray-50 rounded-xl shadow-sm overflow-hidden mb-8">
            <div class="md:flex">
                <div class="md:w-1/3">
                    <img src="/images/dr.jpg" alt="Dr. Ericko Vien G. Juico" class="h-64 w-full object-cover md:h-full">
                </div>
                <div class="p-8 md:w-2/3">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Dr. Ericko Vien G. Juico</h3>
                    <p class="text-orange-500 font-medium mb-4">Founder & Head Veterinarian</p>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        Dr. Juico founded EVG JUICO PET CARE CENTER with a vision to provide exceptional veterinary care to pets in Zambales. With extensive experience in veterinary medicine, Dr. Juico leads our team of professionals committed to the health and well-being of your furry family members.
                    </p>
                    <div class="flex justify-center md:justify-start">
                        <a href="#" class="px-6 py-3 bg-orange-500 text-white font-medium rounded-lg shadow-sm hover:bg-orange-600 transition duration-300 text-center">
                            Meet Our Full Team
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .service-carousel {
        position: relative;
        padding: 0 40px;
    }
    .swiper-container {
        overflow: hidden;
    }
    .swiper-slide {
        height: auto;
    }
    .hero-image-container {
        height: 400px;
    }
    @media (min-width: 768px) {
        .hero-image-container {
            height: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the Swiper carousel
        const swiper = new Swiper('.swiper-container', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.next-button',
                prevEl: '.prev-button',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });
    });
</script>
@endsection