<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hopital extends Model
{
    // les cardinalités des hopitaux
    public function services() {
    return $this->hasMany(Service::class);
}

public function users() {
    return $this->hasMany(User::class);
}
}
