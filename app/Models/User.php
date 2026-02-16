<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'hopital_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /* ---------------- Relationships ---------------- */
    public function hopital()
    {
        return $this->belongsTo(Hopital::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    /* ---------------- Role helpers ---------------- */
    public function hasRole($role): bool
    {
        if (is_array($role)) {
            return in_array($this->role, $role, true);
        }

        return $this->role === $role;
    }

    public function isAdminGlobal(): bool
    {
        return $this->role === 'admin_global';
    }

    public function isAdminHopital(): bool
    {
        return $this->role === 'admin_hopital';
    }

    public function isMedecin(): bool
    {
        return $this->role === 'medecin';
    }

    public function isReceptionniste(): bool
    {
        return $this->role === 'receptionniste';
    }
}

