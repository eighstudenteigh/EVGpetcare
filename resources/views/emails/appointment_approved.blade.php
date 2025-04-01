<!DOCTYPE html>
<html>
<head>
    <title>Appointment Approved</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        h2 {
            color: #FF5733;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <h2>Hello, {{ $customerName }}!</h2>
    <p>We are pleased to inform you that your appointment has been <strong>approved</strong>.</p>
    <p><strong>Date:</strong> {{ $date }}</p>
    <p><strong>Time:</strong> {{ $time }}</p>
    <p>We look forward to seeing you! If you have any questions, feel free to contact us.</p>
    <br>
    <p>Best regards,<br>EVG Juico PetCare Team</p>
    <div class="footer">
        <p>This is an automated message. Please do not reply directly to this email.</p>
    </div>
</body>
</html>
