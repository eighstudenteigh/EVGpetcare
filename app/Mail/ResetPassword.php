<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public string $actionUrl;

    public function __construct(string $actionUrl)
    {
        $this->actionUrl = $actionUrl;
    }

    public function build()
    {
        return $this->subject('Reset Your Password - EVG Petcare and Clinic')
                    ->markdown('emails.reset-password')
                    ->with(['actionUrl' => $this->actionUrl]);
    }
}
