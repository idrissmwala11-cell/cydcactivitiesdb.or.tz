<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CenterDataReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $recipient,
        public string $caption,
        public string $centerId,
        public array $summary,
        public int $totalRecords,
        public int $centerUsersCount,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Taarifa ya Ujazaji wa Data - {$this->centerId}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.center-data-report',
        );
    }
}
