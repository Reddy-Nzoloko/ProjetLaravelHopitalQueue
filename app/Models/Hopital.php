<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hopital extends Model
{
    use HasFactory;

    // La table migrée s'appelle `hopitaux` (pluriel français)
    protected $table = 'hopitaux';

    protected $fillable = [
        'nom',
        'adresse',
        'code_unique',
        'configuration',
    ];

    // les cardinalités des hopitaux
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function guichets()
    {
        return $this->hasMany(Guichet::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
