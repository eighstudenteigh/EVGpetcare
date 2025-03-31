@extends('layouts.admin')

@section('title', 'Manage Inquiries')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">📨 Customer Inquiries</h2>

    @if(session('success'))
        <p class="text-green-600 bg-green-100 p-3 rounded-md">{{ session('success') }}</p>
    @endif

    <!-- 🛠 Inquiry Details Modal -->
    <div id="inquiryDetailsModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 max-h-[90vh] overflow-y-auto">
            <h2 class="text-xl font-bold mb-4">📩 Inquiry Details</h2>

            <div class="space-y-3">
                <p><strong>Name:</strong> <span id="inquiryName"></span></p>
                <p><strong>Email:</strong> <span id="inquiryEmail"></span></p>
                <p><strong>Contact:</strong> <span id="inquiryContact"></span></p>
                <p><strong>Pet Type:</strong> <span id="inquiryPetType">Not specified</span></p>
                <p><strong>Service:</strong> <span id="inquiryService">Not specified</span></p>
                <p><strong>Message:</strong></p>
                <div id="inquiryMessage" class="p-3 bg-gray-100 rounded-md"></div>
                <p><strong>Status:</strong> 
                    <span id="inquiryStatus" class="px-2 py-1 rounded"></span>
                </p>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" id="markAsReadBtn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Mark as Read
                </button>
                <button type="button" id="closeInquiryModal" class="bg-gray-600 hover:bg-gray-800 text-white px-4 py-2 rounded">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- 📩 Inquiries Table -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="w-full border-collapse">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="p-3 text-left w-1/6">Name</th>
                    <th class="p-3 text-left w-1/6">Email</th>
                    <th class="p-3 text-left w-1/6">Contact</th>
                    <th class="p-3 text-left w-1/6">Pet Type</th>
                    <th class="p-3 text-left w-1/6">Service</th>
                    <th class="p-3 text-left w-1/6">Message</th>
                    <th class="p-3 text-left w-1/12">Status</th>
                    <th class="p-3 text-left w-1/6">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inquiries as $inquiry)
                <tr class="border-b inquiry-row" data-id="{{ $inquiry->id }}">
                    <td class="p-3 truncate max-w-[120px]" title="{{ $inquiry->name }}">{{ $inquiry->name }}</td>
                    <td class="p-3 truncate max-w-[150px]" title="{{ $inquiry->email }}">{{ $inquiry->email }}</td>
                    <td class="p-3 truncate max-w-[120px]" title="{{ $inquiry->contact_number }}">{{ $inquiry->contact_number ?? 'N/A' }}</td>
                    <td class="p-3 truncate max-w-[120px]">{{ optional($inquiry->petType)->name ?? 'Not specified' }}</td>
                    <td class="p-3 truncate max-w-[120px]">{{ optional($inquiry->service)->name ?? 'Not specified' }}</td>
                    <td class="p-3 truncate max-w-[150px]" title="{{ $inquiry->message }}">{{ \Illuminate\Support\Str::limit($inquiry->message, 25) }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded {{ $inquiry->status == 'unread' ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                            {{ ucfirst($inquiry->status) }}
                        </span>
                    </td>
                    <td class="p-3 flex gap-2">
                        <!-- 🔍 View Button -->
                        <button class="view-inquiry-btn bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded"
                            data-id="{{ $inquiry->id }}"
                            data-name="{{ $inquiry->name }}"
                            data-email="{{ $inquiry->email }}"
                            data-contact="{{ $inquiry->contact_number ?? 'N/A' }}"
                            data-pettype="{{ optional($inquiry->petType)->name ?? 'Not specified' }}"
                            data-service="{{ optional($inquiry->service)->name ?? 'Not specified' }}"
                            data-message="{{ $inquiry->message }}"
                            data-status="{{ $inquiry->status }}">
                            View
                        </button>

                        <!-- ❌ Delete Button -->
                        <button class="delete-inquiry-btn bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded"
                            data-id="{{ $inquiry->id }}">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach                
            </tbody>
        </table>
    </div>
</div>



<script>document.addEventListener("DOMContentLoaded", function () {
    const viewButtons = document.querySelectorAll(".view-inquiry-btn");
    const inquiryDetailsModal = document.getElementById("inquiryDetailsModal");
    const closeInquiryModal = document.getElementById("closeInquiryModal");
    const markAsReadBtn = document.getElementById("markAsReadBtn");

    // Store the currently selected inquiry ID
    let currentInquiryId = null;

    // ✅ Open Inquiry Modal & Populate Fields
    viewButtons.forEach(button => {
        button.addEventListener("click", function () {
            currentInquiryId = this.dataset.id; // Store the ID

            document.getElementById("inquiryName").textContent = this.dataset.name;
            document.getElementById("inquiryEmail").textContent = this.dataset.email;
            document.getElementById("inquiryContact").textContent = this.dataset.contact || "N/A";
            document.getElementById("inquiryPetType").textContent = this.dataset.pettype || "Not specified";
            document.getElementById("inquiryService").textContent = this.dataset.service || "Not specified";
            document.getElementById("inquiryMessage").textContent = this.dataset.message;

            const statusElement = document.getElementById("inquiryStatus");
            statusElement.textContent = this.dataset.status;

            // ✅ Remove existing status classes
            statusElement.classList.remove("bg-red-500", "bg-green-500", "text-white");

            // ✅ Add correct status classes separately
            if (this.dataset.status === "unread") {
                statusElement.classList.add("bg-red-500", "text-white");
                markAsReadBtn.style.display = "inline-block"; // Show button if unread
            } else {
                statusElement.classList.add("bg-green-500", "text-white");
                markAsReadBtn.style.display = "none"; // Hide if already read
            }

            inquiryDetailsModal.style.display = "flex";
        });
    });

    // ✅ Close Modal
    closeInquiryModal.addEventListener("click", function () {
        inquiryDetailsModal.style.display = "none";
    });

    // ✅ Close modal when clicking outside
    inquiryDetailsModal.addEventListener("click", function (e) {
        if (e.target === inquiryDetailsModal) {
            inquiryDetailsModal.style.display = "none";
        }
    });

    // ✅ Handle AJAX Mark as Read
    markAsReadBtn.addEventListener("click", function () {
        if (!currentInquiryId) return;

        // Alternative approach: Create an actual form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/inquiries/${currentInquiryId}/read`;
        form.style.display = 'none';
        
        // Add CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfInput);
        
        // Add to document and submit
        document.body.appendChild(form);
        
        // Use fetch for AJAX behavior
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // ✅ Update the status in the table instantly
                let row = document.querySelector(`.inquiry-row[data-id="${currentInquiryId}"]`);
                let statusCell = row.querySelector("td:nth-child(7) span"); // Status cell
                
                // ✅ Change the text and color
                statusCell.textContent = "Read";
                statusCell.classList.remove("bg-red-500");
                statusCell.classList.add("bg-green-500", "text-white");
                
                // ✅ Update the button's data-status attribute
                let viewButton = row.querySelector(".view-inquiry-btn");
                if (viewButton) {
                    viewButton.dataset.status = "read";
                }

                // ✅ Hide "Mark as Read" button in modal
                markAsReadBtn.style.display = "none";
                
                // Update status in modal
                const statusElement = document.getElementById("inquiryStatus");
                statusElement.textContent = "read";
                statusElement.classList.remove("bg-red-500");
                statusElement.classList.add("bg-green-500", "text-white");

                // ✅ Hide the modal
                inquiryDetailsModal.style.display = "none";
                
                alert("Inquiry marked as read.");
            } else {
                alert("Failed to mark as read: " + (data.message || "Unknown error"));
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while marking the inquiry as read.");
        })
        .finally(() => {
            // Clean up the form
            form.remove();
        });
    });

    // ✅ Handle Delete with similar approach
    document.querySelectorAll(".delete-inquiry-btn").forEach(button => {
        button.addEventListener("click", function () {
            let inquiryId = this.dataset.id;
            if (!confirm("Are you sure you want to delete this inquiry?")) return;

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/inquiries/${inquiryId}`;
            form.style.display = 'none';
            
            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfInput);
            
            // Add method spoofing for DELETE
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            // Add to document and submit via fetch
            document.body.appendChild(form);
            
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(`.inquiry-row[data-id="${inquiryId}"]`).remove();
                    alert("Inquiry deleted successfully.");
                } else {
                    alert("Failed to delete inquiry.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred while deleting the inquiry.");
            })
            .finally(() => {
                form.remove();
            });
        });
    });
});</script>
    
    

@endsection
