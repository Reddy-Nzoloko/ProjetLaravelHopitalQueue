<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    // cardinalités pour les ticket
    public function service() {
    return $this->belongsTo(Service::class);
}

public function medecin() {
    return $this->belongsTo(User::class, 'user_id');
}

public function consultation() {
    return $this->hasOne(Consultation::class);
}
}
