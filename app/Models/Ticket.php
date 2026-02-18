<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{
    // 1. Les colonnes que l'on peut remplir via un formulaire ou un contrôleur
    protected $fillable = [
        'hopital_id',
        'service_id',
        'guichet_id',
        'user_id',
        'numero_ticket',
        'priorite',
        'statut',
        'heure_arrivee',
        'heure_appel',
        'heure_debut',
        'heure_fin',
    ];

    // 2. Conversion automatique des dates pour faciliter les calculs
    protected $casts = [
        'heure_arrivee' => 'datetime',
        'heure_appel'   => 'datetime',
        'heure_debut'   => 'datetime',
        'heure_fin'     => 'datetime',
    ];

    // --- TES RELATIONS (CARDINALITÉS) ---


    // Un ticket appartient à un hôpital
    public function hopital(): BelongsTo
    {
        return $this->belongsTo(Hopital::class);
    }

    // Un ticket appartient à un service
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
    
    // Un ticket est traité par un médecin (User)
    public function medecin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Un ticket peut avoir une seule consultation associée
    public function consultation(): HasOne
    {
        return $this->hasOne(Consultation::class);
    }
}
