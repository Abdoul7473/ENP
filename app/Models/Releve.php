<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Releve extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'eleve_id',
        'total_coefficient_classe',
        'total_note_classe',
        'total_note_coefficiente_classe',
        'moyenne_classe',
        'total_coefficient_examen',
        'total_note_examen',
        'total_note_coefficiente_examen',
        'moyenne_examen',
        'moyenne_generale',
        'note_memoire',
        'mention',
    ];
     public function eleve() {
        return $this->belongsTo(Eleve::class);
    }
     public function lignes(): HasMany
    {
        return $this->hasMany(Ligne::class);
    }
}
