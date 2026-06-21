<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taarifa ya Ujazaji wa Data</title>
</head>
<body style="margin:0;padding:0;background:#f3f6fb;font-family:Arial,Helvetica,sans-serif;color:#172033;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f3f6fb;padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:760px;background:#ffffff;border-radius:14px;overflow:hidden;box-shadow:0 8px 28px rgba(15,23,42,.08);">
                    <tr>
                        <td style="padding:30px;background:linear-gradient(135deg,#172554,#2563eb);color:#ffffff;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="74" style="vertical-align:top;padding-right:16px;">
                                        <img src="{{ asset('public/images/cydc-email-logo.png') }}" alt="CYDC Activities Database" width="68" height="68" style="display:block;border-radius:50%;background:#ffffff;border:2px solid rgba(255,255,255,.75);">
                                    </td>
                                    <td style="vertical-align:top;color:#ffffff;">
                                        <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;opacity:.82;">Center Profile</div>
                                        <h1 style="margin:10px 0 6px;font-size:28px;line-height:1.2;">{{ $centerId }}</h1>
                                        <p style="margin:0;color:#dbeafe;font-size:14px;">Taarifa ya records zilizojazwa na watumiaji wa center hii.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:26px 30px 10px;">
                            <p style="margin:0 0 8px;font-size:15px;">Habari <strong>{{ $recipient->center_id ?: $recipient->email }}</strong>,</p>
                            <div style="padding:16px 18px;background:#eff6ff;border-left:4px solid #2563eb;border-radius:8px;white-space:pre-line;line-height:1.6;">{{ $caption }}</div>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:18px 30px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%" style="padding-right:7px;">
                                        <div style="padding:18px;border:1px solid #dbe3ef;border-radius:10px;">
                                            <div style="font-size:11px;color:#64748b;text-transform:uppercase;font-weight:700;">Users katika center</div>
                                            <div style="font-size:25px;font-weight:700;margin-top:6px;">{{ number_format($centerUsersCount) }}</div>
                                        </div>
                                    </td>
                                    <td width="50%" style="padding-left:7px;">
                                        <div style="padding:18px;border:1px solid #dbe3ef;border-radius:10px;">
                                            <div style="font-size:11px;color:#64748b;text-transform:uppercase;font-weight:700;">Jumla ya records</div>
                                            <div style="font-size:25px;font-weight:700;margin-top:6px;">{{ number_format($totalRecords) }}</div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:4px 30px 28px;">
                            <h2 style="font-size:18px;margin:0 0 14px;">Muhtasari wa Ujazaji wa Data</h2>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border:1px solid #dbe3ef;">
                                <thead>
                                    <tr style="background:#0f172a;color:#ffffff;">
                                        <th align="left" style="padding:11px 13px;font-size:13px;">Category</th>
                                        <th align="right" style="padding:11px 13px;font-size:13px;">Records</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($summary as $item)
                                        <tr>
                                            <td style="padding:10px 13px;border-top:1px solid #e2e8f0;font-size:13px;">{{ $item['title'] }}</td>
                                            <td align="right" style="padding:10px 13px;border-top:1px solid #e2e8f0;font-size:13px;font-weight:700;">{{ number_format($item['count']) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div style="text-align:center;margin-top:24px;">
                                <a href="{{ route('reports.index') }}" style="display:inline-block;background:#16834b;color:#ffffff;text-decoration:none;padding:12px 22px;border-radius:8px;font-weight:700;font-size:14px;">Fungua Reports Kwenye Mfumo</a>
                            </div>

                            <p style="margin:28px 0 0;line-height:1.65;font-size:14px;color:#334155;">
                                Best Regards,<br>
                                <strong>CYDC ACTIVITIES DATABASE</strong><br>
                                System Administrator<br>
                                Idriss Mwala<br>
                                Tel: <a href="tel:+255673746031" style="color:#2563eb;text-decoration:none;">+255 673 746 031</a><br>
                                Email: <a href="mailto:support@cydcactivitiesdb.or.tz" style="color:#2563eb;text-decoration:none;">support@cydcactivitiesdb.or.tz</a>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:18px 30px;background:#f8fafc;color:#64748b;font-size:12px;text-align:center;">
                            Email hii imetumwa moja kwa moja na {{ config('app.name') }}. Data iliyoonyeshwa ni ya Center ID {{ $centerId }} pekee.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
