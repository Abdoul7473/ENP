<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Demande extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_demande',
        'date_soumis',
        'ville_fait',
        'signature_cachet',
        'date_approbation',
        'date_verif',
        'numero_ordre',
        'type_demande_id',
        'signature_id',
        'type_vol_id',
        'user_id',
        'user_appro',
        'user_verif',
        'user_delete',
        'user_autoriser',
        'statut_id',
        'date_rejet',
        'date_autorisation',
        'motif_rejet',
        'motif_annuler',
        'preciser',
        'revise',
        'date_soumis',
        'date_prevu_vol',
        'permanant',
        'nbre_mois',
        'urgence',
        'payer',
        'payer_revise'

    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('H:i, d M Y');
    }

    public function getDatePrevuVolAttribute($value)
    {
        return Carbon::parse($value)->format('d-M-Y');
    }

    public function signature() {
        return $this->belongsTo(Signature::class);
    }
    
    public function type_vol() {
        return $this->belongsTo(TypeVol::class);
    }

    public function type_demande() {
        return $this->belongsTo(TypeDemande::class);
    }

    public function statut() {
        return $this->belongsTo(Statut::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function user_appro() {
        return $this->belongsTo(User::class,"user_appro");
    }
    public function user_verif() {
        return $this->belongsTo(User::class,"user_verif");
    }
    public function user_autoriser() {
        return $this->belongsTo(User::class,"user_autoriser");
    }
    public function user_delete() {
        return $this->belongsTo(User::class,"user_delete");
    }
    public function aeronefs(): HasMany
    {
        return $this->hasMany(Aeronef::class);
    }
    public function routes(): HasMany
    {
        return $this->hasMany(Route::class);
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
