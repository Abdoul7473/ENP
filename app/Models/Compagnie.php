<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compagnie extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nom',
        'sigle',
        'effectif',
        'passant',
        'corp_id',
        'annee_id'
    ];
    public function corp() {
        return $this->belongsTo(Corp::class);
    }
}
