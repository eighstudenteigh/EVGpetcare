<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\ClosedDay;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function redirectToDashboard(): RedirectResponse
    {
        return redirect(Auth::user()->role === 'admin' ? route('admin.dashboard') : route('customer.dashboard'));
    }

    

}
