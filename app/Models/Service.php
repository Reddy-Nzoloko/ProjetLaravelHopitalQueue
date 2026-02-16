<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    // Cardinalité pour chaque service
    public function hopital() {
    return $this->belongsTo(Hopital::class);
}

public function tickets() {
    return $this->hasMany(Ticket::class);
}
}
