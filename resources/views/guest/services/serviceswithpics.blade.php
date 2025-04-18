@extends('layouts.app') 

@section('title', 'Available Services')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-12 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Our Pet Services</h1>
        <p class="text-gray-600 max-w-2xl mx-auto">Discover the perfect care for your pet</p>
    </div>

    <!-- Services Navigation -->
    <div class="sticky top-0 bg-white py-4 z-10 shadow-sm mb-8">
        <div class="flex overflow-x-auto space-x-4 px-2 pb-2 hide-scrollbar" id="servicesNav">
            <!-- Navigation items will be added dynamically -->
        </div>
    </div>

    <!-- Services Sections -->
    <div class="space-y-16" id="servicesSections">
        <div class="text-center py-10">
            <p class="text-gray-500">Loading services...</p>
        </div>
    </div>

    <!-- Fixed Booking Button -->
    <div class="fixed bottom-10 right-6">
        <button class="bg-orange-600 hover:bg-orange-700 text-white font-medium py-3 px-6 rounded-full shadow-lg flex items-center gap-2 transition-all hover:scale-105" id="bookNowBtn">
            Book a Service
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    gsap.registerPlugin(ScrollTrigger);

    const defaultImage = "/images/services/default.jpg";

    fetch('/services/all')
        .then(response => response.json())
        .then(data => {
            const servicesContainer = document.getElementById('servicesSections');
            const servicesNav = document.getElementById('servicesNav');

            const categorizedServices = categorizeServices(data);

            servicesNav.innerHTML = '';
            servicesContainer.innerHTML = '';

            Object.keys(categorizedServices).forEach((category, index) => {
                const navItem = document.createElement('a');
                navItem.href = `#${category.toLowerCase().replace(' ', '-')}`;
                navItem.className = 'whitespace-nowrap px-4 py-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors text-gray-800 font-medium';
                navItem.textContent = category;
                servicesNav.appendChild(navItem);

                const section = createServiceSection(category, categorizedServices[category], index);
                servicesContainer.appendChild(section);

                gsap.from(section, {
                    opacity: 0,
                    y: 40,
                    duration: 0.5,
                    scrollTrigger: {
                        trigger: section,
                        start: "top 80%",
                        toggleActions: "play none none none"
                    }
                });
            });

            document.querySelectorAll('#servicesNav a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 100,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            const navItems = document.querySelectorAll('#servicesNav a');
            const sectionElements = document.querySelectorAll('.service-section');

            function updateActiveNavItem() {
                let currentSection = '';
                sectionElements.forEach(section => {
                    const sectionTop = section.offsetTop;
                    if (window.scrollY >= sectionTop - 150) {
                        currentSection = '#' + section.id;
                    }
                });
                navItems.forEach(item => {
                    if (item.getAttribute('href') === currentSection) {
                        item.classList.add('bg-orange-600', 'text-white');
                        item.classList.remove('bg-gray-100', 'text-gray-800');
                    } else {
                        item.classList.remove('bg-orange-600', 'text-white');
                        item.classList.add('bg-gray-100', 'text-gray-800');
                    }
                });
            }

            window.addEventListener('scroll', updateActiveNavItem);
            updateActiveNavItem();
        });

    function categorizeServices(services) {
        const categorized = {};
        services.forEach(service => {
            const category = service.name.split(' ')[0];
            if (!categorized[category]) {
                categorized[category] = [];
            }
            categorized[category].push(service);
        });
        return categorized;
    }

    function createServiceSection(category, services, index) {
        const section = document.createElement('section');
        section.className = 'service-section';
        section.id = category.toLowerCase().replace(' ', '-');

        const groupedServices = groupServicesByName(services);

        const reverse = index % 2 !== 0;

        section.innerHTML = `
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">${category} Services</h2>
                <p class="text-gray-600 max-w-3xl">Professional ${category.toLowerCase()} services tailored to your pet’s needs.</p>
            </div>
            <div class="flex flex-col md:flex-row ${reverse ? 'md:flex-row-reverse' : ''} gap-6 mb-8 items-center">
                <div class="w-full md:w-1/2 rounded-xl overflow-hidden">
                    <img src="${defaultImage}" alt="${category} Services" class="w-full h-full object-cover" style="min-height: 200px;">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="servicesContainer-${category}">
                </div>
            </div>
        `;

        const servicesContainer = section.querySelector(`#servicesContainer-${category}`);

        Object.keys(groupedServices).forEach(serviceName => {
            const service = groupedServices[serviceName];
            const card = createServiceCard(service);
            servicesContainer.appendChild(card);
        });

        return section;
    }

    function groupServicesByName(services) {
        const grouped = {};
        services.forEach(service => {
            if (!grouped[service.name]) {
                grouped[service.name] = {
                    name: service.name,
                    descriptions: new Set(),
                    animals: []
                };
            }
            grouped[service.name].descriptions.add(service.description);
            grouped[service.name].animals.push({
                type: service.animal_type,
                price: service.price
            });
        });
        return grouped;
    }

    function createServiceCard(service) {
    const card = document.createElement('div');
    card.className = 'bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 service-card border border-gray-200';

    const description = service.descriptions.values().next().value || 'Comprehensive care for your pet';

    card.innerHTML = `
        <div class="p-6 space-y-4">
            <h3 class="text-xl font-bold text-gray-800 underline">${service.name}</h3>
            <p class="text-gray-600 service-description">${description}</p>
            
            <div class="bg-gray-50 border border-dashed border-gray-200 rounded-lg p-4">
                <div class="flex flex-wrap gap-2">
                    ${service.animals.map(animal => `
                        <div class="flex items-center gap-2 bg-white border border-gray-300 px-3 py-1 rounded-full shadow-sm">
                            <span class="text-sm text-gray-800">${animal.type}</span>
                            <span class="bg-orange-500 text-white text-xs font-semibold px-2 py-0.5 rounded-full">₱${parseFloat(animal.price).toFixed(2)}</span>
                        </div>
                    `).join('')}
                </div>
            </div>
        </div>
    `;

    // Hover effect
    card.addEventListener('mouseenter', () => gsap.to(card, { y: -5, duration: 0.3 }));
    card.addEventListener('mouseleave', () => gsap.to(card, { y: 0, duration: 0.3 }));

    return card;
}

});
</script>

<style>
    .service-card {
        transition: all 0.3s ease;
    }

    .service-card:hover {
        transform: translateY(-2px);
    }

    .animal-tag {
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .animal-tag:hover {
        background-color: #fed7aa !important;
        transform: translateY(-1px);
    }

    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }

    @media (max-width: 640px) {
        #bookNowBtn {
            width: auto;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }
    }
</style>
@endsection
