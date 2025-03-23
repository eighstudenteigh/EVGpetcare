@extends('layouts.app')

@section('title', 'Available Services')

@section('content')
<div class="container mx-auto p-4 md:p-6 flex flex-col md:flex-row gap-4">
    <!-- Sidebar for Animal Type Selection -->
    <aside class="md:w-1/4 p-4 bg-white shadow-md rounded">
        <h3 class="text-lg font-bold mb-3">Filter by Animal Type</h3>

        <!-- Toggle button for mobile view -->
        <button class="md:hidden block bg-orange-500 text-white px-4 py-2 rounded mb-3" id="toggleSidebar">
            Toggle Filters
        </button>

        <div id="sidebarContent" class="flex flex-col gap-2">
            @foreach($animalTypes as $type)
                <button class="animal-toggle px-4 py-2 border rounded text-gray-700 hover:bg-orange-500 hover:text-white transition" 
                        data-animal="{{ $type }}">
                    {{ ucfirst($type) }}
                </button>
            @endforeach
        </div>
    </aside>

    <!-- Services Table -->
    <section class="md:w-3/4 p-4 bg-white shadow-md rounded">
        <h3 class="text-lg font-bold mb-3">Available Services</h3>

        <!-- Services Container -->
        <div id="servicesContainer" class="overflow-x-auto">
            <p class="text-center p-3 text-gray-500">Select an animal type to view services.</p>
        </div>

        <!-- Book Now Button -->
        <div class="mt-4 text-center md:text-right">
            <a href="{{ route('customer.appointments.create') }}" class="hidden bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700 transition" id="bookNowBtn">
                Proceed to Booking
            </a>
        </div>
    </section>
</div>

<!-- ✅ JavaScript for Filtering & UI Effects -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const servicesContainer = document.getElementById("servicesContainer");
        const bookNowBtn = document.getElementById("bookNowBtn");
        const sidebar = document.getElementById("sidebarContent");
        const toggleSidebar = document.getElementById("toggleSidebar");

        let allServices = [];

        // Fetch all services once
        fetch('/services/all')
            .then(response => response.json())
            .then(data => {
                allServices = data;
            });

        // Toggle sidebar visibility on mobile
        toggleSidebar.addEventListener("click", () => {
            sidebar.classList.toggle("hidden");
        });

        // Handle Animal Type Filter Click
        document.querySelectorAll(".animal-toggle").forEach(button => {
            button.addEventListener("click", function () {
                let selectedType = this.dataset.animal;

                // Highlight the selected button
                document.querySelectorAll(".animal-toggle").forEach(btn => btn.classList.remove("bg-orange-500", "text-white"));
                this.classList.add("bg-orange-500", "text-white");

                // Filter Services for Selected Type
                let filteredServices = allServices.filter(service => service.animal_type === selectedType);

                // Render Grouped Services
                renderServices(selectedType, filteredServices);
            });
        });

        // Render Services Function
        function renderServices(animalType, services) {
            servicesContainer.innerHTML = "";

            if (services.length === 0) {
                servicesContainer.innerHTML = `<p class="text-center p-3 text-gray-500">No services available for ${animalType}.</p>`;
                bookNowBtn.classList.add("hidden");
                return;
            }

            let content = `
                <h4 class="text-xl font-semibold text-gray-700 mb-2">${animalType} Services</h4>
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300 min-w-[300px]">
                        <thead>
                            <tr class="bg-gray-700 text-white">
                                <th class="border p-2 text-left">Service Name</th>
                                <th class="border p-2 text-left">Price</th>
                                <th class="border p-2 text-left">Description</th>
                            </tr>
                        </thead>
                        <tbody>`;

            services.forEach(service => {
                content += `
                    <tr class="hover:bg-gray-100 transition">
                        <td class="p-2">${service.name}</td>
                        <td class="p-2 border">₱${parseFloat(service.price).toFixed(2)}</td>
                        <td class="p-2">${service.description ? service.description : 'No description available'}</td>
                    </tr>`;
            });

            content += `</tbody></table></div>`;
            servicesContainer.innerHTML = content;
            bookNowBtn.classList.remove("hidden");
        }
    });
</script>

<!-- Responsive Styling -->
<style>
    @media (max-width: 768px) {
        aside {
            display: none;
        }

        #sidebarContent.hidden {
            display: none;
        }

        #sidebarContent {
            display: block;
            margin-bottom: 1rem;
        }

        table {
            min-width: 300px;
        }
    }
</style>
@endsection
