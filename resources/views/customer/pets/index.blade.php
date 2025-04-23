@extends('layouts.customer')
@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">My Pets</h2>
                        <a href="{{ route('customer.pets.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add New Pet</a>
                    </div>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($pets as $pet)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                                <div class="relative h-48 bg-gray-200">
                                    @if($pet->image)
                                        <img src="{{ asset('storage/' . $pet->image) }}" alt="{{ $pet->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6c-2.209 0-4 1.791-4 4s1.791 4 4 4 4-1.791 4-4-1.791-4-4-4zm0 7c-1.654 0-3-1.346-3-3s1.346-3 3-3 3 1.346 3 3-1.346 3-3 3zm-7 4c.208-.005.4-.105.516-.264l.828-1.104c.135-.18.35-.272.566-.272h10.18c.216 0 .431.092.566.272l.828 1.104c.116.159.308.259.516.264h1v1H5v-1h1z"></path>
                                                <path d="M9 10h1v1H9zm6 0h1v1h-1z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                                        <h3 class="text-xl font-semibold text-white">{{ $pet->name }}</h3>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="text-gray-600">
                                        <p class="flex items-center">
                                            <span class="font-medium w-16">Type:</span> 
                                            <span>{{ $pet->type }}</span>
                                        </p>
                                        <p class="flex items-center">
                                            <span class="font-medium w-16">Breed:</span> 
                                            <span>{{ $pet->breed ?? 'Not specified' }}</span>
                                        </p>
                                        <p class="flex items-center">
                                            <span class="font-medium w-16">Gender:</span> 
                                            <span>{{ ucfirst($pet->gender) }}</span>
                                        </p>
                                        <p class="flex items-center">
                                            <span class="font-medium w-16">Age:</span> 
                                            <span>{{ $pet->age ?? 'Not specified' }} {{ ($pet->age == 1) ? 'year' : 'years' }}</span>
                                        </p>
                                        @if($pet->weight)
                                        <p class="flex items-center">
                                            <span class="font-medium w-16">Weight:</span> 
                                            <span>{{ $pet->weight }} kg</span>
                                        </p>
                                        @endif
                                    </div>
                                    <div class="mt-4 flex justify-between">
                                        <a href="{{ route('customer.pets.show', $pet) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">View Details</a>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('customer.pets.edit', $pet) }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Edit</a>
                                            {{-- <form action="{{ route('customer.pets.destroy', $pet) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to remove this pet?')">Delete</button>
                                            </form> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500">You don't have any pets registered yet.</p>
                                <a href="{{ route('customer.pets.create') }}" class="mt-2 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add Your First Pet</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection