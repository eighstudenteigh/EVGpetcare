@extends('layouts.customer')

@section('content')

<div class="px-4 sm:px-6 py-6">
    <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-darkGray text-center">Book an Appointment</h2>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500 text-white rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-500 text-white rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('customer.appointments.store') }}" method="POST" 
    id="appointmentForm" class="appointment-form">

        @csrf

        <!-- Pet Selection Section -->
        <div class="mb-6 border-b border-orange-500 pb-4">
            <h3 class="text-lg sm:text-xl font-semibold mb-3 text-white flex items-center">
                <span class="mr-2">1.</span> Select Pet(s)
                <span class="ml-2 text-sm text-orange-300">*required</span>
            </h3>
            <div class="mt-2 p-4 rounded-lg bg-gray-700 text-white">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3" id="petSelectionCards">

                    @foreach ($pets as $pet)
                    <div class="pet-card border rounded-lg p-3 sm:p-4 cursor-pointer transition w-full text-center
                                bg-secondary text-gray-800 hover:bg-white hover:text-orange-500"
                         data-pet-id="{{ $pet->id }}">
                        <input type="checkbox" name="pet_ids[]" value="{{ $pet->id }}" 
                               id="pet_{{ $pet->id }}" class="hidden pet-checkbox">
                
                        <span class="pet-icon text-xl sm:text-2xl block">
                            @if(strtolower($pet->type) == 'dog') 🐕 
                            @elseif(strtolower($pet->type) == 'cat') 🐈
                            @else 🐾
                            @endif
                        </span>
                
                        <span class="font-medium text-sm sm:text-base">{{ $pet->name }}</span>
                        <span class="text-xs sm:text-sm block">({{ ucfirst($pet->type) }})</span>
                    </div>
                @endforeach
                
                </div>
                
                @if(count($pets) === 0)
                    <div class="text-center p-4">
                        <p>No pets found. Please add a pet first.</p>
                        <a href="{{ route('customer.pets.create') }}" class="mt-2 inline-block px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600">
                            Add a Pet
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Service Selection Section -->
        <div class="mb-6 border-b border-orange-500 pb-4">
            <h3 class="text-lg sm:text-xl font-semibold mb-3 text-white flex items-center">
                <span class="mr-2">2.</span> Select Service(s)
                <span class="ml-2 text-sm text-orange-300">*required</span>
            </h3>
            <div id="serviceSelectionArea" class="mt-2 p-4 rounded-lg bg-gray-700 text-white">
                <p class="italic text-sm sm:text-base">Please select a pet first</p>
            </div>
        </div>

        <!-- Date & Time Selection -->
        <div class="mb-6 border-b border-orange-500 pb-4">
            <h3 class="text-lg sm:text-xl font-semibold mb-3 text-white flex items-center">
                <span class="mr-2">3.</span> Select Date & Time
                <span class="ml-2 text-sm text-orange-300">*required</span>
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div> 
                    <label for="appointmentDate" class="block font-semibold text-white mb-2">Select Date:</label>
                    <div id="calendarContainer" class="bg-lightGray rounded-lg overflow-hidden">
                        <input type="text" name="appointment_date" id="appointmentDate" 
                              class="w-full p-3 sm:p-4 border rounded-lg bg-lightGray text-black focus:ring-2 focus:ring-orange-500" 
                              readonly placeholder="Click to select a date">
                    </div>
                    <div id="dateMessage" class="mt-2 text-sm hidden"></div>
                </div>

                <div>
                    <label for="appointmentTime" class="block font-semibold text-white mb-2">Select Time:</label>
                    <select name="appointment_time" id="appointmentTime" 
                            class="w-full p-3 sm:p-4 border rounded-lg bg-lightGray text-black focus:ring-2 focus:ring-orange-500">
                        <option value="">Select a date first</option>
                    </select>
                    <div id="timeAvailabilityInfo" class="mt-2 text-sm text-orange-300">
                        <p>Each time slot allows a maximum of 3 appointments</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Section -->
        <div class="mb-6">
            <h3 class="text-lg sm:text-xl font-semibold mb-3 text-white flex items-center">
                <span class="mr-2">4.</span> Additional Notes
                <span class="ml-2 text-sm text-gray-400">(optional)</span>
            </h3>
            <textarea name="notes" id="appointmentNotes" rows="3" 
                    class="w-full p-3 sm:p-4 border rounded-lg bg-lightGray text-black focus:ring-2 focus:ring-orange-500"
                    placeholder="Any special instructions or concerns..."></textarea>
        </div>

        <!-- Confirmation Modal -->
        <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
            <div class="bg-gray-700 p-4 sm:p-6 rounded-lg shadow-lg max-w-md w-full text-white">
                <h3 class="text-lg sm:text-xl font-bold mb-4">Confirm Appointment</h3>
                <div id="confirmationContent" class="mb-4 text-sm sm:text-base"></div>
                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                    <button id="cancelButton" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                        Back
                    </button>
                    <button id="confirmButton" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition">
                        Confirm Booking
                    </button>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-6 flex justify-center">
            @if($acceptedAppointmentsToday >= $maxAppointments)
                <button 
                    class="w-full sm:w-auto px-6 py-3 bg-gray-300 text-gray-500 cursor-not-allowed rounded-lg"
                    disabled 
                    data-tooltip="Appointments are maxed out for today. Try again tomorrow.">
                    Request Appointment
                </button>
            @else
                <button 
                    id="submitButton"
                    class="w-full sm:w-auto px-6 py-3 bg-gray-300 text-gray-500 cursor-not-allowed rounded-lg"
                    type="submit" disabled>
                    Request Appointment
                </button>
            @endif
        </div>

    </form>

</div>

@push('styles')
<style>
    /* Custom Styles for Calendar */
    .flatpickr-calendar {
        background: #333 !important;
        border: none !important;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3) !important;
    }
    
    .flatpickr-day {
        border-radius: 50% !important;
        color: #fff !important;
        background: transparent !important;
    }
    
    .flatpickr-day.selected {
        background: #f97316 !important;
        border-color: #f97316 !important;
    }
    
    .flatpickr-day.today {
        border-color: #f97316 !important;
    }
    
    .flatpickr-day:hover {
        background: rgba(249, 115, 22, 0.3) !important;
    }
    
    .flatpickr-day.flatpickr-disabled, 
    .flatpickr-day.flatpickr-disabled:hover,
    .flatpickr-day.prevMonthDay, 
    .flatpickr-day.nextMonthDay {
        color: #666 !important;
    }
    
    .flatpickr-day.closed-day {
        background-color: rgba(255, 0, 0, 0.2) !important;
        text-decoration: line-through;
        color: #ff6b6b !important;
        cursor: not-allowed !important;
    }

    .flatpickr-months .flatpickr-month,
    .flatpickr-weekdays,
    .flatpickr-current-month .flatpickr-monthDropdown-months,
    span.flatpickr-weekday {
        background: #444 !important;
        color: #fff !important;  
    }
    
    .flatpickr-current-month {
        color: #fff !important;
    }
    
    /* Tooltip for hover info */
    [data-tooltip] {
        position: relative;
    }
    
    [data-tooltip]:hover:after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #333;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        white-space: nowrap;
        font-size: 14px;
        margin-bottom: 5px;
        z-index: 10;
    }
</style>
@endpush

<script>
    
document.addEventListener('DOMContentLoaded', function () {
    console.log("Appointment script loaded");

const dateInput = document.getElementById("appointmentDate");
const dateMessage = document.getElementById("dateMessage");
const confirmationModal = document.getElementById('confirmationModal');
const confirmationContent = document.getElementById('confirmationContent');
const cancelButton = document.getElementById('cancelButton');
const confirmButton = document.getElementById('confirmButton');
const submitButton = document.getElementById('submitButton');

/** ✅ Fetch Closed Days FIRST, then Initialize Calendar */
fetch('/admin/closed-days')
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            console.log("✅ Closed Days Response:", data);

            // ✅ Extract closed dates into an array of strings for Flatpickr
            const closedDates = data.map(item => item.start.toString());

            initializeCalendar(closedDates, data);
        })
        .catch(error => {
            console.error("❌ Error fetching closed days:", error);
            initializeCalendar([], []);
            dateMessage.innerHTML = '<p class="text-red-500">⚠️ Unable to fetch closed days. Some dates may be incorrectly available.</p>';
            dateMessage.classList.remove('hidden');
        });

    /** ✅ Initialize Flatpickr with Disabled Dates */
    function initializeCalendar(closedDates, rawClosedDaysData) {
        const calendar = flatpickr(dateInput, {
            dateFormat: "Y-m-d",
            minDate: new Date().fp_incr(1),
            disable: [
                function(date) { return date.getDay() === 0 || date.getDay() === 6; }, // Disable weekends
                ...closedDates // ✅ Disable closed days
            ],
            onChange: function(selectedDates, dateStr) {
                fetchAvailableTimes(dateStr);
                validateForm();
                dateMessage.classList.add('hidden');
            },
            onDayCreate: function(dObj, dStr, fp, dayElem) {
                const dateString = dayElem.dateObj.toISOString().split('T')[0];

                // ✅ Mark Closed Days
                if (closedDates.includes(dateString)) {
                    dayElem.classList.add('closed-day');
                    const matchingDay = rawClosedDaysData.find(day => day.start === dateString);
                    dayElem.setAttribute('title', matchingDay?.title || 'Closed day');
                }

                // ✅ Mark Weekends
                if ([0, 6].includes(dayElem.dateObj.getDay())) {
                    dayElem.classList.add('weekend-day');
                    dayElem.setAttribute('title', 'Weekend - Not available');
                }
            }
        });

        window.appointmentCalendar = calendar; // Store globally if needed

        // ✅ Refresh Button for Debugging
        const calendarContainer = document.querySelector('.flatpickr-calendar');
        if (calendarContainer) {
            const refreshButton = document.createElement('button');
            refreshButton.className = 'refresh-calendar-btn';
            refreshButton.innerText = '↻ Refresh';
            refreshButton.onclick = function(e) {
                e.preventDefault();
                location.reload(); // Simple refresh logic
            };
            calendarContainer.appendChild(refreshButton);
        }
    }
    
    /** ✅ 2️⃣ Pet Selection Handling */
    document.querySelectorAll('.pet-card').forEach(card => {
        card.addEventListener('click', function () {
            const checkbox = this.querySelector('.pet-checkbox');
            checkbox.checked = !checkbox.checked;

            if (checkbox.checked) {
                this.classList.remove('bg-secondary', 'hover:bg-white', 'hover:text-orange-500'); 
                this.classList.add('bg-orange-500', 'text-white', 'border-white'); 
            } else {
                this.classList.remove('bg-orange-500', 'text-white', 'border-white'); 
                this.classList.add('bg-secondary', 'hover:bg-white', 'hover:text-orange-500'); 
            }

            updateServiceSelection();
            validateForm();
        });
    });


    /** ✅ 3️⃣ Update Service Selection */
    function updateServiceSelection() {
        const selectedPets = document.querySelectorAll('.pet-checkbox:checked');
        const serviceArea = document.getElementById('serviceSelectionArea');

        if (selectedPets.length === 0) {
            serviceArea.innerHTML = '<p class="text-gray-400 italic">Please select a pet first</p>';
            return;
        }

        let html = '';
        selectedPets.forEach(pet => {
            const petId = pet.value;
            const petName = pet.parentElement.querySelector('.font-medium').textContent;

            html += `<div class="mb-4 p-3 border border-gray-600 rounded-lg">
                        <div class="font-medium mb-3 text-orange-300">Services for ${petName}:</div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            ${@json($services).map(service => `
                                <label class="service-card border rounded-lg p-3 cursor-pointer transition  
                                bg-secondary text-gray-800 hover:bg-white hover:text-orange-500 flex flex-col justify-between h-full">
                                    <input type="checkbox" name="pet_services[${petId}][]" value="${service.id}" class="hidden service-checkbox">
                                    <span class="font-medium mb-1">${service.name}</span>
                                    <span class="text-xs">${service.description ? service.description : ''}</span>
                                    <span class="mt-2 font-semibold">₱${service.price}</span>
                                </label>
                            `).join('')}
                        </div>
                    </div>`;
        });

        serviceArea.innerHTML = html;
        setupServiceClickHandlers();
        validateForm();
    }

    /** ✅ 4️⃣ Attach Click Events to Service Selection */
    function setupServiceClickHandlers() {
        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('click', function () {
                const checkbox = this.querySelector('.service-checkbox');
                checkbox.checked = !checkbox.checked;

                if (checkbox.checked) {
                    this.classList.remove('bg-secondary', 'hover:bg-white', 'hover:text-orange-500'); 
                    this.classList.add('bg-orange-600', 'text-white', 'border-white'); 
                } else {
                    this.classList.remove('bg-orange-600', 'text-white', 'border-white'); 
                    this.classList.add('bg-secondary', 'hover:bg-white', 'hover:text-orange-500'); 
                }

                validateForm();
            });
        });
    }

    /** ✅ 5️⃣ Generate Appointment Summary */
    function generateSummary() {
    const selectedPets = document.querySelectorAll('.pet-checkbox:checked');
    let summaryHTML = '<div class="space-y-2">'; // Reduced space

    // ✅ Appointment details section
    summaryHTML += `
        <div class="p-3 bg-gray-800 rounded-lg mb-3">
            <p class="font-semibold text-orange-300">When:</p>
            <p>${new Date(document.getElementById("appointmentDate").value).toLocaleDateString('en-US', {
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
            })}</p>
            <p class="font-semibold text-orange-300 mt-2">Time:</p>
            <p>${document.getElementById("appointmentTime").options[document.getElementById("appointmentTime").selectedIndex].text}</p>
        </div>
    `;

    // ✅ Services per pet section
    summaryHTML += '<div class="p-3 bg-gray-800 rounded-lg">';
    summaryHTML += '<p class="font-semibold text-orange-300 mb-2">Selected Services:</p>';

    let totalEstimate = 0;
    let serviceCount = 0;

    selectedPets.forEach(pet => {
        const petId = pet.value;
        const petName = pet.parentElement.querySelector('.font-medium').textContent;
        const petType = pet.parentElement.querySelector('.text-xs').textContent.trim();
        const selectedServices = document.querySelectorAll(`input[name="pet_services[${petId}][]"]:checked`);

        if (selectedServices.length > 0) {
            summaryHTML += `<p class="font-medium border-b border-gray-600 pb-1">${petName} ${petType}</p>`;
            summaryHTML += `<p class="text-gray-300 text-sm">`;

            selectedServices.forEach(serviceCheckbox => {
                const serviceCard = serviceCheckbox.closest('.service-card');
                const serviceName = serviceCard.querySelector('.font-medium').textContent;
                const servicePrice = serviceCard.querySelector('.font-semibold').textContent.trim();

                // ✅ Fix: Remove ₱ and commas before parsing price
                const priceValue = parseFloat(servicePrice.replace(/[₱,]/g, ''));

                if (!isNaN(priceValue)) {
                    totalEstimate += priceValue;
                    serviceCount++;
                    summaryHTML += `${serviceName} (${servicePrice}), `;
                }
            });

            summaryHTML = summaryHTML.replace(/, $/, ""); // Remove trailing comma
            summaryHTML += `</p>`;
        }
    });

    summaryHTML += `</div>`;

    // ✅ Appointment Notes
    const notes = document.getElementById('appointmentNotes')?.value.trim();
    if (notes) {
        summaryHTML += `
            <div class="p-3 bg-gray-800 rounded-lg">
                <p class="font-semibold text-orange-300">Notes:</p>
                <p class="italic">"${notes}"</p>
            </div>
        `;
    }

    // ✅ Estimated Total
    if (serviceCount > 0) {
        summaryHTML += `
            <div class="mt-2 pt-2 border-t border-gray-600 text-right">
                <p class="font-bold">Estimated Total: <span class="text-orange-300">₱${totalEstimate.toFixed(2)}</span></p>
                <p class="text-xs text-gray-400">Final prices may vary based on additional services required during grooming.</p>
            </div>
        `;
    }

    summaryHTML += '</div>';
    return summaryHTML;
}

    /** ✅ 6️⃣ Fetch Available Time Slots */
function fetchAvailableTimes(date) {
    if (!date) return;

    const timeSelect = document.getElementById('appointmentTime');
    const timeAvailabilityInfo = document.getElementById('timeAvailabilityInfo');
    
    timeSelect.innerHTML = '<option value="">Loading...</option>';
    timeSelect.disabled = true;
    timeAvailabilityInfo.innerHTML = '<p class="text-gray-400">Loading available times...</p>';

    fetch(`/appointments/availability?date=${date}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("🚨 API Error:", data.error);
                timeSelect.innerHTML = '<option value="">No available slots</option>';
                
                // Show error message
                timeAvailabilityInfo.innerHTML = `<p class="text-red-500">${data.error}</p>`;
                return;
            }

            timeSelect.innerHTML = '<option value="">Select a time</option>';
            timeSelect.disabled = false;

            if (data.times.length === 0) {
                let option = new Option("No slots available", "");
                option.disabled = true;
                timeSelect.appendChild(option);
                
                timeAvailabilityInfo.innerHTML = '<p class="text-red-500">All appointment slots for this date are fully booked.</p>';
            } else {
                data.times.forEach(timeStr => {
                    // Convert 12-hour format to 24-hour for value
                    const timeParts = timeStr.match(/(\d+):(\d+) ([AP]M)/);
                    if (timeParts) {
                        let hour = parseInt(timeParts[1]);
                        const minute = timeParts[2];
                        const period = timeParts[3];
                        
                        if (period === "PM" && hour < 12) hour += 12;
                        if (period === "AM" && hour === 12) hour = 0;
                        
                        const value = `${hour.toString().padStart(2, '0')}:${minute}:00`;
                        let option = new Option(timeStr, value);
                        timeSelect.appendChild(option);
                    }
                });

                // ✅ Update the message to reflect 3 per hour instead of 2
                timeAvailabilityInfo.innerHTML = `
                    
                    <p class="text-sm text-gray-400">Each time slot allows a maximum of <strong>3 appointments</strong>.</p>
                `;
            }

            validateForm();
        })
        .catch(error => {
            console.error("❌ Error fetching time slots:", error);
            timeSelect.innerHTML = '<option value="">Error loading times</option>';
            timeSelect.disabled = true;
            
            // Show error message
            timeAvailabilityInfo.innerHTML = '<p class="text-red-500">Failed to load available times. Please try again or contact support.</p>';
        });
}


    /** ✅ 7️⃣ Form Validation */
    function validateForm() {
        const dateField = document.getElementById('appointmentDate');
        const timeField = document.getElementById('appointmentTime');
        
        const petsSelected = document.querySelectorAll('.pet-checkbox:checked').length > 0;
        const servicesSelected = document.querySelectorAll('.service-checkbox:checked').length > 0;
        const dateSelected = dateField.value.trim() !== '';
        const timeSelected = timeField.value.trim() !== '';

        const isValid = petsSelected && servicesSelected && dateSelected && timeSelected;

        if (isValid) {
            submitButton.disabled = false;
            submitButton.classList.remove("bg-gray-300", "text-gray-500", "cursor-not-allowed");
            submitButton.classList.add("bg-orange-500", "text-white", "hover:bg-orange-600");
        } else {
            submitButton.disabled = true;
            submitButton.classList.remove("bg-orange-500", "text-white", "hover:bg-orange-600");
            submitButton.classList.add("bg-gray-300", "text-gray-500", "cursor-not-allowed");
        }
        
        // Visual feedback on form sections
        updateSectionStatus('petSelectionCards', petsSelected);
        updateSectionStatus('serviceSelectionArea', servicesSelected);
        updateSectionStatus('calendarContainer', dateSelected);
        updateSectionStatus('appointmentTime', timeSelected);
    }
    
    // Helper function to update visual status of form sections
    function updateSectionStatus(elementId, isValid) {
        const element = document.getElementById(elementId);
        if (!element) return;
        
        if (isValid) {
            element.classList.add('border-green-500');
            element.classList.remove('border-red-500');
        } else if (element.classList.contains('border-green-500')) {
            element.classList.remove('border-green-500');
        }
    }

    /** ✅ 8️⃣ Modal Handlers */
    function openModal() {
        // Generate and display the summary
        confirmationContent.innerHTML = generateSummary();
        
        // Show the modal
        confirmationModal.classList.remove('hidden');
        confirmationModal.classList.add('flex');
    }

    function closeModal() {
        confirmationModal.classList.remove('flex');
        confirmationModal.classList.add('hidden');
    }

    function submitForm() {
        let form = document.getElementById('appointmentForm');
        if (form) {
            // Add loading state to button
            confirmButton.innerHTML = '<span class="inline-block animate-spin mr-2">↻</span> Booking...';
            confirmButton.disabled = true;
            
            // Submit the form
            form.submit();
        } else {
            console.error("❌ Form not found!");
        }
    }

    /** ✅ 9️⃣ Attach Event Listeners */
    // Form submit handler
    const appointmentForm = document.getElementById('appointmentForm');
    if (appointmentForm) {
        appointmentForm.addEventListener('submit', function(event) {
            event.preventDefault();
            openModal();
        });
    }

    // Cancel button click handler
    if (cancelButton) {
        cancelButton.addEventListener('click', function(event) {
            event.preventDefault();
            closeModal();
        });
    }

    // Confirm button click handler
    if (confirmButton) {
        confirmButton.addEventListener('click', function() {
            submitForm();
        });
    }

    // Time select change handler
    document.getElementById('appointmentTime').addEventListener('change', function() {
        validateForm();
    });

    // Ensure the modal can be closed with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            if (!confirmationModal.classList.contains('hidden')) {
                closeModal();
            }
        }
    });

    // Allow clicking outside the modal to close it
    confirmationModal.addEventListener('click', function(event) {
        if (event.target === confirmationModal) {
            closeModal();
        }
    });
});
</script>
@endsection