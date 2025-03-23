<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Pet;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $appointmentsCount = Appointment::where('user_id', $userId)->count();
        $petsCount = Pet::where('customer_id', $userId)->count();
        $nextAppointment = Appointment::where('user_id', $userId)
            ->where('status', 'approved')
            ->orderBy('appointment_date', 'asc')
            ->first();
        $appointments = Appointment::where('user_id', $userId)->orderBy('appointment_date', 'desc')->get();
        $pets = Pet::where('customer_id', $userId)->get();

        return view('customer.customerdashboard', compact('appointmentsCount', 'petsCount', 'nextAppointment', 'appointments', 'pets'));
    }

}

