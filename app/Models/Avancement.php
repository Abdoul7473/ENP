<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avancement extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'date',
        'heure_depart',
        'heure_arrive',
        'objectif_general',
        'objectif_specific',
        'enseignant_groupe_modulo_id',
        'progression',
        'nombre_heure'
    ];
}
