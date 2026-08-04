<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entite extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'libelle',
        'entite_id'
    ];
    public function entite() {
        return $this->belongsTo(Entite::class);
    }
}
