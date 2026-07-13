<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Numero extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'numero',
        'statut',
        'lot_id'
    ];
    public function lot() {
        return $this->belongsTo(Lot::class);
    }
}
