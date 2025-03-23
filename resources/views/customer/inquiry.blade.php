@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md p-6 rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-700 mb-4"> Send an Inquiry</h2>

    @if(session('success'))
        <p class="text-green-600 bg-green-100 p-3 rounded-md">{{ session('success') }}</p>
    @endif

    <form action="{{ route('customer.inquiry.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="text-gray-700 font-medium">Full Name:</label>
            <input type="text" name="name" class="w-full p-2 border rounded" required>
        </div>
        <div>
            <label class="text-gray-700 font-medium">Email:</label>
            <input type="email" name="email" class="w-full p-2 border rounded" required>
        </div>
        <div>
            <label class="text-gray-700 font-medium">Contact Number:</label>
            <input type="text" name="contact_number" class="w-full p-2 border rounded" pattern="\d{10,11}" maxlength="11" oninput="this.value = this.value.replace(/\D/g, '')">
        </div>

        <!-- 🐾 Optional: Select Pet Type -->
        <div>
            <label class="text-gray-700 font-medium">Pet Type (Optional):</label>
            <select name="pet_type_id" class="w-full p-2 border rounded">
                <option value="">-- Select a Pet Type --</option>
                @foreach($petTypes as $type)
                    <option value="{{ $type->id }}">{{ ucfirst($type->name) }}</option>
                @endforeach
            </select>
        </div>

        <!-- 🛠 Optional: Select Service -->
        <div>
            <label class="text-gray-700 font-medium">Service (Optional):</label>
            <select name="service_id" class="w-full p-2 border rounded">
                <option value="">-- Select a Service --</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-gray-700 font-medium">Message:</label>
            <textarea name="message" class="w-full p-2 border rounded" rows="4" required></textarea>
        </div>
        
        <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
            Send Inquiry
        </button>
    </form>
</div>
@endsection
