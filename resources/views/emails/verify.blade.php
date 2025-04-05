<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verify Your Email</title>
</head>
<body>
    <h2>Hello!</h2>
    <p>Thank you for registering at EVG Juico Pet Care Center. Please verify your email by clicking the button below:</p>

    <p>
        <a href="{{ $verificationUrl }}" style="display:inline-block;padding:10px 20px;background-color:#f97316;color:white;text-decoration:none;border-radius:5px;">
            Verify Email
        </a>
    </p>

    <p>If the button doesn't work, copy and paste this link in your browser:</p>
    <p>{{ $verificationUrl }}</p>
</body>
</html>
