<?php

namespace App\Mail;

use App\Models\RendezVous;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RdvAnnulationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public RendezVous $rdv) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Annulation de votre rendez-vous – Dokita'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.rdv-annulation',
        );
    }
}
