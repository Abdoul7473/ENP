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
        'sexe',
        'tel',
        'date_naiss',
        'lieu_naiss',
        'is_commandant',
        'groupe_sanguin',
        'grade_id',
        'statut',
        'profil_id',
        'entite_id',
        'type',
        'num_decision',
        'document',
        'decision',
        'date_affectation'
    ];
    public function grade() {
        return $this->belongsTo(Grade::class);
    }
    public function entite() {
        return $this->belongsTo(Entite::class);
    }
    public function profil() {
        return $this->belongsTo(Profil::class);
    }
    public function affectations(): HasMany
    {
        return $this->hasMany(Affectation::class);
    }
}
