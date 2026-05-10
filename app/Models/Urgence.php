<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Urgence extends Model
{
    protected $fillable = [
        'patient_id', 'description', 'localisation',
        'latitude', 'longitude', 'statut',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
