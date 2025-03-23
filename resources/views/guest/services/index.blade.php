@extends('layouts.app')

@section('title', 'Available Services')

@section('content')
<div class="container mx-auto p-4 sm:p-6">

    <!-- Sidebar for Animal Type Selection (Visible on larger screens) -->
    <div class="flex flex-col sm:flex-row">
        <aside class="sm:w-1/4 p-4 bg-white shadow-md rounded mb-4 sm:mb-0 sm:mr-6 opacity-0" id="sidebar">
            <h3 class="text-lg font-bold mb-3">Filter by Animal Type</h3>
            <div id="animalTypeButtons" class="flex flex-wrap gap-2 sm:flex-col">
                <!-- Buttons for animal types will be dynamically added here -->
            </div>
        </aside>

        <!-- Services Container -->
        <section class="sm:w-3/4 p-4 bg-white shadow-md rounded opacity-0" id="services-section">
            <h3 class="text-lg font-bold mb-3">Available Services</h3>
            <div id="servicesContainer" class="space-y-4">
                <p class="text-center p-3 text-gray-500">Select an animal type to view services.</p>
            </div>

            <!-- Proceed to Booking Button -->
            <div class="mt-4 text-center sm:text-right">
                <a href="{{ route('customer.appointments.create') }}" 
                   class="hidden bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700 transition transform hover:scale-105" 
                   id="bookNowBtn">Proceed to Booking</a>
            </div>
        </section>
    </div>
</div>

<!-- JavaScript for Filtering & Dynamic Data Loading -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Check if GSAP is loaded
        if (typeof gsap === 'undefined') {
            loadGSAP();
        } else {
            initPage();
        }
    });

    function loadGSAP() {
        const gsapScript = document.createElement('script');
        gsapScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js';
        gsapScript.onload = initPage;
        document.body.appendChild(gsapScript);
    }

    function initPage() {
        const servicesContainer = document.getElementById("servicesContainer");
        const bookNowBtn = document.getElementById("bookNowBtn");
        const animalTypeButtons = document.getElementById("animalTypeButtons");
        const sidebar = document.getElementById("sidebar");
        const servicesSection = document.getElementById("services-section");

        // Initial animations
        const tl = gsap.timeline();
        tl.to(sidebar, { opacity: 1, x: 0, duration: 0.6, ease: "power2.out" })
          .to(servicesSection, { opacity: 1, x: 0, duration: 0.6, ease: "power2.out" }, "-=0.3");

        let allServices = [];
        let animalTypes = new Set();
        let activeButton = null;
        let allButtons = []; // Store all buttons for easier reference

        // Fetch all services from the controller
        fetch('/services/all')
            .then(response => response.json())
            .then(data => {
                allServices = data;

                // Extract unique animal types for sidebar buttons
                data.forEach(service => {
                    animalTypes.add(service.animal_type);
                });

                // Create buttons for each animal type with staggered animation
                const buttonTl = gsap.timeline();
                let delay = 0;

                animalTypes.forEach(type => {
                    const button = document.createElement("button");
                    button.innerText = type.charAt(0).toUpperCase() + type.slice(1);
                    // Initial style: gray background with white text
                    button.classList = "animal-toggle px-4 py-2 border rounded bg-gray-700 text-white transition opacity-0";
                    button.setAttribute("data-animal", type);
                    button.addEventListener("click", () => {
                        // Clear all active states first
                        allButtons.forEach(btn => {
                            btn.classList.remove("bg-orange-500");
                            btn.classList.add("bg-gray-700");
                        });
                        
                        // Add active class to clicked button
                        button.classList.remove("bg-gray-700");
                        button.classList.add("bg-orange-500");
                        activeButton = button;
                        
                        filterServices(type);
                    });
                    
                    animalTypeButtons.appendChild(button);
                    allButtons.push(button); // Add to our array for easier reference
                    
                    // Add button reveal animation
                    buttonTl.to(button, { 
                        opacity: 1, 
                        y: 0, 
                        duration: 0.3,
                        delay: delay
                    });
                    delay += 0.1;
                });
            });

        // Filter services by selected animal type
        function filterServices(animalType) {
            const filteredServices = allServices.filter(service => service.animal_type === animalType);
            renderServices(animalType, filteredServices);
        }

        // Render services with animation
        function renderServices(animalType, services) {
            // Fade out current content
            gsap.to(servicesContainer, {
                opacity: 0,
                duration: 0.3,
                onComplete: () => {
                    servicesContainer.innerHTML = "";

                    if (services.length === 0) {
                        servicesContainer.innerHTML = `<p class="text-center p-3 text-gray-500">No services available for ${animalType}.</p>`;
                        bookNowBtn.classList.add("hidden");
                        
                        // Fade in new content
                        gsap.to(servicesContainer, { opacity: 1, duration: 0.3 });
                        return;
                    }

                    let content = `
                        <h4 class="text-xl font-semibold mb-2 p-2 bg-gray-700 text-white rounded">${animalType.charAt(0).toUpperCase() + animalType.slice(1)} Services</h4>
                        <div id="services-list" class="space-y-4"></div>`;
                    
                    servicesContainer.innerHTML = content;
                    const servicesList = document.getElementById("services-list");
                    
                    // Create service elements with staggered animation
                    services.forEach((service, index) => {
                        const serviceElement = document.createElement("div");
                        serviceElement.className = "p-4 border rounded shadow-md bg-gray-50 flex flex-col sm:flex-row sm:justify-between mb-4 opacity-0 service-item";
                        serviceElement.innerHTML = `
                            <div>
                                <h5 class="text-lg font-semibold text-gray-800">${service.name}</h5>
                                <p class="text-gray-700">₱${parseFloat(service.price).toFixed(2)}</p>
                                <p class="text-gray-600">${service.description ? service.description : 'No description available'}</p>
                            </div>
                        `;
                        servicesList.appendChild(serviceElement);
                    });

                    // Show booking button with bounce effect
                    bookNowBtn.classList.remove("hidden");
                    gsap.fromTo(bookNowBtn, 
                        { scale: 0.8, opacity: 0 },
                        { scale: 1, opacity: 1, duration: 0.5, ease: "back.out(1.7)" }
                    );
                    
                    // Fade in container first
                    gsap.to(servicesContainer, { 
                        opacity: 1, 
                        duration: 0.3,
                        onComplete: () => {
                            // Then animate service items with stagger
                            gsap.to(".service-item", {
                                opacity: 1,
                                y: 0,
                                stagger: 0.1,
                                duration: 0.4,
                                ease: "power2.out"
                            });
                        }
                    });
                }
            });
        }
    }
</script>

<style>
    /* Base styles */
    .animal-toggle {
        transition: all 0.3s ease;
        transform: translateY(10px);
    }
    
    .animal-toggle:hover {
        transform: translateY(0);
    }
    
    /* Service item initial state */
    .service-item {
        transform: translateY(20px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .service-item:hover {
        transform: translateY(0);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    /* Book now button animation */
    #bookNowBtn {
        transition: all 0.3s ease;
    }
    
    /* Additional responsive adjustments */
    @media (max-width: 640px) {
        #animalTypeButtons {
            justify-content: center;
        }
        
        /* Ensure buttons have adequate spacing on mobile */
        .animal-toggle {
            margin-bottom: 8px;
            min-width: 80px;
            text-align: center;
        }
    }
</style>
@endsection