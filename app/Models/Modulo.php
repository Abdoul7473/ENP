<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modulo extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'matiere_id',
        'corp_id',
        'horaire',
        'coefficient'
    ];
    public function matiere() {
        return $this->belongsTo(Matiere::class);
    }
     
}
