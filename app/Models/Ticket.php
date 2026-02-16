<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

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

    protected $casts = [
        'heure_arrivee' => 'datetime',
        'heure_appel' => 'datetime',
        'heure_debut' => 'datetime',
        'heure_fin' => 'datetime',
    ];

    // relations
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function medecin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function consultation()
    {
        return $this->hasOne(Consultation::class);
    }

    public function guichet()
    {
        return $this->belongsTo(Guichet::class);
    }

    public function hopital()
    {
        return $this->belongsTo(Hopital::class);
    }

    // scopes
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeAppeles($query)
    {
        return $query->where('statut', 'appelé');
    }

    // status helpers
    public function markAppel()
    {
        $this->update(['statut' => 'appelé', 'heure_appel' => now()]);

        return $this;
    }

    public function startConsultation()
    {
        $this->update(['statut' => 'en_consultation', 'heure_debut' => now()]);

        return $this;
    }

    public function finishConsultation()
    {
        $this->update(['statut' => 'terminé', 'heure_fin' => now()]);

        return $this;
    }

    // helper to generate readable ticket numbers
    public static function generateNumeroForService(Service $service): string
    {
        $count = self::where('service_id', $service->id)->count() + 1;

        return sprintf('%s-%03d', strtoupper($service->prefixe), $count);
    }
}

