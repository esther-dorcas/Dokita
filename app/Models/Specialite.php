<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    protected $fillable = ['hopital_id','nom_specialite','tarif','icone'];

    public function hopital()
    {
        return $this->belongsTo(Hopital::class);
    }

    public function medecins()
    {
        return $this->hasMany(Medecin::class);
    }
}