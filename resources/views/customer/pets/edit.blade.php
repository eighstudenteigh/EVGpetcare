@extends('layouts.customer')

@section('content')
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Edit Pet: {{ $pet->name }}</h2>
                        <a href="{{ route('customer.pets.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Back to Pets</a>
                    </div>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('customer.pets.update', $pet) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Pet Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $pet->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Pet Type</label>
                                    <select name="type" id="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="">Select Pet Type</option>
                                        @foreach($petTypes as $petType)
                                            <option value="{{ $petType->name }}" {{ old('type', $pet->type) == $petType->name ? 'selected' : '' }}>{{ $petType->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="breed" class="block text-gray-700 text-sm font-bold mb-2">Breed (optional)</label>
                                    <input type="text" name="breed" id="breed" value="{{ old('breed', $pet->breed) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Gender</label>
                                    <div class="flex mt-2">
                                        <div class="mr-4">
                                            <input type="radio" name="gender" id="male" value="male" {{ old('gender', $pet->gender) == 'male' ? 'checked' : '' }} class="mr-1">
                                            <label for="male">Male</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="gender" id="female" value="female" {{ old('gender', $pet->gender) == 'female' ? 'checked' : '' }} class="mr-1">
                                            <label for="female">Female</label>
                                        </div>
                                    </div>
                                    @error('gender')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div>
                                <div class="mb-4">
                                    <label for="age" class="block text-gray-700 text-sm font-bold mb-2">Age (years, optional)</label>
                                    <input type="number" name="age" id="age" value="{{ old('age', $pet->age) }}" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                
                                <div class="mb-4">
                                    <label for="weight" class="block text-gray-700 text-sm font-bold mb-2">Weight (kg, optional)</label>
                                    <input type="number" name="weight" id="weight" value="{{ old('weight', $pet->weight) }}" step="0.01" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                
                                <div class="mb-4">
                                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Pet Image (optional)</label>
                                    @if($pet->image)
                                        <div class="mb-2">
                                            @if($pet->image)
                                            <img src="{{ asset('pets/' . basename($pet->image)) }}" alt="Pet Image">
                                            @endif
                                        </div>
                                    @endif
                                    <input type="file" name="image" id="image" class="w-full">
                                    <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">Notes (optional)</label>
                            <textarea name="notes" id="notes" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('notes', $pet->notes) }}</textarea>
                        </div>
                        
                        <div class="flex items-center justify-between mt-6">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update Pet
                            </button>
                            
                            {{-- <form action="{{ route('customer.pets.destroy', $pet) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this pet? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Delete Pet
                                </button>
                            </form> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection