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

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        return $this->subject('Your Appointment Has Been Approved!')
                    ->view('emails.appointment_approved')
                    ->with([
                        'customerName' => $this->appointment->user->name,
                        'date' => Carbon::parse($this->appointment->appointment_date)->format('F j, Y'),
                        'time' => Carbon::parse($this->appointment->appointment_time)->format('h:i A'),
                    ]);
    }
}
