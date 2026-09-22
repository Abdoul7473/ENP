<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Corp extends Model
{
    use HasFactory;
    public function enseignant_groupe_modulos(): HasMany
    {
        return $this->hasMany(Modulo::class);
    }
}
