<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    // 1. Autoriser l'écriture dans ces colonnes
    protected $fillable = [
        'hopital_id',
        'nom',
        'prefixe'
    ];

    // --- TES RELATIONS ---

    /**
     * Un service appartient à un hôpital.
     */
    public function hopital(): BelongsTo
    {
        return $this->belongsTo(Hopital::class);
    }

    /**
     * Un service possède plusieurs tickets (file d'attente).
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
