@extends('layouts.admin')

@section('title', 'Create Admin')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Register New Admin</h2>

        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-200 text-red-800 p-2 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admins.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-bold">Name:</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                    class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold">Email:</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                    class="w-full p-2 border border-gray-300 rounded" required>
                @if ($errors->has('email'))
                    <p class="text-red-600 text-sm mt-1">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold">Password:</label>
                <input type="password" name="password" 
                    class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold">Confirm Password:</label>
                <input type="password" name="password_confirmation" 
                    class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Admin</button>
        </form>
    </div>
@endsection
