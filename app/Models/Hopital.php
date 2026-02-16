<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hopital extends Model
{
    // Important : Laravel cherche "hopitals" par défaut, on le redirige vers "hopitaux"
    protected $table = 'hopitaux';

    // Autoriser l'enregistrement de ces données
    protected $fillable = [
        'nom',
        'adresse',
        'code_unique',
        'configuration'
    ];

    // Convertit automatiquement le JSON de la base en tableau PHP
    protected $casts = [
        'configuration' => 'array',
    ];

    // --- CARDINALITÉS ---

    /**
     * Un hôpital possède plusieurs services (Pédiatrie, Urgences, etc.)
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Un hôpital possède plusieurs utilisateurs (Médecins, Admins, etc.)
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Un hôpital possède plusieurs guichets (Bureau 1, Box A, etc.)
     */
    public function guichets(): HasMany
    {
        return $this->hasMany(Guichet::class);
    }
}
