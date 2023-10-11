<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendToParent extends Mailable
{
    use Queueable, SerializesModels;

    private $notify;
    /**
     * Create a new message instance.
     */
    public function __construct($notify)
    {
        $this->notify = $notify;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send To Parent',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.send-mail-to-parent-template',
            with: [
                'name' => $this->notify->name,
                'fromName' => $this->notify->from_name,
                'content' => $this->notify->content,
                'link' => $this->notify->link,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
