<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'date',
        'statut',
        'encadreur_id',
        'compagnie_id'
    ];
    public function compagnie() {
        return $this->belongsTo(Compagnie::class);
    }
}
