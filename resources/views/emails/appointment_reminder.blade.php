<!DOCTYPE html>
<html>
<head>
    <title>Appointment Reminder</title>
</head>
<body>
    <h2>Hello {{ $appointment->user->name }},</h2>

    <p>This is a reminder for your upcoming appointment:</p>

    <p>
        <strong>Pet Name:</strong> {{ $appointment->pet->name ?? 'N/A' }} <br>
        <strong>Service:</strong> {{ $appointment->service_type }} <br>
        <strong>Date & Time:</strong> {{ $appointment->appointment_date }} at {{ $appointment->appointment_time }}
    </p>

    <p>Please be on time for your appointment.</p>

    <p>Thank you, <br> EVG Juico PetCare</p>
</body>
</html>
