<?php

return [
    'enabled' => env('SMS_GATEWAY_ENABLED', false),

    'base_url' => env('SMS_GATEWAY_BASE_URL', 'https://api.sms-gate.app/3rdparty/v1'),
    'username' => env('SMS_GATEWAY_USERNAME'),
    'password' => env('SMS_GATEWAY_PASSWORD'),
    'timeout' => (int) env('SMS_GATEWAY_TIMEOUT', 20),

    'from_name' => env('SMS_GATEWAY_FROM_NAME', 'CYDC'),

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
            'morning' => env('SMS_REMINDER_MORNING_MESSAGE', 'Habari za asubuhi. Tafadhali kumbuka kujaza data za kituo chako kwenye CYDC Activities Database leo. Asante.'),
            'afternoon' => env('SMS_REMINDER_AFTERNOON_MESSAGE', 'Habari za mchana. Tafadhali hakikisha data zote za kituo chako zimejazwa kwenye CYDC Activities Database. Asante.'),
            'evening' => env('SMS_REMINDER_EVENING_MESSAGE', 'Habari za jioni. Asante kwa huduma ya leo. Tafadhali kamilisha data zilizosalia. Usiku mwema.'),
        ],
    ],
];
