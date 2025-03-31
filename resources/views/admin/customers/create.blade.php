@extends('layouts.admin')

@section('title', 'Add New Customer')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Add New Customer</h2>

    <!-- ✅ Success Message -->
    @if(session('success'))
        <p class="text-green-600 bg-green-100 p-3 rounded-md">{{ session('success') }}</p>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.customers.store') }}" method="POST">
            @csrf

            <!-- 🔹 Full Name (Letters and spaces only, max 255) -->
            <div class="mb-4">
                <label class="text-gray-700 font-medium">Full Name <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}" 
                    class="w-full p-2 border rounded @error('name') border-red-500 @enderror"
                    pattern="^[A-Za-z\s]{1,255}$"
                    title="Only letters and spaces are allowed, max 255 characters."
                    maxlength="255"
                    required
                    placeholder="Enter full name"
                >
                @error('name') 
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- 🔹 Email (Validated by HTML5) -->
            <div class="mb-4">
                <label class="text-gray-700 font-medium">Email <span class="text-red-500">*</span></label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    class="w-full p-2 border rounded @error('email') border-red-500 @enderror"
                    maxlength="255"
                    required
                    placeholder="Enter a valid email address"
                >
                @error('email') 
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- 🔹 Password (Min 8 characters, one uppercase, one lowercase, one number) -->
            <div class="mb-4">
                <label class="text-gray-700 font-medium">Password <span class="text-red-500">*</span></label>
                <input 
                    type="password" 
                    name="password" 
                    class="w-full p-2 border rounded @error('password') border-red-500 @enderror"
                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$"
                    title="At least 8 characters, with one uppercase, one lowercase, and one number."
                    required
                    placeholder="Enter a strong password"
                >
                @error('password') 
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- 🔹 Confirm Password -->
            <div class="mb-4">
                <label class="text-gray-700 font-medium">Confirm Password <span class="text-red-500">*</span></label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    class="w-full p-2 border rounded"
                    required
                    placeholder="Re-enter the password"
                >
            </div>

            <!-- 🔹 Phone (10-11 digits only) -->
            <div class="mb-4">
                <label class="text-gray-700 font-medium">Phone <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    name="phone" 
                    value="{{ old('phone') }}" 
                    class="w-full p-2 border rounded @error('phone') border-red-500 @enderror"
                    pattern="\d{10,11}"
                    maxlength="11"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);"
                    required
                    placeholder="Enter a 10-11 digit phone number"
                >
                @error('phone') 
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- 🔹 Address (Letters, numbers, and basic punctuation) -->
            <div class="mb-4">
                <label class="text-gray-700 font-medium">Address <span class="text-red-500">*</span></label>
                <textarea 
                    name="address" 
                    class="w-full p-2 border rounded @error('address') border-red-500 @enderror"
                    maxlength="255"
                    required
                    placeholder="Enter address (max 255 characters)"
                    oninput="this.value = this.value.replace(/[^A-Za-z0-9\s,.-]/g, '').slice(0, 255);"
                >{{ old('address') }}</textarea>
                @error('address') 
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- 🔹 Submit Button -->
            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
                Add Customer
            </button>
        </form>
    </div>
</div>
@endsection
