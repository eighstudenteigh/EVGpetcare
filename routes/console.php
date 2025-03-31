<?php

use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Appointment;
use App\Mail\AppointmentReminder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;
use Carbon\Carbon;

Schedule::call(function () {
    $appointments = Appointment::where('status', 'approved')
        ->whereDate('appointment_date', now())
        ->whereTime('appointment_time', '<=', now()->addHours(3)->format('H:i:s'))
        ->whereTime('appointment_time', '>', now()->format('H:i:s'))
        ->get();

    foreach ($appointments as $appointment) {
        Mail::to($appointment->user->email)->send(new AppointmentReminder($appointment));
    }
})->everyMinute();
