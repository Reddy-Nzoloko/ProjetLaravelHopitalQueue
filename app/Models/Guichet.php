<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guichet extends Model
{
    use HasFactory;

    protected $fillable = [
        'hopital_id',
        'nom',
        'est_ouvert',
    ];

    protected $casts = [
        'est_ouvert' => 'boolean',
    ];

    public function hopital()
    {
        return $this->belongsTo(Hopital::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function open()
    {
        $this->update(['est_ouvert' => true]);
    }

    public function close()
    {
        $this->update(['est_ouvert' => false]);
    }

    public function scopeOpen($query)
    {
        return $query->where('est_ouvert', true);
    }
}
