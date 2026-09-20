<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Groupe extends Model
{
    use HasFactory;
     protected $fillable = [
        'id',
        'libelle',
        'effectif',
        'corp_id'
    ];
    public function corp() {
        return $this->belongsTo(Corp::class);
    }
    public function eleves(): HasMany
    {
        return $this->hasMany(Eleve::class);
    }
    public function enseignant_groupe_modulos(): HasMany
    {
        return $this->hasMany(EnseignantGroupeModulo::class);
    }
    
}
