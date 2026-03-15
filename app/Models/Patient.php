<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'hopital_id',
        'service_id',
        'guichet_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hopital()
    {
        return $this->belongsTo(Hopital::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function guichet()
    {
        return $this->belongsTo(Guichet::class);
    }
}
