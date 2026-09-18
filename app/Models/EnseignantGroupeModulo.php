<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EnseignantGroupeModulo extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'modulo_id',
        'groupe_id',
        'enseignant_id'
    ];
    public function enseignant() {
        return $this->belongsTo(Enseignant::class);
    }
    public function modulo() {
        return $this->belongsTo(Modulo::class);
    }
    public function avancements(): HasMany
    {
        return $this->hasMany(Avancement::class);
    }
    public function groupe() {
        return $this->belongsTo(Groupe::class);
    }
}
