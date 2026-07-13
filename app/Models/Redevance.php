<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Redevance extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'num_autorisation_id',
        'demande_id',
        'type_vol',
        'autorisation_excep',
        'nbre_passagers_arr',
        'nbre_passagers_dep',
        'marchand_valeur_arr',
        'marchand_valeur_dep',
        'autre_que_marchand_valeur_arr',
        'autre_que_marchand_valeur_dep',
        'rib',
        'mode_payement',
        'montant',
        'payer',
        'statut',
        'aerodrome',
        'poids_aeronef',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('H:i, d M Y');
    }

    public function num_autorisation() {
        return $this->belongsTo(NumAutorisation::class);
    }

    public function demande() {
        return $this->belongsTo(Demande::class);
    }
}
