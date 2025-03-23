<?php

namespace App\Console\Commands;

use App\Mail\AppointmentReminderMail;
use App\Models\Appointment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:send-reminders';
    protected $description = 'Send email reminders for upcoming appointments 6 hours before';

    public function handle()
    {
        $now = Carbon::now();
        $sixHoursLater = $now->copy()->addHours(6);

        $appointments = Appointment::where('status', 'approved')
            ->whereBetween('appointment_date', [$now->toDateString(), $sixHoursLater->toDateString()])
            ->where('appointment_time', '>=', $now->toTimeString())
            ->where('appointment_time', '<=', $sixHoursLater->toTimeString())
            ->get();

        foreach ($appointments as $appointment) {
            Mail::to($appointment->user->email)->send(new AppointmentReminderMail($appointment));
        }

        $this->info('Appointment reminders sent successfully.');
    }
}
