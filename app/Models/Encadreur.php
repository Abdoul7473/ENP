<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Encadreur extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nom',
        'prenom',
        'matricule',
        'email',
        'sexe',
        'tel',
        'date_naiss',
        'lieu_naiss',
        'is_commandant',
        'groupe_sanguin',
        'grade_id'
    ];
    public function grade() {
        return $this->belongsTo(Grade::class);
    }
    public function affectations(): HasMany
    {
        return $this->hasMany(Affectation::class);
    }
}
