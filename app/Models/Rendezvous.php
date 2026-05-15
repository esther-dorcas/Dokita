<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    protected $table = 'rendez_vous';

    protected $fillable = [
        'patient_id','medecin_id','hopital_id','date_heure',
        'motif','statut','rappel_envoye',
        'paiement_mode','paiement_statut','paiement_ref'
    ];

    protected $casts = ['date_heure' => 'datetime'];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }

    public function hopital()
    {
        return $this->belongsTo(Hopital::class);
    }
}