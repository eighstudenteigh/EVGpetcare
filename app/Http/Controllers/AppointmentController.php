<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\Pet;
use App\Models\ClosedDay;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ServiceVaccinePricing;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    protected function attachPets($appointment, $petIds)
    {
        $appointment->pets()->attach($petIds);
    }
    // Show user's appointments
    public function index(Request $request)
{
    $userId = Auth::id();
    
    // Start building the query
    $query = Appointment::where('user_id', $userId)
        ->with(['pets', 'services'])
        ->orderBy('appointment_date', 'asc')
        ->orderBy('appointment_time', 'asc');

    // Status Filter
    if ($request->has('status') && $request->status != 'all') {
        $query->where('status', $request->status);
    }

    // Date Range Filter
    if ($request->has('date_range')) {
        switch ($request->date_range) {
            case 'upcoming':
                $query->where('appointment_date', '>=', now()->format('Y-m-d'));
                break;
            case 'past':
                $query->where('appointment_date', '<', now()->format('Y-m-d'));
                break;
            case 'custom' && $request->has(['start_date', 'end_date']):
                $query->whereBetween('appointment_date', [
                    $request->start_date,
                    $request->end_date
                ]);
                break;
        }
    }

    // Pet Filter
    if ($request->has('pet_id') && $request->pet_id != 'all') {
        $query->whereHas('pets', function($q) use ($request) {
            $q->where('pets.id', $request->pet_id);
        });
    }

    // Service Filter
    if ($request->has('service_id') && $request->service_id != 'all') {
        $query->whereHas('services', function($q) use ($request) {
            $q->where('services.id', $request->service_id);
        });
    }

    $appointments = $query->get();
    $pets = Pet::where('customer_id', $userId)->get();
    $services = Service::all();
    $petsCount = $pets->count();

    return view('customer.appointments.index', compact('appointments', 'pets', 'services', 'petsCount'));
}

    // Get available time slots
    public function getAvailability(Request $request)
    {
        $date = $request->input('date');
    
        if (!$date || !strtotime($date)) {
            return response()->json(['error' => 'Invalid date provided'], 400);
        }
    
        $appointmentDate = Carbon::parse($date);
        if ($appointmentDate->isWeekend()) {
            return response()->json(['error' => 'Appointments cannot be booked on weekends'], 400);
        }
    
        if (ClosedDay::where('date', $appointmentDate->format('Y-m-d'))->exists()) {
            return response()->json(['error' => 'This date is unavailable for appointments'], 400);
        }
    
        $maxAppointmentsPerDay = config('settings.max_appointments_per_day', 10);
        $maxAppointmentsPerSlot = 3;
    
        // Check total bookings for the selected day
        $dailyCount = Appointment::where('appointment_date', $date)
            ->whereIn('status', ['pending', 'approved'])
            ->count();
    
        if ($dailyCount >= $maxAppointmentsPerDay) {
            return response()->json(['error' => 'No available slots. The day is fully booked.'], 400);
        }
    
        // Check per-hour bookings
        $bookedSlots = Appointment::where('appointment_date', $date)
            ->whereIn('status', ['pending', 'approved'])
            ->selectRaw('appointment_time, COUNT(*) as total_booked')
            ->groupBy('appointment_time')
            ->pluck('total_booked', 'appointment_time');
    
        $timeSlots = [];
        for ($hour = 9; $hour <= 16; $hour++) {
            $time24 = sprintf('%02d:00:00', $hour);
            $time12 = Carbon::createFromFormat('H:i:s', $time24)->format('h:i A');
    
            if (!isset($bookedSlots[$time24]) || $bookedSlots[$time24] < $maxAppointmentsPerSlot) {
                $timeSlots[] = $time12;
            }
        }
    
        return response()->json(['times' => $timeSlots]);
    }
    public function create(Request $request)
{
    $userId = Auth::id();
    
    $pets = Pet::where('customer_id', $userId)->with('petType')->get();
    if ($pets->isEmpty()) {
        return redirect()->route('customer.pets.create')
            ->with('error', 'Please register at least one pet before booking.');
    }

    // Get all pet types of the user's pets
    $petTypeIds = $pets->pluck('pet_type_id')->unique();

    // Load services with all petTypes (no filter) and vaccinePricings
    $services = Service::with([
        'petTypes', // <--- No more filtering here
        'vaccinePricings' => function($query) {
            $query->with(['vaccineType', 'petType']);
        }
    ])
    ->where(function($query) use ($petTypeIds) {
        $query->whereHas('petTypes', function($q) use ($petTypeIds) {
            $q->whereIn('pet_types.id', $petTypeIds);
        })
        ->orWhereDoesntHave('petTypes');
    })
    ->get();

    $closedDays = ClosedDay::pluck('date')->toArray();
    
    return view('customer.appointments.create', [
        'pets' => $pets,
        'services' => $services,
        'closedDays' => $closedDays,
        'selectedPetTypeIds' => $petTypeIds->toArray(),
    ]);
}

    // Get services compatible with selected pets
    public function getCompatibleServices(Request $request)
    {
        $petTypeIds = Pet::whereIn('id', $request->pet_ids)
            ->pluck('pet_type_id')
            ->unique();

        $services = Service::with(['petTypes', 'vaccinePricings' => function($query) use ($petTypeIds) {
            $query->whereIn('pet_type_id', $petTypeIds)->orWhereNull('pet_type_id');
        }])
        ->whereHas('petTypes', function($query) use ($petTypeIds) {
            $query->whereIn('pet_types.id', $petTypeIds);
        })
        ->get();

        return response()->json([
            'services' => $services,
            'vaccine_prices' => ServiceVaccinePricing::whereIn('pet_type_id', $petTypeIds)
                ->orWhereNull('pet_type_id')
                ->get()
        ]);
    }

    // Store new appointment
    public function store(Request $request)
{
    try {
        $validated = $this->validateRequest($request);
        
        if ($error = $this->checkAvailability($validated)) {
            return back()->with('error', $error)->withInput();
        }
        
        DB::beginTransaction();
        
        $appointment = $this->createAppointment($validated);
        $this->attachPets($appointment, $validated['pet_ids']);
        $this->attachServices($appointment, $validated['services']);
        
        DB::commit();
        
        return redirect()->route('customer.appointments.show', $appointment)
            ->with('success', 'Appointment booked successfully!');
            
    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()
            ->withErrors($e->validator)
            ->withInput();
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Appointment booking failed: '.$e->getMessage());
        return back()->with('error', 'Failed to book appointment. Please try again.')->withInput();
    }
}
    // Validate request data
    protected function validateRequest(Request $request)
    {
        $data = json_decode($request->appointment_data, true);
        
        // Convert 12-hour format to 24-hour format if needed
        if (isset($data['appointment_time'])) {
            try {
                $time = Carbon::createFromFormat('h:i A', $data['appointment_time']);
                $data['appointment_time'] = $time->format('H:i');
            } catch (\Exception $e) {
                // If conversion fails, let validation handle it
            }
        }
    
        $validator = Validator::make($data, [
            'pet_ids' => 'required|array',
            'pet_ids.*' => 'exists:pets,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'services' => 'required|array',
            'services.*.id' => 'required|exists:services,id',
            'services.*.pet_id' => 'required|exists:pets,id',
            'services.*.price' => 'required|numeric|min:0',
            'services.*.vaccine_type_ids' => 'sometimes|array',
            'services.*.vaccine_type_ids.*' => 'exists:vaccine_types,id',
        ]);
    
        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }
    
        return $validator->validated();
    }
    
    // Check time slot availability
    protected function checkAvailability($validated)
    {
        $date = $validated['appointment_date']; // ✅ instead of $request->input('date')
        
        $appointmentDate = Carbon::parse($date);
        if ($appointmentDate->isWeekend()) {
            return 'Appointments cannot be booked on weekends';
        }
    
        if (ClosedDay::where('date', $appointmentDate->format('Y-m-d'))->exists()) {
            return 'This date is unavailable for appointments';
        }
    
        $maxAppointmentsPerDay = config('settings.max_appointments_per_day', 10);
        $maxAppointmentsPerSlot = 3;
    
        $dailyCount = Appointment::where('appointment_date', $date)
            ->whereIn('status', ['pending', 'approved'])
            ->count();
    
        if ($dailyCount >= $maxAppointmentsPerDay) {
            return 'No available slots. The day is fully booked.';
        }
    
        $bookedSlots = Appointment::where('appointment_date', $date)
            ->whereIn('status', ['pending', 'approved'])
            ->selectRaw('appointment_time, COUNT(*) as total_booked')
            ->groupBy('appointment_time')
            ->pluck('total_booked', 'appointment_time');
    
        $time24 = sprintf('%02d:00:00', Carbon::parse($validated['appointment_time'])->hour);
    
        if (isset($bookedSlots[$time24]) && $bookedSlots[$time24] >= $maxAppointmentsPerSlot) {
            return 'Selected time slot is full. Please choose a different time.';
        }
    
        return null; // ✅ No error
    }
    

    // Create appointment record
    protected function createAppointment($validated)
    {
        return Appointment::create([
            'user_id' => Auth::id(),
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null
        ]);
    }

    // Attach services and vaccines to appointment
    protected function attachServices($appointment, $services)
{
    foreach ($services as $serviceData) {
        // First attach the service to the appointment using the pivot table
        $appointmentService = $appointment->services()->attach($serviceData['id'], [
            'pet_id' => $serviceData['pet_id'],
            'price' => $serviceData['price'],
        ]);
        
        // If there are vaccine types, attach them through the appointmentServices relationship
        if (!empty($serviceData['vaccine_type_ids']) && is_array($serviceData['vaccine_type_ids'])) {
            // Get the pivot ID from the attachment
            $pivotId = DB::table('appointment_service')
                ->where('appointment_id', $appointment->id)
                ->where('service_id', $serviceData['id'])
                ->where('pet_id', $serviceData['pet_id'])
                ->value('id');
                
            // If we found the pivot ID, attach the vaccines
            if ($pivotId) {
                foreach ($serviceData['vaccine_type_ids'] as $vaccineTypeId) {
                    DB::table('appointment_service_vaccine')->insert([
                        'appointment_service_id' => $pivotId,
                        'vaccine_type_id' => $vaccineTypeId,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
    }
}
    

    // Get primary pet ID for service (simplified - can be enhanced)
    protected function getPrimaryPetId($petIds, $serviceId)
    {
        return $petIds[0]; // Default to first pet - adjust based on your logic
    }

    // Cancel an appointment
    public function cancel($id)
    {
        $appointment = Appointment::where('id', $id)
                                  ->where('user_id', Auth::id())
                                  ->firstOrFail();

        if (Carbon::parse($appointment->appointment_date)->isPast()) {
            return redirect()->back()->with('error', 'You cannot cancel past appointments.');
        }

        if ($appointment->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending appointments can be canceled.');
        }

        $appointment->delete();
        return redirect()->route('customer.appointments.index')->with('success', 'Appointment canceled.');
    }
    public function show(Appointment $appointment)
    {
        // Verify the appointment belongs to the authenticated user
        if ($appointment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Load the appointment with all necessary relationships
        $appointment->load([
            'pets',
            'services',
            'records' => function($query) {
                $query->with(['pet', 'service']);
            }
        ]);

        return view('customer.appointments.show', compact('appointment'));
    }
}