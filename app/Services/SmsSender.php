<?php

namespace App\Services;

use App\Models\SmsLog;
use App\Models\User;
use Throwable;

class SmsSender
{
    public function __construct(private readonly SmsGatewayClient $client)
    {
    }

    public function sendToPhone(string $phone, string $message, string $type = 'manual', ?User $user = null): SmsLog
    {
        $normalizedPhone = $this->normalizePhone($phone);
        $formattedMessage = $this->formatMessage($message);

        $log = SmsLog::create([
            'user_id' => $user?->id,
            'phone' => $normalizedPhone,
            'type' => $type,
            'message' => $formattedMessage,
            'status' => 'pending',
        ]);

        try {
            $response = $this->client->send([$normalizedPhone], $formattedMessage);
            $payload = $response->json();

            $log->update([
                'status' => 'sent',
                'provider_message_id' => $this->extractMessageId($payload),
                'provider_response' => $payload ?? ['body' => $response->body()],
                'sent_at' => now(),
            ]);
        } catch (Throwable $exception) {
            $log->update([
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
            ]);
        }

        return $log->fresh();
    }

    public function formatMessage(string $body): string
    {
        $body = trim($body);
        $title = trim((string) config('sms_gateway.format.title'));
        $greeting = trim((string) config('sms_gateway.format.greeting'));
        $signature = trim((string) config('sms_gateway.format.signature'));

        if ($greeting !== '' && str_starts_with(strtolower($body), strtolower($greeting))) {
            $body = trim(substr($body, strlen($greeting)));
        }

        return collect([$title, $greeting, $body, $signature])
            ->filter(fn (string $part): bool => trim($part) !== '')
            ->implode("\n\n");
    }

    public function normalizePhone(string $phone): string
    {
        $phone = trim($phone);

        if (str_starts_with($phone, '+')) {
            return '+'.preg_replace('/\D+/', '', substr($phone, 1));
        }

        $digits = preg_replace('/\D+/', '', $phone) ?: '';

        if (str_starts_with($digits, '0') && strlen($digits) === 10) {
            return '+255'.substr($digits, 1);
        }

        if (strlen($digits) === 9 && preg_match('/^[67]/', $digits) === 1) {
            return '+255'.$digits;
        }

        if (str_starts_with($digits, '255')) {
            return '+'.$digits;
        }

        return $digits;
    }

    private function extractMessageId(mixed $payload): ?string
    {
        if (! is_array($payload)) {
            return null;
        }

        foreach (['id', 'messageId', 'message_id', 'requestId', 'request_id'] as $key) {
            if (! empty($payload[$key])) {
                return (string) $payload[$key];
            }
        }

        if (! empty($payload[0]) && is_array($payload[0])) {
            return $this->extractMessageId($payload[0]);
        }

        return null;
    }
}
