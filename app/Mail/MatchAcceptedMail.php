<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MatchAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ServiceMatch $match
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Ton match a été accepté !',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.match-accepted',
        );
    }