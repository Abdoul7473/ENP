<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perm extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'eleve_id',
        'date_debut',
        'date_fin',
        'numero',
        'lieu',
        'motif',
        'heure_arrive',
        'nombre_jour'
    ];
    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }
}
