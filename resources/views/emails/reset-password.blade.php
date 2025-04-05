<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Your Password</title>
</head>
<body>
    <h1>Password Reset Request</h1>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>
        Click the link below to reset your password:
        <a href="{{ $url }}">{{ $url }}</a>
    </p>
    <p>This password reset link will expire in {{ $count }} minutes.</p>
    <p>If you did not request a password reset, no further action is required.</p>
</body>
</html>
