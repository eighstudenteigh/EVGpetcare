@component('mail::message')
# Reset Password Notification

You are receiving this email because we received a password reset request for your account.

@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

This password reset link will expire in {{ $count }} minutes.

If you did not request a password reset, no further action is required.

Thanks,<br>
**EVG Petcare and Clinic Team**
@endcomponent