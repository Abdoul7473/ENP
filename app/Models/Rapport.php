<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rapport extends Model
{
    use HasFactory;
     protected $fillable = [
        'id',
        'description',
        'encadreur_id'
    ];
    public function encadreur(): BelongsTo
    {
        return $this->belongsTo(Encadreur::class);
    }
    public function situations(): HasMany
    {
        return $this->hasMany(Situation::class);
    }
}
