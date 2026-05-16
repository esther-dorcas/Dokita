<?php

namespace App\Mail;

use App\Models\RendezVous;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RdvStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rdv;
    public $status;
    public $recipientType;

    public function __construct(RendezVous $rdv, $status, $recipientType = 'patient')
    {
        $this->rdv = $rdv;
        $this->status = $status;
        $this->recipientType = $recipientType;
    }

    public function build()
    {
        $subject = $this->status === 'confirme' 
            ? '✅ Confirmation de votre rendez-vous - Dokita' 
            : '❌ Annulation de votre rendez-vous - Dokita';

        if ($this->status === 'reprogramme') {
            $subject = '🔄 Modification de votre rendez-vous - Dokita';
        }

        return $this->subject($subject)
                    ->view('emails.rdv_status');
    }
}
