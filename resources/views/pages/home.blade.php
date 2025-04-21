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
            
            <button id="openMapButton" class="flex items-center  bg-blue-600 hover:bg-blue-700 rounded-lg px-8 py-4 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-orange-200">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span class="font-bold uppercase tracking-wider text-white ">Visit Us</span>
            </button>
  
            <a href="{{ route('customer.appointments.create') }}" class="font-bold uppercase tracking-wider px-8 py-4 bg-orange-500 text-white rounded-lg shadow hover:bg-gray-600 transition duration-300">
              Book Appointment Now
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

<!-- Map Modal -->
<div id="mapModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden">
  <!-- Backdrop -->
  <div class="fixed inset-0 bg-black bg-opacity-50"></div>
  
  <!-- Modal Container -->
  <div class="relative bg-white rounded-lg shadow-xl w-full max-w-4xl mx-4 max-h-[90vh] overflow-y-auto z-[101]">
    <!-- Modal Content -->
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-semibold text-gray-900">Our Locations</h3>
        <button id="closeModalButton" class="text-gray-400 hover:text-gray-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      
      <!-- Leaflet Map Container -->
      <div id="branchMap" class="w-full h-96 rounded-lg border border-gray-200"></div>
      
      <!-- Location list -->
      <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="p-4 border rounded-lg">
          <h4 class="font-bold">EVG Juico Pet Care Center</h4>
          <p>#1 RH 5 National Hwy, Castillejos, 2208 Zambales</p>
          <p>Phone: 0943-6774256</p>
          <p class="text-sm text-gray-500 mt-1">Mon-Fri: 9am-5pm</p>
          <button data-location-index="0" class="view-on-map mt-2 text-orange-500 hover:text-orange-700 text-sm font-medium">
            View on map
          </button>
        </div>
        <div class="p-4 border rounded-lg">
          <h4 class="font-bold">Evg Juico Pet Care Ilwas</h4>
          <p>Purok 1, Mangan-Vaca, AML Eyeworth Bldg, Subic, Zambales</p>
          <p>Phone: 0968-3079283</p>
          <p class="text-sm text-gray-500 mt-1">Mon-Fri: 9am-5pm</p>
          <button data-location-index="1" class="view-on-map mt-2 text-orange-500 hover:text-orange-700 text-sm font-medium">
            View on map
          </button>
        </div>
      </div>
    </div>
    <div class="bg-gray-50 px-6 py-4 flex justify-end">
      <button id="closeModalButton2" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
        Close
      </button>
    </div>
  </div>
</div>

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
        <p class="text-lg mb-8 text-white">
          From regular check-ups to emergency surgeries, our experienced team is here to provide complete and compassionate care for your furry family members.
        </p>
        <a href="#services" class="inline-block bg-white text-gray-900  rounded-full shadow font-bold uppercase tracking-wider px-8 py-4 hover:bg-blue-600 hover:text-white  transition">
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
                  <img src="{{ asset('images/dr.jpeg') }}" alt="Dr. Ericko Vien G. Juico" class="h-64 w-full object-cover md:h-full">
                </div>
                <div class="p-8 md:w-2/3">
                    <h3 class="tracking-normal text-2xl font-bold text-gray-900 mb-2">Dr. Ericko Vien G. Juico</h3>
                    <p class="text-orange-500 font-medium mb-4">Founder & Head Veterinarian</p>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        Dr. Juico founded EVG JUICO PET CARE CENTER with a vision to provide exceptional veterinary care to pets in Zambales. With extensive experience in veterinary medicine, Dr. Juico leads our team of professionals committed to the health and well-being of your furry family members.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4">
                    <div class="flex justify-center md:justify-start">
                        <a href="{{ route('team') }}" class="font-bold uppercase tracking-wider px-8 py-4 bg-orange-500 text-white rounded-lg shadow hover:bg-gray-600 transition duration-300">
                            Meet Our Team
                        </a>
                    </div>
                    <!-- Book Button -->
                    <a href="{{ route('customer.appointments.create') }}" class="font-bold uppercase tracking-wider px-8 py-4 bg-orange-500 text-white rounded-lg shadow hover:bg-gray-600 transition duration-300">
                        Book Appointment
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Leaflet Resources -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

<!-- Map Modal Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  console.log('DOM fully loaded');
  
  // Get elements
  const mapModal = document.getElementById('mapModal');
  const openMapButton = document.getElementById('openMapButton');
  const closeButtons = document.querySelectorAll('#closeModalButton, #closeModalButton2');
  const viewOnMapButtons = document.querySelectorAll('.view-on-map');

  // Test modal visibility
  console.log('Modal element exists:', !!mapModal);
  console.log('Open button exists:', !!openMapButton);

  // Open modal event listener
  if (openMapButton && mapModal) {
    openMapButton.addEventListener('click', function() {
      console.log('Open button clicked');
      mapModal.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    });
  }

  // Close modal event listeners
  if (closeButtons.length) {
    closeButtons.forEach(button => {
      button.addEventListener('click', function() {
        console.log('Close button clicked');
        mapModal.classList.add('hidden');
        document.body.style.overflow = '';
      });
    });
  }

  // Close when clicking outside
  if (mapModal) {
    mapModal.addEventListener('click', function(e) {
      if (e.target === mapModal) {
        console.log('Clicked outside modal');
        mapModal.classList.add('hidden');
        document.body.style.overflow = '';
      }
    });
  }
});
</script>

<!-- Main Map Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Map variables
  let map = null;
  let markers = [];
  const locations = [
    {
      position: [14.934114511323422, 120.20054795191984],
      title: "EVG Juico Pet Care Center",
      address: "#1 RH 5 National Hwy, Castillejos, 2208 Zambales",
      phone: "0943-6774256",
      hours: "Mon-Fri: 9am-5pm"
    },
    {
      position: [14.904412111173814, 120.22462714251847],
      title: "Evg Juico Pet Care Ilwas",
      address: "Purok 1, Mangan-Vaca, AML Eyeworth Bldg, Subic, Zambales",
      phone: "0968-3079283",
      hours: "Mon-Fri: 9am-5pm"
    }
  ];

  // Initialize map
  function initMap() {
    console.log('Initializing map...');
    if (map) {
      map.invalidateSize();
      return;
    }

    const centerLat = (locations[0].position[0] + locations[1].position[0]) / 2;
    const centerLng = (locations[0].position[1] + locations[1].position[1]) / 2;
    
    map = L.map('branchMap').setView([centerLat, centerLng], 12);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      maxZoom: 18,
    }).addTo(map);
    
    const markersGroup = L.featureGroup().addTo(map);
    
    const customIcon = L.divIcon({
      className: 'custom-marker',
      iconSize: [24, 24],
      iconAnchor: [12, 12],
      popupAnchor: [0, -12]
    });
    
    locations.forEach((location, index) => {
      const marker = L.marker(location.position, {
        icon: customIcon,
        title: location.title
      }).addTo(markersGroup);
      
      marker.bindPopup(`
        <div class="text-sm">
          <h3 class="font-bold">${location.title}</h3>
          <p>${location.address}</p>
          <p>${location.phone}</p>
          <p class="text-gray-500">${location.hours}</p>
        </div>
      `);
      
      markers.push(marker);
    });
    
    map.fitBounds(markersGroup.getBounds(), { padding: [50, 50] });
    console.log('Map initialized');
  }

  // Focus on location
  const viewOnMapButtons = document.querySelectorAll('.view-on-map');
  if (viewOnMapButtons.length) {
    viewOnMapButtons.forEach(button => {
      button.addEventListener('click', function() {
        const index = parseInt(this.getAttribute('data-location-index'));
        if (map && markers[index]) {
          map.setView(markers[index].getLatLng(), 15);
          markers[index].openPopup();
        }
      });
    });
  }

  // Initialize map when modal opens
  const mapModal = document.getElementById('mapModal');
  if (mapModal) {
    const observer = new MutationObserver(function(mutations) {
      mutations.forEach(function(mutation) {
        if (mutation.attributeName === 'class') {
          if (!mapModal.classList.contains('hidden')) {
            setTimeout(initMap, 100);
          }
        }
      });
    });
    
    observer.observe(mapModal, {
      attributes: true,
      attributeFilter: ['class']
    });
  }
});
</script>
@endsection