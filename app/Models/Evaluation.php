<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evaluation extends Model
{
    use HasFactory;
    

    public function enseignant_groupe_modulo() {
        return $this->belongsTo(EnseignantGroupeModulo::class);
    }
}
