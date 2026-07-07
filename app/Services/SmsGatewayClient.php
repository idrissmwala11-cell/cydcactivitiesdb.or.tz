<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class SmsGatewayClient
{
    public function send(array $phoneNumbers, string $message): Response
    {
        if (! config('sms_gateway.enabled')) {
            throw new RuntimeException('SMS gateway is disabled. Set SMS_GATEWAY_ENABLED=true in .env.');
        }

        $username = (string) config('sms_gateway.username');
        $password = (string) config('sms_gateway.password');

        if ($username === '' || $password === '') {
            throw new RuntimeException('SMS gateway username/password are missing in .env.');
        }

        $endpoint = rtrim((string) config('sms_gateway.base_url'), '/').'/messages';

        return Http::timeout((int) config('sms_gateway.timeout', 20))
            ->acceptJson()
            ->asJson()
            ->withBasicAuth($username, $password)
            ->post($endpoint.'?skipPhoneValidation=true&deviceActiveWithin=12', [
                'textMessage' => [
                    'text' => $message,
                ],
                'phoneNumbers' => array_values($phoneNumbers),
                'ttl' => 3600,
                'priority' => 100,
            ])
            ->throw();
    }
}
