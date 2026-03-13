<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guichet extends Model
{
    // on autorise l'écriture dans ces colonnes
    protected $fillable = [
        'hopital_id',
        'service_id',
        'nom',
        'est_ouvert',
    ];

    /**
     * Le guichet appartient à un hôpital.
     */
    public function hopital(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Hopital::class);
    }

    /**
     * Le guichet peut être rattaché à un service.
     */
    public function service(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
