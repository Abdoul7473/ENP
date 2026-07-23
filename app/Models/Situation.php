<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Situation extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nombre_present',
        'nombre_absent',
        'nombre_malade',
        'nombre_permissionnaire',
        'compagnie_id',
        'statut'
    ];
    public function compagnie(): BelongsTo
    {
        return $this->belongsTo(Compagnie::class);
    }
    public function rapport(): BelongsTo
    {
        return $this->belongsTo(Rapport::class);
    }
    public function absents(): HasMany
    {
        return $this->hasMany(Absent::class);
    }
    public function malades(): HasMany
    {
        return $this->hasMany(Malade::class);
    }
    public function permissionnaires(): HasMany
    {
        return $this->hasMany(Permissionnaire::class);
    }
}
