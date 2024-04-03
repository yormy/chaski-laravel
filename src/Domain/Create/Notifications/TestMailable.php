<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Create\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMailable extends Mailable
{
    use Queueable, SerializesModels;

    public string $title = 'Mailable Title';

    public string $msg = 'Mailable message';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): \Illuminate\Mail\Mailables\Envelope
    {
        return new Envelope(
            subject: 'Test MAilable',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): \Illuminate\Mail\Mailables\Content
    {
        return new Content(
            html: 'chaski-laravel::email',
            text: 'chaski-laravel::email_text',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
