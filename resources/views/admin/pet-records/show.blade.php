@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Current Appointment Services</h1>
        <div>
            <a href="{{ route('admin.appointments.approved') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Back to Appointments
            </a>
        </div>
    </div>

    <!-- Appointment Details Card -->
    <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
        <div class="bg-blue-600 text-white px-6 py-4">
            <h2 class="text-xl font-semibold">Appointment Details</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="mb-2"><strong class="text-gray-700">Client:</strong> {{ $appointment->user->name }}</p>
                    <p class="mb-2"><strong class="text-gray-700">Date:</strong> {{ $appointment->appointment_date->format('M d, Y') }}</p>
                    <p class="mb-2"><strong class="text-gray-700">Time:</strong> {{ $appointment->appointment_date->format('h:i A') }}</p>
                </div>
                <div>
                    <p class="mb-2"><strong class="text-gray-700">Status:</strong> 
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ getStatusBadge($appointment->status) }}-100 text-{{ getStatusBadge($appointment->status) }}-800">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </p>
                    <p class="mb-2"><strong class="text-gray-700">Services:</strong> 
                        @foreach($services as $service)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mr-1">
                                {{ $service->name }}
                            </span>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Entry Forms Card -->
    <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
        <div class="bg-blue-600 text-white px-6 py-4">
            <h2 class="text-xl font-semibold">Service Entry Forms</h2>
        </div>
        <div class="p-6">
            <!-- Pet service cards grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($pets as $pet)
                <div class="border rounded-lg overflow-hidden">
                    <div class="bg-white border-b px-4 py-3">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $pet->name }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ getPetCompletionBadge($pet, $appointment, $services) }}-100 text-{{ getPetCompletionBadge($pet, $appointment, $services) }}-800">
                                {{ getPetCompletionText($pet, $appointment, $services) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <div class="flex mb-4">
                            @if($pet->photo_path)
                                <img src="{{ asset('storage/' . $pet->photo_path) }}" alt="{{ $pet->name }}" class="w-20 h-20 rounded-full object-cover border-2 border-gray-200">
                            @else
                                <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center border-2 border-gray-200">
                                    <i class="fas fa-paw text-gray-400 text-2xl"></i>
                                </div>
                            @endif
                            
                            <div class="ml-4">
                                <p class="text-sm mb-1"><strong class="text-gray-700">Type:</strong> {{ $pet->petType->name ?? 'N/A' }}</p>
                                <p class="text-sm mb-1"><strong class="text-gray-700">Breed:</strong> {{ $pet->breed }}</p>
                                <p class="text-sm"><strong class="text-gray-700">Age:</strong> {{ $pet->age }}</p>
                            </div>
                        </div>
                        
                        <h4 class="border-b pb-2 mb-3 text-gray-700 font-medium">Services To Complete</h4>
                        
                        <div class="space-y-2">
                            @foreach($services as $service)
                                @php
                                    $recordExists = false;
                                    if ($service->service_type == 'grooming') {
                                        $recordExists = $pet->hasGroomingRecord($appointment->id);
                                        $route = route('admin.pet-records.create-grooming', ['appointment' => $appointment->id, 'pet' => $pet->id]);
                                        $color = 'blue';
                                        $icon = 'fa-cut';
                                    } elseif ($service->service_type == 'medical') {
                                        $recordExists = $pet->hasMedicalRecord($appointment->id);
                                        $route = route('admin.pet-records.create-medical', ['appointment' => $appointment->id, 'pet' => $pet->id]);
                                        $color = 'red';
                                        $icon = 'fa-heartbeat';
                                    } elseif ($service->service_type == 'boarding') {
                                        $recordExists = $pet->hasBoardingRecord($appointment->id);
                                        $route = route('admin.pet-records.create-boarding', ['appointment' => $appointment->id, 'pet' => $pet->id]);
                                        $color = 'yellow';
                                        $icon = 'fa-home';
                                    }
                                    $buttonText = $recordExists ? 'Edit Service Record' : 'Create Service Record';
                                @endphp
                        
                                <div class="border rounded-md p-3">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <div class="flex items-center">
                                                <i class="fas {{ $icon }} mr-2 text-{{ $color }}-500"></i>
                                                <h6 class="font-medium text-gray-800">{{ $service->name }}</h6>
                                            </div>
                                            <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-xs font-medium bg-{{ $recordExists ? 'green' : 'gray' }}-100 text-{{ $recordExists ? 'green' : 'gray' }}-800">
                                                <i class="fas {{ $recordExists ? 'fa-check' : 'fa-clock' }} mr-1"></i>
                                                {{ $recordExists ? 'Completed' : 'Pending' }}
                                            </span>
                                        </div>
                        
                                        <!-- ✅ Changed from <form> to <a> since this is just navigation -->
                                        <a href="{{ $route }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-{{ $color }}-600 hover:bg-{{ $color }}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $color }}-500">
                                            <i class="fas {{ $recordExists ? 'fa-edit' : 'fa-plus' }} mr-1"></i>
                                            {{ $buttonText }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Appointment Progress Card -->
<div class="bg-white rounded-lg shadow-md mt-6 overflow-hidden">
    <div class="bg-blue-600 text-white px-6 py-4">
        <h2 class="text-xl font-semibold">Appointment Progress</h2>
    </div>
    <div class="p-6">
        @php
            $totalServices = count($pets) * count($services);
            $completedServices = 0;
            
            foreach($pets as $pet) {
                foreach($services as $service) {
                    if($service->service_type == 'grooming' && $pet->hasGroomingRecord($appointment->id)) {
                        $completedServices++;
                    } elseif($service->service_type == 'medical' && $pet->hasMedicalRecord($appointment->id)) {
                        $completedServices++;
                    } elseif($service->service_type == 'boarding' && $pet->hasBoardingRecord($appointment->id)) {
                        $completedServices++;
                    }
                }
            }
            
            $percentComplete = $totalServices > 0 ? ($completedServices / $totalServices) * 100 : 0;
            $allComplete = $completedServices == $totalServices && $totalServices > 0;
        @endphp
        
        <h6 class="text-gray-700 mb-2">Service Records: {{ $completedServices }} of {{ $totalServices }} completed</h6>
        
        
        
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            @if($appointment->status !== 'completed')

                <form action="{{ route('admin.appointments.complete', $appointment->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-check-circle mr-2"></i> Mark Appointment as Completed
                    </button>
                </form>
            @else
                <div class="flex items-center">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-1"></i> Appointment Completed
                    </span>
                </div>
            @endif
            
            <form action="{{ route('admin.appointments.finalize', $appointment->id) }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 {{ $allComplete ? '' : 'opacity-50 cursor-not-allowed' }}" {{ $allComplete ? '' : 'disabled' }}>
                    <i class="fas fa-clipboard-check mr-2"></i> Finalize All Records
                </button>
            </form>
        </div>
    </div>
</div>
</div>

@php
/**
 * Get the appropriate badge color for the appointment status
 */
function getStatusBadge($status) {
    switch($status) {
        case 'pending': return 'yellow';
        case 'approved': return 'blue';
        case 'completed': return 'green';
        case 'finalized': return 'indigo';
        case 'rejected': return 'red';
        default: return 'gray';
    }
}

/**
 * Get the appropriate badge color for pet completion status
 */
function getPetCompletionBadge($pet, $appointment, $services) {
    $totalServices = count($services);
    $completedServices = 0;
    
    foreach($services as $service) {
        if($service->service_type == 'grooming' && $pet->hasGroomingRecord($appointment->id)) {
            $completedServices++;
        } elseif($service->service_type == 'medical' && $pet->hasMedicalRecord($appointment->id)) {
            $completedServices++;
        } elseif($service->service_type == 'boarding' && $pet->hasBoardingRecord($appointment->id)) {
            $completedServices++;
        }
    }
    
    if($completedServices === 0) return 'gray';
    if($completedServices < $totalServices) return 'yellow';
    return 'green';
}

/**
 * Get the text representation of pet completion status
 */
function getPetCompletionText($pet, $appointment, $services) {
    $totalServices = count($services);
    $completedServices = 0;
    
    foreach($services as $service) {
        if($service->service_type == 'grooming' && $pet->hasGroomingRecord($appointment->id)) {
            $completedServices++;
        } elseif($service->service_type == 'medical' && $pet->hasMedicalRecord($appointment->id)) {
            $completedServices++;
        } elseif($service->service_type == 'boarding' && $pet->hasBoardingRecord($appointment->id)) {
            $completedServices++;
        }
    }
    
    if($completedServices === 0) return 'Not Started';
    if($completedServices < $totalServices) return $completedServices . '/' . $totalServices . ' Services';
    return 'All Complete';
}
@endphp
@endsection