<?php

namespace App\Mail;

use App\Models\Talep;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class YeniTalepMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Talep $talep)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Yeni Teklif Talebi — ' . $this->talep->ad,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.yeni-talep',
        );
    }
}
