<?php

namespace App\Mail;

use App\Models\RendezVous;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RdvRappelMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public RendezVous $rdv) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rappel – Votre rendez-vous demain – Dokita'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.rdv-rappel',
        );
    }
}
