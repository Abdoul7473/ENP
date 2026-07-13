<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facture extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'montant',
         'rib',
        'mode_payement',
        'payer',
    ];
    public function facture_orders(): HasMany
    {
        return $this->hasMany(FactureOrder::class);
    }
}
