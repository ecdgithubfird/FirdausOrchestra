<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\Mail\Models\Mail;

class BulkEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $requestId;

    public function __construct($requestId)
    {
        $this->requestId = $requestId;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        
       $subject = Mail::where('id', $this->requestId)->value('subject');
       return new Envelope(
           subject: $subject ?? 'Default Subject',
       );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
         $content = Mail::where('id', $this->requestId)->value('description');
         return new Content(
             view: 'backend.emails.custom_template' // Use your actual email template
         );
    }    
    /**
     * Build the message.
     */
    public function build()
    {
        $content = Mail::where('id', $this->requestId)->value('description');

        return $this->view('backend.emails.custom_template')
                    ->with(['content' => $content ?? 'Default Content']);
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
