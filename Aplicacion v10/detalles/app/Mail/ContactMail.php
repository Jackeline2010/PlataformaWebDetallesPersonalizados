<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactData;

    /**
     * Create a new message instance.
     */
    public function __construct($contactData)
    {
        $this->contactData = $contactData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subjectMap = [
            'consulta' => 'Consulta de producto',
            'pedido' => 'Estado de pedido',
            'soporte' => 'Soporte y ayuda',
            'otro' => 'Consulta general'
        ];

        $subject = $subjectMap[$this->contactData['asunto']] ?? 'Consulta general';

        return new Envelope(
            from: $this->contactData['email'],
            replyTo: $this->contactData['email'],
            subject: 'SandyDecor - ' . $subject . ' - ' . $this->contactData['nombre'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
            with: [
                'contactData' => $this->contactData,
            ],
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
