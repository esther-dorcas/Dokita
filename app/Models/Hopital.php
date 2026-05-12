<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Hopital extends Model
{
    protected $table = 'hopitaux';

    protected $fillable = [
        'user_id','nom','adresse','latitude','longitude',
        'telephone','whatsapp','horaires','description'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialites()
    {
        return $this->hasMany(Specialite::class);
    }

    public function medecins()
    {
        return $this->hasMany(Medecin::class);
    }

    public function rendezVous()
    {
        return $this->hasManyThrough(RendezVous::class, Medecin::class);
    }

    public function isOuvert(): bool
    {
        $h = now()->hour;
        return $h >= 8 && $h < 18;
    }

    public function tarifMin()
    {
        return $this->specialites->min('tarif') ?? 0;
    }
}