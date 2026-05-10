<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'telephone',
        'role',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function medecin()
    {
        return $this->hasOne(Medecin::class);
    }

    public function hopital()
    {
        return $this->hasOne(Hopital::class);
    }

    public function rendezVous()
    {
        return $this->hasMany(Rendezvous::class, 'patient_id');
    }

    public function urgences()
    {
        return $this->hasMany(Urgence::class, 'patient_id');
    }

    // Helper methods
    public function isPatient()
    {
        return $this->role === 'patient';
    }

    public function isMedecin()
    {
        return $this->role === 'medecin';
    }

    public function isHopital()
    {
        return $this->role === 'hopital';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
