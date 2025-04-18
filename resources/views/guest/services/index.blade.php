@extends('layouts.app')

@section('title', 'Our Services')

@section('content')
<div class="container mx-auto p-4 sm:p-6">
    <!-- Header -->
    <div class="mb-4 text-center opacity-0" id="page-header">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Our Services</h1>
        <p class="text-gray-600 max-w-2xl mx-auto">Discover the perfect care for your pet</p>
    </div>

    <!-- Services Container -->
    <section class="p-4 bg-white shadow-lg rounded-lg opacity-0" id="services-section">
        <div class="mb-6 p-4 border-orange-400 text-orange-700 rounded">
            <p class="text-sm"><strong>Note:</strong> Prices shown are base rates and may vary depending on your pet's specific needs and condition. Final pricing will be confirmed after examination.</p>
        </div>

        <div id="servicesContainer" class="space-y-6">
            <!-- Placeholder while loading -->
            <div class="text-center py-8">
                <div class="spinner border-4 border-orange-500 border-t-transparent rounded-full w-12 h-12 mx-auto animate-spin"></div>
                <p class="mt-4 text-gray-600">Loading our services...</p>
            </div>
        </div>
    </section>
</div>

<!-- Fixed Book Now Button -->
<div class="fixed bottom-8 right-6 z-50 opacity-0" id="book-now-button">
    <a href="{{ route('customer.appointments.create') }}" 
       class="inline-block bg-orange-600 text-white px-6 py-3 rounded-full hover:bg-orange-700 text-lg shadow-lg transition-transform transform hover:scale-105 flex items-center">
        
        Book now
    </a>
</div>

<!-- JavaScript for Dynamic Data Loading -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    if (typeof gsap === 'undefined') {
        loadGSAP();
    } else {
        initPage();
    }

    function loadGSAP() {
        const gsapScript = document.createElement('script');
        gsapScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js';
        gsapScript.onload = initPage;
        document.body.appendChild(gsapScript);
    }

    function initPage() {
        const servicesContainer = document.getElementById("servicesContainer");
        const pageHeader = document.getElementById("page-header");
        const servicesSection = document.getElementById("services-section");
        const bookNowButton = document.getElementById("book-now-button");

        // Initial animations
        const tl = gsap.timeline();
        tl.to(pageHeader, { opacity: 1, y: 0, duration: 0.6, ease: "back.out(1)" })
          .to(servicesSection, { opacity: 1, y: 0, duration: 0.6, ease: "back.out(1)" }, "-=0.3")
          .to(bookNowButton, { opacity: 1, y: 0, duration: 0.4, ease: "back.out(1)" }, "-=0.2");

        // Fetch services
        fetch('/services/all')
            .then(res => res.json())
            .then(data => {
                servicesContainer.innerHTML = "";

                const servicesByName = {};
                data.forEach(service => {
                    if (!servicesByName[service.name]) {
                        servicesByName[service.name] = {
                            name: service.name,
                            description: service.description,
                            prices: {},
                            animalTypes: []
                        };
                    }
                    servicesByName[service.name].prices[service.animal_type] = service.price;
                    servicesByName[service.name].animalTypes.push(service.animal_type);
                });

                Object.values(servicesByName).forEach(service => renderServiceCard(service));
            })
            .catch(err => {
                console.error('Error:', err);
                servicesContainer.innerHTML = `
                    <div class="text-center p-8 bg-red-50 rounded-lg">
                        <p class="text-red-600 font-medium">Unable to load services at this time.</p>
                        <p class="text-gray-600 mt-2">Please try again later.</p>
                    </div>
                `;
            });

        function renderServiceCard(service) {
            const serviceElement = document.createElement("div");
            serviceElement.className = "service-card p-6 border border-gray-200 border-t-4 border-orange-500 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 opacity-0";

            // Process the description to preserve line breaks
            const formattedDescription = service.description 
                ? service.description.replace(/\n/g, '<br>') 
                : 'Comprehensive care for your pet';

            let priceListHTML = '';
            for (const [animalType, price] of Object.entries(service.prices)) {
                priceListHTML += `
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-700 font-medium">${animalType.charAt(0).toUpperCase() + animalType.slice(1)}</span>
                        <span class="inline-block bg-orange-100 text-orange-800 text-sm px-3 py-1 rounded-full font-semibold">
                            ₱${parseFloat(price).toFixed(2)}
                        </span>
                    </div>
                `;
            }

            const badgesHTML = service.animalTypes.map(type => `
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 mr-1 mb-1">
                    ${type.charAt(0).toUpperCase() + type.slice(1)}
                </span>
            `).join('');

            serviceElement.innerHTML = `
                <div class="mb-3">
                    <h3 class="text-2xl font-bold underline text-gray-800">${service.name}</h3>
                </div>
                <div class="text-gray-700 mb-4 whitespace-pre-line">${formattedDescription}</div>

                <div class="mb-4">
                    <h4 class="text-sm font-semibold text-orange-600 mb-2 uppercase tracking-wide">Available For</h4>
                    <div class="flex flex-wrap">
                        ${badgesHTML}
                    </div>
                </div>

                <div class="bg-white p-4 rounded-lg mb-4 shadow-inner">
                    <h4 class="text-sm font-medium text-gray-600 mb-2">Pricing</h4>
                    ${priceListHTML}
                    <p class="text-xs text-gray-500 mt-2">*Prices may vary based on specific needs</p>
                </div>
            `;

            servicesContainer.appendChild(serviceElement);

            gsap.to(serviceElement, {
                opacity: 1,
                y: 0,
                duration: 0.4,
                delay: 0.1 * Array.from(servicesContainer.children).length,
                ease: "power2.out"
            });
        }
    }
});
</script>

<style>
    .spinner {
        border-top-color: transparent;
    }

    .service-card {
        transform: translateY(20px);
        transition: all 0.3s ease;
    }

    .service-card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-color: rgba(249, 115, 22, 0.3);
    }

    @media (min-width: 640px) {
        #servicesContainer {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .service-card {
            margin-bottom: 0;
        }
    }

    .prose {
        max-width: 100%;
    }

    .prose p {
        margin-bottom: 0.75rem;
        text-align: justify;
        text-justify: inter-word;
    }

    #book-now-button {
        transform: translateY(20px);
    }
</style>
@endsection