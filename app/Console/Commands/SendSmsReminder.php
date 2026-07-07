<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\SmsSender;
use Illuminate\Console\Command;

class SendSmsReminder extends Command
{
    protected $signature = 'sms:send-reminder {type : morning|afternoon|evening}';

    protected $description = 'Send scheduled SMS reminders to approved users with phone numbers.';

    public function handle(SmsSender $sender): int
    {
        $type = (string) $this->argument('type');
        $messages = config('sms_gateway.reminders.messages', []);

        if (! in_array($type, ['morning', 'afternoon', 'evening'], true)) {
            $this->error('Invalid reminder type.');

            return self::FAILURE;
        }

        if (! config('sms_gateway.reminders.enabled')) {
            $this->info('SMS reminders are disabled.');

            return self::SUCCESS;
        }

        $message = (string) ($messages[$type] ?? '');

        if ($message === '') {
            $this->error('Reminder message is empty.');

            return self::FAILURE;
        }

        $sent = 0;
        $failed = 0;
        $sleep = max(0, (int) config('sms_gateway.reminders.sleep_seconds', 2));
        $batchSize = max(1, (int) config('sms_gateway.reminders.batch_size', 30));

        User::query()
            ->where('role', 'user')
            ->where('status', 'approved')
            ->whereNotNull('phone')
            ->where('phone', '!=', '')
            ->orderBy('id')
            ->chunkById($batchSize, function ($users) use ($sender, $message, $type, $sleep, &$sent, &$failed): void {
                foreach ($users as $user) {
                    $log = $sender->sendToPhone(
                        (string) $user->phone,
                        $this->personalizeMessage($message, $user),
                        $type.'_reminder',
                        $user
                    );

                    $log->status === 'sent' ? $sent++ : $failed++;

                    if ($sleep > 0) {
                        sleep($sleep);
                    }
                }
            });

        $this->info("SMS reminder completed. Sent: {$sent}. Failed: {$failed}.");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function personalizeMessage(string $message, User $user): string
    {
        $name = trim((string) ($user->name ?? ''));

        if ($name === '') {
            $name = trim((string) ($user->center_id ?? ''));
        }

        if ($name === '') {
            $name = 'dear user';
        }

        return str_replace(
            ['{name}', '{center_id}', '{email}'],
            [$name, (string) ($user->center_id ?? ''), (string) ($user->email ?? '')],
            $message
        );
    }
}
