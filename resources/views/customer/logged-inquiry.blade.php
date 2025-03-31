@extends('layouts.customer')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mt-8">
    <h2 class="text-2xl font-semibold mb-4">Customer Inquiry Form</h2>

    {{-- ✅ Success Message --}}
    @if(session('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- ❌ Error Message --}}
    @if(session('error'))
        <div class="p-4 mb-4 text-red-700 bg-red-100 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- 🛑 Validation Errors --}}
    @if ($errors->any())
        <div class="p-4 mb-4 text-red-700 bg-red-100 rounded-lg">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customer.inquiry.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="w-full p-2 border rounded" required>
        </div>

        <div>
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="w-full p-2 border rounded" required>
        </div>

        <div>
            <label class="block text-gray-700">Contact Number</label>
            <input type="text" name="contact_number" value="{{ old('contact_number') }}" class="w-full p-2 border rounded" placeholder="required">
        </div>

        <div>
            <label class="block text-gray-700">Select Pet Type</label>
            <select name="pet_type_id" class="w-full p-2 border rounded">
                <option value="" selected>None</option>
                @foreach($petTypes as $petType)
                    <option value="{{ $petType->id }}" {{ old('pet_type_id') == $petType->id ? 'selected' : '' }}>
                        {{ $petType->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Select Service</label>
            <select name="service_id" class="w-full p-2 border rounded">
                <option value="" selected>None</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                        {{ $service->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Message</label>
            <textarea name="message" class="w-full p-2 border rounded" required>{{ old('message') }}</textarea>
        </div>

        <button type="submit" class="bg-orange-600 text-white py-2 px-4 rounded hover:bg-gray-700">
            Send Inquiry
        </button>
    </form>
</div>
@endsection
