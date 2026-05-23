<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CYDC Login Verification Code</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.6;">
    <p>Hello {{ $user->center_id ?? $user->email }},</p>

    <p>Use this verification code to complete your CYDC login:</p>

    <p style="font-size: 28px; font-weight: 700; letter-spacing: 6px; color: #1d4ed8;">
        {{ $code }}
    </p>

    <p>This code will expire in 10 minutes.</p>

    <p>If you did not try to login, please ignore this email.</p>

    <p>CYDC Activities System</p>
</body>
</html>
