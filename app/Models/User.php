<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $role
 * @property int|null $hopital_id
 */
class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',        // Doit être ici pour ServiceController
        'hopital_id',  // Doit être ici pour ServiceController
    ];

    public function hopital(): BelongsTo
    {
        return $this->belongsTo(Hopital::class);
    }
}
