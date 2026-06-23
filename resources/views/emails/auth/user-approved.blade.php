<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Your Account Has Been Approved</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.6; background-color: #f3f4f6; margin: 0; padding: 24px;">
    <div style="max-width: 620px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; padding: 28px; border: 1px solid #e5e7eb;">
        <h1 style="font-size: 22px; color: #1d4ed8; margin: 0 0 8px;">CYDC Activities Database</h1>
        <h2 style="font-size: 17px; color: #374151; margin: 0 0 24px;">Account Approved</h2>

        <p>Hello Dear User,</p>

        <p>
            Your CYDC Activities Database account has been approved. You can now log in and continue using the system.
        </p>

        <p>
            <strong>Center ID:</strong> {{ $user->center_id ?: 'Not provided' }}<br>
            <strong>Email:</strong> {{ $user->email }}
        </p>

        <p style="margin-top: 28px;">
            Best Regards,<br>
            <strong>CYDC ACTIVITIES DATABASE</strong><br>
            System Administrator<br>
            Idriss Mwala<br>
            Tel: <a href="tel:+255673746031" style="color: #1d4ed8; text-decoration: none;">+255 673 746 031</a><br>
            Email: <a href="mailto:support@cydcactivitiesdb.or.tz" style="color: #1d4ed8; text-decoration: none;">support@cydcactivitiesdb.or.tz</a>
        </p>
    </div>
</body>
</html>
