<?php

namespace App\Notifications;

use App\Mail\ResetPasswordMail;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class ResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
{
    $resetUrl = url(route('password.reset', [
        'token' => $this->token,
        'email' => $notifiable->getEmailForPasswordReset(),
    ], false));

    return (new ResetPasswordMail(
        $resetUrl,
        config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')
    ))->to($notifiable->email); 
}

}