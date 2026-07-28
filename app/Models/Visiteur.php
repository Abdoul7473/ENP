<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visiteur extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'statut',
        'nom',
        'date',
        'prenom',
        'mat_vehicule',
        'num_carte',
        'email',
        'sexe',
        'tel',
        'date_naiss',
        'heure_arrive',
        'heure_depart',
        'localite',
        'motif',
    ];
}
