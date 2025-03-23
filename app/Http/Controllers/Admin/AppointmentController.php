<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Setting;

class AppointmentController extends Controller
{
    // ✅ Show pending appointments for admin
    public function index()
    {
        $appointments = Appointment::with(['user', 'pets', 'services'])
            ->orderBy('appointment_date', 'asc')
            ->get();
    
        // ✅ Fetch max appointments from settings table (fallback to 10)
        $maxAppointments = Setting::first()->max_appointments_per_day ?? 10;
    
        // ✅ Count accepted appointments for today
        $acceptedAppointmentsToday = Appointment::whereDate('appointment_date', Carbon::today())
            ->where('status', 'approved')
            ->count();
    
        return view('admin.appointments.index', compact('appointments', 'acceptedAppointmentsToday', 'maxAppointments'));
    }
    
    public function approved()
    {
        // ✅ Fetch approved appointments
        $appointments = Appointment::with(['user', 'pets', 'services'])
            ->where('status', 'approved')
            ->orderBy('appointment_date', 'asc')
            ->get();
    
        // ✅ Fetch max appointments from settings table (fallback to 10)
        $maxAppointments = Setting::first()->max_appointments_per_day ?? 10;
    
        // ✅ Count approved appointments for today
        $acceptedAppointmentsToday = Appointment::whereDate('appointment_date', now())
            ->where('status', 'approved')
            ->count();
    
        return view('admin.appointments.approved', compact('appointments', 'acceptedAppointmentsToday', 'maxAppointments'));
    }
    

public function rejected()
{
    $appointments = Appointment::with(['user', 'pets', 'services'])
        ->where('status', 'rejected') // ✅ Fetch only rejected appointments
        ->orderBy('appointment_date', 'asc')
        ->get();

    return view('admin.appointments.rejected', compact('appointments'));
}
public function all(Request $request)
{
    $query = Appointment::with(['user', 'pets', 'services']);

    // ✅ Apply status filter (if selected)
    if ($request->has('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
        $query->where('status', $request->status);
    }

    // ✅ Sorting options
    if ($request->has('sort_by')) {
        $sortField = $request->sort_by;
        $allowedSortFields = ['appointment_date', 'user_name', 'pet_name'];

        if (in_array($sortField, $allowedSortFields)) {
            if ($sortField === 'user_name') {
                $query->join('users', 'appointments.user_id', '=', 'users.id')
                      ->orderBy('users.name');
            } elseif ($sortField === 'pet_name') {
                $query->join('appointment_pet', 'appointments.id', '=', 'appointment_pet.appointment_id')
                      ->join('pets', 'appointment_pet.pet_id', '=', 'pets.id')
                      ->orderBy('pets.name');
            } else {
                $query->orderBy($sortField);
            }
        }
    } else {
        $query->orderBy('appointment_date', 'asc');
    }

    // ✅ Paginate results
    $appointments = $query->paginate(10);

    return view('admin.appointments.all', compact('appointments'));
}

    // ✅ Approve an appointment
     public function approve(Appointment $appointment)
{
    // Check if max limit has been reached
    $maxAppointments = Setting::first()->max_appointments_per_day ?? 10;
    $approvedToday = Appointment::whereDate('appointment_date', Carbon::today())
                                ->where('status', 'approved')
                                ->count();

    if ($approvedToday >= $maxAppointments) {
        return redirect()->route('admin.appointments')
            ->with('error', 'Max appointments limit reached for today. Approval denied.');
    }

    if ($appointment->status !== 'pending') {
        return redirect()->route('admin.appointments')
            ->with('error', 'Only pending appointments can be approved.');
    }

    // Approve the appointment
    $appointment->update([
        'status' => 'approved',
        'approved_at' => Carbon::now(),
    ]);

    return redirect()->route('admin.appointments')
        ->with('success', 'Appointment approved successfully.');
}

    // ✅ Reject an appointment
    public function reject(Appointment $appointment)
    {
        if ($appointment->status !== 'pending') {
            return redirect()->route('admin.appointments')->with('error', 'Only pending appointments can be rejected.');
        }

        $appointment->update(['status' => 'rejected']);

        return redirect()->route('admin.appointments')->with('success', 'Appointment rejected.');
    }

    // ✅ Delete an appointment (new addition)
    public function destroy(Appointment $appointment)
    {
        if (!in_array($appointment->status, ['pending', 'rejected'])) {
            return redirect()->route('admin.appointments')
                ->with('error', 'Only pending or rejected appointments can be deleted.');
        }        

        $appointment->delete();
        return redirect()->route('admin.appointments')->with('success', 'Appointment deleted successfully.');
    }
}
