<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    protected $fillable = [
        'user_id','hopital_id','specialite_id',
        'specialite','experience','tarif','bio','disponibilites','statut'
    ];

    protected $casts = ['disponibilites' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hopital()
    {
        return $this->belongsTo(Hopital::class);
    }

    public function specialite()
    {
        return $this->belongsTo(Specialite::class);
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }

    public function getInitialesAttribute(): string
    {
        $parts = explode(' ', $this->user->name ?? 'Dr');
        return strtoupper(substr($parts[0],0,1).(isset($parts[1]) ? substr($parts[1],0,1) : ''));
    }

    public function creneauxDisponibles(string $date): array
    {
        $rdvPris = $this->rendezVous()
            ->whereDate('date_heure', $date)
            ->whereNotIn('statut', ['annule'])
            ->pluck('date_heure')
            ->map(fn($d) => \Carbon\Carbon::parse($d)->format('H:i'))
            ->toArray();

        $creneaux = [];
        $start = \Carbon\Carbon::parse($date.' 08:00');
        $end   = \Carbon\Carbon::parse($date.' 18:00');
        $maintenant = now();

        while ($start < $end) {
            $heure = $start->format('H:i');
            
            // Le créneau est libre s'il n'est pas pris ET s'il n'est pas déjà passé
            $isLibre = !in_array($heure, $rdvPris) && $start > $maintenant;

            $creneaux[] = [
                'heure' => $heure,
                'libre' => $isLibre
            ];
            $start->addMinutes(15);
        }
        return $creneaux;
    }
}