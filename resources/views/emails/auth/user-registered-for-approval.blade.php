<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New User Registration Pending Approval</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.6; background-color: #f3f4f6; margin: 0; padding: 24px;">
    <div style="max-width: 640px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; padding: 28px; border: 1px solid #e5e7eb;">
        <h1 style="font-size: 22px; color: #1d4ed8; margin: 0 0 8px;">CYDC Activities Database</h1>
        <h2 style="font-size: 17px; color: #374151; margin: 0 0 24px;">New User Registration Pending Approval</h2>

        <p>Hello Admin,</p>

        <p>A new user has registered in the system and is waiting for approval.</p>

        <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse; margin: 20px 0;">
            <tr>
                <td style="padding: 10px; border: 1px solid #e5e7eb; font-weight: 700; background: #f9fafb;">Center ID</td>
                <td style="padding: 10px; border: 1px solid #e5e7eb;">{{ $user->center_id ?: 'Not provided' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #e5e7eb; font-weight: 700; background: #f9fafb;">Email</td>
                <td style="padding: 10px; border: 1px solid #e5e7eb;">{{ $user->email }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #e5e7eb; font-weight: 700; background: #f9fafb;">Phone</td>
                <td style="padding: 10px; border: 1px solid #e5e7eb;">{{ $user->phone ?: 'Not provided' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #e5e7eb; font-weight: 700; background: #f9fafb;">Cluster</td>
                <td style="padding: 10px; border: 1px solid #e5e7eb;">{{ $user->cluster_name ?: 'Not provided' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #e5e7eb; font-weight: 700; background: #f9fafb;">Registered At</td>
                <td style="padding: 10px; border: 1px solid #e5e7eb;">{{ optional($user->created_at)->format('M d, Y H:i') }}</td>
            </tr>
        </table>

        <p>Please log in to the admin panel and approve this user if the details are correct.</p>

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
