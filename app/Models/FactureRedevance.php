<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureRedevance extends Model
{
    use HasFactory;
    protected $fillable = [
        'r_facture_id',
        'redevance_id',
    ];

    public function rfacture() {
        return $this->belongsTo(RFacture::class);
    }

    public function redevance() {
        return $this->belongsTo(Redevance::class);
    }
}
