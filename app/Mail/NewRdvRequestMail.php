<?php

namespace App\Mail;

use App\Models\RendezVous;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewRdvRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rdv;

    public function __construct(RendezVous $rdv)
    {
        $this->rdv = $rdv;
    }

    public function build()
    {
        return $this->subject('Nouvelle demande de consultation - Dokita')
                    ->view('emails.new_rdv_request');
    }
}
