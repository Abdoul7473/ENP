<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visiteur extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nom',
        'prenom',
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
