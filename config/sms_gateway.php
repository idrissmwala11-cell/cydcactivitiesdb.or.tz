<?php

return [
    'enabled' => env('SMS_GATEWAY_ENABLED', false),

    'base_url' => env('SMS_GATEWAY_BASE_URL', 'https://api.sms-gate.app/3rdparty/v1'),
    'username' => env('SMS_GATEWAY_USERNAME'),
    'password' => env('SMS_GATEWAY_PASSWORD'),
    'timeout' => (int) env('SMS_GATEWAY_TIMEOUT', 20),

    'from_name' => env('SMS_GATEWAY_FROM_NAME', 'CYDC'),

    'blocked_numbers' => array_filter(array_map(
        'trim',
        explode(',', filled(env('SMS_BLOCKED_NUMBERS')) ? env('SMS_BLOCKED_NUMBERS') : '0747746838,0687752210')
    )),

    'format' => [
        'title' => env('SMS_MESSAGE_TITLE', 'CHILD AND YOUTH DEVELOPMENT CENTER (CYDC)'),
        'greeting' => env('SMS_MESSAGE_GREETING', 'Shalom!'),
        'signature' => env('SMS_MESSAGE_SIGNATURE', "Best Regards,\nCYDC ACTIVITIES DATABASE\nSystem Administrator\nIdriss Mwala\nTel: +255 673 746 031\nEmail: support@cydcactivitiesdb.or.tz"),
    ],

    'reminders' => [
        'enabled' => env('SMS_REMINDERS_ENABLED', false),
        'batch_size' => (int) env('SMS_REMINDERS_BATCH_SIZE', 30),
        'sleep_seconds' => (int) env('SMS_REMINDERS_SLEEP_SECONDS', 2),

        'messages' => [
            'morning' => env('SMS_REMINDER_MORNING_MESSAGE', 'Good morning {name}. This is a kind reminder to fill in your center data in the CYDC Activities Database system. Have a blessed morning.'),
            'afternoon' => env('SMS_REMINDER_AFTERNOON_MESSAGE', 'Good afternoon {name}. This is a kind reminder to fill in your center data in the CYDC Activities Database system. Have a blessed afternoon.'),
            'evening' => env('SMS_REMINDER_EVENING_MESSAGE', 'Good evening {name}. This is a kind reminder to fill in your center data in the CYDC Activities Database system. Have a blessed evening and a good night.'),
        ],
    ],
];
