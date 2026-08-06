<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LowBalanceMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ServiceMatch $match
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🤝 Quelqu\'un veut t\'aider sur TimeBank !',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.match-proposed',
        );
    }
    

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Low Balance Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
