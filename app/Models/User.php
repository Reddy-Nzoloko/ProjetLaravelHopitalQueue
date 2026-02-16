<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les attributs qui peuvent être remplis (Mass Assignment).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'hopital_id', // AJOUT : Pour lier l'utilisateur à son hôpital
        'role',       // AJOUT : Pour gérer les permissions
    ];

    /**
     * Les attributs cachés (pour la sécurité).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversion des types (Casting).
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELATIONS (CARDINALITÉS) ---

    /**
     * Un utilisateur appartient à un hôpital.
     */
    public function hopital(): BelongsTo
    {
        return $this->belongsTo(Hopital::class);
    }

    /**
     * Si l'utilisateur est un médecin, il peut traiter plusieurs tickets.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
