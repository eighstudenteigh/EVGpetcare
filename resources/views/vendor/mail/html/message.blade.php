@component('mail::message')
# Welcome to EVG Petcare and Clinic 🐾

Thank you for registering! To activate your account, please verify your email address.

@component('mail::button', ['url' => $actionUrl])
Verify Email
@endcomponent

If you did not register, no action is required.

Thanks,<br>
**EVG Petcare and Clinic Team**
@endcomponent
