<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $role
 * @property int|null $hopital_id
 */
class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',        // Doit être ici pour ServiceController
        'hopital_id',  // Doit être ici pour ServiceController
        'service_id',  // Ajouté pour rattacher les médecins
    ];

    public function hopital(): BelongsTo
    {
        return $this->belongsTo(Hopital::class);
    }

    /**
     * Si l'utilisateur est médecin, il appartient à un service.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Service::class);
    }
}
