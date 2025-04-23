@extends('layouts.customer')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Add New Pet</h2>
                
                <form method="POST" action="{{ route('customer.pets.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Pet Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Pet Type</label>
                        <select name="type" id="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Pet Type</option>
                            @foreach($petTypes as $petType)
                                <option value="{{ $petType->name }}" {{ old('type') == $petType->name ? 'selected' : '' }}>{{ $petType->name }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="breed" class="block text-gray-700 text-sm font-bold mb-2">Breed (optional)</label>
                        <input type="text" name="breed" id="breed" value="{{ old('breed') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Gender</label>
                        <div class="flex mt-2">
                            <div class="mr-4">
                                <input type="radio" name="gender" id="male" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} class="mr-1">
                                <label for="male">Male</label>
                            </div>
                            <div>
                                <input type="radio" name="gender" id="female" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} class="mr-1">
                                <label for="female">Female</label>
                            </div>
                        </div>
                        @error('gender')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="age" class="block text-gray-700 text-sm font-bold mb-2">Age (years, optional)</label>
                        <input type="number" name="age" id="age" value="{{ old('age') }}" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    
                    <div class="mb-4">
                        <label for="weight" class="block text-gray-700 text-sm font-bold mb-2">Weight (kg, optional)</label>
                        <input type="number" name="weight" id="weight" value="{{ old('weight') }}" step="0.01" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    
                    <div class="mb-4">
                        <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">Notes (optional)</label>
                        <textarea name="notes" id="notes" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('notes') }}</textarea>
                    </div>
                    
                    <div class="mb-6">
                        <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Pet Image (optional)</label>
                        <input type="file" name="image" id="image" class="w-full">
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Add Pet
                        </button>
                        <a href="{{ route('customer.pets.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection