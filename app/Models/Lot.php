<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lot extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nombre',
        'date',
    ];
    
   public function numeros(): HasMany
    {
        return $this->hasMany(Numero::class);
    }
}
