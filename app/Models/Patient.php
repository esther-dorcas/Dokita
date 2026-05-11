<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'groupe_sanguin',
        'poids',
        'taille',
        'tension',
        'allergies',
        'contact_urgence_nom',
        'contact_urgence_tel',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
