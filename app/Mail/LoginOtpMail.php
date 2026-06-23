<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $code,
        public User $user,
        public ?int $expireMinutes = null,
    ) {
        $this->expireMinutes ??= (int) config('auth.login_otp.expire_minutes', 30);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'CYDC Login Verification Code',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.auth.login-otp',
        );
    }
}
