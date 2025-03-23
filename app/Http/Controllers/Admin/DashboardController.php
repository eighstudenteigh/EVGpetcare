<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Setting;
use App\Models\ClosedDay;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Pet;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = User::where('role', 'customer')->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $totalPets = Pet::count();
        $totalServices = Service::count();

        // ✅ Fix: Avoid `null` error when `settings` is empty
        $maxAppointments = Setting::first()?->max_appointments_per_day ?? 10;

        // ✅ Fix: Ensure closed days are correctly formatted
        $closedDays = ClosedDay::pluck('date')->map(fn ($date) => [
            'title' => 'Closed',
            'start' => Carbon::parse($date)->format('Y-m-d'),
            'color' => '#FF0000'
        ])->toArray();

        // ✅ Accepted Appointments for Today
        $acceptedAppointmentsToday = Appointment::where('status', 'approved')
            ->whereDate('appointment_date', Carbon::today())
            ->count();

        // ✅ Fix: Load related pet and service data for upcoming appointments
        $upcomingAppointments = Appointment::with(['pets.petType', 'services'])
            ->where('status', 'approved')
            ->where('appointment_date', '>=', now()->toDateString())
            ->orderBy('appointment_date', 'asc')
            ->limit(5)
            ->get();

        // ✅ Fix: Eager load related data for activity log
        $recentActivities = ActivityLog::latest()->limit(5)->get();

        // ✅ Fix: Ensure correct grouping when fetching accepted appointments per day
        $acceptedAppointments = Appointment::where('status', 'approved')
            ->selectRaw('DATE(appointment_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get()
            ->pluck('count', 'date');

        // ✅ Available slots calculation (fix: avoid negative values)
        $availableSlots = [];
        foreach ($acceptedAppointments as $date => $count) {
            $availableSlots[$date] = max($maxAppointments - $count, 0);
        }

        return view('admin.dashboard', compact(
            'totalCustomers', 'pendingAppointments', 'totalPets', 'totalServices',
            'maxAppointments', 'closedDays', 'upcomingAppointments', 'recentActivities',
            'acceptedAppointments', 'availableSlots', 'acceptedAppointmentsToday'
        ));
    }

    public function updateMaxAppointments(Request $request)
    {
        $request->validate(['max_appointments_per_day' => 'required|integer|min:1']);

        Setting::updateOrCreate([], ['max_appointments_per_day' => $request->max_appointments_per_day]);

        return back()->with('success', 'Max appointments updated successfully.');
    }

    public function getClosedDays()
    {
        // ✅ Fix: Ensure dates are formatted correctly
        $closedDays = ClosedDay::pluck('date')->map(fn ($date) => Carbon::parse($date)->format('Y-m-d'))->toArray();

        return response()->json($closedDays);
    }
}
