{{-- resources\views\customer\pets\show.blade.php --}}
@extends('layouts.customer')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $pet->name }}</h2>
                        <div class="flex space-x-2">
                            <a href="{{ route('customer.pets.edit', $pet) }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Edit Pet</a>
                            <a href="{{ route('customer.pets.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Back to Pets</a>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <div class="bg-gray-100 p-4 rounded-lg">
                                @if($pet->image)
    <img src="{{ asset($pet->image) }}" alt="{{ $pet->name }}" class="w-full h-auto rounded">
@else
    <div class="w-full h-48 bg-gray-300 rounded flex items-center justify-center">
        <span class="text-gray-500">No Image</span>
    </div>
@endif

                                
                                <div class="mt-4">
                                    <h3 class="text-lg font-semibold mb-2">Basic Information</h3>
                                    <ul class="space-y-2">
                                        <li><span class="font-medium">Type:</span> {{ $pet->type }}</li>
                                        <li><span class="font-medium">Breed:</span> {{ $pet->breed ?? 'Not specified' }}</li>
                                        <li><span class="font-medium">Gender:</span> {{ ucfirst($pet->gender) }}</li>
                                        <li><span class="font-medium">Age:</span> {{ $pet->age ?? 'Not specified' }} years</li>
                                        <li><span class="font-medium">Weight:</span> {{ $pet->weight ? $pet->weight . ' kg' : 'Not specified' }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2">
                            <div class="bg-gray-100 p-4 rounded-lg mb-6">
                                <h3 class="text-lg font-semibold mb-2">Notes</h3>
                                <p class="text-gray-700">{{ $pet->notes ?? 'No notes available.' }}</p>
                            </div>
                            
                            <div class="bg-gray-100 p-4 rounded-lg"><div class="bg-gray-100 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-2">Appointment History</h3>
                                @if($appointments->count() > 0)
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full bg-white">
                                            <thead>
                                                <tr>
                                                    <th class="px-4 py-2 text-left">Date</th>
                                                    <th class="px-4 py-2 text-left">Service</th>
                                                    <th class="px-4 py-2 text-left">Status</th>
                                                    <th class="px-4 py-2 text-left">Actions</th> <!-- New column -->
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                @foreach($appointments as $appointment)
                                                    <tr>
                                                        <td class="px-4 py-2 whitespace-nowrap">{{ $appointment->appointment_date }}</td>
                                                        <td class="px-4 py-2 whitespace-nowrap">
                                                            @if($appointment->services->count() > 0)
                                                                {{ $appointment->services->pluck('name')->join(', ') }}
                                                            @else
                                                                No services specified
                                                            @endif
                                                        </td>
                                                        <td class="px-4 py-2 whitespace-nowrap">
                                                            @if($appointment->status == 'completed')
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    Completed
                                                                </span>
                                                            @elseif($appointment->status == 'approved')
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                                    Approved
                                                                </span>
                                                            @elseif($appointment->status == 'pending')
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                                    Pending
                                                                </span>
                                                            @else
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                    {{ ucfirst($appointment->status) }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td class="px-4 py-2 whitespace-nowrap">
                                                            @if($appointment->status == 'completed' || $appointment->status == 'finalized')
                                                                <a href="{{ route('customer.appointments.show', $appointment) }}" 
                                                                   class="text-blue-600 hover:text-blue-800">
                                                                    <i class="fas fa-eye"></i> View Details
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-gray-500">No appointment history available.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection