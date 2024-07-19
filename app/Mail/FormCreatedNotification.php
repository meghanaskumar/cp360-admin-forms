<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use App\Models\Form;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormCreatedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $form;

    /**
     * Create a new message instance.
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Form Created Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.form-created',
            with: [
                'formName' => $this->form->name,
                'formFields' => $this->form->fields
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
