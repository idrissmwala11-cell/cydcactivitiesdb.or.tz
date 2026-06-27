<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Published Results List Available</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.6; background-color: #f3f4f6; margin: 0; padding: 24px;">
    <div style="max-width: 640px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; padding: 28px; border: 1px solid #e5e7eb;">
        <h1 style="font-size: 22px; color: #1d4ed8; margin: 0 0 8px;">CYDC Activities Database</h1>
        <h2 style="font-size: 17px; color: #374151; margin: 0 0 24px;">Published Results List Available</h2>

        <p>Hello Dear User,</p>

        <p>
            A results list has been published in the CYDC Activities Database system.
            Please log in to your account and check your dashboard. You will see the
            <strong>View Results List</strong> button; click it to view the participants' results.
        </p>

        <p>
            <strong>Level:</strong> {{ ucfirst($assessment->education_level) }}<br>
            <strong>Class:</strong> {{ $assessment->class_level }}<br>
            <strong>Assessment:</strong> {{ $assessment->name }}<br>
            <strong>Published By:</strong> {{ $publishedBy->center_id ?: $publishedBy->email }}
        </p>

        <p style="margin: 24px 0;">
            <a href="{{ $resultsUrl }}" style="display: inline-block; background-color: #1d4ed8; color: #ffffff; padding: 12px 18px; border-radius: 8px; text-decoration: none; font-weight: bold;">
                View Results List
            </a>
        </p>

        <p>
            If the button does not open, copy and paste this link into your browser:<br>
            <a href="{{ $resultsUrl }}" style="color: #1d4ed8;">{{ $resultsUrl }}</a>
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
