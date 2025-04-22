<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentApproved;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    //pending appointments for admin
    public function index()
    {
        // Fetch approved appointments with necessary relationships
        $appointments = Appointment::with([
            'user',
            'pets',
            'services'
        ])->where('status', 'pending')
        ->orderBy('appointment_date', 'asc')
        ->get();

        // For each appointment, attach the specific services to each pet
    $appointments->each(function ($appointment) {
        $appointment->pets->each(function ($pet) use ($appointment) {
            // Get service IDs for this appointment
            $serviceIds = $appointment->services->pluck('id')->toArray();
            
            // Load only services that belong to both the pet AND this appointment
            $pet->load(['services' => function($query) use ($serviceIds) {
                $query->whereIn('services.id', $serviceIds);
            }]);
        });
    });

    $maxAppointments = Setting::first()->max_appointments_per_day ?? 10;
    $acceptedAppointmentsToday = Appointment::whereDate('appointment_date', now())
        ->where('status', 'approved')
        ->count();
    
        return view('admin.appointments.index', compact('appointments', 'acceptedAppointmentsToday', 'maxAppointments'));
    }
    public function approved()
{
    // Fetch approved appointments with necessary relationships
    $appointments = Appointment::with([
        'user',
        'pets',
        'services'
    ])
    ->where('status', 'approved')
    ->orderBy('appointment_date', 'asc')
    ->get();

    // For each appointment, attach the specific services to each pet
    $appointments->each(function ($appointment) {
        $appointment->pets->each(function ($pet) use ($appointment) {
            // Get service IDs for this appointment
            $serviceIds = $appointment->services->pluck('id')->toArray();
            
            // Load only services that belong to both the pet AND this appointment
            $pet->load(['services' => function($query) use ($serviceIds) {
                $query->whereIn('services.id', $serviceIds);
            }]);
        });
    });

    $maxAppointments = Setting::first()->max_appointments_per_day ?? 10;
    $acceptedAppointmentsToday = Appointment::whereDate('appointment_date', now())
        ->where('status', 'approved')
        ->count();

    return view('admin.appointments.approved', compact('appointments', 'acceptedAppointmentsToday', 'maxAppointments'));
}
    public function completed()
{
   // Fetch approved appointments with necessary relationships
   $appointments = Appointment::with([
    'user',
    'pets',
    'services'
])
->where('status', 'completed')
->orderBy('appointment_date', 'asc')
->get();

// For each appointment, attach the specific services to each pet
$appointments->each(function ($appointment) {
    $appointment->pets->each(function ($pet) use ($appointment) {
        // Get service IDs for this appointment
        $serviceIds = $appointment->services->pluck('id')->toArray();
        
        // Load only services that belong to both the pet AND this appointment
        $pet->load(['services' => function($query) use ($serviceIds) {
            $query->whereIn('services.id', $serviceIds);
        }]);
    });
});

$maxAppointments = Setting::first()->max_appointments_per_day ?? 10;
    $acceptedAppointmentsToday = Appointment::whereDate('appointment_date', now())
        ->where('status', 'approved')
        ->count();

    return view('admin.appointments.completed', compact('appointments'));
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

        // ✅ Sorting options with direction
        if ($request->has('sort_by')) {
            $sortField = $request->sort_by;
            $sortDirection = $request->sort_order === 'desc' ? 'desc' : 'asc';
            $allowedSortFields = ['appointment_date', 'user_name', 'pet_name'];

            if (in_array($sortField, $allowedSortFields)) {
                if ($sortField === 'user_name') {
                    $query->join('users', 'appointments.user_id', '=', 'users.id')
                        ->orderBy('users.name', $sortDirection);
                } elseif ($sortField === 'pet_name') {
                    $query->join('appointment_pet', 'appointments.id', '=', 'appointment_pet.appointment_id')
                        ->join('pets', 'appointment_pet.pet_id', '=', 'pets.id')
                        ->orderBy('pets.name', $sortDirection);
                } else {
                    $query->orderBy($sortField, $sortDirection);
                }
            }
        } else {
            $query->orderBy('appointment_date', 'asc'); // Default sorting
        }

        // ✅ Paginate results
        $appointments = $query->paginate(10);

        return view('admin.appointments.all', compact('appointments'));
    }
    //  Approve an appointment
    public function approve(Appointment $appointment)
{
    $maxAppointments = Setting::first()->max_appointments_per_day ?? 10;
    $approvedToday = Appointment::whereDate('appointment_date', now())
                                ->where('status', 'approved')
                                ->count();

    if ($approvedToday >= $maxAppointments) {
        return redirect()->route('admin.appointments')->with('error', 'Max appointments reached for today.');
    }

    if ($appointment->status !== 'pending') {
        return redirect()->route('admin.appointments')->with('error', 'Only pending appointments can be approved.');
    }

    $appointment->update([
        'status' => 'approved',
        'approved_at' => now(),
    ]);

    try {
        // ✅ Send Email Notification
        Mail::to($appointment->user->email)->send(new AppointmentApproved($appointment));
        return redirect()->route('admin.appointments')->with('success', 'Appointment approved and email sent.');
    } catch (\Exception $e) {
        // Log the error for debugging
        Log::error('Failed to send appointment approval email: ' . $e->getMessage());
        return redirect()->route('admin.appointments')->with('warning', 'Appointment approved but email could not be sent.');
    }
}
    //  Complete an appointment
    public function complete(Appointment $appointment)
    {
        // Verify appointment is approved and for today
        if ($appointment->status !== 'approved') {
            return back()->with('error', 'Only approved appointments can be marked completed');
        }
    
        // Update status
        $appointment->update([
            'status' => 'completed'
        ]);
    
        // Redirect to the show-completed route instead
        return redirect()->route('admin.appointments.show-completed', $appointment)
            ->with('success', 'Appointment marked as complete. You can now create pet records.');
    }
public function show($id)
{
    $appointment = Appointment::with([
        'user',
        'pets.services', // Only load services tied to this appointment
        'services'
    ])->findOrFail($id);

    return view('appointments.show-completed', compact('appointment'));
}
public function showCompleted(Appointment $appointment)
{
    $appointment->load([
        'user',
        'pets.services', // Only load services booked for this appointment
        'services',
        'records' // Load all records for this appointment
    ]);

    return view('admin.appointments.show-completed', compact('appointment'));
}
/**
 * Finalize an appointment after all service records are completed
 * 
 * @param Appointment $appointment
 * @return \Illuminate\Http\RedirectResponse
 */
/**
 * Finalize an appointment after all service records are completed
 * 
 * @param Appointment $appointment
 * @return \Illuminate\Http\RedirectResponse
 */
public function finalize(Appointment $appointment)
{
    // Verify appointment is completed
    if ($appointment->status !== 'completed') {
        return redirect()->route('admin.pet-records.show', $appointment->id)
            ->with('error', 'Only completed appointments can be finalized.');
    }
    
    // Get services and pets for this appointment
    $services = $appointment->services;
    $pets = $appointment->pets;
    
    // Check if all services for all pets have been recorded
    $allRecordsComplete = true;
    $missingRecords = [];
    
    foreach ($pets as $pet) {
        foreach ($services as $service) {
            $recordExists = false;
            
            if ($service->service_type === 'grooming') {
                $recordExists = $pet->hasGroomingRecord($appointment->id);
            } elseif ($service->service_type === 'medical') {
                $recordExists = $pet->hasMedicalRecord($appointment->id);
            } elseif ($service->service_type === 'boarding') {
                $recordExists = $pet->hasBoardingRecord($appointment->id);
            }
            
            if (!$recordExists) {
                $allRecordsComplete = false;
                $missingRecords[] = "$pet->name - " . $service->name;
            }
        }
    }
    
    if (!$allRecordsComplete) {
        $missingList = implode(', ', $missingRecords);
        return redirect()->route('admin.pet-records.show', $appointment->id)
            ->with('error', "Cannot finalize: Missing records for $missingList");
    }
    
    // All records are complete, mark the appointment as finalized
    $appointment->update([
        'status' => 'finalized',
    ]);
    
    // Redirect to the appointments list with success message
    return redirect()->route('admin.appointments.approved')
        ->with('success', 'Appointment has been finalized with all service records completed.');
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
