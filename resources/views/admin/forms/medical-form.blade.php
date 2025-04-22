@extends('layouts.admin')

@section('title', 'Medical Service Record')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Medical Record</h2>

    <form action="{{ route('admin.pet-records.store-medical', ['appointment' => $appointment->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="pet_id" value="{{ $pet->id }}">

        <div class="bg-white p-6 rounded-lg shadow border border-gray-200 mb-6">
            <h4 class="text-xl font-semibold text-red-600 mb-4">Medical Details</h4>

            <!-- Pet Information (auto-filled) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block mb-2 text-gray-700 font-medium">Pet Name</label>
                    <p class="text-gray-900 font-semibold">{{ $pet->name }}</p>
                </div>
                <div>
                    <label class="block mb-2 text-gray-700 font-medium">Pet Type</label>
                    <p class="text-gray-900 font-semibold">{{ $pet->type }}</p>
                </div>
            </div>

            @php
                // Define all medical tabs with their display names
                $medicalTabs = [
                    'vaccination' => 'Vaccination',
                    'checkup' => 'Check-Up / Wellness Exams',
                    'surgery' => 'Surgery'
                ];
            @endphp
            
            <!-- Service name Selection -->
            <div class="mb-6">
                <label class="block mb-2 text-gray-700 font-medium">Service Type</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="flex items-center space-x-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="radio" name="service_type" value="vaccination" class="h-5 w-5 text-red-600" checked>
                        <span class="text-gray-700">Vaccination</span>
                    </label>
                    <label class="flex items-center space-x-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="radio" name="service_type" value="checkup" class="h-5 w-5 text-red-600">
                        <span class="text-gray-700">Check-Up</span>
                    </label>
                    <label class="flex items-center space-x-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="radio" name="service_type" value="surgery" class="h-5 w-5 text-red-600">
                        <span class="text-gray-700">Surgery</span>
                    </label>
                </div>
            </div>

            <!-- Dynamic Form Sections -->
            <div id="vaccination-section" class="service-section">
                <h5 class="text-lg font-medium text-gray-800 mb-3">Vaccination Details</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="vaccine_type" class="block mb-2 text-gray-700 font-medium">Vaccine Type</label>
                        <select id="vaccine_type" name="vaccine_type" class="w-full border rounded px-4 py-2">
                            <option value="">Select Vaccine</option>
                            <option value="rabies">Rabies</option>
                            <option value="distemper">Distemper</option>
                            <option value="parvovirus">Parvovirus</option>
                            <option value="bordetella">Bordetella</option>
                        </select>
                    </div>
                    <div>
                        <label for="next_due_date" class="block mb-2 text-gray-700 font-medium">Next Due Date</label>
                        <input type="date" id="next_due_date" name="next_due_date" class="w-full border rounded px-4 py-2">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="vaccination_notes" class="block mb-2 text-gray-700 font-medium">Notes</label>
                    <textarea id="vaccination_notes" name="vaccination_notes" rows="3" class="w-full border rounded px-4 py-2"></textarea>
                </div>
            </div>

            <div id="checkup-section" class="service-section hidden">
                <h5 class="text-lg font-medium text-gray-800 mb-3">Check-Up Details</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="weight" class="block mb-2 text-gray-700 font-medium">Weight (kg)</label>
                        <input type="number" step="0.1" id="weight" name="weight" class="w-full border rounded px-4 py-2">
                    </div>
                    <div>
                        <label for="temperature" class="block mb-2 text-gray-700 font-medium">Temperature (°C)</label>
                        <input type="number" step="0.1" id="temperature" name="temperature" class="w-full border rounded px-4 py-2">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700 font-medium">Check-Up Items</label>
                    <div class="space-y-2">
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="checkup_items[]" value="teeth" class="h-5 w-5 text-red-600">
                            <span class="text-gray-700">Teeth Examination</span>
                        </label>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="checkup_items[]" value="ears" class="h-5 w-5 text-red-600">
                            <span class="text-gray-700">Ears Examination</span>
                        </label>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="checkup_items[]" value="skin" class="h-5 w-5 text-red-600">
                            <span class="text-gray-700">Skin & Coat Check</span>
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="checkup_notes" class="block mb-2 text-gray-700 font-medium">Notes</label>
                    <textarea id="checkup_notes" name="checkup_notes" rows="3" class="w-full border rounded px-4 py-2"></textarea>
                </div>
            </div>

            <div id="surgery-section" class="service-section hidden">
                <h5 class="text-lg font-medium text-gray-800 mb-3">Surgery Details</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="surgery_type" class="block mb-2 text-gray-700 font-medium">Surgery Type</label>
                        <select id="surgery_type" name="surgery_type" class="w-full border rounded px-4 py-2">
                            <option value="">Select Surgery Type</option>
                            <option value="spay_neuter">Spay/Neuter</option>
                            <option value="dental">Dental Surgery</option>
                            <option value="orthopedic">Orthopedic Surgery</option>
                            <option value="soft_tissue">Soft Tissue Surgery</option>
                        </select>
                    </div>
                    <div>
                        <label for="anesthesia_type" class="block mb-2 text-gray-700 font-medium">Anesthesia Type</label>
                        <input type="text" id="anesthesia_type" name="anesthesia_type" class="w-full border rounded px-4 py-2">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="surgery_date" class="block mb-2 text-gray-700 font-medium">Surgery Date</label>
                        <input type="datetime-local" id="surgery_date" name="surgery_date" class="w-full border rounded px-4 py-2">
                    </div>
                    <div>
                        <label for="recovery_time" class="block mb-2 text-gray-700 font-medium">Recovery Time (days)</label>
                        <input type="number" id="recovery_time" name="recovery_time" class="w-full border rounded px-4 py-2">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="post_op_instructions" class="block mb-2 text-gray-700 font-medium">Post-Op Instructions</label>
                    <textarea id="post_op_instructions" name="post_op_instructions" rows="3" class="w-full border rounded px-4 py-2"></textarea>
                </div>
            </div>

            <!-- Common Medical Fields -->
            <div class="mb-6">
                <label for="diagnosis" class="block mb-2 text-gray-700 font-medium">Diagnosis</label>
                <input type="text" id="diagnosis" name="diagnosis" class="w-full border rounded px-4 py-2" required>
            </div>

            <div class="mb-6">
                <label for="treatment" class="block mb-2 text-gray-700 font-medium">Treatment</label>
                <textarea id="treatment" name="treatment" rows="4" class="w-full border rounded px-4 py-2"></textarea>
            </div>

            <!-- Medications Section -->
            <div class="mb-6">
                <label class="block mb-2 text-gray-700 font-medium">Medications</label>
                <div id="medications-container">
                    <div class="medication-entry grid grid-cols-1 md:grid-cols-5 gap-4 mb-3">
                        <div>
                            <input type="text" name="medications[0][name]" placeholder="Medication Name" class="w-full border rounded px-4 py-2">
                        </div>
                        <div>
                            <input type="text" name="medications[0][dosage]" placeholder="Dosage" class="w-full border rounded px-4 py-2">
                        </div>
                        <div>
                            <input type="text" name="medications[0][frequency]" placeholder="Frequency" class="w-full border rounded px-4 py-2">
                        </div>
                        <div>
                            <input type="text" name="medications[0][duration]" placeholder="Duration" class="w-full border rounded px-4 py-2">
                        </div>
                        <div>
                            <button type="button" class="remove-medication text-red-600 hover:text-red-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-medication" class="mt-2 inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded text-white bg-red-600 hover:bg-red-700">
                    <i class="fas fa-plus mr-1"></i> Add Medication
                </button>
            </div>

            <!-- Attachments -->
            <div class="mb-6">
                <label class="block mb-2 text-gray-700 font-medium">Attachments</label>
                <input type="file" name="attachments[]" multiple accept="image/*,.pdf" class="w-full border rounded px-4 py-2">
                <p class="text-sm text-gray-500 mt-1">Upload images or PDFs (max 5 files)</p>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.pet-records.show', $appointment->id) }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">Cancel</a>
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                Submit Record
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show/hide service type sections
    const serviceTypeRadios = document.querySelectorAll('input[name="service_type"]');
    const serviceSections = document.querySelectorAll('.service-section');
    
    serviceTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            serviceSections.forEach(section => {
                section.classList.add('hidden');
            });
            document.getElementById(`${this.value}-section`).classList.remove('hidden');
        });
    });

    // Medication management
    let medicationCount = 1;
    const addMedicationBtn = document.getElementById('add-medication');
    const medicationsContainer = document.getElementById('medications-container');
    
    addMedicationBtn.addEventListener('click', function() {
        const newEntry = document.createElement('div');
        newEntry.className = 'medication-entry grid grid-cols-1 md:grid-cols-5 gap-4 mb-3';
        newEntry.innerHTML = `
            <div>
                <input type="text" name="medications[${medicationCount}][name]" placeholder="Medication Name" class="w-full border rounded px-4 py-2">
            </div>
            <div>
                <input type="text" name="medications[${medicationCount}][dosage]" placeholder="Dosage" class="w-full border rounded px-4 py-2">
            </div>
            <div>
                <input type="text" name="medications[${medicationCount}][frequency]" placeholder="Frequency" class="w-full border rounded px-4 py-2">
            </div>
            <div>
                <input type="text" name="medications[${medicationCount}][duration]" placeholder="Duration" class="w-full border rounded px-4 py-2">
            </div>
            <div>
                <button type="button" class="remove-medication text-red-600 hover:text-red-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        medicationsContainer.appendChild(newEntry);
        medicationCount++;
    });

    medicationsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-medication') || e.target.closest('.remove-medication')) {
            const entry = e.target.closest('.medication-entry');
            if (entry) {
                entry.remove();
            }
        }
    });
});
</script>
@endsection