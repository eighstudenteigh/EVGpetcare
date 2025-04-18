@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="bg-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col-reverse md:flex-row items-center justify-between gap-10 py-12 md:py-20">
        
        <!-- Left Column -->
        <div class="md:w-1/2 text-center md:text-left">
            <h1 class="[text-shadow:_0_1px_2px_rgba(0,0,0,0.2)] text-4xl md:text-5xl lg:text-6xl font-heading font-bold leading-tight tracking-tight">
            Caring Hands for Your <span class="text-orange-500">Beloved Pets</span>
          </h1>
          
          <p class="text-lg text-gray-900 mb-8 max-w-md mx-auto md:mx-0">
            Professional pet care clinic and grooming services dedicated to keeping your furry friends happy, healthy, and looking their best.
          </p>
          
          <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4">
            <!-- Location Button -->
            <div class="flex items-center bg-white hover:bg-gray-100 border border-gray-300 rounded-lg px-8 py-4 transition cursor-pointer">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span class="font-medium text-gray-700">Our Locations</span>
            </div>
  
            <!-- Book Button -->
            <a href="{{ route('customer.appointments.create') }}" class="font-bold uppercase tracking-wider px-8 py-4 bg-orange-500 text-white rounded-lg shadow hover:bg-orange-600 transition duration-300">
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
<section class="bg-blue-900 text-white py-20" id="highlight-services min-h-[90vh]">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col lg:flex-row items-center gap-10">
      
      <!-- Image Placeholder (replace src with your image) -->
      <div class="w-full lg:w-1/2">
        <img src="/images/pet-clinic.jpg" alt="Happy pet and vet" class="rounded-2xl shadow-xl w-full object-cover h-80 lg:h-96">
      </div>
  
      <!-- Text Content -->
      <div class="w-full lg:w-1/2 text-center lg:text-left">
        <h2 class="gray-900 text-3xl md:text-4xl font-heading font-bold tracking-tight text-white">
            Tending to Your Pets with <span class="underline decoration-white/30">Passion & Expertise</span>
        </h2>
        <p class="text-lg mb-8 text-orange-100">
          From regular check-ups to emergency surgeries, our experienced team is here to provide complete and compassionate care for your furry family members.
        </p>
        <a href="#services" class="inline-block bg-white text-gray-900  rounded-full shadow font-bold uppercase tracking-wider px-8 py-4 hover:bg-orange-100 transition">
          Explore Our Services
        </a>
      </div>
  
    </div>
  </section>
  

  
          
<!-- Mission & Vision Section -->
<section class="py-20 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-heading font-bold tracking-tight">Our Commitment</h2>
  
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-8">
        <!-- Vision Text -->
        <div class="bg-white p-8 rounded-2xl shadow-md border border-orange-600">
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
        <div class="bg-white p-8 rounded-2xl shadow-md border border-orange-600">
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
        
        
        <!-- Featured Team Member -->
        <div class="bg-gray-50 rounded-xl shadow-sm overflow-hidden mb-8">
            <div class="md:flex">
                <div class="md:w-1/3">
                    <img src="/images/dr.jpg" alt="Dr. Ericko Vien G. Juico" class="h-64 w-full object-cover md:h-full">
                </div>
                <div class="p-8 md:w-2/3">
                    <h3 class="tracking-normal text-2xl font-bold text-gray-900 mb-2">Dr. Ericko Vien G. Juico</h3>
                    <p class="text-orange-500 font-medium mb-4">Founder & Head Veterinarian</p>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        Dr. Juico founded EVG JUICO PET CARE CENTER with a vision to provide exceptional veterinary care to pets in Zambales. With extensive experience in veterinary medicine, Dr. Juico leads our team of professionals committed to the health and well-being of your furry family members.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4">
                    <div class="flex justify-center md:justify-start">
                        <a href="#" class="font-bold uppercase tracking-wider px-8 py-4 bg-orange-500 text-white rounded-lg shadow hover:bg-orange-600 transition duration-300">
                            Meet Our Team
                        </a>
                    </div>
                    <!-- Book Button -->
                    <a href="{{ route('customer.appointments.create') }}" class="font-bold uppercase tracking-wider px-8 py-4 bg-orange-500 text-white rounded-lg shadow hover:bg-orange-600 transition duration-300">
                        Book Appointment
                    </a>
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

</style>

@endsection