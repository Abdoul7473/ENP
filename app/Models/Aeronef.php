<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aeronef extends Model
{
    use HasFactory;
    protected $fillable = [
        'imatriculation',
        'type',
        'indicatif_appel',
        'demande_id',
        'proprietaire_aeronef',
        'commandant_bord',
        'email_exploitant',
        'tel_exploitant',
        'nom_exploitant',
    ];
    
    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}
