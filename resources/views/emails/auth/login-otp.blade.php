<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CYDC Activities Database - Secure OTP Verification</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.6; background-color: #f3f4f6; margin: 0; padding: 24px;">
    <div style="max-width: 620px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; padding: 28px; border: 1px solid #e5e7eb;">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin:0 0 24px;">
            <tr>
                <td width="70" style="vertical-align:middle;padding-right:14px;">
                    <img src="{{ asset('images/cydc-activities-logo.png') }}" alt="CYDC Activities Database" width="58" height="58" style="display:block;border-radius:50%;object-fit:cover;border:1px solid #dbeafe;">
                </td>
                <td style="vertical-align:middle;">
                    <h1 style="font-size: 22px; color: #1d4ed8; margin: 0 0 4px;">CYDC Activities Database</h1>
                    <h2 style="font-size: 16px; color: #374151; margin: 0;">Secure OTP Verification</h2>
                </td>
            </tr>
        </table>

        <p>Hello Dear User,</p>

        <p>
            Thank you for using CYDC Activities Database. Please use the verification code below to continue accessing your account.
            This OTP code will expire in 10 minutes for security purposes.
        </p>

        <div style="text-align: center; margin: 28px 0;">
            <div style="display: inline-block; font-size: 32px; font-weight: 700; letter-spacing: 8px; color: #1d4ed8; background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 16px 24px;">
                {{ $code }}
            </div>
        </div>

        <p>If you did not request this code, please ignore this email.</p>

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
