<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $customerName;
    public $appointmentDate;
    public $appointmentTime;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->customerName = $appointment->user->name ?? 'Customer';
        $this->appointmentDate = Carbon::parse($appointment->appointment_date)->format('l, F j, Y');
        $this->appointmentTime = Carbon::parse($appointment->appointment_time)->format('h:i A');
    }

    public function build()
    {
        return $this->subject('Your Appointment Has Been Approved!')
                    ->view('emails.appointment_approved')
                    ->with([
                        'customerName' => $this->customerName,
                        'date' => $this->appointmentDate,
                        'time' => $this->appointmentTime,
                    ]);
    }
}
