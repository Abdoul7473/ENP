<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;
     protected $fillable = [
        'id',
        'nom',
        'prenom',
        'date_naiss',
        'lieu_naiss',
        'telephone',
        'sexe'
    ];
}
