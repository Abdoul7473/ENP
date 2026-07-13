<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RFacture extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'montant',
        'rib',
        'mode_payement',
        'payer',
    ];
    public function facture_redevances(): HasMany
    {
        return $this->hasMany(FactureRedevance::class);
    }
}
