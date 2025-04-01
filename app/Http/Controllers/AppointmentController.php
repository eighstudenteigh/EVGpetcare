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

class AppointmentController extends Controller
{
    // Show user's appointments
    public function index()
    {
        $userId = Auth::id();
        $appointments = Appointment::where('user_id', $userId)
            ->with(['pets', 'services'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        $petsCount = Pet::where('customer_id', $userId)->count();

        return view('customer.appointments.index', compact('appointments', 'petsCount'));
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

    // Show appointment booking page
    public function create()
    {
        $userId = Auth::id();
    
        $pets = Pet::where('customer_id', $userId)->with('services')->get();
        $services = DB::table('services')
            ->join('service_pet_type', 'services.id', '=', 'service_pet_type.service_id')
            ->join('pet_types', 'service_pet_type.pet_type_id', '=', 'pet_types.id')
            ->select('services.id', 'services.name', 'services.description', 'service_pet_type.price', 'pet_types.name as pet_type')
            ->get();
        $closedDays = ClosedDay::pluck('date')->toArray();
    
        $acceptedAppointmentsToday = Appointment::where('appointment_date', now()->toDateString())
                                             ->where('status', 'approved')
                                             ->count();
    
        $maxAppointments = 10;
    
        if ($pets->isEmpty()) {
            return redirect()->route('customer.dashboard')
                             ->with('error', 'You must add a pet before booking an appointment.');
        }
    
        return view('customer.appointments.create', compact('pets', 'services', 'acceptedAppointmentsToday', 'maxAppointments'));
    }
    
    // Store a new appointment
    public function store(Request $request)
    {
        $request->validate([
            'pet_ids' => 'required|array',
            'pet_services' => 'required|array',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|string'
        ]);

        $userId = Auth::id();
        $maxAppointmentsPerSlot = 3;

        // Check if the selected time slot is already full
        $timeSlotCount = Appointment::where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        if ($timeSlotCount >= $maxAppointmentsPerSlot) {
            return back()->with('error', 'This time slot is already fully booked. Please select another time.');
        }

        // Check if the total for the day exceeds the max
        $dailyCount = Appointment::where('appointment_date', $request->appointment_date)
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        $maxAppointmentsPerDay = config('settings.max_appointments_per_day', 10);
        if ($dailyCount >= $maxAppointmentsPerDay) {
            return back()->with('error', 'Maximum appointments for the day reached. Please pick another day.');
        }

        // Proceed with booking
        $appointment = Appointment::create([
            'user_id' => $userId,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending'
        ]);

        // Attach pets & services
        $appointment->pets()->attach($request->pet_ids);
        foreach ($request->pet_ids as $petId) {
            if (isset($request->pet_services[$petId])) {
                foreach ($request->pet_services[$petId] as $serviceId) {
                    $appointment->services()->attach($serviceId, ['pet_id' => $petId]);
                }
            }
        }

        return redirect()->route('customer.appointments.index')
                         ->with('success', 'Appointment booked successfully!');
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
}