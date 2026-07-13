<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
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
        'groupe_sanguin',
        'compagnie_id'
    ];
     public function compagnie() {
        return $this->belongsTo(Compagnie::class);
    }
}
