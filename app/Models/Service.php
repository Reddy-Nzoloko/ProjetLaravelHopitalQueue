<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'hopital_id',
        'nom',
        'prefixe',
    ];

    // Cardinalité pour chaque service
    public function hopital()
    {
        return $this->belongsTo(Hopital::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function scopeForHopital($query, $hopitalId)
    {
        return $query->where('hopital_id', $hopitalId);
    }
}
