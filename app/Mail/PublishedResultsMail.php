<?php

namespace App\Mail;

use App\Models\FormTwoAssessment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PublishedResultsMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public FormTwoAssessment $assessment,
        public User $publishedBy,
        public string $resultsUrl,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Published Results List Available - CYDC Activities Database',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.published-results',
        );
    }
}
