<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Pet;
use Carbon\Carbon;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $now = Carbon::now();
        
        // Next Appointment (future approved only) - with pets relationship
        $nextAppointment = Appointment::with(['pets', 'services'])
            ->where('user_id', $userId)
            ->where('status', 'approved')
            ->whereDate('appointment_date', '>=', $now->toDateString())
            ->orderBy('appointment_date', 'asc')
            ->first();
            
        // Upcoming Appointments count (future approved only)
        $upcomingCount = Appointment::where('user_id', $userId)
            ->where('status', 'approved')
            ->whereDate('appointment_date', '>=', $now->toDateString())
            ->count();
            
        // Recent Appointments (last 2 weeks) - with pets relationship
        $recentAppointments = Appointment::with(['pets', 'services'])
            ->where('user_id', $userId)
            ->whereDate('appointment_date', '>=', $now->subDays(14)->toDateString())
            ->orderBy('appointment_date', 'desc')
            ->get();

     

        $petsCount = Pet::where('customer_id', $userId)->count();
        $pendingCount = Appointment::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();
        $pets = Pet::where('customer_id', $userId)->get();

        return view('customer.customerdashboard', compact(
            'nextAppointment',
            'upcomingCount',
            'pendingCount',
            'recentAppointments',
            'petsCount',
            'pets'
        ));
    }
}