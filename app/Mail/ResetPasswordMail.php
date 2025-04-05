<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ResetPasswordMail extends Mailable
{
    public $url;
    public $count;

    public function __construct($url, $count)
    {
        $this->url = $url;
        $this->count = $count;
    }

    public function build()
    {
        return $this->subject('Reset Password Notification')
                    ->view('emails.reset-password');
    }
}