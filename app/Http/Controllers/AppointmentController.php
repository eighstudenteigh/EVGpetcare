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

class AppointmentController extends Controller
{
    // ✅ Show user's appointments
    public function index()
    {
        $appointments = Appointment::where('user_id', Auth::id())
            ->with(['pets', 'services'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('customer.appointments.index', compact('appointments'));
    }

    // ✅ Show appointment booking page
    public function create()
    {
        $userId = Auth::id();

        $pets = Pet::where('customer_id', $userId)->with('services')->get();
        $services = Service::all(); 
        $closedDays = ClosedDay::pluck('date')->toArray();

        $acceptedAppointmentsToday = Appointment::where('appointment_date', now()->toDateString())
                                                 ->where('status', 'accepted')
                                                 ->count();

        $maxAppointments = 10;

        if ($pets->isEmpty()) {
            return redirect()->route('customer.dashboard')
                             ->with('error', 'You must add a pet before booking an appointment.');
        }

        return view('customer.appointments.create', compact('pets', 'services', 'acceptedAppointmentsToday', 'maxAppointments'));
    }

    // ✅ Get available time slots (FIXED)
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
    
        // ✅ Get max appointments per day from admin settings (default to 10)
        $maxAppointmentsPerDay = config('settings.max_appointments_per_day', 10);
        $maxAppointmentsPerSlot = 3; // ✅ Adjusted to allow 3 per hour
    
        // ✅ Check total bookings for the selected day
        $dailyCount = Appointment::where('appointment_date', $date)
            ->whereIn('status', ['pending', 'approved'])
            ->count();
    
        if ($dailyCount >= $maxAppointmentsPerDay) {
            return response()->json(['error' => 'No available slots. The day is fully booked.'], 400);
        }
    
        // ✅ Check per-hour bookings
        $bookedSlots = Appointment::where('appointment_date', $date)
            ->whereIn('status', ['pending', 'approved'])
            ->selectRaw('appointment_time, COUNT(*) as total_booked')
            ->groupBy('appointment_time')
            ->pluck('total_booked', 'appointment_time');
    
        $timeSlots = [];
        for ($hour = 9; $hour <= 16; $hour++) { // ✅ From 9 AM to 4 PM
            $time24 = sprintf('%02d:00:00', $hour);
            $time12 = Carbon::createFromFormat('H:i:s', $time24)->format('h:i A');
    
            if (!isset($bookedSlots[$time24]) || $bookedSlots[$time24] < $maxAppointmentsPerSlot) {
                $timeSlots[] = $time12;
            }
        }
    
        return response()->json(['times' => $timeSlots]);
    }
    
    // ✅ Store a new appointment with a hard booking limit
    public function store(Request $request)
{
    $request->validate([
        'pet_ids' => 'required|array',
        'pet_services' => 'required|array',
        'appointment_date' => 'required|date|after:today',
        'appointment_time' => 'required|string'
    ]);

    $userId = Auth::id();
    $maxAppointmentsPerSlot = 3; // ✅ Ensure this is the same as getAvailability()

    // ✅ Check if the selected time slot is already full
    $timeSlotCount = Appointment::where('appointment_date', $request->appointment_date)
        ->where('appointment_time', $request->appointment_time)
        ->whereIn('status', ['pending', 'approved'])
        ->count();

    if ($timeSlotCount >= $maxAppointmentsPerSlot) {
        return back()->with('error', 'This time slot is already fully booked. Please select another time.');
    }

    // ✅ Check if the total for the day exceeds the admin-defined max
    $dailyCount = Appointment::where('appointment_date', $request->appointment_date)
        ->whereIn('status', ['pending', 'approved'])
        ->count();

    $maxAppointmentsPerDay = config('settings.max_appointments_per_day', 10);
    if ($dailyCount >= $maxAppointmentsPerDay) {
        return back()->with('error', 'Maximum appointments for the day reached. Please pick another day.');
    }

    // ✅ Proceed with booking
    $appointment = Appointment::create([
        'user_id' => $userId,
        'appointment_date' => $request->appointment_date,
        'appointment_time' => $request->appointment_time,
        'status' => 'pending'
    ]);

    // ✅ Attach pets & services using Eloquent relationships
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

    // ✅ Cancel an appointment (Fixed Loophole)
    public function cancel($id)
    {
        $appointment = Appointment::where('id', $id)
                                  ->where('user_id', Auth::id())
                                  ->firstOrFail();

        // ✅ Fix: Prevent canceling past appointments
        if (Carbon::parse($appointment->appointment_date)->isPast()) {
            return redirect()->back()->with('error', 'You cannot cancel past appointments.');
        }

        // ✅ Only allow canceling pending appointments
        if ($appointment->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending appointments can be canceled.');
        }

        $appointment->delete();
        return redirect()->route('customer.appointments.index')->with('success', 'Appointment canceled.');
    }
}
