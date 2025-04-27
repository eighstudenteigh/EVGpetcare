@extends('layouts.customer')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Book New Appointment</h1>
    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form id="appointment-form" action="{{ route('customer.appointments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="selected_pets" id="selected-pets-data">
        

        <!-- Step 1: Pet Selection -->
        <div class="bg-white rounded-lg shadow p-6 mb-6 step-section" id="step-1">
            <h2 class="text-xl font-semibold mb-4">1. Select Your Pet(s)</h2>
            <p class="text-gray-600 mb-4">You can select one or more pets for this appointment.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($pets as $pet)
                <div class="border rounded-lg p-4 pet-card hover:bg-gray-50 cursor-pointer transition"
                     data-pet-id="{{ $pet->id }}"
                     data-pet-type-id="{{ $pet->petType->id }}"
                     data-pet-type-name="{{ $pet->petType->name }}">
                    <div class="flex items-center">
                        @if($pet->image)
                        <img src="{{ asset('storage/'.$pet->image) }}" alt="{{ $pet->name }}" class="w-16 h-16 rounded-full object-cover mr-4">
                        @else
                        <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        @endif
                        <div>
                            <h3 class="font-medium">{{ $pet->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $pet->petType->name }}</p>
                        </div>
                    </div>
                    <input type="checkbox" name="pet_ids[]" value="{{ $pet->id }}" class="hidden pet-checkbox">
                </div>
                @endforeach
            </div>
            
            <div class="mt-6 flex justify-end">
                <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition next-step disabled:bg-gray-400"
                        data-next="step-2" disabled>Next: Select Services</button>
            </div>
        </div>

        <!-- Step 2: Service Selection -->
        <div class="bg-white rounded-lg shadow p-6 mb-6 step-section hidden" id="step-2">
            <h2 class="text-xl font-semibold mb-4">2. Select Services</h2>
            <p class="text-gray-600 mb-4">Choose services for each of your selected pets.</p>
            
            <div id="services-container">
                <!-- Will be populated by JavaScript -->
            </div>
            
            <div class="mt-6 flex justify-between">
                <button type="button" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition prev-step"
                        data-prev="step-1">Back</button>
                <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition next-step"
                        data-next="step-3">Next: Select Date & Time</button>
            </div>
        </div>

        <!-- Step 3: Date & Time Selection -->
        <div class="bg-white rounded-lg shadow p-6 mb-6 step-section hidden" id="step-3">
            <h2 class="text-xl font-semibold mb-4">3. Select Date & Time</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Appointment Date</label>
                    <input type="date" name="appointment_date" id="appointment-date" 
                           class="w-full border rounded px-3 py-2" 
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           required>
                    <div class="text-sm text-gray-500 mt-1">Closed on weekends and holidays</div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Available Time Slots</label>
                    <select name="appointment_time" id="appointment-time" class="w-full border rounded px-3 py-2" disabled required>
                        <option value="">Select a date first</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-6 flex justify-between">
                <button type="button" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition prev-step"
                        data-prev="step-2">Back</button>
                <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition next-step"
                        data-next="step-4">Next: Review & Confirm</button>
            </div>
        </div>

        <!-- Step 4: Review & Confirm -->
        <div class="bg-white rounded-lg shadow p-6 mb-6 step-section hidden" id="step-4">
            <h2 class="text-xl font-semibold mb-4">4. Review Your Appointment</h2>
            
            <div class="mb-6">
                <h3 class="text-lg font-medium mb-2">Selected Pets</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="review-pets">
                    <!-- Filled by JavaScript -->
                </div>
            </div>
            
            <div class="mb-6">
                <h3 class="text-lg font-medium mb-2">Selected Services</h3>
                <div class="space-y-4" id="review-services">
                    <!-- Filled by JavaScript -->
                </div>
            </div>
            
            <div class="mb-6">
                <h3 class="text-lg font-medium mb-2">Appointment Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600">Date:</p>
                        <p id="review-date" class="font-medium"></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Time:</p>
                        <p id="review-time" class="font-medium"></p>
                    </div>
                </div>
            </div>
            
            <div class="border-t pt-4">
                <div class="flex justify-between items-center">
                    <p class="text-lg font-medium">Total Estimated Cost:</p>
                    <p class="text-xl font-bold" id="review-total">₱0.00</p>
                </div>
            </div>
            
            <div class="mt-6 flex justify-between">
                <button type="button" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition prev-step"
                        data-prev="step-3">Back</button>
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                    Confirm Booking
                </button>
            </div>
        </div>
    </form>
</div>

<style>
    .step-section {
        transition: all 0.3s ease;
    }
    .pet-card, .service-card {
        transition: all 0.2s ease;
    }
    .pet-card:hover, .service-card:hover {
        transform: translateY(-2px);
    }
    .pet-card.selected {
        border-color: #3b82f6;
        background-color: #eff6ff;
        border-width: 2px;
    }
    .pet-card.selected:hover {
        background-color: #dbeafe;
    }
    .service-card.selected {
        border-color: #3b82f6;
        background-color: #eff6ff;
        border-width: 2px;
    }
    .selected-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: #3b82f6;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }
    .pet-services-section {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    .pet-services-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }
    .pet-services-title {
        font-weight: 600;
        margin-left: 0.75rem;
    }
    .service-checkbox-container {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    .service-checkbox {
        margin-right: 0.5rem;
    }
    .vaccine-checkboxes {
        margin-left: 1.5rem;
        margin-top: 0.5rem;
    }
    .vaccine-checkbox-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.25rem;
    }
</style>

@push('scripts')
<script>
    let selectedPets = [];
    document.addEventListener('DOMContentLoaded', function() {
        const closedDays = @json($closedDays);
        const services = @json($services);
        
        var availabilityUrl = "{{ route('customer.appointments.availability') }}";
    
        // Initialize pet selection
        updatePetSelection();
    
        // Step navigation
        document.querySelectorAll('.next-step').forEach(button => {
            button.addEventListener('click', function() {
                const nextStep = this.dataset.next;
                if (nextStep === 'step-2') {
                    renderPetServices();
                } else if (nextStep === 'step-4') {
                    updateReviewSection();
                }
                document.getElementById(nextStep).classList.remove('hidden');
                this.closest('.step-section').classList.add('hidden');
            });
        });
    
        document.querySelectorAll('.prev-step').forEach(button => {
            button.addEventListener('click', function() {
                const prevStep = this.dataset.prev;
                document.getElementById(prevStep).classList.remove('hidden');
                this.closest('.step-section').classList.add('hidden');
            });
        });
    
        // Pet selection
        document.querySelectorAll('.pet-card').forEach(card => {
            card.addEventListener('click', function() {
                const checkbox = this.querySelector('.pet-checkbox');
                checkbox.checked = !checkbox.checked;
                this.classList.toggle('selected', checkbox.checked);
                updatePetSelection();
                updateSelectedCount();
    
                const nextButton = document.querySelector('[data-next="step-2"]');
                nextButton.disabled = !document.querySelectorAll('.pet-checkbox:checked').length;
            });
        });
    
        function updateSelectedCount() {
            document.querySelectorAll('.pet-card').forEach(card => {
                const existingBadge = card.querySelector('.selected-count');
                if (existingBadge) existingBadge.remove();
    
                const checkbox = card.querySelector('.pet-checkbox');
                if (checkbox.checked) {
                    const selected = Array.from(document.querySelectorAll('.pet-checkbox:checked'));
                    const position = selected.indexOf(checkbox) + 1;
    
                    const badge = document.createElement('div');
                    badge.className = 'selected-count';
                    badge.textContent = position;
                    card.style.position = 'relative';
                    card.appendChild(badge);
                }
            });
        }
    
        function updatePetSelection() {
            selectedPets = [];
            document.querySelectorAll('.pet-checkbox:checked').forEach(checkbox => {
                const petCard = checkbox.closest('.pet-card');
                selectedPets.push({
                    id: petCard.dataset.petId,
                    typeId: petCard.dataset.petTypeId,
                    typeName: petCard.dataset.petTypeName,
                    name: petCard.querySelector('h3').textContent,
                    photo: petCard.querySelector('img') ? petCard.querySelector('img').src : null
                });
            });
    
            document.getElementById('selected-pets-data').value = JSON.stringify(selectedPets);
        }
    
        function renderPetServices() {
            const container = document.getElementById('services-container');
            container.innerHTML = '';
    
            selectedPets.forEach(pet => {
                const petSection = document.createElement('div');
                petSection.className = 'pet-services-section';
                petSection.dataset.petId = pet.id;
    
                const header = document.createElement('div');
                header.className = 'pet-services-header';
                header.innerHTML = `
                    ${pet.photo ? `<img src="${pet.photo}" alt="${pet.name}" class="w-12 h-12 rounded-full object-cover">` :
                    `<div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>`}
                    <h3 class="pet-services-title">Services for ${pet.name} (${pet.typeName})</h3>
                `;
                petSection.appendChild(header);
    
                const servicesList = document.createElement('div');
    
                // Regular services
                const normalServices = services.filter(s => !s.is_vaccination);
                if (normalServices.length > 0) {
                    const normalHeader = document.createElement('h4');
                    normalHeader.className = 'font-medium mb-2';
                    normalHeader.textContent = 'Regular Services';
                    servicesList.appendChild(normalHeader);
    
                    normalServices.forEach(service => {
                        const isAvailable = service.pet_types.length === 0 || service.pet_types.some(pt => pt.id == pet.typeId);
                        if (!isAvailable) return;
    
                        let price = service.base_price;
                        const petTypePrice = service.pet_types.find(pt => pt.id == pet.typeId);
                        if (petTypePrice) price = petTypePrice.pivot.price;
    
                        const serviceDiv = document.createElement('div');
                        serviceDiv.className = 'service-checkbox-container';
                        serviceDiv.innerHTML = `
                            <input type="checkbox"
                                   id="service-${service.id}-pet-${pet.id}"
                                   class="service-checkbox"
                                   data-service-id="${service.id}"
                                   data-pet-id="${pet.id}"
                                   data-price="${price}">
                            <label for="service-${service.id}-pet-${pet.id}" class="font-medium cursor-pointer">
                                ${service.name}
                            </label>
                            <span class="ml-auto font-medium">₱${parseFloat(price).toFixed(2)}</span>
                        `;
                        servicesList.appendChild(serviceDiv);
                    });
                }
    
                // Vaccination services
                const vaccineServices = services.filter(s => s.is_vaccination);
                if (vaccineServices.length > 0) {
                    const vaccineHeader = document.createElement('h4');
                    vaccineHeader.className = 'font-medium mb-2 mt-4';
                    vaccineHeader.textContent = 'Vaccination Services';
                    servicesList.appendChild(vaccineHeader);
    
                    vaccineServices.forEach(service => {
                        const compatibleVaccines = service.vaccine_pricings.filter(vp =>
                            !vp.pet_type_id || vp.pet_type_id == pet.typeId
                        );
    
                        if (compatibleVaccines.length === 0) return;
    
                        const serviceDiv = document.createElement('div');
                        serviceDiv.className = 'service-checkbox-container';
                        serviceDiv.innerHTML = `
                            <input type="checkbox"
                                   id="service-${service.id}-pet-${pet.id}"
                                   class="service-checkbox"
                                   data-service-id="${service.id}"
                                   data-pet-id="${pet.id}"
                                   data-is-vaccination="true">
                            <label for="service-${service.id}-pet-${pet.id}" class="font-medium cursor-pointer">
                                ${service.name}
                            </label>
                        `;
    
                        const vaccineOptions = document.createElement('div');
                        vaccineOptions.className = 'vaccine-checkboxes ml-6 mt-2';
    
                        compatibleVaccines.forEach(vaccine => {
                            vaccineOptions.innerHTML += `
                                <div class="vaccine-checkbox-item">
                                    <input type="checkbox"
                                           id="vaccine-${vaccine.vaccine_type_id}-pet-${pet.id}-service-${service.id}"
                                           name="services[${service.id}][pets][${pet.id}][vaccine_ids][]"
                                           value="${vaccine.vaccine_type_id}"
                                           data-price="${vaccine.price}"
                                           data-vaccine-name="${vaccine.vaccine_type.name}"
                                           class="vaccine-checkbox"
                                           disabled>
                                    <label for="vaccine-${vaccine.vaccine_type_id}-pet-${pet.id}-service-${service.id}" class="ml-2 cursor-pointer">
                                        ${vaccine.vaccine_type.name} - ₱${parseFloat(vaccine.price).toFixed(2)}
                                    </label>
                                </div>
                            `;
                        });
    
                        serviceDiv.appendChild(vaccineOptions);
                        servicesList.appendChild(serviceDiv);
                    });
                }
    
                petSection.appendChild(servicesList);
                container.appendChild(petSection);
            });
    
            // Event Listeners
            document.querySelectorAll('.service-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const isVaccination = this.dataset.isVaccination === 'true';
                    const petId = this.dataset.petId;
                    const serviceId = this.dataset.serviceId;
    
                    if (isVaccination) {
                        document.querySelectorAll(
                            `input[name="services[${serviceId}][pets][${petId}][vaccine_ids][]"]`
                        ).forEach(cb => {
                            cb.disabled = !this.checked;
                            if (!this.checked) cb.checked = false;
                        });
                    }
                    updateReviewSection();
                });
            });
    
            document.querySelectorAll('.vaccine-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateReviewSection();
                });
            });
        }
    
        document.getElementById('appointment-date').addEventListener('change', function() {
            const date = this.value;
            const timeSelect = document.getElementById('appointment-time');
    
            if (!date) {
                timeSelect.innerHTML = '<option value="">Select a date first</option>';
                timeSelect.disabled = true;
                return;
            }
    
            const dateObj = new Date(date);
            if (dateObj.getDay() === 0 || dateObj.getDay() === 6 || closedDays.includes(date)) {
                timeSelect.innerHTML = '<option value="">No availability (closed)</option>';
                timeSelect.disabled = true;
                return;
            }
    
            fetch(availabilityUrl + '?date=' + date)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    timeSelect.innerHTML = `<option value="">${data.error}</option>`;
                    timeSelect.disabled = true;
                } else {
                    timeSelect.innerHTML = '<option value="">Select a time</option>';
                    data.times.forEach(time => {
                        const option = document.createElement('option');
                        option.value = time;
                        option.textContent = time;
                        timeSelect.appendChild(option);
                    });
                    timeSelect.disabled = false;
                }
            })
            .catch(() => {
                timeSelect.innerHTML = '<option value="">Error loading times</option>';
                timeSelect.disabled = true;
            });
        });
    
        function updateReviewSection() {
            const petsSection = document.getElementById('review-pets');
            petsSection.innerHTML = '';
            selectedPets.forEach(pet => {
                petsSection.innerHTML += `
                    <div class="border rounded-lg p-3">
                        <div class="flex items-center">
                            ${pet.photo ? `<img src="${pet.photo}" alt="${pet.name}" class="w-12 h-12 rounded-full object-cover">` :
                            `<div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>`}
                            <div class="ml-3">
                                <h4 class="font-medium">${pet.name}</h4>
                                <p class="text-sm text-gray-600">${pet.typeName}</p>
                            </div>
                        </div>
                    </div>
                `;
            });
    
            const servicesSection = document.getElementById('review-services');
            servicesSection.innerHTML = '';
            let total = 0;
    
            document.querySelectorAll('.service-checkbox:checked').forEach(serviceCheckbox => {
    const serviceId = serviceCheckbox.dataset.serviceId;
    const petId = serviceCheckbox.dataset.petId;
    const isVaccination = serviceCheckbox.dataset.isVaccination === 'true';
    const service = services.find(s => s.id == serviceId);
    const pet = selectedPets.find(p => p.id == petId);

    if (!service || !pet) return;

    let servicePrice = parseFloat(serviceCheckbox.dataset.price) || 0;
    let serviceText = `<h4 class="font-medium">${service.name} (${pet.name})</h4>`;
    let displayPrice = 0; // This will be used to show in the right-side price span

    if (isVaccination) {
        const vaccineCheckboxes = document.querySelectorAll(`input[name="services[${serviceId}][pets][${petId}][vaccine_ids][]"]:checked`);
        vaccineCheckboxes.forEach(vaccineCheckbox => {
            const vaccineName = vaccineCheckbox.dataset.vaccineName || '';
            const vaccinePrice = parseFloat(vaccineCheckbox.dataset.price) || 0;
            serviceText += `<p class="text-sm text-gray-600">Vaccine: ${vaccineName} (₱${vaccinePrice.toFixed(2)})</p>`;
            total += vaccinePrice;
            displayPrice += vaccinePrice;
        });
    } else {
        total += servicePrice;
        displayPrice = servicePrice;
    }

    servicesSection.innerHTML += `
        <div class="border-b pb-3 mb-2">
            <div class="flex justify-between">
                <div>${serviceText}</div>
                <span class="font-medium">₱${displayPrice.toFixed(2)}</span>
            </div>
        </div>
    `;
});

document.getElementById('review-date').textContent = document.getElementById('appointment-date').value;
document.getElementById('review-time').textContent = document.getElementById('appointment-time').value;
document.getElementById('review-total').textContent = `₱${total.toFixed(2)}`;
        }
    });
    
    // Before submitting the form, transform the data
    document.getElementById('appointment-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Collect all selected services and vaccines
    const formData = new FormData(this);
    const servicesData = [];
    
    // Get basic form data
    const appointmentData = {
        pet_ids: selectedPets.map(pet => pet.id),
        appointment_date: formData.get('appointment_date'),
        appointment_time: formData.get('appointment_time'),
        services: servicesData
    };
    
    // Process regular services
    document.querySelectorAll('.service-checkbox:checked').forEach(checkbox => {
        const serviceId = checkbox.dataset.serviceId;
        const petId = checkbox.dataset.petId;
        const isVaccination = checkbox.dataset.isVaccination === 'true';
        
        const service = {
            id: parseInt(serviceId),
            pet_id: parseInt(petId),
            price: parseFloat(checkbox.dataset.price) || 0
        };
        
        if (isVaccination) {
            const vaccineIds = [];
            document.querySelectorAll(`input[name="services[${serviceId}][pets][${petId}][vaccine_ids][]"]:checked`).forEach(vaccineCb => {
                vaccineIds.push(parseInt(vaccineCb.value)); // Fixed this line - removed extra parenthesis
            });
            service.vaccine_type_ids = vaccineIds;
        }
        
        servicesData.push(service);
    });
    
    // Add the transformed data to a hidden input
    const dataInput = document.createElement('input');
    dataInput.type = 'hidden';
    dataInput.name = 'appointment_data';
    dataInput.value = JSON.stringify(appointmentData);
    this.appendChild(dataInput);
    
    // Submit the form
    this.submit();
});
    </script>
    
@endpush
@endsection