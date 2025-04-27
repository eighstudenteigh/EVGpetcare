@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Services</h1>
        <div class="space-x-2">
            <a href="{{ route('admin.services.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Create Service</a>
            <a href="{{ route('admin.vaccine-types.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">Create Vaccine Type</a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 bg-white rounded shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Service</th>
                    <th class="px-4 py-2 text-left">Type</th>
                    <th class="px-4 py-2 text-left">Pricing Details</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr class="border-t">
                        <td class="px-4 py-3 font-semibold">
                            {{ $service->name }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $service->is_vaccination ? 'Vaccination' : 'Regular' }}
                        </td>
                        <td class="px-4 py-3">
                            @if($service->is_vaccination)
    @foreach($service->vaccinePricings as $pricing)
        <div class="text-sm">
            <span class="font-medium">{{ $pricing->vaccineType->name }}</span> 
            @if($pricing->petType)
                for {{ $pricing->petType->name }}: 
            @else
                (Universal):
            @endif
            ₱{{ number_format($pricing->price, 2) }}
        </div>
    @endforeach
@else
    @foreach($service->petTypes as $petType)
        <div class="text-sm">
            {{ $petType->name }}: 
            <span class="font-medium">₱{{ number_format($petType->pivot->price, 2) }}</span>
        </div>
    @endforeach
@endif
                        </td>
                        <td class="px-4 py-3 space-y-1">
                            <a href="{{ route('admin.services.edit', $service) }}" 
                               class="text-blue-600 hover:underline block">Edit</a>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection